<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insumos - Tacostomi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 20px; background-color: #f4f4f9; }
        .main-card { background: white; padding: 25px; border-radius: 8px; max-width: 1100px; margin: 0 auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        .actions-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 10px; flex-wrap: wrap; }
        th { background-color: #264653 !important; color: white !important; }
        tr.fila-baja { background-color: #fff3cd !important; }
        tr.fila-agotada { background-color: #f8d7da !important; }
    </style>
</head>
<body>
    <div class="main-card">
        <div class="actions-bar">
            <a href="/admin" class="btn btn-secondary">← Volver al Panel</a>
            <a href="/crearInsumo" class="btn btn-success">+ Registrar Insumo</a>
        </div>

        <h1 class="h2 text-dark mb-3">Administración de Insumos</h1>

        @if($insumosBajos > 0)
            <div class="alert alert-warning">
                Hay <strong>{{ $insumosBajos }}</strong> insumo(s) en o por debajo del mínimo configurado.
                <a href="/insumos?solo_bajos=1" class="alert-link">Ver solo bajos</a>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        <div class="mb-3 d-flex gap-2">
            <a href="/insumos" class="btn btn-outline-secondary btn-sm {{ !request('solo_bajos') ? 'active' : '' }}">Todos</a>
            <a href="/insumos?solo_bajos=1" class="btn btn-outline-warning btn-sm {{ request('solo_bajos') ? 'active' : '' }}">Solo bajos / agotados</a>
        </div>

        <div class="table-responsive border rounded">
            <table class="table table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Unidad</th>
                        <th>Stock actual</th>
                        <th>Mínimo</th>
                        <th>Estado</th>
                        <th class="text-center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($insumos as $insumo)
                        @php $estado = $insumo->estadoStock(); @endphp
                        <tr class="{{ $estado === 'agotado' ? 'fila-agotada' : ($estado === 'bajo' ? 'fila-baja' : '') }}">
                            <td class="fw-bold">{{ $insumo->nombre }}</td>
                            <td>{{ $insumo->unidad_medida }}</td>
                            <td>{{ rtrim(rtrim(number_format($insumo->stock_actual, 3, '.', ''), '0'), '.') }}</td>
                            <td>{{ rtrim(rtrim(number_format($insumo->stock_minimo, 3, '.', ''), '0'), '.') }}</td>
                            <td>
                                @if($estado === 'agotado')
                                    <span class="badge bg-danger">Agotado</span>
                                @elseif($estado === 'bajo')
                                    <span class="badge bg-warning text-dark">Bajo mínimo</span>
                                @else
                                    <span class="badge bg-success">OK</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="/insumos/{{ $insumo->id }}/movimiento" class="btn btn-sm btn-outline-primary">Entrada / Salida</a>
                                <a href="/editarInsumo/{{ $insumo->id }}" class="btn btn-sm btn-outline-dark">Editar</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No hay insumos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
