<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa de Mesas - TacosTomi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 p-6 min-h-screen">
    <div class="max-w-6xl mx-auto">
        
        <div class="flex justify-between items-center mb-6">
            
            <div class="flex items-center gap-4">
                <h1 class="text-3xl font-bold text-gray-800">
                    Mapa - {{ auth()->user()->nombre ?? 'Mesero' }}
                </h1>
                
                <a href="/logout" class="bg-red-400 hover:bg-red-600 text-white px-4 py-2 rounded-lg font-semibold shadow transition-colors text-sm flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Salir
                </a>
            </div>

            <div class="flex gap-4 bg-white p-3 rounded-lg shadow-sm">
                <span class="flex items-center gap-2"><div class="w-4 h-4 bg-green-500 rounded-full border border-gray-300"></div> Disponible</span>
                <span class="flex items-center gap-2"><div class="w-4 h-4 bg-red-500 rounded-full border border-gray-300"></div> Ocupada</span>
                <span class="flex items-center gap-2"><div class="w-4 h-4 bg-yellow-400 rounded-full border border-gray-300"></div> Reservada</span>
            </div>
            
        </div>

        <div id="mapa-mesas" class="relative w-full h-[700px] bg-white border border-gray-300 rounded-xl shadow-lg overflow-hidden">
            
            @foreach($mesas as $mesa)
                @php
                    // 1. Lógica de Colores por Estado (Bordes)
                    $borderColor = 'border-gray-400'; // Por defecto
                    if($mesa->estado == 'disponible') $borderColor = 'border-green-500';
                    if($mesa->estado == 'ocupada') $borderColor = 'border-red-500';
                    if($mesa->estado == 'reservada') $borderColor = 'border-yellow-400';

                    // 2. Lógica de Asignación y Opacidad
                    $esMiMesa = $mesa->mesero_id == auth()->id();
                    
                    // Si es su mesa, opacidad al 100%, cursor de "clic" y hover. 
                    // Si NO es su mesa, opacidad baja y evitamos que JavaScript registre clics (pointer-events-none).
                    $opacidadYEventos = $esMiMesa ? 'opacity-100 cursor-pointer hover:scale-110 transition-transform shadow-lg' : 'opacity-30 pointer-events-none';
                    
                    // Número en BOLD si es suya
                    $pesoTexto = $esMiMesa ? 'font-black text-2xl text-gray-800' : 'font-normal text-lg text-gray-500';
                @endphp

                <div class="mesa absolute w-24 h-24 rounded-lg border-4 flex items-center justify-center bg-gray-50 select-none {{ $borderColor }} {{ $opacidadYEventos }}"
                     style="left: {{ $mesa->pos_x }}px; top: {{ $mesa->pos_y }}px;"
                     @if($esMiMesa) onclick="abrirMenuMesa({{ $mesa->id }}, {{ $mesa->numero_mesa }}, event)" @endif>
                    <span class="{{ $pesoTexto }}">{{ $mesa->numero_mesa }}</span>
                </div>
            @endforeach

        </div>
    </div>

    <div id="menu-flotante" class="hidden fixed bg-white rounded-lg shadow-2xl border border-gray-200 w-48 overflow-hidden z-50 transition-opacity">
        <div class="bg-gray-800 text-white text-center py-2 font-bold" id="menu-titulo">Mesa #</div>
        <button onclick="accionEditar()" class="w-full text-left px-5 py-3 hover:bg-blue-50 border-b font-semibold text-blue-600 transition-colors">EDITAR</button>
        <button onclick="accionPagado()" class="w-full text-left px-5 py-3 hover:bg-green-50 border-b font-semibold text-green-600 transition-colors">PAGADO</button>
        <button onclick="accionGerente()" class="w-full text-left px-5 py-3 hover:bg-red-50 font-semibold text-red-600 transition-colors">GERENTE</button>
    </div>

    <script>
        let mesaSeleccionada = null;
        const menuFlotante = document.getElementById('menu-flotante');

        function abrirMenuMesa(id, numero, event) {
            event.stopPropagation(); // Evita que el clic cierre el menú al instante
            
            mesaSeleccionada = id;
            document.getElementById('menu-titulo').innerText = 'Mesa ' + numero;

            // Posicionamos el menú exactamente donde el mesero hizo clic
            menuFlotante.style.left = `${event.clientX}px`;
            menuFlotante.style.top = `${event.clientY}px`;
            
            // Mostramos el menú
            menuFlotante.classList.remove('hidden');
        }

        // Si hacen clic en cualquier otra parte del mapa, el menú se esconde
        document.addEventListener('click', function(event) {
            if (!menuFlotante.contains(event.target)) {
                menuFlotante.classList.add('hidden');
            }
        });

        // ----------------------------------------------------
        // ACCIONES DE LOS BOTONES (Por ahora son solo Alertas)
        // ----------------------------------------------------
        function accionEditar() {
            alert('Abriendo pedido de la mesa ID: ' + mesaSeleccionada);
            // window.location.href = '/editar-pedido/' + mesaSeleccionada;
        }

        function accionPagado() {
            alert('Cobrando mesa ID: ' + mesaSeleccionada + ' y liberándola...');
            // window.location.href = '/pagar-mesa/' + mesaSeleccionada;
        }

        function accionGerente() {
            // Mandamos al 404 como pediste por ahora
            window.location.href = '/llamada-gerente-404';
        }
    </script>
</body>
</html>