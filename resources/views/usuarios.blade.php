<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Personal</title>
    
    <!-- Bootstrap 5 CSS & JS (Necesario para los dropdowns) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" defer></script>

    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            padding: 20px; 
            background-color: #f4f4f9; 
            color: #333;
        }
        .card { 
            background: white; 
            padding: 25px; 
            border-radius: 8px; 
            max-width: 800px; 
            margin: 0 auto; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
        }

        /* Contenedor para alinear los botones superiores */
        .actions-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Estilos generales para botones superiores */
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
        }

        .btn-custom:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.15);
        }

        .btn-back { background-color: #6c757d; color: white; }
        .btn-back:hover { background-color: #5a6268; color: white; }

        .btn-add { background-color: #2a9d8f; color: white; }
        .btn-add:hover { background-color: #218377; color: white; }

        /* Estilos de la Tabla */
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px 10px; border-bottom: 1px solid #ccc; text-align: left; vertical-align: middle; }
        th { background-color: #264653; color: white; }
        tr:hover { background-color: #f8f9fa; }
    </style>
</head>
<body>

    <div class="card">
        <!-- Barra superior de acciones -->
        <div class="actions-bar">
            <a href="{{ url('/admin') }}" class="btn-custom btn-back">← Volver al Panel</a>
            <a href="{{ url('/crearUsuario') }}" class="btn-custom btn-add">+ Agregar Nuevo Personal</a>
        </div>

        <h2>Personal de Tacostomi</h2>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Rol</th>
                    <th class="text-center">Opciones</th>
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

                    <td class="text-center">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Opciones
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="/editarUsuario/{{ $user->id }}">Editar</a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="/eliminarUsuario/{{ $user->id }}" method="POST" style="margin: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                            Eliminar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>