<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Insumo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0">Editar Insumo: {{ $insumo->nombre }}</h5>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <p class="text-muted">El stock no se edita aquí. Usa Entrada / Salida para mover inventario.</p>

                        <form action="/editarInsumo/{{ $insumo->id }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-bold">Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $insumo->nombre) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Unidad de medida</label>
                                <select name="unidad_medida" class="form-select" required>
                                    @php $unidad = old('unidad_medida', $insumo->unidad_medida); @endphp
                                    @foreach(['kg','g','L','ml','pza','bolsa'] as $u)
                                        <option value="{{ $u }}" {{ $unidad === $u ? 'selected' : '' }}>{{ $u }}</option>
                                    @endforeach
                                    @if($unidad && !in_array($unidad, ['kg','g','L','ml','pza','bolsa']))
                                        <option value="{{ $unidad }}" selected>{{ $unidad }}</option>
                                    @endif
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Stock mínimo</label>
                                <input type="number" step="0.001" min="0" name="stock_minimo" class="form-control" value="{{ old('stock_minimo', $insumo->stock_minimo) }}" required>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success w-100">Guardar Cambios</button>
                                <a href="/insumos" class="btn btn-outline-secondary w-100">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
