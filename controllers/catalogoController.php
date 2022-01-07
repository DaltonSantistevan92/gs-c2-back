<?php

require_once 'app/cors.php';
require_once 'app/request.php';
require_once 'core/conexion.php';
require_once 'models/catalogoModel.php';
/* require_once 'models/productoModel.php';  */


class CatalogoController
{

    private $cors;
    private $db;

    public function __construct()
    {
        $this->cors = new Cors();
        $this->db = new Conexion();
    }

    public function buscar($params){
        $this->cors->corsJson();
        $response = [];
        $proveedor_id = intval($params['proveedor_id']);

        $dataCatalogo = Catalogo::where('proveedor_id',$proveedor_id)->get();

        if($dataCatalogo){
            foreach($dataCatalogo as $dC){
                $dC->producto;
            }
            $response = [
                'status' => true,
                'mensaje' => 'existen datos',
                'catalogo' => $dataCatalogo
            ];
        }else{
            $response = [
                'status' => false,
                'mensaje' => 'No existen datos',
                'catalogo' => null
            ];
        }
        echo json_encode($response);
    }


    public function guardarCatalogo(Request $request){
        $this->cors->corsJson();
        $catalogo = $request->input('catalogo');
        $response = [];

        if($catalogo){
            $proveedor_id = intval($catalogo->proveedor_id);
            $producto_id = intval($catalogo->producto_id);
            $precio_compra = floatval($catalogo->precio_compra);

            $nuevoCatalogo = new Catalogo();
            $nuevoCatalogo->proveedor_id = $proveedor_id;
            $nuevoCatalogo->producto_id = $producto_id;
            $nuevoCatalogo->estado = 'A';

            $existe = Catalogo::where('proveedor_id',$proveedor_id)->where('producto_id',$producto_id)->get()->first();

            if($existe){
                //actualizar el precio de compra en la tabla producto        
                $this->actualizarPrecioCompraProducto($producto_id,$precio_compra);

                $response = [
                    'status' => true,
                    'mensaje' => 'El precio se actualizo',
                ];
            }else{
                if($nuevoCatalogo->save()){
                    //actualizar el precio de compra en la tabla producto
                    $this->actualizarPrecioCompraProducto($producto_id,$precio_compra);

                    $response = [
                        'status' => true,
                        'mensaje' => 'Se ha asignado el catalogo',
                        'catalogo' => $nuevoCatalogo,
                    ];
                }else{
                    $response = [
                        'status' => false,
                        'mensaje' => 'No se ha guardado los datos',
                        'catalogo' => null,
                    ];
                }
            }

        }else {
            $response = [
                'status' => false,
                'mensaje' => 'No ha enviado datos',
                'vehiculo' => null,
            ];
        }
        echo json_encode($response);
    }


    protected function actualizarPrecioCompraProducto($producto_id,$precio_compra){
        $producto = Producto::find($producto_id);
        $producto->precio_compra = $precio_compra;
        $producto->save();
    }


}