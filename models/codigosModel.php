<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';


use Illuminate\Database\Eloquent\Model;

class Codigo extends Model
{

    protected $table = "codigos";
    protected $fillable = ['codigo','tipo','estado'];
    public $timestamps = false;

}
