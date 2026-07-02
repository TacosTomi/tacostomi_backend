<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador - Tacostomi</title>
    <style>
        body { 
            font-family: sans-serif; 
            display: flex; 
            justify-content: center; 
            margin-top: 50px; 
            background-color: #f4f4f9; 
        }
        .container { 
            background-color: white; 
            border: 1px solid #ccc; 
            padding: 30px; 
            border-radius: 8px; 
            width: 400px; 
            text-align: center; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        }
        h1 { color: #264653; margin-top: 0; }
        p { font-size: 1.1em; color: #333; margin-bottom: 30px; }
        .btn-add { 
            display: inline-block; 
            padding: 12px 20px; 
            background-color: #2a9d8f; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
            font-weight: bold; 
            transition: background-color 0.3s;
            width: 80%;
        }
        .btn-add:hover { background-color: #21867a; }
        .logout-link {
            display: block;
            margin-top: 25px;
            color: #e63946;
            text-decoration: none;
            font-size: 0.9em;
        }
        .btnsPanel{margin-bottom: 15px}
    </style>
</head>
<body>

    <div class="container">
        <h1>Panel de Administrador</h1>
        
        <p>¡Bienvenido de vuelta, <strong>{{ auth()->user()->nombre }}</strong>!</p>

        <div class="btnsPanel">
            <a  href="/crearUsuario" class="btn-add">+ Agregar Nuevo Personal</a>
        </div>
        <div class="btnsPanel">        
            <a  href="/usuarios" class="btn-add" style="background-color: #e9c46a; color: #264653;">Ver Lista de Personal</a>
        </div>
    
        <div class="btnsPanel">
            <a href="/crearPlatillo" class="btn-add" style="background-color: #e9c46a; color: #264653;">Agregar platillos</a>
        </div>

        <div class="btnsPanel">
            <a href="/platillos" class="btn-add" style="background-color: #e9c46a; color: #264653;">Ver platillos</a>
        </div>

        <a href="/logout" class="logout-link">Cerrar Sesión</a>
    </div>

</body>
</html>