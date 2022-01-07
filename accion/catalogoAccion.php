<?php

require_once 'app/error.php';

class CatalogoAccion
{

    public function index($metodo_http, $ruta, $params = null)
    {

        switch ($metodo_http) {
            case 'get':
                if ($ruta == '/catalogo/listar' && $params) {
                    Route::get('/catalogo/listar/:proveedor_id', 'catalogoController@buscar', $params);
                } else {
                    ErrorClass::e('404', 'No se encuentra la url');
                }
                break;

            case 'post':
                if ($ruta == '/catalogo/save') {
                    Route::post('/catalogo/save', 'catalogoController@guardarCatalogo');
                }
                break;
        }
    }
}
