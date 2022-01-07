<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'models/rolModel.php';

class RolController
{

    private $cors;

    public function __construct()
    {
        $this->cors = new Cors();
    }

    public function listar()
    {
        $this->cors->corsJson();
        $roles = Rol::where('estado', 'A')->orderBy('cargo')->get();
        $response = [];

        if ($roles) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen cargos',
                'rol' => $roles,
            ];
        } else {
            $response = [
                'status' => false,
                'cargo' => null,
                'mensaje' => 'No existen cargos',
            ];
        }
        echo json_encode($response);
    }

    public function buscar($params){
        $this->cors->corsJson();
        $id = intval($params['id']);
        $roles = Rol::find($id);
        $response = [];

        if($roles){
        $response = [
            'status' => true,
            'mensaje' => 'Existen datos',
            'rol' => $roles
         ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'rol' => null
             ];
        }
        echo json_encode($response);
    }

    public function guardar(Request $request){
        $this->cors->corsJson();
        $rol = $request->input("rol");
        $cargo = ucfirst($rol->cargo);

        $response = [];

        if($rol){
            $existeRol = Rol::where('cargo',$cargo)->get()->first();

            if($existeRol){
                $response = [
                    'status' => false,
                    'mensaje' => 'El rol ya se encuentra registrado',
                    'rol' => null,
                ];
            }else{
                $nuevoRol = new Rol();
                $nuevoRol->cargo = $cargo;
                $nuevoRol->estado = 'A';

                if($nuevoRol->save()){
                    $response = [
                        'status' => true,
                        'mensaje' => 'El rol se ha guardado correctamente',
                        'rol' => $nuevoRol,
                    ];
                }else{
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se puede guardar el rol',
                        'rol' => null,
                    ];
                }
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'rol' => null,
            ];
        }
        echo json_encode($response);
    }
    
    public function datatable()
    {
        $this->cors->corsJson();
        $roles = Rol::where('estado', 'A')->orderBy('cargo')->get();
        $data = [];       $i = 1;
        foreach ($roles as $r) {

            $botones = '<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="editar_rol(' . $r->id . ')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="eliminar_rol(' . $r->id . ')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $r->cargo,
                2 => $botones,
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

    public function editar(Request $request){
        $this->cors->corsJson();
        $requestRol = $request->input('rol');
        $id = intval($requestRol->id);
        $cargo = ucfirst($requestRol->cargo);

        $response = [];
        $roles = Rol::find($id);

        if($requestRol){
            if($roles){
                $roles->cargo = $cargo;
                $roles->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha actualizado el rol',
                    'rol' => $roles
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'No se ha actualizado el rol',
                    'rol' => null
                ];
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar'
            ];
        }
        echo json_encode($response);
    }

    public function eliminar(Request $request){
        $this->cors->corsJson();
        $requestRol = $request->input('rol');
        $id = intval($requestRol->id);
        $response = [];
        $roles = Rol::find($id);

        if($roles){
            $roles->estado = 'I';
            $roles->save();
            
            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado el rol',
                'rol' => $roles             
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No se ha eliminado el rol',
                'rol' => null             
            ];
        }
        echo json_encode($response);

    }
}