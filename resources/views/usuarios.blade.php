<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Personal</title>
    <style>
        body { font-family: sans-serif; padding: 20px; background-color: #f4f4f9; }
        .card { background: white; padding: 20px; border-radius: 8px; max-width: 600px; margin: 0 auto; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 10px; border-bottom: 1px solid #ccc; text-align: left; }
        th { background-color: #264653; color: white; }
        .btn-back { display: inline-block; padding: 8px 15px; background-color: #ccc; text-decoration: none; color: black; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>

    <div class="card">
        <a href="/admin" class="btn-back">← Volver al Panel</a>
        <h2>Personal de Tacostomi</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->nombre }}</td>
                    <td>{{ $user->correo }}</td>
                    <td>
                        @switch($user->rol_id)
                            @case(1)
                                <span style="color: blue; font-weight: bold;">Gerente</span>
                                @break
                            @case(2)
                                Cajero
                                @break
                            @case(3)
                                Mesero
                                @break
                            @case(4)
                                Garrotero
                                @break
                            @case(5)
                                Cocinero
                                @break
                            @default
                                Desconocido
                        @endswitch
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>