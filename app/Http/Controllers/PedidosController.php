<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Repositories\PedidoRepository;
use App\Http\Requests\StorePedidoRequest;


class PedidosController extends Controller
{

    protected $pedidoRepository; 


    public function __construct(PedidoRepository $pedidoRepository)
    {
        $this->pedidoRepository = $pedidoRepository;
    }


    public function indexApi(){
    
        try {
            $pedidos = $this->pedidoRepository->obtenerPedidos();
            return response()->json([
            'exito' => true,
            'data'  => $pedidos
        ], 200);
        } catch (\Exception $e) {
            return response()->json([
        "mensaje"=>$e->getMessage()
        ],500);
        }
    }


    public function create(StorePedidoRequest $request){

        try {
            $pedido = $this->pedidoRepository->crearPedido($request->all());

            return response()->json([
                'exito' =>true,
                'data' => $pedido
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
            "mensaje"=>$e->getMessage()
            ],500);
        }

    }
   

}
