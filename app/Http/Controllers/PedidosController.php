<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Repositories\PedidoRepository;
use App\Http\Requests\StorePedidoRequest;
use Illuminate\Http\Request;

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


    public function createApi(StorePedidoRequest $request){

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
    public function verPedidosAdmin()
{
    $pedidos = $this->pedidoRepository->obtenerPedidosParaAdmin();
    return view('pedidos_admin', compact('pedidos'));
}

public function actualizarEstadoWeb(Request $request, $id)
{
    $request->validate([
    'estado' => 'required|string|in:recibido,en preparación,listo,entregado'
]);

    $this->pedidoRepository->actualizarEstado($id, $request->estado);

    return redirect('/pedidosAdmin')->with('success', 'Estado actualizado.');
}

public function eliminarPedidoWeb($id)
{
    $this->pedidoRepository->eliminarPedido($id);
    return redirect('/pedidosAdmin')->with('success', 'Pedido eliminado.');
}
    public function show($id){
        try {
            $pedido = $this->pedidoRepository->obtenerPedidoPorId($id);
            return response()->json([
                'exito' => true,
                'data'  => $pedido
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "mensaje"=>$e->getMessage()
            ],500);
        }
    }
     
    public function update(Request $request, $id){
       $request->validate([
            'mesa_id' => 'required|integer',       
            'cliente_id' => 'required|integer',
            'mesero_id'=> 'required|integer',    
            'estado'=> 'required|string',    
            'total'=> 'required|numeric',
            'fecha_hora' => 'required|date'
        ]);
        try {
            $pedido = $this->pedidoRepository->actualizarPedido($id, $request->all());
            return response()->json([
                'exito' => true,
                'data'  => $pedido
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                "mensaje"=>$e->getMessage()
            ],500);
        }
    }

        public function updateEstado(Request $request, $id){
            $request->validate([
             'estado'=> 'required|string|in:recibido,en preparación,listo,entregado'
              ]);
            try {
                $pedido = $this->pedidoRepository->actualizarEstado($id, $request->estado);
                return response()->json([
                    'exito' => true,
                    'data'  => $pedido
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    "mensaje"=>$e->getMessage()
                ],500);
            }
        }
        public function destroy($id){
            try {
                $this->pedidoRepository->eliminarPedido($id);
                return response()->json([
                    'exito' => true,
                    'mensaje'  => 'Pedido eliminado correctamente'
                ], 200);
            } catch (\Exception $e) {
                return response()->json([
                    "mensaje"=>$e->getMessage()
                ],500);
            }
        }
        public function obtenerPedidosPorCliente($clienteId){
            try {
                $pedidos = $this->pedidoRepository->obtenerPedidosPorCliente($clienteId);
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
    }


