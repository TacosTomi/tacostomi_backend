<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimiento de Insumo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h1 class="h3">Stock: {{ $insumo->nombre }}</h1>
                    <a href="/insumos" class="btn btn-secondary">Volver</a>
                </div>

                @php $estado = $insumo->estadoStock(); @endphp
                <div class="alert {{ $estado === 'agotado' ? 'alert-danger' : ($estado === 'bajo' ? 'alert-warning' : 'alert-success') }}">
                    Stock actual: <strong>{{ rtrim(rtrim(number_format($insumo->stock_actual, 3, '.', ''), '0'), '.') }} {{ $insumo->unidad_medida }}</strong>
                    · Mínimo: {{ rtrim(rtrim(number_format($insumo->stock_minimo, 3, '.', ''), '0'), '.') }}
                    @if($estado === 'agotado')
                        · Agotado
                    @elseif($estado === 'bajo')
                        · Bajo el mínimo
                    @endif
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">Registrar entrada o salida</div>
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

                        <form action="/insumos/{{ $insumo->id }}/movimiento" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tipo</label>
                                <select name="tipo" class="form-select" required>
                                    <option value="ENTRADA" {{ old('tipo') === 'ENTRADA' ? 'selected' : '' }}>Entrada</option>
                                    <option value="SALIDA" {{ old('tipo') === 'SALIDA' ? 'selected' : '' }}>Salida</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Cantidad ({{ $insumo->unidad_medida }})</label>
                                <input type="number" step="0.001" min="0.001" name="cantidad" class="form-control" value="{{ old('cantidad') }}" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Actualizar stock</button>
                        </form>
                    </div>
                </div>

                @if($insumo->platillos->count())
                    <div class="card shadow-sm mt-4">
                        <div class="card-header">Se usa en estos platillos</div>
                        <ul class="list-group list-group-flush">
                            @foreach($insumo->platillos as $platillo)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>{{ $platillo->nombre }}</span>
                                    <span class="text-muted">{{ $platillo->pivot->cantidad_necesaria }} {{ $insumo->unidad_medida }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
