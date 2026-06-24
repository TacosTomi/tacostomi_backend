<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Tacostomi</title>
    <style>
        body { font-family: sans-serif; display: flex; justify-content: center; margin-top: 50px; }
        .card { border: 1px solid #ccc; padding: 20px; border-radius: 8px; width: 300px; }
        .form-group { margin-bottom: 15px; }
        input { width: 90%; padding: 8px; }
        button { width: 100%; padding: 10px; background-color: #e63946; color: white; border: none; cursor: pointer; }
    </style>
</head>
<body>

    <div class="card">
        <h2>Iniciar Sesión</h2>

        @if($errors->any())
            <div style="color: red; margin-bottom: 15px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST">
            @csrf <div class="form-group">
                <label>Correo:</label>
                <input type="email" name="correo" required>
            </div>

            <div class="form-group">
                <label>Contraseña:</label>
                <input type="password" name="password" required>
            </div>

            <button type="submit">Entrar</button>
        </form>
    </div>

</body>
</html>