<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú del Restaurante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
        }
        /* Estilos del Banner */
        .banner-container {
            position: relative;
            height: 220px;
            overflow: hidden;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .banner-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(0.6); /* Oscurece un poco la imagen para que resalte el texto */
        }
        .banner-title {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-weight: 800;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
        }
        
        /* Menú de categorías scrolleable en móvil */
        .category-tabs {
            display: flex;
            overflow-x: auto;
            gap: 10px;
            padding-bottom: 10px;
            -ms-overflow-style: none; /* Oculta scrollbar en IE */
            scrollbar-width: none; /* Oculta scrollbar en Firefox */
        }
        .category-tabs::-webkit-scrollbar {
            display: none; /* Oculta scrollbar en Chrome/Safari */
        }
        .btn-category {
            white-space: nowrap;
            border-radius: 20px;
            font-weight: 600;
            padding: 8px 24px;
        }

        /* Estilos de las tarjetas (Grid) */
        .platillo-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }
        .platillo-card:hover {
            transform: translateY(-5px);
        }
        .img-platillo {
            height: 160px;
            object-fit: cover;
            border-top-left-radius: 16px;
            border-top-right-radius: 16px;
        }
        
        /* Truncar descripción a 2 líneas */
        .desc-truncate {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>

    <div class="banner-container">
        <img src="https://images.unsplash.com/photo-1551504734-5ee1c4a1479b?auto=format&fit=crop&w=1200&q=80" alt="Banner" class="banner-img">
        <h1 class="banner-title text-center">NUESTRO MENÚ</h1>
    </div>

    <div class="container mt-4 mb-5">
        
        <div class="d-flex justify-content-end mb-4">
            <button class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm">
                <i class="bi bi-bag-check-fill me-2"></i> Ver Mi Orden
            </button>
        </div>

        <div class="category-tabs mb-4" id="categoryTabs">
            <button class="btn btn-danger btn-category active filter-btn" data-filter="all">Todos</button>
            <button class="btn btn-outline-danger btn-category filter-btn" data-filter="2">Tacos</button>
            <button class="btn btn-outline-danger btn-category filter-btn" data-filter="3">Bebidas</button>
            <button class="btn btn-outline-danger btn-category filter-btn" data-filter="1">Postres</button>
        </div>

        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3" id="menuGrid">
            
            @foreach($platillos as $platillo)
                <div class="col platillo-item" data-category="{{ $platillo->categoria_id }}">
                    <div class="card platillo-card h-100">
                        @if($platillo->imagen_url)
                            <img src="{{ $platillo->imagen_url }}" class="card-img-top img-platillo" alt="{{ $platillo->nombre }}">
                        @else
                            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=400&q=80" class="card-img-top img-platillo" alt="Sin foto">
                        @endif
                        
                        <div class="card-body p-2 p-md-3 d-flex flex-column justify-content-between">
                            <div class="d-flex justify-content-between align-items-start gap-2 mb-1">
                                <h6 class="card-title fw-bold mb-0 text-dark lh-sm" style="font-size: 0.95rem;">
                                    {{ $platillo->nombre }}
                                </h6>
                                <span class="badge bg-danger rounded-pill fs-6">
                                    ${{ number_format($platillo->precio, 2) }}
                                </span>
                            </div>
                            <p class="text-muted mt-2 mb-0 desc-truncate">{{ $platillo->descripcion }}</p>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const menuItems = document.querySelectorAll('.platillo-item');

            filterButtons.forEach(button => {
                button.addEventListener('click', () => {
                    // 1. Quitar la clase 'btn-danger' y 'active' a todos los botones, dejarlos como outline
                    filterButtons.forEach(btn => {
                        btn.classList.remove('btn-danger', 'active');
                        btn.classList.add('btn-outline-danger');
                    });

                    // 2. Poner 'btn-danger' al botón seleccionado
                    button.classList.remove('btn-outline-danger');
                    button.classList.add('btn-danger', 'active');

                    // 3. Obtener el filtro (1, 2, 3 o 'all')
                    const filterValue = button.getAttribute('data-filter');

                    // 4. Mostrar/Ocultar los platillos con una animación sencilla
                    menuItems.forEach(item => {
                        if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>