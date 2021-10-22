<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'models/categoriaModel.php';
require_once 'models/productoModel.php'; 


class CategoriaController
{

    private $cors;
    private $db;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->db = new Conexion();
    }

    public function buscar_producto($params){
        $this->cors->corsJson();
        $categoria_id = intval($params['id']);

        $categoria = Categoria::find($categoria_id);
        $categoria->producto;
    
        echo json_encode($categoria);

    }

    public function buscar($params){
        $this->cors->corsJson();
        $id = intval($params['id']);
        $categoria = Categoria::find($id);
        if($categoria){
            $response = [
                'status' => true,
                'mensaje' =>'Existen datos',
                'categoria' => $categoria
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' =>'No existen datos',
                'categoria' => null
            ];
        } 
        echo json_encode($response);
    }

    public function listar()
    {
        $this->cors->corsJson();
        $categorias = Categoria::where('estado', 'A')
            ->orderBy('categoria')
            ->get();
        $response = [];

        if (count($categorias) > 0) {
            $response = $categorias;
        }

        echo json_encode($response);
    }

    public function datatable()
    {
        $this->cors->corsJson();
        $categorias = Categoria::where('estado', 'A')->orderBy('categoria')->get();
        $data = [];       $i = 1;
        foreach ($categorias as $ca) {

            $botonVer = '<div class="text-center">
                            <button class="btn btn-primary btn-sm" onclick="ver_producto(' . $ca->id . ')">
                                <i class="fas fa-eye"  ></i>
                            </button>
                        </div>';

            $botones = '<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="editar_categoria(' . $ca->id . ')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="eliminar(' . $ca->id . ')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $ca->categoria,
                2 => $botonVer,
                3 => $ca->fecha,
                4 => $botones,
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

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $cat = $request->input("categoria");

        $nombre = ucfirst($cat->nombre);
        $response = [];

        if ($cat) {
            $nuevo = new Categoria; 
            $existe = Categoria::where('categoria', $nombre)->get()->first();

            if ($existe) {
                $response = [
                    'status' => false,
                    'mensaje' => 'La categoría ya existe',
                    'categoria' => null,
                ];
            } else {
                $nuevo->categoria = $nombre;
                $nuevo->fecha = date('Y-m-d');
                $nuevo->estado = 'A';

                if ($nuevo->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'Guardando los datos',
                        'categoria' => $nuevo,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se pudo guardar categoria, intente nuevamente',
                        'categoria' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'categoria' => null,
            ];
        }

        echo json_encode($response);
    }

    public function eliminar($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);

        $categoria = Categoria::find($id);
        $response = [];

        if ($categoria) {
            $categoria->estado = 'I';
            $categoria->save();

            $response = [
                'status' => true,
                'mensaje' => 'La categoría ha sido Eliminada',
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'La categoría no existe',
            ];
        }

        echo json_encode($response);
    }

    public function contar(){
        $this->cors->corsJson();
        $categorias = Categoria::where('estado','A')->get();
        $response = [];

        if($categorias){
            $response = [
                'status'  => true,
                'mensaje' => 'Existen datos',
                'Modelo' => 'categorias',
                'cantidad' => $categorias->count()
            ];
        }else{
            $response = [
                'status'  => false,
                'mensaje' => 'No existen datos',
                'Modelo' => 'categoria',
                'cantidad' => 0
            ];
        }
        echo json_encode($response);
    }

    public function editar(Request $request)
    {
        $this->cors->corsJson();
        $cateRequest = $request->input('categoria');
        $id = intval($cateRequest->id);
        $categoria  = $cateRequest->categoria;
        $response = [];
        $cate = Categoria::find($id);

        if ($cateRequest) {
            if ($cate) {
                $cate->categoria = $categoria;  
                $cate->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'La categoria se ha actualizado',
                    'data' => $cate,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar la categoria',
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos...!!'
            ];
        }
        echo json_encode($response);
    }



}
