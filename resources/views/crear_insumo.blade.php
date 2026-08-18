<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Insumo - Tacostomi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3 text-dark">Registrar Insumo</h1>
                    <a href="/insumos" class="btn btn-secondary">Volver</a>
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

                        <form action="/crearInsumo" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="nombre" class="form-label fw-bold">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="{{ old('nombre') }}" required placeholder="Ej. Tortilla">
                            </div>

                            <div class="mb-3">
                                <label for="unidad_medida" class="form-label fw-bold">Unidad de medida</label>
                                <select class="form-select" id="unidad_medida" name="unidad_medida" required>
                                    @php $unidad = old('unidad_medida'); @endphp
                                    <option value="">Selecciona...</option>
                                    @foreach(['kg','g','L','ml','pza','bolsa'] as $u)
                                        <option value="{{ $u }}" {{ $unidad === $u ? 'selected' : '' }}>{{ $u }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="stock_minimo" class="form-label fw-bold">Stock mínimo</label>
                                <input type="number" step="0.001" min="0" class="form-control" id="stock_minimo" name="stock_minimo" value="{{ old('stock_minimo') }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="stock_inicial" class="form-label fw-bold">Stock inicial (opcional)</label>
                                <input type="number" step="0.001" min="0" class="form-control" id="stock_inicial" name="stock_inicial" value="{{ old('stock_inicial', 0) }}">
                                <div class="form-text">Si lo dejas en 0, el insumo arranca vacío y luego registras una entrada.</div>
                            </div>

                            <button type="submit" class="btn btn-success w-100">Guardar Insumo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
