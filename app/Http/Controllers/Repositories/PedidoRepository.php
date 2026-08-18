<?php
namespace App\Http\Controllers\Repositories;

use App\Models\Pedidos;

final class PedidoRepository 
{


    public function obtenerPedidos() {
        return Pedidos::all();
    }   


    public function crearPedido(array $data){

        try {
            return Pedidos::create([
            'mesa_id'=>$data['mesa_id'],
            'cliente_id' =>$data['cliente_id'],
            'mesero_id'=>$data['mesero_id'],
            'estado'=>$data['estado'],
            'total'=>$data['total'],
            'fecha_hora'=>$data['fecha_hora']
            ]);
        } catch (\Throwable $e) {
        
            return[
                'mensaje' => $e->getMessage()
            ];
        }

    }
     public function obtenerPedidoPorId($id){
       
        return Pedidos::findOrFail($id);
    }
    public function obtenerPedidosParaAdmin() {
    return Pedidos::with(['mesa', 'cliente', 'mesero'])
        ->orderBy('fecha_hora', 'desc')
        ->get();
}
    public function actualizarPedido($id, array $data){
        $pedido = Pedidos::findOrFail($id);
        $pedido->update($data);
        return $pedido;
        
    }
    public function actualizarEstado($id, $estado){
        $pedido = Pedidos::findOrFail($id);
        $pedido->estado = $estado;
        $pedido->save();
        return $pedido;
    }
    public function eliminarPedido($id){
        $pedido = Pedidos::findOrFail($id);
        $pedido->delete();
        return true;
    }
    public function obtenerPedidosPorCliente($clienteId){
        return Pedidos::where('cliente_id', $clienteId)
        ->orderBy('fecha_hora')
        ->get();
    }



    

    


}
