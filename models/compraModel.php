<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/proveedorModel.php';
require_once 'models/usuarioModel.php';
require_once 'models/detallecompraModel.php';
require_once 'models/estado_compraModel.php';


use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = "compras";
    protected $fillable = ['proveedor_id', 'usuario_id', 'serie_documento', 'descuento', 'sub_total', 'iva', 'total', 'fecha_compra', 'estado','estado_compra_id'];

    //Muchos a uno --- uno a muchos(Inverso)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    //Muchos a uno --- uno a muchos(Inverso)
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    //uno a muchos
    public function detalle_compra()
    {
        return $this->hasMany(DetalleCompra::class);
    }

    public function estado_compra()
    {
        return $this->belongsTo(Estado_Compra::class);
    }
}
