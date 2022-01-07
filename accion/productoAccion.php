<?php

require_once 'app/error.php';

class ProductoAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/producto/listar' && $params) {
                    Route::get('/producto/listar/:id', 'productoController@listarxID',$params);
                } else
                if ($ruta == '/producto/listar') {
                    Route::get('/producto/listar', 'productoController@listar');
                } else
                if ($ruta == '/producto/contar') {
                    Route::get('/producto/contar', 'productoController@contar');
                } else
                if ($ruta == '/producto/datatable') {
                    Route::get('/producto/datatable', 'productoController@dataTable');
                } else
                if ($ruta == '/producto/buscar' & $params) {
                    Route::get('/producto/buscar/:texto', 'productoController@buscarProducto', $params);
                }else
                if ($ruta == '/producto/generar_codigo' && $params) {
                    Route::get('/producto/generar_codigo/:tipo', 'productoController@getCodigo',$params);
                } else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
                break;

                
            case 'post':
                if ($ruta == '/producto/save') {
                    Route::post('/producto/save', 'productoController@guardar');
                }else
                if($ruta == '/producto/aumentarCodigo'){
                    Route::post('/producto/aumentarCodigo', 'productoController@aumentarCodigo');
                } else
                if ($ruta == '/producto/fichero') {
                    Route::post('/producto/fichero', 'productoController@subirFichero', true);
                } else 
                if($ruta == '/producto/editar'){
                    Route::post('/producto/editar', 'productoController@editar');
                }else 
                if($ruta == '/producto/eliminar'){
                    Route::post('/producto/eliminar', 'productoController@eliminar');
                }else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
                break;

        }
    }
}
