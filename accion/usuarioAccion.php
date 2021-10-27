<?php

require_once 'app/error.php';

class UsuarioAccion
{

    public function __construct()
    {
    }

    //Configurar rutas y controllers
    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/usuario/listar' && $params) {
                    Route::get('/usuario/listar/:id', 'usuarioController@buscar', $params);
                }else 
                if ($ruta == '/usuario/listar') {
                    Route::get('/usuario/listar', 'usuarioController@listar');
                } else
                if ($ruta == '/usuario/datatable') {
                    Route::get('/usuario/datatable', 'usuarioController@dataTable');
                } else
                if ($ruta == '/usuario/contar') {
                    Route::get('/usuario/contar', 'usuarioController@contar');
                } else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                break;

            case 'post':
                if ($ruta == '/usuario/login') {
                    Route::post('/usuario/login', 'usuarioController@login');
                } else
                if ($ruta == '/usuario/guardar') {
                    Route::post('/usuario/guardar', 'usuarioController@guardar');
                } else
                if ($ruta == '/usuario/fichero') {
                    Route::post('/usuario/fichero', 'usuarioController@subirFichero', true);
                } else
                if ($ruta == '/usuario/editar') {
                    Route::post('/usuario/editar', 'usuarioController@editar');
                } else
                if ($ruta == '/usuario/eliminar') {
                    Route::post('/usuario/eliminar', 'usuarioController@eliminar');
                }else 
                if ($ruta == '/usuario/enviarcorreo') {
                    Route::post('/usuario/enviarcorreo', 'usuarioController@solicitudPassword');
                }
                else {
                    ErrorClass::e(404, "La ruta no existe");
                }
                break; 
        }
    }
}
