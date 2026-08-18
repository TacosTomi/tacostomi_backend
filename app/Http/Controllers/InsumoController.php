<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInsumoRequest;
use App\Http\Requests\StoreMovimientoInsumoRequest;
use App\Http\Requests\UpdateInsumoRequest;
use App\Models\Insumo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InsumoController extends Controller
{
    private function asegurarAdmin(): void
    {
        if (auth()->user()->rol_id !== 1) {
            abort(403, 'Alto ahi chiavo! esta funcion es solo para Admins Vrgs');
        }
    }

    public function index(Request $request)
    {
        $this->asegurarAdmin();

        $query = Insumo::query()->orderBy('nombre');

        if ($request->boolean('solo_bajos')) {
            $query->bajoMinimo();
        }

        $insumos = $query->get();
        $insumosBajos = Insumo::bajoMinimo()->count();

        return view('ver_insumos', compact('insumos', 'insumosBajos'));
    }

    public function create()
    {
        $this->asegurarAdmin();

        return view('crear_insumo');
    }

    public function store(StoreInsumoRequest $request)
    {
        $this->asegurarAdmin();

        $stockInicial = (float) ($request->stock_inicial ?? 0);

        $insumo = Insumo::create([
            'nombre' => $request->nombre,
            'unidad_medida' => $request->unidad_medida,
            'stock_minimo' => $request->stock_minimo,
            'stock_actual' => $stockInicial,
            'proveedor_id' => $request->proveedor_id ?: null,
        ]);

        $mensaje = 'Insumo registrado correctamente.';
        if ($insumo->estaBajoMinimo()) {
            $mensaje .= ' Atención: el stock quedó en o bajo el mínimo configurado.';
        }

        return redirect('/insumos')->with('success', $mensaje);
    }

    public function edit($id)
    {
        $this->asegurarAdmin();

        $insumo = Insumo::findOrFail($id);

        return view('editar_insumo', compact('insumo'));
    }

    public function update(UpdateInsumoRequest $request, $id)
    {
        $this->asegurarAdmin();

        $insumo = Insumo::findOrFail($id);
        $insumo->nombre = $request->nombre;
        $insumo->unidad_medida = $request->unidad_medida;
        $insumo->stock_minimo = $request->stock_minimo;

        if ($request->filled('proveedor_id')) {
            $insumo->proveedor_id = $request->proveedor_id;
        }

        $insumo->save();

        return redirect('/insumos')->with('success', 'Insumo actualizado correctamente.');
    }

    public function movimiento($id)
    {
        $this->asegurarAdmin();

        $insumo = Insumo::with('platillos')->findOrFail($id);

        return view('movimiento_insumo', compact('insumo'));
    }

    public function registrarMovimiento(StoreMovimientoInsumoRequest $request, $id)
    {
        $this->asegurarAdmin();

        $cantidad = (float) $request->cantidad;
        $tipo = $request->tipo;

        $insumo = DB::transaction(function () use ($id, $cantidad, $tipo) {
            $insumo = Insumo::lockForUpdate()->findOrFail($id);
            $stockActual = (float) $insumo->stock_actual;

            if ($tipo === 'SALIDA' && $cantidad > $stockActual) {
                throw ValidationException::withMessages([
                    'cantidad' => 'No hay stock suficiente. Disponible: '.$stockActual.' '.$insumo->unidad_medida,
                ]);
            }

            $insumo->stock_actual = $tipo === 'SALIDA'
                ? $stockActual - $cantidad
                : $stockActual + $cantidad;

            $insumo->save();

            return $insumo->fresh();
        });

        if ($tipo === 'SALIDA' && $insumo->estaBajoMinimo()) {
            return redirect('/insumos')->with(
                'warning',
                $insumo->nombre.' quedó bajo el mínimo ('.$insumo->stock_actual.' '.$insumo->unidad_medida.' / mín. '.$insumo->stock_minimo.').'
            );
        }

        return redirect('/insumos')->with('success', 'Stock actualizado correctamente.');
    }
}
