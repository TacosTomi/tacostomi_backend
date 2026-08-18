<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Platillos</title>
    
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
            max-width: 1000px; 
            margin: 0 auto; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        }

        /* Barra superior de botones */
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

        .btn-add { background-color: #2a9d8f; color: white; }
        .btn-add:hover { background-color: #218377; color: white; }

        /* Miniatura de imagen */
        .img-thumbnail-custom {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Tabla */
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #264653 !important; color: white !important; }
    </style>
</head>
<body>

    <div class="main-card">
        <!-- Barra superior de botones -->
        <div class="actions-bar">
            <a href="/admin" class="btn-custom btn-back">← Volver al Panel Admin</a>
            <a href="/crearPlatillo" class="btn-custom btn-add">+ Agregar Nuevo Platillo</a>
        </div>

        <h1 class="h2 text-dark mb-4">Menú de Platillos</h1>

        <!-- Tarjeta de Filtros -->
        <div class="card mb-4 border-0 bg-light shadow-sm">
            <div class="card-header bg-dark text-white fw-bold">
                Filtrar Búsqueda
            </div>
            <div class="card-body">
                <form action="/platillosAdmin" method="GET" class="row g-3 align-items-end">
        
                    <div class="col-md-3">
                        <label for="categoria_id" class="form-label fw-semibold">Categoría</label>
                        <select name="categoria_id" id="categoria_id" class="form-select">
                            <option value="">Todas</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ request('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="precio_max" class="form-label fw-semibold">Precio Máx ($)</label>
                        <input type="number" name="precio_max" id="precio_max" class="form-control" step="0.01" placeholder="Ej. 150.00" value="{{ request('precio_max') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="disponibilidad" class="form-label fw-semibold">Disponibilidad</label>
                        <select name="disponibilidad" id="disponibilidad" class="form-select">
                            <option value="">Todos</option>
                            <option value="1" {{ request('disponibilidad') == '1' ? 'selected' : '' }}>Activos</option>
                            <option value="0" {{ request('disponibilidad') == '0' ? 'selected' : '' }}>Inactivos</option>
                        </select>
                    </div>

                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Aplicar</button>
                        <a href="/platillosAdmin" class="btn btn-outline-secondary w-100">Limpiar</a>                    
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de Platillos -->
        <div class="table-responsive border rounded">
            <table class="table table-striped table-hover mb-0 align-middle">
                <thead>
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
                            <td class="text-secondary text-wrap" style="max-width: 250px;">{{ $platillo->descripcion }}</td>
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
                                    <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Opciones
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="/editarPlatillo/{{ $platillo->id }}">Editar</a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="/eliminarPlatillo/{{ $platillo->id }}" method="POST" style="margin: 0;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Seguro que quieres eliminar este platillo?')">
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
                            <td colspan="7" class="text-center py-4 text-muted">
                                No se encontraron platillos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>