<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Personal - Tacostomi</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; margin-top: 50px; }
        .card { border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 350px; }
        .form-group { margin-bottom: 15px; }
        input, select { width: 95%; padding: 8px; margin-top: 5px; }
        .btn-submit { width: 100%; padding: 10px; background-color: #2a9d8f; color: white; border: none; cursor: pointer; margin-bottom: 10px; }
        .btn-back { display: block; text-align: center; width: 95%; padding: 10px; background-color: #ccc; color: black; text-decoration: none; }
        .error-box { background-color: #ffe6e6; color: red; padding: 10px; margin-bottom: 15px; border: 1px solid red; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Alta de Personal</h2>

        @if($errors->any())
            <div class="error-box">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/crearUsuario" method="POST">
            @csrf <div class="form-group">
                <label>Nombre Completo:</label>
                <input type="text" name="nombre" required>
            </div>

            <div class="form-group">
                <label>Correo Electrónico:</label>
                <input type="email" name="correo" required>
            </div>

            <div class="form-group">
                <label>Contraseña Temporal:</label>
                <input type="password" name="password" required>
            </div>

            <div class="form-group">
                <label>Confirmar Contraseña:</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <div class="form-group">
                <label>Rol en el Restaurante:</label>
                <select name="rol_id" required>
                    <option value="1">Administrador</option>
                    <option value="2">Cajero</option>
                    <option value="3" selected>Mesero</option>
                    <option value="4">Garrotero</option>
                    <option value="5">Cocina</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Registrar Empleado</button>
            
            <a href="/admin" class="btn-back">Cancelar y Volver</a>
        </form>
    </div>

</body>
</html>