<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Mesa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-dark">Editar Mesa #{{ $mesa->numero_mesa }}</h1>
                    <a href="/verMesas" class="btn btn-secondary">Volver</a>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="/editarMesa/{{ $mesa->id }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Número de Mesa</label>
                                <input type="text" class="form-control bg-light" value="{{ $mesa->numero_mesa }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="estado" class="form-label fw-bold">Estado de la Mesa</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="disponible" {{ (old('estado', $mesa->estado) == 'disponible') ? 'selected' : '' }}>Disponible</option>
                                    <option value="ocupada" {{ (old('estado', $mesa->estado) == 'ocupada') ? 'selected' : '' }}>Ocupada</option>
                                    <option value="reservada" {{ (old('estado', $mesa->estado) == 'reservada') ? 'selected' : '' }}>Reservada</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="mesero_id" class="form-label fw-bold">Asignar / Cambiar Mesero</label>
                                <select class="form-select" id="mesero_id" name="mesero_id" required>
                                    <option value="">Selecciona un mesero...</option>
                                    @foreach($meseros as $mesero)
                                        <option value="{{ $mesero->id }}" {{ (old('mesero_id', $mesa->mesero_id) == $mesero->id) ? 'selected' : '' }}>
                                            {{ $mesero->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Actualizar Mesa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>