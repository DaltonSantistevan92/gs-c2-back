<?php

require_once 'app/error.php';

class RolAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/rol/listar' && $params) {
                    Route::get('/rol/listar/:id', 'rolController@buscar',$params);
                } else
                if ($ruta == '/rol/listar') {
                    Route::get('/rol/listar', 'rolController@listar');
                } else
                if ($ruta == '/rol/datatable') {
                    Route::get('/rol/datatable', 'rolController@datatable');
                }
                break;

            case 'post':
                if ($ruta == '/rol/save') {
                    Route::post('/rol/save', 'rolController@guardar');
                } else 
                if ($ruta == '/rol/editar'){
                    Route::post('/rol/editar', 'rolController@editar');
                } else 
                if ($ruta == '/rol/eliminar'){
                    Route::post('/rol/eliminar', 'rolController@eliminar');
                } else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
                break;
        }
    }
}
