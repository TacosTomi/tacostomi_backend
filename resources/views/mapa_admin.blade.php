<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion de mesas - TacosTomi</title>
    <!-- CSRF Token necesario para enviar datos por POST en JS -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Librería para el Drag & Drop -->
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
</head>
<body class="bg-gray-100 p-6 min-h-screen">
    <div class="max-w-6xl mx-auto">
        
        <!-- HEADER ADMIN -->
        <div class="flex justify-between items-center mb-6">
            <div class="flex items-center gap-4">
                <h1 class="text-3xl font-bold text-gray-800">GESTION DE MESAS</h1>
                
                <!-- Filtro de Meseros -->
                <select id="filtro-mesero" class="border border-gray-300 rounded p-2" onchange="filtrarMesero()">
                    <option value="ALL">MESEROS [ALL]</option>
                    @foreach($meseros as $mesero)
                        <option value="{{ $mesero->id }}">{{ $mesero->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <a href="/admin" class="bg-gray-800 text-white px-4 py-2 rounded shadow hover:bg-gray-700">MENU ADMIN</a>
                <a href="/verMesas" class="bg-gray-800 text-white px-4 py-2 rounded shadow hover:bg-gray-700">VISTA TABLA</a>
                <button id="btn-editar" onclick="toggleModoEdicion()" class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-500">EDITAR MAPA</button>
                
                <!-- Botones ocultos que aparecen al editar -->
                <button id="btn-deshacer" onclick="deshacer()" class="hidden bg-yellow-500 text-white px-4 py-2 rounded shadow hover:bg-yellow-400">DESHACER</button>
                <button id="btn-hecho" onclick="guardarMapa()" class="hidden bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-500">HECHO</button>
            </div>
        </div>

        <!-- CONTENEDOR DEL MAPA -->
        <div id="mapa-mesas" class="relative w-full h-[700px] bg-white border border-gray-300 rounded-xl shadow-lg overflow-hidden">
            
            @foreach($mesas as $mesa)
                @php
                    // Lógica de Colores por Estado (Bordes)
                    $borderColor = 'border-gray-400';
                    if($mesa->estado == 'disponible') $borderColor = 'border-green-500';
                    if($mesa->estado == 'ocupada') $borderColor = 'border-red-500';
                    if($mesa->estado == 'reservada') $borderColor = 'border-yellow-400';
                @endphp

                <!-- Cada mesa tiene data-id y data-mesero para facilitar el JS -->
                <div class="mesa absolute w-24 h-24 rounded-lg border-4 flex items-center justify-center bg-gray-50 select-none {{ $borderColor }} transition-opacity duration-300"
                     data-id="{{ $mesa->id }}"
                     data-mesero="{{ $mesa->mesero_id }}"
                     style="left: {{ $mesa->pos_x }}px; top: {{ $mesa->pos_y }}px;">
                    <span class="font-normal text-lg text-gray-700 mesa-numero">{{ $mesa->numero_mesa }}</span>
                </div>
            @endforeach

        </div>
    </div>

    <script>
        let modoEdicion = false;
        let historialMovimientos = []; // Aquí guardaremos el paso anterior para el Ctrl+Z

        // 1. LÓGICA DEL FILTRO DE MESEROS
        function filtrarMesero() {
            if(modoEdicion) return; // No filtramos si estamos editando
            
            const meseroSeleccionado = document.getElementById('filtro-mesero').value;
            const mesas = document.querySelectorAll('.mesa');

            mesas.forEach(mesa => {
                const idMeseroMesa = mesa.getAttribute('data-mesero');
                const numeroSpan = mesa.querySelector('.mesa-numero');

                if (meseroSeleccionado === 'ALL') {
                    mesa.classList.remove('opacity-30');
                    numeroSpan.classList.replace('font-black', 'font-normal');
                    numeroSpan.classList.replace('text-2xl', 'text-lg');
                } else {
                    if (idMeseroMesa === meseroSeleccionado) {
                        mesa.classList.remove('opacity-30');
                        numeroSpan.classList.replace('font-normal', 'font-black');
                        numeroSpan.classList.replace('text-lg', 'text-2xl');
                    } else {
                        mesa.classList.add('opacity-30');
                        numeroSpan.classList.replace('font-black', 'font-normal');
                        numeroSpan.classList.replace('text-2xl', 'text-lg');
                    }
                }
            });
        }

        // 2. ACTIVAR / DESACTIVAR MODO EDICIÓN
        function toggleModoEdicion() {
            modoEdicion = !modoEdicion;
            
            // Forzamos ver todas las mesas sin opacidad al editar
            document.getElementById('filtro-mesero').value = 'ALL';
            filtrarMesero();
            document.getElementById('filtro-mesero').disabled = modoEdicion;

            // Mostrar/Ocultar botones
            document.getElementById('btn-editar').classList.toggle('hidden');
            document.getElementById('btn-deshacer').classList.toggle('hidden');
            document.getElementById('btn-hecho').classList.toggle('hidden');

            const mesas = document.querySelectorAll('.mesa');
            mesas.forEach(mesa => {
                if (modoEdicion) {
                    mesa.classList.add('cursor-move', 'draggable', 'border-dashed');
                } else {
                    mesa.classList.remove('cursor-move', 'draggable', 'border-dashed');
                }
            });
        }

        // 3. LÓGICA DE DRAG & DROP (Interact.js)
        interact('.draggable').draggable({
            listeners: {
                start(event) {
                    // Guardamos la posición original antes de mover para el botón DESHACER
                    const target = event.target;
                    historialMovimientos.push({
                        elemento: target,
                        oldLeft: target.style.left,
                        oldTop: target.style.top
                    });
                },
                move(event) {
                    const target = event.target;
                    
                    // Obtenemos las coordenadas actuales, sumamos el movimiento del mouse y aplicamos
                    let currentLeft = parseFloat(target.style.left) || 0;
                    let currentTop = parseFloat(target.style.top) || 0;

                    target.style.left = (currentLeft + event.dx) + 'px';
                    target.style.top = (currentTop + event.dy) + 'px';
                }
            }
        });

        // 4. BOTÓN DESHACER (1 paso)
        function deshacer() {
            if (historialMovimientos.length > 0) {
                const ultimoPaso = historialMovimientos.pop();
                ultimoPaso.elemento.style.left = ultimoPaso.oldLeft;
                ultimoPaso.elemento.style.top = ultimoPaso.oldTop;
            }
        }

        // 5. GUARDAR MAPA (Enviar datos a Laravel)
        function guardarMapa() {
            const mesasElements = document.querySelectorAll('.mesa');
            let datosMesas = [];

            // Recopilamos los datos de todas las mesas
            mesasElements.forEach(mesa => {
                datosMesas.push({
                    id: mesa.getAttribute('data-id'),
                    // Agregamos Math.round() para que Postgres no rechace los decimales
                    x: Math.round(parseFloat(mesa.style.left)) || 0,
                    y: Math.round(parseFloat(mesa.style.top)) || 0
                });
            });

            // Petición AJAX (Fetch) a Laravel
            fetch('/guardarCoordenadas', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ mesas: datosMesas })
            })
            .then(async response => {
                if (!response.ok) {
                    const errorText = await response.text();
                    throw new Error('Error del servidor: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.message); 
                    toggleModoEdicion(); 
                    historialMovimientos = []; 
                    
                    window.location.href = '/descargarExcelMapa';
                }
            })
            .catch(error => {
                console.error('Error completo:', error);
                alert('Ocurrió un error al guardar. Presiona F12 y revisa la pestaña "Console" para más detalles.');
            });
        }
    </script>
</body>
</html>