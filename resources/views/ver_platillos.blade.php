<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Platillos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .img-thumbnail-custom {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h2 text-dark">Menú de Platillos</h1>
            <a href="/admin" class="btn btn-secondary">Volver al Panel Admin</a>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0 card-title fs-6">Filtrar Búsqueda</h5>
            </div>
            <div class="card-body">
                <form action="/platillos" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="categoria_id" class="form-label fw-semibold">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="form-select">
                            <option value="">Todas las categorías</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="precio_max" class="form-label fw-semibold">Precio Máximo ($)</label>
                        <input type="number" name="precio_max" id="precio_max" class="form-control" step="0.01" placeholder="Ej. 150.00" value="{{ request('precio_max') }}">
                    </div>

                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100">Aplicar Filtros</button>
                        <a href="/platillos" class="btn btn-outline-secondary w-100">Limpiar</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0 align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th style="width: 80px;">Imagen</th>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Precio</th>
                                <th>Categoría</th>
                                <th>Estado</th>
                                <th class="text-center">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($platillos as $platillo)
                                <tr>
                                    <td>
                                        @if($platillo->imagen_url)
                                            <img src="{{ $platillo->imagen_url }}" alt="{{ $platillo->nombre }}" class="img-thumbnail img-thumbnail-custom">
                                        @else
                                            <div class="bg-light text-muted d-flex align-items-center justify-content-center border img-thumbnail-custom fs-7 text-center p-1" style="font-size: 11px;">
                                                Sin Foto
                                            </div>
                                        @endif
                                    </td>
                                    <td class="fw-bold">{{ $platillo->nombre }}</td>
                                    <td class="text-secondary text-wrap" style="max-width: 300px;">{{ $platillo->descripcion }}</td>
                                    <td class="fw-semibold">${{ number_format($platillo->precio, 2) }}</td>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $platillo->categoria ? $platillo->categoria->nombre : 'Sin categoría' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($platillo->activo)
                                            <span class="badge bg-success">Activo</span>
                                        @else
                                            <span class="badge bg-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                Opciones
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="/editarPlatillo/{{ $platillo->id }}">Editar</a>
                                                </li>
                                                <li><hr class="dropdown-divider"></li>
                                                <li>
                                                    <a class="dropdown-item text-danger" href="#">Eliminar</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        No se encontraron platillos con los criterios de búsqueda seleccionados.
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