<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/compraModel.php';

use Illuminate\Database\Eloquent\Model;

class Estado_Compra extends Model
{

    protected $table = "estado_compra";
  

    //uno a muchos
    public function compra(){
        return $this->hasMany(Compra::class);
    }
    
}
