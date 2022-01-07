<?php

require_once 'vendor/autoload.php';
require_once 'core/conexion.php';
require_once 'models/categoriaModel.php';
require_once 'models/catalogoModel.php';

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{

    protected $table = "productos";
    protected $fillable = ['categoria_id', 'codigo', 'nombre', 'img', 'descripcion', 'stock',
        'precio_compra', 'precio_venta', 'margen', 'fecha', 'estado'];

    //Muchos a uno --- uno a muchos(Inverso)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    //uno a muchos
    public function catalogo()
    {
        return $this->hasMany(Catalogo::class);
    }
} 
