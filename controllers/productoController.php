<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'core/params.php';
require_once 'models/productoModel.php';
require_once 'models/categoriaModel.php';

class ProductoController
{

    private $cors;
    private $conexion;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();
    }

    public function buscarProducto($params)
    {
        $this->cors->corsJson();
        $texto = ucfirst($params['texto']);
        $response = [];

        $sql = "SELECT pr.id,pr.codigo,pr.nombre,pr.stock,pr.precio_venta FROM productos pr
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

            if ($buscar) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El código del producto ya existe',
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
                $nuevo->precio_venta = $producto->precio_venta;
                $nuevo->margen = $producto->precio_venta;
                $nuevo->fecha = $producto->fecha;
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
        $productos = Producto::where('estado', 'A')->orWhere('estado', 'I')->orderBy('nombre')->get();
        $data = [];    $i = 1;

        foreach ($productos as $p) {
            $url = BASE . 'resources/productos/' . $p->img;
            $estado = $p->estado == 'A' ? '<span class="badge bg-success">Activado</span>' : '<span class="badge bg-danger">Desactivado</span>';
            $icono = $p->estado == 'I' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-trash"></i>';
            $clase = $p->estado == 'I' ? 'btn-success btn-sm' : 'btn-danger btn-sm';
            $other = $p->estado == 'A' ? 0 : 1;

            $botones = '<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="editar_producto(' . $p->id . ')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn ' . $clase . '" onclick="eliminar(' . $p->id . ',' . $other . ')">
                                ' . $icono . '
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
                5 => $p->precio_venta,
                6 => $span,
                7 => $estado,
                8 => $botones,
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



}
