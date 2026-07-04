<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Mesas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 text-dark">Gestión de Mesas</h1>
            <div>
                <a href="/crearMesa" class="btn btn-success me-2">Nueva Mesa</a>
                <a href="/admin" class="btn btn-secondary">Volver al Panel</a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>Número de Mesa</th>
                                <th>Estado</th>
                                <th>Mesero Asignado</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($mesas as $mesa)
                                <tr>
                                    <td class="fw-bold fs-5">#{{ $mesa->numero_mesa }}</td>
                                    <td>
                                        @if($mesa->estado == 'disponible')
                                            <span class="badge bg-success">Disponible</span>
                                        @elseif($mesa->estado == 'ocupada')
                                            <span class="badge bg-danger">Ocupada</span>
                                        @else
                                            <span class="badge bg-warning text-dark">Reservada</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($mesa->mesero)
                                            <span class="fw-semibold">{{ $mesa->mesero->nombre }}</span>
                                        @else
                                            <span class="text-muted fst-italic">Sin asignar</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Opciones
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="/editarMesa/{{ $mesa->id }}">Editar</a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <form action="/eliminarMesa/{{ $mesa->id }}" method="POST" style="margin: 0;">
                                                        @csrf
                                                        @method('DELETE') 
                                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Seguro que quieres eliminar la mesa #{{ $mesa->numero_mesa }}, chiavo?')">
                                                            Eliminar 
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        No hay mesas registradas aún. ¡Crea la primera!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>