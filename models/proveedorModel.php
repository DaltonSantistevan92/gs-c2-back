<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/catalogoModel.php';


use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{

    protected $table = "proveedores";
    protected $fillable = ['ruc', 'razon_social', 'direccion', 'correo', 'fecha', 'telefono', 'estado'];

    //uno a muchos
    public function catalogo()
    {
        return $this->hasMany(Catalogo::class);
    }
}
