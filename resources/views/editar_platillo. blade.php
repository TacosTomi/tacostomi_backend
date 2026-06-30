<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Platillo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">✏️ Editar Platillo: {{ $platillo->nombre }}</h5>
                    </div>
                    <div class="card-body">
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="/editarPlatillo/{{ $platillo->id }}" method="POST">
                            @csrf 
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre del Platillo:</label>
                                <input type="text" name="nombre" class="form-control" value="{{ $platillo->nombre }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Descripción:</label>
                                <textarea name="descripcion" class="form-control" rows="3" required>{{ $platillo->descripcion }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Precio ($):</label>
                                <input type="number" name="precio" step="0.01" class="form-control" value="{{ $platillo->precio }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Categoría:</label>
                                <select name="categoria_id" class="form-select" required>
                                    @foreach($categorias as $cat)
                                        <option value="{{ $cat->id }}" {{ $platillo->categoria_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Estado:</label>
                                <select name="activo" class="form-select" required>
                                    <option value="1" {{ $platillo->activo == 1 ? 'selected' : '' }}>Activo (Visible en el menú)</option>
                                    <option value="0" {{ $platillo->activo == 0 ? 'selected' : '' }}>Inactivo (Oculto / Agotado)</option>
                                </select>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
                                <a href="/admin" class="btn btn-outline-secondary w-100">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>