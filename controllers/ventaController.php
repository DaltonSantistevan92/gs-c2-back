<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/helper.php';
require_once 'core/conexion.php';
require_once 'core/params.php';
require_once 'models/ventaModel.php';
require_once 'models/codigosModel.php';
require_once 'controllers/detalleventaController.php';

class VentaController
{
    private $cors;
    private $db;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->db = new Conexion();
    }

    public function getCodigo($params)
    {
        $tipo = $params['tipo'];
        $registro = Codigo::where('tipo', $tipo)->orderBy('id', 'DESC')->first();
        $response = [];

        if ($registro == null) {
            $response = [
                'status' => true,
                'tipo' => $tipo,
                'mensaje' => 'Primer registro',
                'codigo' => '0001',
            ];
        } else {
            $numero = intval($registro->codigo);
            $siguiente = '000' . ($numero += 1);
            $response = [
                'status' => true,
                'tipo' => $tipo,
                'mensaje' => 'Existen datos,aumentando registro venta',
                'codigo' => $siguiente,
            ];
        }
        echo json_encode($response);
    }

    public function aumentarCodigo(Request $request)
    {
        $this->cors->corsJson();
        $tipoRequest = $request->input('codigo');
        $tipo = $tipoRequest->tipo;
        $codigo = $tipoRequest->codigo;
        $response = [];

        if ($tipoRequest == null) {
            $response = [
                'status' => false,
                'mensaje' => 'no ahi datos',
            ];
        } else {
            $nuevo = new Codigo();
            $nuevo->codigo = $codigo;
            $nuevo->tipo = $tipo;
            $nuevo->estado = 'A';
            $nuevo->save();

            $response = [
                'status' => true,
                'mensaje' => 'Guardando datos',
                'codigo' => $nuevo,
            ];
        }
        echo json_encode($response);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $venta = $request->input('venta');
        $detalles_ventas = $request->input('detalles');

        $serie = $venta->serie;
        $response = [];

        if ($venta) {
            $venta->serie = $venta->serie;
            $venta->usuario_id = intval($venta->usuario_id);
            $venta->cliente_id = intval($venta->cliente_id);
            $venta->subtotal = floatval($venta->subtotal);
            $venta->iva = floatval($venta->iva);
            $venta->total = floatval($venta->total);

            //Empieza
            $nuevo = new Venta();
            $nuevo->serie = $venta->serie;
            $nuevo->usuario_id = $venta->usuario_id;
            $nuevo->cliente_id = $venta->cliente_id;
            $nuevo->subtotal = $venta->subtotal;
            $nuevo->iva = $venta->iva;
            $nuevo->total = $venta->total;
            $nuevo->fecha_venta = date('Y-m-d');
            $nuevo->hora_venta = date('H:i:s');
            $nuevo->estado = 'A';

            //validar con first para que no se repita la serie
            $existe = Venta::where('serie', $serie)->get()->first();

            if ($existe) {
                $response = [
                    'status' => false,
                    'mensaje' => 'La venta ya existe',
                    'venta' => null,
                    'detalle' => null,
                ];
            } else {

                if ($nuevo->save()) {

                    //Guarda detalle de venta
                    $detalleController = new DetalleVentaController();

                    $extra = $detalleController->guardar($nuevo->id, $detalles_ventas);

                    $response = [
                        'status' => true,
                        'mensaje' => 'Guardando los datos',
                        'venta' => $nuevo,
                        'detalle' => $extra,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se puede guardar',
                        'venta' => null,
                        'detalle' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'venta' => null,
                'detalle' => null,

            ];
        }
        echo json_encode($response);
    }

    public function listar()
    {
        $this->cors->corsJson();
        $ventas = Venta::where('estado', 'A')->get();
        $response = [];

        foreach ($ventas as $item) {
            $aux = [
                'ventas' => $item,
                'cliente_id' => $item->cliente->persona->id,
                'usuario_id' => $item->usuario->id,

            ];
            $response[] = $aux;
        }

        echo json_encode($response);
    }

    public function buscar($params)
    {
        $this->cors->corsJson();
        $idventa = intval($params['id']);

        $buscar = Venta::find($idventa);

        $response = [];

        if ($buscar) {
            foreach ($buscar->detalle_venta as $subbuscar) {
                $subbuscar->producto;
            }

            $response = [
                'status' => true,
                'mensaje' => 'Existe',
                'venta' => $buscar,
                'cliente_id' => $buscar->cliente->id,
                'cliente_persona' => $buscar->cliente->persona->id,
                'usuario_id' => $buscar->usuario->id,
                'usuario_persona' => $buscar->usuario->persona->id,
                'detalle_venta' => $buscar->detalle_venta,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No Existe la venta',
                'venta' => null,
            ];
        }

        echo json_encode($response);
    }

    public function datatable()
    {
        $this->cors->corsJson();

        $ventas = Venta::where('estado', 'A')
            ->orderBy('id', 'DESC')
            ->get();

        $data = [];
        $i = 1;

        //datatable
        foreach ($ventas as $v) {

            $botones = '<div class="text-center">
                <button class="btn btn-sm btn-danger" onclick="ir_venta_factura(' . $v->id . ')">
                    <i class="fas fa-clipboard-list"></i>
                </button>
            </div>';

            $data[] = [

                0 => $i,
                1 => $v->serie,
                2 => $v->cliente->persona->nombres,
                3 => number_format($v->total, 2, '.', ''),
                4 => $v->fecha_venta,
                5 => $botones,
            ];
            $i++;
        }
        $result = [
            'sEcho' => 1,
            'iTotalRecords' => count($data),
            'iTotalDisplayRecords' => count($data),
            'aaData' => $data,
        ];

        echo json_encode($result);
    }

    public function total()
    {
        $this->cors->corsJson();
        $meses = [
            'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre',
        ];
        $posMes = intval(date('m')) - 1;
        $hoy = date('Y-m-d');
        $inicio_mes = date('Y') . '-' . date('m') . '-01';

        $ventas = Venta::where('estado', 'A')
            ->where('fecha_venta', '>=', $inicio_mes)
            ->where('fecha_venta', '<=', $hoy)->get();

        $response = [];
        $total = 0;

        if ($ventas) {
            foreach ($ventas as $v) {
                $aux = $total += $v->total;
                $total = round($aux, 2);
            }
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'total' => $total,
                'mes' => $meses[$posMes],
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No Existen datos',
                'total' => 0,
                'mes' => $meses[$posMes],
            ];
        }
        echo json_encode($response);
    }

    public function grafica_venta()
    {
        $this->cors->corsJson();
        $year = date('Y');

        $meses = [
            'ENERO', 'FEBRERO', 'MARZO', 'ABRIL', 'MAYO', 'JUNIO', 'JULIO', 'AGOSTO', 'SEPTIEMBRE', 'OCTUBRE', 'NOVIEMBRE', 'DICIEMBRE',
        ];
        $data = [];

        //Obtener total de ventas
        for ($i = 0; $i < count($meses); $i++) {
            $sqlVentas = "SELECT SUM(total) as suma FROM `ventas` WHERE MONTH(fecha_venta) = ($i + 1) AND  YEAR(fecha_venta) = $year AND estado = 'A'";

            $ventaMes = $this->db->database::select($sqlVentas);

            $data[] = ($ventaMes[0]->suma) ? round($ventaMes[0]->suma, 2) : 0;

            $response = [
                'venta' => [
                    'labels' => $meses,
                    'data' => $data,
                    'anio' => $year,
                ],
            ];
        }
        echo json_encode($response);
    }

    public function ventaMensuales($params)
    {

        $inicio = $params['inicio'];
        $fin = $params['fin'];
        $meses = Helper::MESES();

        $inicio = new DateTime($inicio);
        $fin = new DateTime($fin);

        $mesInicio = intval(explode('-', $params['inicio'])[1]);
        $mesFin = intval(explode('-', $params['fin'])[1]);

        $data = [];
        $labels = [];
        $dataTotal = [];
        $dataIva = [];
        $dataSubtotal = [];
        $totalGeneral = 0;
        $ivaGeneral = 0;
        $subtotalGeneral = 0;

        for ($i = $mesInicio; $i <= $mesFin; $i++) {
            $sql = "SELECT SUM(total) as total, SUM(subtotal) as subtotal, SUM(iva) as iva, fecha_venta FROM `ventas` WHERE MONTH(fecha_venta) = ($i) AND estado = 'A'";
            $ventasMes = $this->db->database::select($sql)[0];

            $iva = (isset($ventasMes->iva)) ? (round($ventasMes->iva, 2)) : 0;
            $subtotal = (isset($ventasMes->subtotal)) ? (round($ventasMes->subtotal, 2)) : 0;
            $total = (isset($ventasMes->total)) ? (round($ventasMes->total, 2)) : 0;
            $fecha = (isset($ventasMes->fecha_venta)) ? $ventasMes->fecha_venta : '-';
            $serie = 'Ventas Totales de ' . $meses[$i - 1];

            $aux = [
                'fecha' => $fecha,
                'serie' => $serie,
                'iva' => $iva,
                'subtotal' => $subtotal,
                'total' => $total,
            ];
            $aux2 = [
                'mes' => $meses[$i - 1],
                'data' => $aux,
            ];
            $data[] = $aux2;
            $labels[] = ucfirst($meses[$i - 1]);
            $dataTotal[] = $total;
            $dataIva[] = $iva;
            $dataSubtotal[] = $subtotal;
            $totalGeneral += $total;
            $ivaGeneral += $iva;
            $subtotalGeneral += $subtotal;
        }

        $ivaGeneral = round($ivaGeneral, 2);
        $response = [
            'lista' => $data,
            'totales' => [
                'total' => $totalGeneral,
                'iva' => $ivaGeneral,
                'subtotal' => $subtotalGeneral,
            ],
            'barra' => [
                'labels' => $labels,
                'dataTotal' => $dataTotal,
                'dataSubtotal' => $dataSubtotal,
                'dataIva' => $dataIva,
            ],
        ];

        echo json_encode($response);
    }

    public function ventasfrecuentes($params)
    {

        $inicio = $params['inicio'];
        $fin = $params['fin'];
        $limit = intval($params['limit']);

        $ventas = Venta::where('fecha_venta', '>=', $inicio)
            ->where('fecha_venta', '<=', $fin)
            ->where('estado', 'A')
            ->take($limit)->get();

        $productos_id = []; //array principal
        $secundario = [];

        foreach ($ventas as $item) {
            $item->detalle_venta; //array
            foreach ($item->detalle_venta as $detalle) {

                $aux = [
                    'id' => $detalle->producto_id,
                    'cantidad' => $detalle->cantidad,
                ];

                $productos_id[] = (object) $aux;
                $secundario[] = $detalle->producto_id;
            }
        }

        $no_repetidos = array_values(array_unique($secundario));
        $nuevo_array = [];
        $contador = 0;

        //Algoritmo para contar y eliminar los elementos repetidos de un array
        for ($i = 0; $i < count($no_repetidos); $i++) {
            foreach ($productos_id as $item) {
                if ($item->id === $no_repetidos[$i]) {
                    $contador += $item->cantidad;
                }
            }
            $aux = [
                'producto_id' => $no_repetidos[$i],
                'cantidad' => $contador,
            ];

            $contador = 0;
            $nuevo_array[] = (object) $aux;
            $aux = [];
        }

        $array_productos = $this->ordenar_array($nuevo_array);
        $array_productos = Helper::invertir_array($array_productos);

        $array_seudoFinal = [];
        //Recortar segun limite
        if (count($array_productos) < $limit) {
            $array_seudoFinal = $array_productos;
        } else
        if (count($array_productos) == $limit) {
            $array_seudoFinal = $array_productos;
        } else
        if (count($array_productos) > $limit) {
            for ($i = 0; $i < $limit; $i++) {
                $array_seudoFinal[] = $array_productos[$i];
            }
        }

        $arrayFinal = [];
        $total_global = 0;
        $totalParcentaje = 0;

        foreach ($array_seudoFinal as $item) {
            $p = Producto::find($item->producto_id);
            $total = $p->precio_venta * $item->cantidad;
            $total_global += $total;
            $totalParcentaje += $item->cantidad;

            $aux = [
                'producto' => $p,
                'cantidad' => $item->cantidad,
                'total' => $total,
            ];
            $arrayFinal[] = (object) $aux;
        }

        //Armar data de grafico de pastel para cantidad productos mas vendidos
        //Armar la data de grafico pastel por porcentaje
        $masVendidos = [];
        $labels = [];
        $porcentajes = [];

        foreach ($arrayFinal as $item) {

            $labels[] = $item->producto->nombre;
            $masVendidos[] = $item->cantidad;
            $p = round((100 * $item->cantidad) / $totalParcentaje, 2);
            $porcentajes[] = $p;
        }

        $response = [
            'lista' => $arrayFinal,
            'data' => [
                'masVendidos' => [
                    'data' => $masVendidos,
                    'labels' => $labels,
                ],
                'porcentajes' => [
                    'data' => $porcentajes,
                    'labels' => $labels,
                ],
            ],
            'total_general' => $total_global,
        ];

        echo json_encode($response);
    }

    public function ventasFrecuentesv2($params){
        $inicio = $params['inicio'];
        $fin = $params['fin'];
        $limit = intval($params['limit']);

        $ventas = Venta::where('fecha_venta', '>=', $inicio)
            ->where('fecha_venta', '<=', $fin)
            ->where('estado', 'A')
            ->take($limit)->get();


        $productos_id = []; //array principal
        $secundario = [];

        foreach ($ventas as $item) {
            $item->detalle_venta; //array
            foreach ($item->detalle_venta as $detalle) {

                $aux = [
                    'id' => $detalle->producto_id,
                    'cantidad' => $detalle->cantidad,
                ];

                $productos_id[] = (object) $aux;
                $secundario[] = $detalle->producto_id;
            }
        }

        $no_repetidos = array_values(array_unique($secundario));
        $nuevo_array = [];
        $contador = 0;

        //Algoritmo para contar y eliminar los elementos repetidos de un array
        for ($i = 0; $i < count($no_repetidos); $i++) {
            foreach ($productos_id as $item) {
                if ($item->id === $no_repetidos[$i]) {
                    $contador += $item->cantidad;
                }
            }
            $aux = [
                'producto_id' => $no_repetidos[$i],
                'cantidad' => $contador,
            ];

            $contador = 0;
            $nuevo_array[] = (object) $aux;
            $aux = [];
        }

        $array_productos = $this->ordenar_array($nuevo_array);
        $array_productos = Helper::invertir_array($array_productos);

        $array_seudoFinal = [];
        //Recortar segun limite
        if (count($array_productos) < $limit) {
            $array_seudoFinal = $array_productos;
        } else
        if (count($array_productos) == $limit) {
            $array_seudoFinal = $array_productos;
        } else
        if (count($array_productos) > $limit) {
            for ($i = 0; $i < $limit; $i++) {
                $array_seudoFinal[] = $array_productos[$i];
            }
        }

        $arrayFinal = [];   $arrayPercent = [];
        $total_global = 0;  
        $totalParcentaje = 0; $index = 0;

        foreach ($array_seudoFinal as $item) {
            $p = Producto::find($item->producto_id);
            $total = $p->precio_venta * $item->cantidad;
            $total_global += $total;
            $totalParcentaje += $item->cantidad;

            if($index == 0){
                $aux = [
                    'name' => $p->nombre,
                    'y' => $item->cantidad,
                    'sliced' => true,
                    'selected' => true,
                ];
            }else{
                $aux = [
                    'name' => $p->nombre,
                    'y' => $item->cantidad
                ];
            }

            $arrayFinal[] = (object) $aux;
            $index++;
        }

        $index = 0;
        foreach ($array_seudoFinal as $item) {
            $p = Producto::find($item->producto_id);
            $total = $p->precio_venta * $item->cantidad;
            // $total_global += $total;

            $percent = round((100 * $item->cantidad) / $totalParcentaje, 2);

            if($index == 0){
                $aux = [
                    'name' => $p->nombre,
                    'y' => $percent,
                    'sliced' => true,
                    'selected' => true,
                ];
            }else{
                $aux = [
                    'name' => $p->nombre,
                    'y' => $percent
                ];
            }
            $index++;
            $arrayPercent[] = (object) $aux;
        }

        $final = [
            'cantidad' => [
                'lista' => $arrayFinal,
                'total' => $total_global
            ],
            'porcentaje' => [
                'lista' => $arrayPercent
            ]
        ];

        echo json_encode($final);
    } 

    public function ordenar_array($array)
    {
        for ($i = 1; $i < count($array); $i++) {
            for ($j = 0; $j < count($array) - $i; $j++) {
                if ($array[$j]->cantidad > $array[$j + 1]->cantidad) {

                    $k = $array[$j + 1];
                    $array[$j + 1] = $array[$j];
                    $array[$j] = $k;
                }
            }
        }

        return $array;
    }

    public function proyeccion($params)
    {

        $this->cors->corsJson();
        $year = intval($params['year']); //2021
        $tabla = [];
        $response = [];
        $burbuja = [];
        $radio = 5;
        $labels = [];

        $ventas = Venta::whereYear('created_at', $year)->get(); //Obtener todas las ventas anuales
        $fecha_min = $ventas[0]->fecha_venta; //Obtener fecha inicio de ventas
        $fecha_max = $ventas[count($ventas) - 1]->fecha_venta; //Obtener fecha hasta de la última venta

        $date1 = new DateTime($fecha_min); //Parseamos la fecha de inicio en objet Datetime
        $date2 = new DateTime($fecha_max); //Parseamos la fecha de fin en objet Datetime
        $diff = $date1->diff($date2); //Hacer la resta o diferencia de las fechas
        $dias = $diff->days; //Obtener la diferencia en días

        if (count($ventas) > 0) {
            for ($i = 0; $i <= $dias; $i++) { //Recorrer el numero de días
                $sumDay = "+ " . ($i) . " days"; //Armar el string para sumar de (1 días) y contando
                $fc = date("Y-m-d", strtotime($fecha_min . $sumDay)); //Sumar el numero de dias según el contador
                $labels[] = $fc; //Guardar la nueva fecha y guardar en un array
                $ventaDia = Venta::where('fecha_venta', $fc)->get(); //Obtener la venta de la fecha específica - intervalo de fecha inicio y maxima

                if ($ventaDia && count($ventaDia) > 0) { //Validar si existe la venta
                    $cant = 0;
                    $total = 0; //Iniciar las variables
                    foreach ($ventaDia as $vd) { //Recorrer las ventas de la fecha especifica
                        $cant++; //Aumentar la cantidad
                        $total += $vd->total; //Sumar el total de la venta
                    }

                    $total = round($total, 2); //Redondear en dos cifras
                    $auxDia = [ //Armar el array asociativo
                        'fecha' => $fc,
                        'cantidad' => $cant, //x
                        'venta' => $total, //y
                    ];

                    $tabla[] = (object) $auxDia; //Parsear un objeto el array asociativo e insertarlo en un nuevo array
                    $cant = 0;
                    $total = 0; //Resetear las variables
                }
            }

            $it = 1;
            foreach ($tabla as $t) { //Recorrer los datos de todas las ventas
                $auxB = [ //Armar el nuevo objeto
                    'x' => $it,
                    'y' => $t->venta,
                    'r' => $t->cantidad,
                ];

                $it++;
                $burbuja[] = (object) $auxB; //Insertar datos en el array para armar la data
            }

            $full = [];
            $i = 0;
            $sumax2 = 0;
            $sumaxy = 0;
            $sumax = 0;
            $sumay = 0;

            foreach ($tabla as $t) { //Recorrer todas las ventas
                $x2 = pow($t->cantidad, 2); //Elevar x o cantidad al cuadrado
                $xy = round($t->cantidad * $t->venta, 2); //Elevar x*y o la cantidad total de ventas por el numero de dias al cuadrado

                $sumax += $t->cantidad;

                $sumay += $t->venta; //Sumar x --- sumar y -> sumadores
                $sumax2 += $x2;
                $sumaxy += $xy; //sumar x al cuadrado,

                $aux = [ //Armar el array asociativo
                    'venta' => ($i + 1), //x
                    'cantidad' => $t->cantidad, //Cantidad de ventas de ese día
                    'total' => $t->venta, //y
                    'x2' => $x2, // x al cuadrado
                    'xy' => $xy, //x*y
                ];

                $full[] = (object) $aux; //Guardar en un nuevo array

            }
            $n = count($tabla); //Guardar el numero de datos a procesar
            $xPromedio = round(($sumax / $n), 2); //Obtener el promedio de x
            $yPromedio = round(($sumay / $n), 2); //Obtener el promedio de y

            $b = ($sumaxy - ($n * $xPromedio * $yPromedio)) / ($sumax2 - ($n * (pow($xPromedio, 2)))); //Calcular la constante b

            $a = $yPromedio - $b * $xPromedio; //Calcular la constante a -> formula ypromedio - b* xpromedio

            $b = round($b, 2);
            $a = round($a, 2); //Redondear a dos decimales la constantes

            $singo = ($b > 0) ? '+' : '-'; //Obtner el signo de la constante b
            
            //formula y= a+bx  regresion lineal
            //y = a + b(x)   "=> y= total de ventas" "=>x= dias"
            $ecuacion = (string) $a . $singo . $b . '*x'; //Armar la ecuacion en forma de un string

            
            //formula para medir el error en regresion lineal ess el error estandar de estimación

            $r1 = pow($sumay,2);
            $r2 = $a * $sumay;
            $r3 = $b * $sumaxy;
            $r4 = $n - 2;

            $syx = ($r1 - ($r2) - ($r3)) / ($r4); //formula para medir el error

            $ss = sqrt($syx); //raiz cuadrado de la formula
            
            $s = (round($ss,4));  //redondea en 4 decimal
            
            //var_dump($s); die();
            //echo json_encode($ecuacion); die();

            $response = [
                'status' => true,
                'tabla' => $tabla,
                'burbuja' => [
                    'data' => $burbuja,
                    'labels' => $labels,
                ],
                'data' => [
                    'tabla' => $full,
                    'promedio' => [
                        'x' => $xPromedio,
                        'y' => $yPromedio,
                    ],
                    'sumatoria' => [
                        'sumax2' => $sumax2,
                        'sumaxy' => $sumaxy,
                    ],
                    'constantes' => [
                        'b' => $b,
                        'a' => $a,
                    ],
                    'signo' => $singo,
                    'ecuacion' => $ecuacion,
                    'error' => $s
                ],
            ];
        } else {
            $response = [
                'status' => false,
                'tabla' => [],
                'burbuja' => false,
            ];
        }

        echo json_encode($response);
    }

    public function actualizarPrecioVentaMargen(Request $request)
    {
        $this->cors->corsJson();
        $response = [];
        $datos = $request->input('datos');

        if ($datos) {

            $productos_id = intval($datos->producto_id);
            $precio_venta = doubleval($datos->precio_venta);
            $margen = doubleval($datos->margen);

            $producto = Producto::find($productos_id);
            $producto->precio_venta = $precio_venta;
            $producto->margen = $margen;

            if ($producto->save()) {
                $response = [
                    'status' => true,
                    'mensaje' => 'Se ah actualizado el precio de venta y el margen',
                    'datos' => $producto,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar',
                    'datos' => null,
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'no hay datos para procesar',
                'datos' => null,
            ];
        }
        echo json_encode($response);

    }
}
