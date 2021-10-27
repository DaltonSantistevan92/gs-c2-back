<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'app/error.php';
require_once 'app/helper.php';
require_once 'models/usuarioModel.php';
require_once 'models/personaModel.php';
require_once 'controllers/personaController.php';
require_once './util/claseCorreo.php';

class UsuarioController
{

    private $cors;
    private $personaController;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->db = new Conexion();
        $this->personaController = new PersonaController();
    }

    public function listar()
    {
        $this->cors->corsJson();
        $usuarios = Usuario::all();
        $response = [];

        for ($i = 0; $i < count($usuarios); $i++) {
            $item = [
                'usuario' => $usuarios[$i],
                'persona' => $usuarios[$i]->persona,
                'rol' => $usuarios[$i]->rol,
            ];
            $response[] = $item;
        }
        echo json_encode($usuarios);
    }

    public function buscar($params){
        $this->cors->corsJson();
        $id = intval($params['id']);
        $usuario = Usuario::find($id);

        if($usuario){
            $usuario->persona;
            $usuario->rol;

            $response = [
                'status' => true,
                'mensaje' => 'Existen datos',
                'usuario' => $usuario
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos',
                'usuario' => null
            ];
        }
        echo json_encode($response);
    }

    public function contar(){
        $this->cors->corsJson();
        $usuarios = Usuario::where('estado','A')->get();
        $response = [];
        if($usuarios){
            $response = [
                'status' => true,
                'mensaje' => 'Existen Usuario',
                'Modelo' => 'Usuario',
                'cantidad' => $usuarios->count()
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No Existen Usuario',
                'Modelo' => 'Usuario',
                'cantidad' => 0
            ];
        }
        echo json_encode($response);
    }

     public function login(Request $request)
    {
        $data = $request->input('login');

        $entrada = $data->entrada;
        $clave = $data->clave;
        $encriptar = hash('sha256', $clave);

        $this->cors->corsJson();
        $response = [];

        if ((!isset($entrada) || $entrada == "") || (!isset($clave) || $clave == "")) {
            $response = [
                'estatus' => false,
                'mensaje' => 'Falta datos',
            ];
        } else {
            $usuario = Usuario::where('usuario', $entrada)->get()->first();
            $persona = Persona::where('correo', $entrada)->get()->first();

            if ($usuario || $persona) {
                $us = $usuario;

                if ($persona) {
                    $us = $persona->usuario[0];
                }

                //Segun con la verificacion de credenciales
                if ($encriptar == $us->clave) {
                    $persona = Persona::find($us->persona->id);

                    $per = $us->persona->nombres . " " . $us->persona->apellidos;
                    $rol = $us->rol->cargo;

                    $response = [
                        'status' => true,
                        'mensaje' => 'Acceso al sistema',
                        'rol' => $rol,
                        'persona' => $per,
                        'usuario' => $us,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'La contraseña es incorrecta',
                    ];
                }
            } else {
                $response = [
                    'estatus' => false,
                    'mensaje' => 'El correo o usuario no existe',
                ];
            }
        }

        echo json_encode($response);
    }

    public function dataTable()
    {
        $this->cors->corsJson();
        $usuarios = Usuario::where('estado', 'A')->orderBy('usuario')->get();

        $data = [];     $i = 1;

        foreach ($usuarios as $u) {
            $url = BASE . 'resources/usuarios/' . $u->img;
            $icono = $u->estado == 'I' ? '<i class="fas fa-check"></i>' : '<i class="fas fa-trash"></i>';
            $clase = $u->estado == 'I' ? 'btn-success btn-sm' : 'btn-danger btn-sm';
            $other = $u->estado == 'A' ? 0 : 1;

            $botones = '<div class="text-center">
                            <button class="btn btn-warning btn-sm" onclick="editar_usuario(' . $u->id . ')">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn ' . $clase . '" onclick="eliminar_usuario(' . $u->id . ',' . $other . ')">
                                ' . $icono . '
                            </button>
                        </div>';

            $data[] = [
                0 => $i,
                1 => $u->usuario,
                2 => $u->rol->cargo,
                3 => $u->persona->nombres,
                4 => $u->persona->apellidos,
                5 => '<div class="box-img-usuario"><img src=' . "$url" . '></div>',
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

    public function guardar(Request $request)
    {
        $this->cors->corsJson();
        $user = $request->input('usuario');
        $response = [];

        if (!isset($user) || $user == null) {
            $response = [
                'status' => false,
                'mensaje' => 'No hay datos para procesar',
                'usuario' => null,
            ];
        } else {
            $resPersona = $this->personaController->guardarPersona($request);

            $id_pers = $resPersona['persona']->id;

            $clave = $user->clave;
            $encriptar = hash('sha256', $clave);
            $user->rol_id = intval($user->rol_id);

            $usuario = new Usuario;

            $usuario->persona_id = $id_pers;
            $usuario->rol_id = $user->rol_id;
            $usuario->usuario = $user->usuario;
            $usuario->img = $user->img;
            $usuario->clave = $encriptar;
            $usuario->conf_clave = $encriptar;
            $usuario->estado = 'A';

            //buscar en usuarios el id_persona si existe y validar
            $exis_user = Usuario::where('persona_id', $id_pers)->get()->first();

            if ($exis_user) {
                $response = [
                    'status' => false,
                    'mensaje' => 'El usuario ya se encuentra registrado',
                    'usuario' => null,
                ];
            } else {
                if ($usuario->save()) {
                    //para guardar en otra tablas

                    $response = [
                        'status' => true,
                        'mensaje' => 'Se ha guardado el usuario',
                        'usuario' => $usuario,
                    ];
                } else {
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se pudo guardar :C',
                        'usuario' => null,
                    ];
                }
            }

        }

        echo json_encode($response);
    }

    public function subirFichero($file)
    {
        $this->cors->corsJson();
        $img = $file['fichero'];
        $path = 'resources/usuarios/';

        $response = Helper::save_file($img, $path);
        echo json_encode($response);
    } 
    
    public function editar(Request $request){
        $this->cors->corsJson();
        $usuarioRequest = $request->input('usuario');
        $id = intval($usuarioRequest->id);
        $persona_id = intval($usuarioRequest->persona_id);
        $rol_id = intval($usuarioRequest->rol_id);
        $usuario = ucfirst($usuarioRequest->usuario);

        $response = [];

        $datausuario = Usuario::find($id);

        if($usuarioRequest){
            if($datausuario){
                $datausuario->persona_id = $persona_id;
                $datausuario->rol_id = $rol_id;
                $datausuario->usuario = $usuario;

                $persona = Persona::find($datausuario->persona_id);
                $persona->nombres = ucfirst($usuarioRequest->nombres);
                $persona->apellidos = ucfirst($usuarioRequest->apellidos);
                $persona->save();
                $datausuario->save();  

                $response = [
                    'status' => true,
                    'mensaje' => 'El usuario se ha actualizado',
                    'data' => $datausuario,
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede actualizar el usuario',
                ];
            }
        }else{
            $response = [
                'status' => true,
                'mensaje' => 'No ahi datos para procesar'
            ];
        }

        echo json_encode($response);

    }

    public function eliminar(Request $request)
    {
        $this->cors->corsJson();
        $usuarioRequest = $request->input('usuario');
        $id = intval($usuarioRequest->id);
        $response = [];

        $datausuario = Usuario::find($id);

        if($datausuario){
            $datausuario->estado = 'I';
            $datausuario->save();

            $response = [
                'status' => true,
                'mensaje' => 'Se ha eliminado el usuario',
                'usuario' => $datausuario
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No se puede eliminar el usuario'

            ];
        }
        echo json_encode($response);
    }


    protected function enviarCorreo($correo,$nombre,$usuario = null){
        $claseCorreo = new Correo($correo,$nombre);
        $texto = 'Se ha generado una nueva contraseña debido a su solicitud, su contraseña actual ahora es: ';
        $titulo = 'Solicitud de contrasena';
        $codigo = substr(hash('sha256',time()),0,4); 
        $usuario->clave = hash('sha256',$codigo);
        $usuario->save();
        $proceso  = $claseCorreo->enviarCorreo($titulo,$texto,$codigo);

        return $proceso;
    }

    public function solicitudPassword(Request $request){
        $this->cors->corsJson();
        $correo = $request->input('correo');
        $persona = Persona::where('correo',$correo)->first();
        
        if($persona){
            $usuario = Usuario::where('persona_id',$persona->id)->first();
            $nombres= $usuario->persona->nombres.' '.$usuario->persona->apellidos;
    
            $estado = $this->enviarCorreo($correo,$nombres,$usuario);
            $response = [];
    
            if($estado){
                $response = [
                    'status' => true,
                    'mensaje' => 'Se ha enviado la contraseña a su correo'
                ];
            }else{
                $response = [
                    'status' => false,
                    'mensaje' => 'No se puede enviar el correo'
                ];
            }
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'El correo ingresado no existe'
            ];
        }       
        echo json_encode($response);
    }

    



    
}
