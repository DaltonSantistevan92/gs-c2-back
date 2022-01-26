<?php

require_once 'app/error.php';

class CompraAccion
{ 

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {

            case 'get':
                if ($ruta == '/compra/listar'&& $params) {
                    Route::get('/compra/listar/:id', 'compraController@buscar', $params);
                } else
                if ($ruta == '/compra/listar' ) {
                    Route::get('/compra/listar/', 'compraController@listar');
                } else
                if ($ruta == '/compra/datatable') {
                    Route::get('/compra/datatable', 'compraController@datatable');
                }else
                if($ruta == '/compra/total'){
                    Route::get('/compra/total', 'compraController@total');
                }else
                if($ruta == '/compra/grafica_compra'){
                    Route::get('/compra/grafica_compra', 'compraController@grafica_compra');
                }else
                if($ruta == '/compra/mensuales' && $params){
                    Route::get('/compra/mensuales/:inicio/:fin', 'compraController@compraMensuales',$params);
                }else
                if ($ruta == '/compra/generar_codigo' && $params) {
                    Route::get('/compra/generar_codigo/:tipo', 'compraController@getCodigo',$params);
                }else
                if( $ruta == '/compra/proyeccion' && $params){
                    Route::get('/compra/proyeccion/:year', 'compraController@proyeccion', $params); 
                }else
                if($ruta == '/compra/frecuentesv2' && $params){
                    Route::get('/compra/frecuentesv2/:inicio/:fin/:limit', 'compraController@comprasFrecuentesv2',$params);  
                 } else
                if($ruta == '/compra/frecuentes' && $params){
                    Route::get('/compras/frecuentes/:inicio/:fin/:limit', 'compraController@comprasfrecuentes',$params);  
                }else
                if($ruta == '/compra/confirmarCompra' && $params){
                    Route::get('/compras/confirmarCompra/:id/:estado_compra_id', 'compraController@confirmarCompra',$params);  
                } else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }  
                break;

            case 'post':
                if ($ruta == '/compra/save') {
                    Route::post('/compra/save', 'compraController@guardar');
                }else
                if($ruta == '/compra/aumentarCodigo'){
                    Route::post('/compra/aumentarCodigo', 'compraController@aumentarCodigo');
                }else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
                break;

        }
    }
}
