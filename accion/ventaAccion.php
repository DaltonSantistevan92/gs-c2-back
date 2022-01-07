<?php

require_once 'app/error.php'; 

class VentaAccion 
{
    public function index($metodo_http, $ruta, $params = null) 
    {
        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/venta/listar' && $params) {
                    Route::get('/venta/listar/:id', 'ventaController@buscar', $params);
                }else 
                if ($ruta == '/venta/listar') {
                    Route::get('/venta/listar', 'ventaController@listar');
                }else
                if ($ruta == '/venta/datatable') {
                    Route::get('/venta/datatable', 'ventaController@datatable');
                }else
                if($ruta == '/venta/total'){
                    Route::get('/venta/total', 'ventaController@total'); 
                }else
                if($ruta == '/venta/grafica_venta'){
                    Route::get('/venta/grafica_venta', 'ventaController@grafica_venta');
                }else
                if($ruta == '/venta/mensuales' && $params){
                    Route::get('/venta/mensuales/:inicio/:fin', 'ventaController@ventaMensuales',$params);
                }else
                if($ruta == '/venta/frecuentes' && $params){
                    Route::get('/venta/frecuentes/:inicio/:fin/:limit', 'ventaController@ventasfrecuentes',$params);  
                }else
                if( $ruta == '/venta/proyeccion' && $params){
                    Route::get('/venta/proyeccion/:year', 'ventaController@proyeccion', $params);
                }else
                if ($ruta == '/venta/generar_codigo' && $params) {
                    Route::get('/venta/generar_codigo/:tipo', 'ventaController@getCodigo',$params);
                }else
                if($ruta == '/venta/grafica_venta'){
                    Route::get('/venta/grafica_venta', 'ventaController@grafica_venta');
                }
                else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
                break;

            case 'post':
                if ($ruta == '/venta/save') {
                    Route::post('/venta/save', 'ventaController@guardar');
                }else
                if($ruta == '/venta/actualizarPrecioVentaMargen'){
                    Route::post('/venta/actualizarPrecioVentaMargen', 'ventaController@actualizarPrecioVentaMargen');
                }else
                if($ruta == '/venta/aumentarCodigo'){
                    Route::post('/venta/aumentarCodigo', 'ventaController@aumentarCodigo');
                }else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
                break;
        }
    }
}
