<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Platillo - Tacostomi</title>
    <style>
        body { 
            font-family: sans-serif; 
            display: flex; 
            justify-content: center; 
            margin-top: 50px; 
            background-color: #f4f4f9; 
        }
        .card { 
            background-color: white; 
            border: 1px solid #ccc; 
            padding: 30px; 
            border-radius: 8px; 
            width: 400px; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        }
        h2 { color: #264653; text-align: center; margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; font-size: 0.9em; }
        input[type="text"], input[type="number"], select, textarea { 
            width: 95%; 
            padding: 10px; 
            border: 1px solid #ccc; 
            border-radius: 4px; 
            font-size: 14px; 
        }
        textarea { resize: vertical; height: 80px; }
        .btn-submit { 
            width: 100%; 
            padding: 12px; 
            background-color: #e76f51; /* Un tono naranja/rojizo para que resalte */
            color: white; 
            border: none; 
            border-radius: 4px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold; 
            margin-bottom: 10px; 
            transition: background-color 0.3s;
        }
        .btn-submit:hover { background-color: #d65a3e; }
        .btn-back { 
            display: block; 
            text-align: center; 
            width: 95%; 
            padding: 10px; 
            background-color: #ccc; 
            color: black; 
            text-decoration: none; 
            border-radius: 4px; 
            transition: background-color 0.3s;
        }
        .btn-back:hover { background-color: #bbb; }
        .error-box { 
            background-color: #ffe6e6; 
            color: red; 
            padding: 10px; 
            margin-bottom: 15px; 
            border: 1px solid red; 
            border-radius: 4px; 
            font-size: 0.9em;
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Nuevo Platillo</h2>

        @if($errors->any())
            <div class="error-box">
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="/crearPlatillo" method="POST">
            @csrf <div class="form-group">
                <label>Nombre del Platillo:</label>
                <input type="text" name="nombre" placeholder="Ej. Tacos al Pastor" required>
            </div>

            <div class="form-group">
                <label>Descripción:</label>
                <textarea name="descripcion" placeholder="Ej. Orden de 5 tacos con piña, cebolla y cilantro..." required></textarea>
            </div>

            <div class="form-group">
                <label>Precio ($):</label>
                <input type="number" name="precio" step="0.01" required>
            </div>

            <div class="form-group">
                <label>Categoría:</label>
                <select name="categoria_id" required>
                    <option value="" disabled selected>Selecciona una categoría...</option>
                    
                    @foreach($categorias as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Estado Inicial:</label>
                <select name="activo" required>
                    <option value="1" selected>Activo (Visible en el menú)</option>
                    <option value="0">Inactivo (Oculto / Agotado)</option>
                </select>
            </div>

            <button type="submit" class="btn-submit">Guardar Platillo</button>
            <a href="/admin" class="btn-back">Cancelar y Volver</a>
        </form>
    </div>

</body>
</html>