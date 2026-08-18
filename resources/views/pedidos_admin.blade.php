<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Pedidos</title>

    <!-- Bootstrap 5 CSS & JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            background-color: #f4f4f9;
            color: #333;
        }

        .main-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            max-width: 1100px;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .actions-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
            flex-wrap: wrap;
        }

        .btn-custom {
            display: inline-flex;
            align-items: center;
            padding: 10px 16px;
            font-size: 0.95rem;
            font-weight: bold;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.2s ease, transform 0.1s ease, box-shadow 0.2s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            border: none;
        }

        .btn-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.15);
        }

        .btn-back { background-color: #6c757d; color: white; }
        .btn-back:hover { background-color: #5a6268; color: white; }

        table { width: 100%; border-collapse: collapse; }
        th { background-color: #264653 !important; color: white !important; }

        .estado-select {
            min-width: 160px;
        }
    </style>
</head>
<body>

    <div class="main-card">
        <div class="actions-bar">
            <a href="/admin" class="btn-custom btn-back">← Volver al Panel Admin</a>
        </div>

        <h1 class="h2 text-dark mb-4">Administración de Pedidos</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive border rounded">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mesa</th>
                        <th>Cliente</th>
                        <th>Mesero</th>
                        <th>Total</th>
                        <th>Fecha / Hora</th>
                        <th>Estado</th>
                        <th class="text-center">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pedidos as $pedido)
                        <tr>
                            <td class="fw-bold">{{ $pedido->id }}</td>
                            <td>{{ $pedido->mesa->numero_mesa ?? 'Mesa #' . $pedido->mesa_id }}</td>
                            <td>{{ $pedido->cliente->nombre ?? 'Cliente #' . $pedido->cliente_id }}</td>
                            <td>{{ $pedido->mesero->nombre ?? 'Mesero #' . $pedido->mesero_id }}</td>
                            <td class="fw-semibold">${{ number_format($pedido->total, 2) }}</td>
                            <td>{{ $pedido->fecha_hora }}</td>
                            <td>
                                @php
                                    $badgeColor = match($pedido->estado) {
                                        'recibido' => 'bg-secondary',
                                        'en preparación' => 'bg-warning text-dark',
                                        'listo' => 'bg-info text-dark',
                                        'entregado' => 'bg-success',
                                        default => 'bg-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $badgeColor }}">{{ $pedido->estado }}</span>
                            </td>
                            <td class="text-center">
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end p-2" style="min-width: 220px;">
                                        <li>
                                            <form action="/pedidosAdmin/{{ $pedido->id }}/estado" method="POST" class="d-flex gap-1">
                                                @csrf
                                                <select name="estado" class="form-select form-select-sm estado-select">
                                                    @foreach(['recibido','en preparación','listo','entregado'] as $estado)
                                                        <option value="{{ $estado }}" {{ $pedido->estado === $estado ? 'selected' : '' }}>
                                                            {{ $estado }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <button type="submit" class="btn btn-sm btn-primary">Guardar</button>
                                            </form>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="/pedidosAdmin/{{ $pedido->id }}" method="POST" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Seguro que quieres eliminar este pedido?')">
                                                    Eliminar pedido
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                No se encontraron pedidos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
