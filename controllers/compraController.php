<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'app/helper.php';
require_once 'core/conexion.php';
require_once 'controllers/detallecompraController.php';
require_once 'models/compraModel.php';
require_once 'models/codigosModel.php';


class CompraController
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
        $registro = Codigo::where('tipo',$tipo)->orderBy('id','DESC')->first();
        $response = [];

        if ($registro == null) {
            $response = [
                'status' => true,
                'tipo' => $tipo,
                'mensaje' => 'Primer registro',
                'codigo' => '0001'
            ];
        } else {
            $numero = intval($registro->codigo);
            $siguiente = '000' . ($numero += 1);
            $response = [
                'status' => true,
                'tipo' => $tipo,
                'mensaje' => 'Existen datos, aumentando registro compra',
                'codigo' => $siguiente
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
                'mensaje' => 'no ahi datos'
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
                'codigo' => $nuevo
            ];
        }
        echo json_encode($response);
    }

    public function listar()
    {
        $this->cors->corsJson();
        $compras = Compra::where('estado', 'A')->get();
        $response = [];

        foreach ($compras as $item) {
            $aux = [
                'compras' => $item,
                'proveedor_id' => $item->proveedor->id,
                'usuario_id' => $item->usuario->id,

            ];
            $response[] = $aux;
        }

        echo json_encode($response);
    }

    public function buscar($params)
    {

        $this->cors->corsJson();
        $idcompra = intval($params['id']);
        $buscar = Compra::find($idcompra);
        $response = [];

        if ($buscar) {

            foreach ($buscar->detalle_compra as $subbuscar) {
                $subbuscar->producto;
            }

            $response = [
                'status' => true,
                'mensaje' => 'Existe',
                'compra' => $buscar,
                'proveedor_id' => $buscar->proveedor->id,
                'usuario_id' => $buscar->usuario->id,
                'usuario_persona' => $buscar->usuario->persona->id,
                'detalle_compra_id' => $buscar->detalle_compra,

            ];

        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No esiste la compra',
                'compra' => null,
            ];
        }

        echo json_encode($response);

    }

    public function guardar(Request $request)
    {

        $this->cors->corsJson();
        $datacompra = $request->input("compra");
        $detalles_compras = $request->input("detalle_compras");

        $serie_documento = $datacompra->serie_documento;

        $response = [];

        if ($datacompra) {
            $datacompra->proveedor_id = intval($datacompra->proveedor_id);
            $datacompra->usuario_id = intval($datacompra->usuario_id);
            $datacompra->serie_documento = $datacompra->serie_documento;
            $datacompra->descuento = floatval($datacompra->descuento);
            $datacompra->sub_total = floatval($datacompra->sub_total);
            $datacompra->iva = floatval($datacompra->iva);
            $datacompra->total = floatval($datacompra->total);

            //Empieza
            $nuevo = new compra();
            $nuevo->proveedor_id = $datacompra->proveedor_id;
            $nuevo->usuario_id = $datacompra->usuario_id;
            $nuevo->serie_documento = $datacompra->serie_documento;
            $nuevo->descuento = $datacompra->descuento;
            $nuevo->sub_total = $datacompra->sub_total;
            $nuevo->iva = $datacompra->iva;
            $nuevo->total = $datacompra->total;
            $nuevo->estado = 'A';
            $nuevo->fecha_compra = date('Y-m-d');

            $existe = Compra::where('serie_documento', $serie_documento)->get()->first();

            if ($existe) {
                $response = [
                    'status' => false,
                    'mensaje' => 'La compra ya existe',
                    'compra' => null,
                    'detalle' => null,
                ];
            } else {
                if ($nuevo->save()) {

                    //Guardar detalle de compras
                    $detalleController = new DetalleCompraController();
                    $extra = $detalleController->guardar($nuevo->id, $detalles_compras);

                    $response = [
                        'status' => true,
                        'mensaje' => 'Guardando los datos',
                        'compra' => $nuevo,
                        'detalle' => $extra,
                    ];

                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se pudo guardar, intente nuevamente',
                        'compra' => null,
                        'detalle' => null,
                    ];
                }
            }

        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'compra' => null,
                'detalle' => null,
            ];}

        echo json_encode($response);
    }
 
    public function datatable() 
    {
        $this->cors->corsJson();
        $compras = Compra::where('estado', 'A')
            ->orderBy('id', 'DESC')->get();

        $data = [];
        $i = 1;

        foreach ($compras as $com) {

            $botones = '<div class="text-center">
                <button class="btn btn-sm btn-primary" onclick="ver_factura(' . $com->id . ')">
                    <i class="fas fa-clipboard-list"></i>
                </button>
            </div>';

            $data[] = [
                0 => $i,
                1 => $com->serie_documento,
                2 => $com->proveedor->razon_social,
                3 => number_format($com->total,2,'.',''),
                4 => $com->fecha_compra,
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

        $compras = Compra::where('estado', 'A')
            ->where('fecha_compra', '>=', $inicio_mes)
            ->where('fecha_compra', '<=', $hoy)
            ->get();

        $response = [];
        $total = 0;

        if ($compras) {
            foreach ($compras as $c) {
                $aux = $total += $c->total;
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
                'mensaje' => 'No existen datos',
                'total' => 0,
                'mes' => $meses[$posMes],
            ];
        }
        echo json_encode($response);
    }

    public function grafica_compra(){
        $this->cors->corsJson();
        $year = date('Y');

        $meses = [
            'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'
        ];
        $data = []; 

         //Obtener total de compras
         for($i = 0; $i < count($meses); $i++){
            $sqlCompras = "SELECT SUM(total ) as suma FROM `compras` WHERE MONTH(fecha_compra ) = ($i + 1) AND estado = 'A'";
            
            $comprasMes = $this->db->database::select($sqlCompras);
    
           $data[] = ($comprasMes[0]->suma) ? round($comprasMes[0]->suma, 2) : 0;
           
           $response = [
               'compra' => [
                   'labels' => $meses,
                   'data' => $data
               ]
           ];
        }
        echo json_encode($response);

    }

    function compraMensuales($params){

        $inicio = $params['inicio'];
        $fin = $params['fin'];
        $meses = Helper::MESES(); 

        $inicio  = new DateTime($inicio);
        $fin = new DateTime($fin);

        $mesInicio = intval(explode('-',$params['inicio'])[1]);
        $mesFin = intval(explode('-',$params['fin'])[1]);

        $data = []; $labels = [];   $dataTotal = [];    $dataIva = [];  $dataSubtotal = [];
        $totalGeneral = 0;  $ivaGeneral = 0;    $subtotalGeneral = 0;
       
        for($i = $mesInicio; $i <= $mesFin; $i++){
            $sql = "SELECT SUM(total) as total, SUM(sub_total) as subtotal, SUM(iva) as iva, fecha_compra FROM `compras` WHERE MONTH(fecha_compra) = ($i) AND estado = 'A'";
            $comprasMes = $this->db->database::select($sql)[0];
            
            $iva = (isset($comprasMes->iva)) ? (round($comprasMes->iva,2)) : 0;
            $subtotal = (isset($comprasMes->subtotal)) ? (round($comprasMes->subtotal, 2)) : 0;
            $total = (isset($comprasMes->total)) ? (round($comprasMes->total, 2)) : 0;
            $fecha = (isset($comprasMes->fecha_compra)) ? $comprasMes->fecha_compra: '-'; 
            $serie = 'Compras Totales de '.$meses[$i-1];

            $aux = [
                'fecha' => $fecha,
                'serie' => $serie,
                'iva' => $iva,
                'subtotal' => $subtotal,
                'total' => $total
            ];
            $aux2 = [
                'mes' => $meses[$i],
                'data' => $aux
            ];
            $data[] = $aux2;
            $labels[] = ucfirst($meses[$i-1]);
            $dataTotal[] = $total;
            $dataIva[] = $iva;
            $dataSubtotal[] = $subtotal;
            $totalGeneral += $total;
            $ivaGeneral += $iva;
            $subtotalGeneral += $subtotal;
        }

        $ivaGeneral= round($ivaGeneral,2);
        $response = [
            'lista' => $data,
            'totales' => [
                'total' => $totalGeneral,
                'iva' => $ivaGeneral,
                'subtotal' => $subtotalGeneral
            ],
            'barra' => [
                'labels' => $labels,
                'dataTotal' => $dataTotal,
                'dataSubtotal' => $dataSubtotal,
                'dataIva' => $dataIva
            ],
        ];

        echo json_encode($response);
    }

    public function proyeccion($params){

        $this->cors->corsJson();
        $year = intval($params['year']);
        $tabla = [];    $response = [];     $burbuja = [];  $radio = 5; $labels = [];
        
        $ventas = Compra::whereYear('created_at',$year)->get();      //Obtener todas las ventas anuales
        $fecha_min = $ventas[0]->fecha_compra;                       //Obtener fecha inicio de ventas
        $fecha_max = $ventas[count($ventas) - 1]->fecha_compra;      //Obtener fecha de la última venta

        $date1 = new DateTime($fecha_min);                          //Parseamos la fecha de inicio en objet Datetime
        $date2 = new DateTime($fecha_max);                          //Parseamos la fecha de fin en objet Datetime
        $diff = $date1->diff($date2);                               //Hacer la resta o diferencia de las fechas
        $dias = $diff->days;                                        //Obtener la diferencia en días

        if(count($ventas) > 0){
           for($i = 0; $i <= $dias; $i++){                          //Recorrer el numero de días
            $sumDay = "+ ".($i)." days";                            //Armar el string para sumar de (1 días) y contando
            $fc = date("Y-m-d",strtotime($fecha_min.$sumDay));      //Sumar el numero de dias según el contador
            $labels[] = $fc;                                        //Guardar la nueva fecha y guardar en un array
            
            $ventaDia = Compra::where('fecha_compra', $fc)->get();    //Obtener la venta de la fecha específica - intervalo de fecha inicio y maxima
            
            if($ventaDia && count($ventaDia) > 0){                  //Validar si existe la venta
                $cant = 0;  $total = 0;                             //Iniciar las variables
                foreach($ventaDia as $vd){                          //Recorrer las ventas de la fecha especifica
                    $cant++;                                        //Aumentar la cantidad 
                    $total += $vd->total;                           //Sumar el total de la venta
                }
                
                $total = round($total, 2);                          //Redondear en dos cifras
                $auxDia = [                                         //Armar el array asociativo
                    'fecha' => $fc,
                    'cantidad' => $cant,    //x
                    'venta' => $total       //y
                ];

                $tabla[] = (object)$auxDia;                         //Parsear un objeto el array asociativo e insertarlo en un nuevo array
                $cant = 0;  $total = 0;                             //Resetear las variables
            }
           }

           $it = 1;
           foreach($tabla as $t){                                   //Recorrer los datos de todas las ventas
                $auxB = [                                           //Armar el nuevo objeto
                    'x' => $it,
                    'y' => $t->venta,
                    'r' => $t->cantidad
                ];

                $it++;
                $burbuja[] = (object)$auxB;                         //Insertar datos en el array para armar la data
           }

           $full = [];  $i = 0; $sumax2 = 0;    $sumaxy = 0;    $sumax = 0; $sumay = 0;

           foreach($tabla as $t){                                   //Recorrer todas las ventas
                $x2 = pow($t->cantidad, 2);                         //Elevar x o cantidad al cuadrado
                $xy = round($t->cantidad * $t->venta, 2);           //Elevar x*y o la cantidad total de ventas por el numero de dias al cuadrado

                $sumax += $t->cantidad;     $sumay += $t->venta;    //Sumar x --- sumar y -> sumadores
                $sumax2 += $x2;     $sumaxy += $xy;                 //sumar x al cuadrado, 

                $aux = [                                            //Armar el array asociativo 
                    'venta' => ($i + 1),                            //x
                    'cantidad' => $t->cantidad,                     //Cantidad de ventas de ese día
                    'total' => $t->venta,                           //y
                    'x2' => $x2,                                    // x al cuadrado
                    'xy' => $xy                                     //x*y
                ];

                $full[] = (object)$aux;                             //Guardar en un nuevo array
           }
           $n = count($tabla);                                      //Guardar el numero de datos a procesar

           $xPromedio = round(($sumax / $n),2);                     //Obtener el promedio de x
           $yPromedio = round(($sumay / $n),2);                     //Obtener el promedio de y

           $b = ($sumaxy - $n*$xPromedio*$yPromedio) / ($sumax2 - $n*(pow($xPromedio,2)));  //Calcular la constante b
           $a = $yPromedio - $b*$xPromedio;                         //Calcular la constante a -> formula ypromedio - b* xpromedio
           
           $b = round($b,2);    $a = round($a,2);                   //Redondear a dos decimales la constantes
           $singo = ($b > 0) ? '+' : '-';                           //Obtner el signo de la constante b
           $ecuacion = (string)$a.$singo.$b.'*x';                   //Armar la ecuacion en forma de un string

           $response = [
               'status' => true,
               'tabla' => $tabla,
               'burbuja' => [
                   'data' => $burbuja,
                   'labels' => $labels
               ],
               'data' => [
                   'tabla' => $full,
                   'promedio' => [
                       'x' => $xPromedio,
                       'y' => $yPromedio
                   ],
                   'sumatoria' => [
                       'sumax2' => $sumax2,
                       'sumaxy' => $sumaxy
                   ],
                   'constantes' => [
                       'b' => $b,
                       'a' => $a
                   ],
                   'signo' => $singo,
                   'ecuacion' => $ecuacion
               ]
           ];
        }else{
            $response = [
                'status' => false,
                'tabla' => [],
                'burbuja' => false
            ];
        }

        echo json_encode($response);
    }


}