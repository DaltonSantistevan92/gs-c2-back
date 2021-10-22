<?php

require_once 'app/error.php';

class ProveedorAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/proveedor/listar' && $params) {
                    Route::get('/proveedor/listar/:id', 'proveedorController@buscar', $params);
                } else
                if ($ruta == '/proveedor/listar') {
                    Route::get('/proveedor/listar', 'proveedorController@listar');
                } else
                if ($ruta == '/proveedor/datatable') {
                    Route::get('/proveedor/datatable', 'proveedorController@datatable');
                } else
                if ($ruta == '/proveedor/buscar' & $params) {
                    Route::get('/proveedor/buscar/:texto', 'proveedorController@buscarProveedor', $params);
                } else
                if ($ruta == '/proveedor/contar') {
                    Route::get('/proveedor/contar', 'proveedorController@contar');
                } else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
                break;

            case 'post':
                if ($ruta == '/proveedor/save') {
                    Route::post('/proveedor/save', 'proveedorController@guardar');
                } else 
                if ($ruta == '/proveedor/editar') {
                    Route::post('/proveedor/editar', 'proveedorController@editar');
                } else 
                if ($ruta == '/proveedor/eliminar') {
                    Route::post('/proveedor/eliminar', 'proveedorController@eliminar');
                } else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
                break;
        }
    }
}
