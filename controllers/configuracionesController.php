<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'core/params.php';
require_once 'app/error.php';
require_once 'models/configuracionesModel.php';
require_once 'models/productoModel.php';


class ConfiguracionesController
{

    private $cors;
    private $conexion;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->conexion = new Conexion();
    }

    public function buscar($params){
        $this->cors->corsJson();
        $id = intval($params['id']);
        $config = Configuraciones::find($id);
        $response = [];

        if($config){  
        $response = [
            'status' => true,
            'mensaje' => 'Existen datos',
            'config' => $config
         ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'config' => null
             ];
        }
        echo json_encode($response);
    }

    public function listar()
    {
        $this->cors->corsJson();
        $config = Configuraciones::where('estado', 'A')->get();
        $response = [];

        if (count($config) > 0) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'config' => $config
             ];
        }

        echo json_encode($response);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $config = $request->input('configuraciones');
        $response = [];

        if ($config) {
                $configuraciones = new Configuraciones();
                $configuraciones->porcentaje_ganancia = $config->porcentaje_ganancia;
                $configuraciones->estado = 'A';

                if ($configuraciones->save()) {
                    $response = [
                        'status' => true,
                        'mensaje' => 'Se ha registrado un nuevo porcentaje de ganancia',
                        'configuraciones' => $configuraciones,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se pudo guardar, intente nuevamente',
                        'configuraciones' => null,
                    ];
                }
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'configuraciones' => null,
            ];
        }

        echo json_encode($response);
    }

    public function editar(Request $request){
        $this->cors->corsJson();
        $requestConfig = $request->input('configuraciones');
        $id = intval($requestConfig->id);

        $response = [];
        $config = Configuraciones::find($id);

        if($requestConfig){
            if($config){
                $config->porcentaje_ganancia = $requestConfig->porcentaje_ganancia;
                $config->iva = $requestConfig->iva;
                $config->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha actualizado correctamente',
                    'config' => $config
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'No se ha actualizado',
                    'config' => null
                ];
            }
        }else{
            $response = [
                'status' => false,
                'config' => 'No hay datos'
            ];
        }
        echo json_encode($response);
    }

    public function actualizarPventa(Request $request){
        $this->cors->corsJson();
        $confRequest = $request->input('config');
        $id = intval($confRequest->producto_id);

        $producto = Producto::find($id);
        $response = [];
        if($confRequest){

            if($producto){
                $margen = doubleval($confRequest->margen);
                $precio_venta = doubleval($confRequest->precio_venta);

                $producto->precio_venta = $precio_venta;
                $producto->margen = $margen;
                $producto->save();

                $response = [
                    'status' =>true,
                    'mensaje' => 'Se ha actualizados todos los datos',
                    'conf' => $producto
                ];
            }else{
                $response = [
                    'status' =>false,
                    'mensaje' => 'No se ha actualizados los datos',
                    'conf' => $producto
                ];

            }
        }else{
            $response = [
                'status' =>false,
                'mensaje' => 'no hay datos para procesar',
                'conf' => null
            ];
        }
        echo json_encode($response);
    }

}