<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'core/params.php';
require_once 'app/error.php';
require_once 'models/proveedorModel.php';

class ProveedorController
{

    private $cors;
    private $conexion;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();
    }

    public function buscar($params)
    {
        $this->cors->corsJson();
        $id = intval($params['id']);
        $proveedor = Proveedor::find($id);
        $response = [];

        if ($proveedor) {
            $response = [
                'status' => true,
                'proveedor' => $proveedor,
                'persona' => $proveedor->persona,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se encuentra el proveedor',
                'proveedor' => null,
                'persona' => null,
            ];         
        }
        echo json_encode($response);
    }

    public function listar()
    {
        $this->cors->corsJson();
        $proveedores = Proveedor::where('estado', 'A')
            ->orderBy('razon_social')->get();

        echo json_encode($proveedores);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $prov = $request->input('proveedor');
        $response = [];

        if ($prov) {
            $existe = Proveedor::where('ruc', $prov->ruc)->get()->first();

            if ($existe) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El proveedor ya se encuetra registrado',
                    'proveedor' => $existe,
                ];
            } else {
                $proveedor = new Proveedor;
                $proveedor->ruc = $prov->ruc;
                $proveedor->razon_social = $prov->razon_social;
                $proveedor->direccion = $prov->direccion;
                $proveedor->correo = $prov->correo;
                $proveedor->fecha = date('Y-m-d');
                $proveedor->telefono = $prov->telefono;
                $proveedor->estado = 'A';

                if ($proveedor->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'Se ha registrado un nuevo proveedor',
                        'proveedor' => $proveedor,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se pudo guardar, intente nuevamente',
                        'proveedor' => null,
                    ];
                }
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'proveedor' => null,
            ];
        }

        echo json_encode($response);
    }

    public function datatable()
    {
        $this->cors->corsJson();
        $proveedores = Proveedor::where('estado', 'A')->orderBy('razon_social')->get();

        $data = [];
        $i = 1;
        foreach ($proveedores as $pr) {

            $botones = '<div class="btn-group">
                            <button class="btn btn-warning btn-sm" onclick="editar_proveedor(' . $pr->id . ')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btm-sm" onclick="eliminar_proveedor(' . $pr->id . ')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $pr->ruc,
                2 => $pr->razon_social,
                3 => $pr->correo,
                4 => $pr->telefono,
                5 => $pr->direccion,
                6 => $botones,
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

    public function search($params)
    {
        $this->cors->corsJson();

        $texto = strtolower($params['texto']);
        $proveedores = Proveedor::where('razon_social', 'like', $texto . '%')
            ->where('estado', 'A')->get();
        $response = [];

        if ($texto == "") {
            $response = [
                'status' => true,
                'mensaje' => 'Todos los registros',
                'proveedores' => $proveedores,
            ];
        } else {
            if (count($proveedores) > 0) {
                $response = [
                    'status' => true,
                    'mensaje' => 'Coincidencias encontradas',
                    'proveedores' => $proveedores,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No hay registros',
                    'proveedores' => null,
                ];
            }
        }
        echo json_encode($response);
    }

    public function contar()
    {
        $this->cors->corsJson();
        $proveedores = Proveedor::where('estado', 'A')->get();
        $response = [];

        if ($proveedores) {
            $response = [
                'status'  => true,
                'mensaje' => 'Existen datos',
                'Modelo' => 'proveedores',
                'cantidad' => $proveedores->count()
            ];
        } else {
            $response = [
                'status'  => false,
                'mensaje' => 'No existen datos',
                'Modelo' => 'proveedores',
                'cantidad' => 0
            ];
        }
        echo json_encode($response);
    }

    public function eliminar(Request $request)
    {
        $this->cors->corsJson();
        $proveedorRequest = $request->input('proveedor');
        $id = intval($proveedorRequest->id);
        $proveedor = Proveedor::find($id);
        $response = [];

        if ($proveedor) {
            $proveedor->estado = 'I';
            $proveedor->save();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado el proveedor',
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No se ha podido eliminar el proveedor',
            ];
        }
        echo json_encode($response);
    }

    public function editar(Request $request)
    {
        $this->cors->corsJson();
        $provRequest = $request->input('proveedor');
        $id = intval($provRequest->id);
        $razon_social  = $provRequest->razon_social;
        $direccion = $provRequest->direccion;
        $correo   = $provRequest->correo;
        $telefono = $provRequest->telefono;

        $response = [];
        $proveedor = Proveedor::find($id);

        if ($provRequest) {
            if ($proveedor) {
                $proveedor->razon_social = $razon_social;
                $proveedor->direccion = $direccion;
                $proveedor->correo = $correo;
                $proveedor->telefono = $telefono;
                $proveedor->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'El proveedor se ha actualizado',
                    'data' => $proveedor,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el proveedor',
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

    public function buscarProveedor($params){
        $this->cors->corsJson();
        $texto = strtolower($params['texto']);
        $proveedores = Proveedor::where('ruc', 'like', $texto . '%')
                        ->orWhere('razon_social', 'like', $texto . '%')
                        ->where('estado', 'A')->get();
        $response = [];

        if ($texto == "") {
            $response = [
                'status' => true,
                'mensaje' => 'Todos los registros',
                'proveedores' => $proveedores,
            ];
        } else {
            if (count($proveedores) > 0) {
                $response = [
                    'status' => true,
                    'mensaje' => 'Coincidencias encontradas',
                    'proveedores' => $proveedores,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No hay registros',
                    'proveedores' => null,
                ];
            }
        }
        echo json_encode($response);
    }
}
