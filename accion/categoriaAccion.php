<?php

require_once 'app/error.php';

class CategoriaAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/categoria/listar' && $params) {
                    Route::get('/categoria/listar/:id', 'categoriaController@buscar', $params);
                }else if ($ruta == '/categoria/listar') {
                    Route::get('/categoria/listar', 'categoriaController@listar');
                } else
                if ($ruta == '/categoria/datatable') {
                    Route::get('/categoria/datatable', 'categoriaController@datatable');
                } else
                if ($ruta == '/categoria/buscar_producto' && $params) {
                    Route::get('/categoria/buscar_producto/:id', 'categoriaController@buscar_producto', $params);
                }else
                if($ruta == '/categoria/contar'){
                    Route::get('/categoria/contar', 'categoriaController@contar');
                } else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
                break;

            case 'post':
                if ($ruta == '/categoria/save') {
                    Route::post('/categoria/save', 'categoriaController@guardar');
                }else 
                if ($ruta == '/categoria/editar') {
                    Route::post('/categoria/editar', 'categoriaController@editar');
                }
                break;

            case 'delete':
                if ($params) {
                    if ($ruta == '/categoria/eliminar') {
                        Route::delete('/categoria/eliminar/:id', 'categoriaController@eliminar', $params);
                    }
                } else {
                    ErrorClass::e('400', 'No ha enviado parámetros por la url');
                }
                break;
        }
    }
}
