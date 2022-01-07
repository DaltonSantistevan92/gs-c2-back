<?php

require_once 'app/error.php';

class ConfiguracionesAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {

            case 'get':
                if ($ruta == '/configuraciones/listar' && $params) {
                    Route::get('/configuraciones/listar/:id', 'configuracionesController@buscar',$params);
                }
                else
                if($ruta == '/configuraciones/listar'){
                    Route::get('/configuraciones/listar', 'configuracionesController@listar');
                }
                break;

            case 'post':
                if ($ruta == '/configuraciones/editar') {
                    Route::post('/configuraciones/editar', 'configuracionesController@editar');
                } else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
                break;
        }
    }
}