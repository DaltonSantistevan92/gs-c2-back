<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'core/params.php';
require_once 'models/productoModel.php';
require_once 'models/categoriaModel.php';
require_once 'models/codigosModel.php';


class ProductoController
{

    private $cors;
    private $conexion;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();
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
                'codigo' => 'P0001'
            ];
        } else {
            $numero = substr($registro->codigo,1);
            $siguiente = 'P000' . ($numero += 1);
            
            $response = [
                'status' => true,
                'tipo' => $tipo,
                'mensaje' => 'Existen datos,aumentando registro producto',
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

    public function listarxID($params){
        $this->cors->corsJson();
        $id = intval($params['id']);
        $productos = Producto::find($id);
        $response = [];

        if($productos){
            $productos->categoria;   
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'producto' => $productos
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'producto' => null
             ];
        }
        echo json_encode($response);
    }
    
    public function buscarProducto($params)
    {
        $this->cors->corsJson();
        $texto = ucfirst($params['texto']);
        $response = [];

        $sql = "SELECT pr.id,pr.codigo,pr.nombre,pr.stock,pr.precio_compra,pr.precio_venta FROM productos pr
        WHERE pr.estado = 'A' AND (pr.codigo LIKE '$texto%' OR pr.nombre LIKE '%$texto%')";

        $array = $this->conexion->database::select($sql);

        if ($array) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'productos' => $array,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existen coincidencias',
                'productos' => null,
            ];
        }
        echo json_encode($response);
    }

    public function listar()
    {
        $this->cors->corsJson();
        $productos = Producto::where('estado', 'A')->orderBy('nombre')->get();
        $response = [];
        foreach ($productos as $p) {
            $response[] = [
                'producto' => $p,
                'categoria_id' => $p->categoria->id,
            ];
        }
        echo json_encode($productos);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $producto = $request->input("producto");
        $response = [];

        if ($producto) {
            $producto->nombre = ucfirst($producto->nombre);

            $buscar = Producto::where('codigo', $producto->codigo)->get()->first();
            $existeNombre = Producto::where('nombre', $producto->nombre)->get()->first();

            if ($buscar) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El código del producto ya existe',
                    'producto' => null,
                ];
            } else
            if ($existeNombre){
                $response = [
                    'status' => false,
                    'mensaje' => 'El nombre del producto ya existe',
                    'producto' => null,
                ];
            } else {
                $nuevo = new Producto;
                $nuevo->categoria_id = $producto->categoria_id;
                $nuevo->codigo = $producto->codigo;
                $nuevo->nombre = $producto->nombre;
                $nuevo->img = $producto->img;
                $nuevo->descripcion = $producto->descripcion;
                $nuevo->precio_compra = 0.00;
                $nuevo->stock = 0;
                $nuevo->precio_venta = 0.00;
                $nuevo->margen = 0.00;
                $nuevo->fecha = date('Y-m-d');
                $nuevo->estado = 'A';

                if ($nuevo->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'Producto guardado',
                        'producto' => $nuevo,
                    ];
                } else {
                    $response = [
                        'status' => true,
                        'mensaje' => 'No se pudo guardar, intente nuevamente',
                        'producto' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'producto' => null,
            ];
        }

        echo json_encode($response);
    }

    public function subirFichero($file)
    {
        $this->cors->corsJson();
        $target_path = "resources/productos/";

        $imagen = $file['fichero'];
        $target_path = $target_path . basename($imagen['name']);

        $enlace_actual = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
        $enlace_actual = str_replace('index.php', '', $enlace_actual);

        $response = [];

        if (move_uploaded_file($imagen['tmp_name'], $target_path)) {
            $response = [
                'status' => true,
                'mensaje' => 'Fichero subido',
                'imagen' => $imagen['name'],
                'direccion' => $enlace_actual . '/' . $target_path,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se pudo guardar el fichero',
                'imagen' => null,
                'direccion' => null,
            ];
        }

        echo json_encode($response);
    }

    public function dataTable()
    {
        $this->cors->corsJson();
        $productos = Producto::where('estado', 'A')->orderBy('nombre')->get();
        $data = [];    $i = 1;

        foreach ($productos as $p) {
            $url = BASE . 'resources/productos/' . $p->img;
            $estado = $p->estado == 'A' ? '<span class="badge bg-success">Activado</span>' : '<span class="badge bg-danger">Desactivado</span>';
           /*  $icono = $p->estado == 'I' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-trash"></i>';
            $clase = $p->estado == 'I' ? 'btn-success btn-sm' : 'btn-danger btn-sm'; */

            $botones = '<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="editar_producto(' . $p->id . ')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="eliminar_producto(' . $p->id . ')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';

            $span = "";
            /* si el stock es menor a 6 su color es rojo */
            if ($p->stock < 6) {
                $span = '<span class="badge bg-danger" style="font-size: 1.2rem;">' . $p->stock . '</span>';
            } else
            if ($p->stock >= 6 && $p->stock < 11) {
                /* si el stock es mayor a 6 y menor a 11 color es amarillo */
                $span = '<span class="badge bg-warning" style="font-size: 1.2rem;">' . $p->stock . '</span>';
            } else {
                /* si el stock es mayor 11 es verde */
                $span = '<span class="badge bg-success" style="font-size: 1.2rem;">' . $p->stock . '</span>';
            }

            $data[] = [
                0 => $i,
                1 => '<div class="box-img-producto"><img src=' . "$url" . '></div>',
                2 => $p->codigo,
                3 => $p->nombre,
                4 => $p->categoria->categoria,
                5 => number_format($p->precio_compra,2,'.',''),
                6 => number_format($p->precio_venta,2,'.',''),
                7 => $span,
                8 => $estado,
                9 => $botones,
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

    public function contar(){
        $this->cors->corsJson();
        $producto = Producto::where('estado','A')->get();
        $response = [];

        if($producto){
            $response = [
                'status'  => true,
                'mensaje' => 'Existen datos',
                'Modelo' => 'producto',
                'cantidad' => $producto->count()
            ];
        }else{
            $response = [
                'status'  => false,
                'mensaje' => 'No existen datos',
                'Modelo' => 'producto',
                'cantidad' => 0
            ];
        }
        echo json_encode($response);
    }

    public function eliminar(Request $request){
        $this->cors->corsJson();
        $requestProducto = $request->input('producto');
        $id = intval($requestProducto->id);
        $response = [];
        $productos = Producto::find($id);

        if($productos){
            $productos->estado = 'I';
            $productos->save();
            
            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado el producto',
                'producto' => $productos             
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No se ha eliminado el producto',
                'producto' => null             
            ];
        }
        echo json_encode($response);

    }

    public function editar(Request $request){
        $this->cors->corsJson();
        $requestProducto = $request->input('producto');
        $id = intval($requestProducto->id);
        $categoria_id  = intval($requestProducto->categoria_id);
        $nombre = ucfirst($requestProducto->nombre);

        $response = [];
        $productos = Producto::find($id);

        if($requestProducto){
            if($productos){
                $productos->categoria_id = $categoria_id;
                $productos->nombre = $nombre;
                $productos->precio_venta = $requestProducto->precio_venta;
                $productos->descripcion = $requestProducto->descripcion;

                $productoMargen = Producto::find($id);
                $productoMargen->margen = $requestProducto->precio_venta - $productoMargen->precio_compra;
                $productoMargen->save();
                $productos->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha actualizado el producto',
                    'producto' => $productos
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'No se ha actualizado el producto',
                    'producto' => null
                ];
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos'
            ];
        }
        echo json_encode($response);
    }



}
