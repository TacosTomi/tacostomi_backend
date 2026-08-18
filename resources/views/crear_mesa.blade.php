<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Mesa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-dark">Crear Nueva Mesa</h1>
                    <a href="/admin" class="btn btn-secondary">Volver</a>
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

                        <form action="/crearMesa" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="numero_mesa" class="form-label fw-bold">Número de Mesa</label>
                                <input type="number" class="form-control" id="numero_mesa" name="numero_mesa" value="{{ old('$sugerencia') }}" required placeholder="Ej. 1">
                            </div>

                            <div class="mb-3">
                                <label for="estado" class="form-label fw-bold">Estado Inicial</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="disponible" {{ old('estado') == 'disponible' ? 'selected' : '' }}>Disponible</option>
                                    <option value="ocupada" {{ old('estado') == 'ocupada' ? 'selected' : '' }}>Ocupada</option>
                                    <option value="reservada" {{ old('estado') == 'reservada' ? 'selected' : '' }}>Reservada</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="mesero_id" class="form-label fw-bold">Asignar Mesero (Opcional)</label>
                                <select class="form-select" id="mesero_id" name="mesero_id">
                                    <option value="">Sin asignar</option>
                                    @foreach($meseros as $mesero)
                                        <option value="{{ $mesero->id }}" {{ old('mesero_id') == $mesero->id ? 'selected' : '' }}>
                                            {{ $mesero->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Guardar Mesa</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>