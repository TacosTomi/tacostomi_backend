<?php
namespace App\Http\Controllers\Repositories;

use App\Models\Pedidos;
use App\Models\Platillo;

final class PedidoRepository 
{


    public function obtenerPedidos() {
        return Platillo::all();
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
    


}
