<?php

require_once 'app/error.php';

class PersonaAccion{

    public function index($metodo_http, $ruta, $params = null){

        switch($metodo_http){
            case 'get':
               
                break;
            
            case 'post':
                if($ruta == '/persona/save'){
                    Route::post('/persona/save', 'personaController@guardar');
                }
                break;
        }
    }
}