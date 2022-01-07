<?php

require_once 'app/cors.php';
require_once 'core/conexion.php';
require_once 'app/request.php';
require_once 'models/personaModel.php';
require_once 'models/clienteModel.php';
require_once 'controllers/personaController.php';

class ClienteController {
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
        $clientes = Cliente::find($id);
        $response = [];

        if($clientes){
        $clientes->persona;   
        $response = [
            'status' => true,
            'mensaje' => 'Existen datos',
            'cliente' => $clientes
         ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'cliente' => null
             ];
        }
        echo json_encode($response);
    }

    public function listar()
    {
        $this->cors->corsJson();
        $clientes = Cliente::where('estado', 'A')->get();
        $response = [];
        foreach ($clientes as $item) {
            $aux = [
                'cliente' => $item,
                'persona' => $item->persona->id,
            ];
            $response[] = $aux;
        }
        echo json_encode($response);
    }

    public function buscarCliente($params)
    {
        $this->cors->corsJson();
        $texto = ucfirst($params['texto']);
        $response = [];

        $sql = "SELECT c.id, p.cedula, p.nombres, p.apellidos, p.telefono, p.correo,p.direccion FROM personas p
        INNER JOIN clientes c ON c.persona_id = p.id
        WHERE p.estado = 'A' and (p.cedula LIKE '$texto%' OR p.nombres LIKE '%$texto%' OR p.apellidos LIKE '%$texto%')";

        $array = $this->conexion->database::select($sql);

        if ($array) {
            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'clientes' => $array,
            ];
        } else {
            $response = [
                'status' => false,
                'mensaje' => 'No existen coincidencias',
                'clientes' => null,
            ];
        }
        echo json_encode($response);
    }

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $response = [];
        $personaController = new PersonaController();
        $data = $personaController->guardarPersona($request);
        $objet = (object) $data;

        if ($objet->status) {
            $cliente = new Cliente;
            $cliente->persona_id = $objet->persona->id;
            $cliente->fecha_ingreso = date('Y-m-d');
            $cliente->hora_ingreso = date('h:m:s');
            $cliente->estado = 'A';

            if ($cliente->save()) {
                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha registrado el nuevo cliente',
                    'persona' => $cliente->persona->cedula,
                    'cliente' => $cliente,
                ];
            } else {
                $response = [
                    'status' => false,
                    'mensaje' => 'No se ha podido guardar el cliente',
                    'cliente' => null,
                ];
            }
        } else {
            $response = [
                'status' => false,
                'mensaje' => $objet->mensaje,
                'cliente' => null,
            ];
        }
        echo json_encode($response);
    }

    public function datatable()
    {
        $clientes = Cliente::where('estado', 'A')->get();
        $data = [];     $i = 1;
        foreach ($clientes as $c) {
            $botones = '<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="editar_cliente(' . $c->id . ')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" onclick="eliminar_cliente(' . $c->id . ')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $c->persona->cedula,
                2 => $c->persona->nombres,
                3 => $c->persona->apellidos,
                4 => $c->persona->telefono,
                5 => $c->persona->correo,
                6 => $c->persona->direccion,
                7 => $botones,
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
        $clientes = Cliente::where('estado','A')->get();
        $response = [];

        if($clientes){
            $response = [
                'status'  => true,
                'mensaje' => 'Existen clientes',
                'Modelo' => 'Cliente',
                'cantidad' => $clientes->count()
            ];
        }else{
            $response = [
                'status'  => false,
                'mensaje' => 'No existen datos',
                'Modelo' => 'Cliente',
                'cantidad' => 0
            ];
        }
        echo json_encode($response);
    }

    public function editar(Request $request){
        $this->cors->corsJson();
        $requestCliente = $request->input('cliente');
        $id = intval($requestCliente->id);
        $persona_id = intval($requestCliente->persona_id);
        $nombres = ucfirst($requestCliente->nombres);
        $apellidos = ucfirst($requestCliente->apellidos);
        $telefono = $requestCliente->telefono;
        $correo = $requestCliente->correo;
        $direccion = $requestCliente->direccion;

        $response = [];
        $clientes = Cliente::find($id);

        if($requestCliente){
            if($clientes){
                $clientes->persona_id = $persona_id;
                $persona = Persona::find($persona_id);
                $persona->nombres = $nombres;
                $persona->apellidos = $apellidos;
                $persona->telefono = $telefono;
                $persona->correo = $correo;
                $persona->direccion = $direccion;
                $persona->save();
                $clientes->save();

                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha actualizado el cliente',
                    'cliente' => $clientes
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'No se ha actualizado el cliente',
                    'cliente' => null
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

    public function eliminar(Request $request){
        $this->cors->corsJson();
        $requestCliente = $request->input('cliente');
        $id = intval($requestCliente->id);
        $response = [];
        $clientes = Cliente::find($id);

        if($clientes){
            $clientes->estado = 'I';
            $clientes->save();
            
            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado el cliente',
                'cliente' => $clientes             
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No se ha eliminado el cliente',
                'cliente' => null             
            ];
        }
        echo json_encode($response);

    }
}