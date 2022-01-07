<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/proveedorModel.php';
require_once 'models/productoModel.php';


use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{

    protected $table = "catalogo";
    protected $fillable = ['proveedor_id','producto_id','estado'];
    public $timestamps = false;

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

}