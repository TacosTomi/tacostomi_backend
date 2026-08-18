<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario - Tacos Tomi</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            padding: 20px; 
            background-color: #f4f4f9; 
            color: #333;
        }
        .card-custom { 
            background: white; 
            padding: 30px; 
            border-radius: 8px; 
            max-width: 550px; 
            margin: 40px auto; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        }
        .btn-custom {
            background-color: #2a9d8f;
            color: white;
            font-weight: bold;
        }
        .btn-custom:hover {
            background-color: #218377;
            color: white;
        }
    </style>
</head>
<body>

    <div class="card-custom">
        <a href="/usuarios" class="btn btn-secondary btn-sm mb-3">← Volver al Personal</a>
        
        <h2 class="h4 mb-4 text-dark border-bottom pb-2">Editar Empleado: {{ $user->nombre }}</h2>

        <form action="/editarUsuario/{{ $user->id }}" method="POST">
            @csrf

            <!-- Nombre -->
            <div class="mb-3">
                <label for="nombre" class="form-label fw-semibold">Nombre Completo</label>
                <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $user->nombre) }}" required>
            </div>

            <!-- Correo -->
            <div class="mb-3">
                <label for="correo" class="form-label fw-semibold">Correo Electrónico</label>
                <input type="email" name="correo" id="correo" class="form-control" value="{{ old('correo', $user->correo) }}" required>
            </div>

            <!-- Rol -->
            <div class="mb-4">
                <label for="rol_id" class="form-label fw-semibold">Rol del Usuario</label>
                <select name="rol_id" id="rol_id" class="form-select" required>
                    <option value="1" {{ $user->rol_id == 1 ? 'selected' : '' }}>Gerente</option>
                    <option value="2" {{ $user->rol_id == 2 ? 'selected' : '' }}>Cajero</option>
                    <option value="3" {{ $user->rol_id == 3 ? 'selected' : '' }}>Mesero</option>
                    <option value="4" {{ $user->rol_id == 4 ? 'selected' : '' }}>Cocinero</option>
                    <option value="5" {{ $user->rol_id == 5 ? 'selected' : '' }}>Cliente</option>
                </select>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-end gap-2">
                <a href="/usuarios" class="btn btn-outline-secondary">Cancelar</a>
                <button type="submit" class="btn btn-custom">Guardar Cambios</button>
            </div>
        </form>
    </div>

</body>
</html>