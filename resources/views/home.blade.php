<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tacos Tomi - Inicio</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            text-align: center;
            padding: 20px;
            background-color: #f8f9fa;
            color: #333;
        }

        /* Estilos de la barra de navegación / botones */
        .nav-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .btn {
            text-decoration: none;
            padding: 12px 24px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border-radius: 6px;
            transition: background-color 0.2s, transform 0.1s;
            box-shadow: 0 2px 5px rgba(0,0,0,0.15);
        }

        .btn:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }

        .btn-admin { background-color: #343a40; }
        .btn-admin:hover { background-color: #23272b; }

        .btn-mesero { background-color: #28a745; }
        .btn-mesero:hover { background-color: #218838; }

        .btn-cajero { background-color: #fd7e14; }
        .btn-cajero:hover { background-color: #e06b0d; }

        /* Contenedor del Video */
        .video-container {
            max-width: 800px;
            margin: 0 auto;
            min-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .home-video {
            width: 100%;
            max-width: 720px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            cursor: pointer;
            outline: none;
        }

        .fallback-text {
            display: none;
            font-size: 1.3rem;
            color: #d9534f;
            font-weight: bold;
            padding: 25px;
            border: 2px dashed #d9534f;
            border-radius: 8px;
            background-color: #fdf2f2;
        }
    </style>
</head>
<body>

    <!-- Botones de Navegación -->
    <div class="nav-buttons">
        <a href="{{ url('/platillosAdmin') }}" class="btn btn-admin">Administrador</a>
        <a href="{{ url('/mesero') }}" class="btn btn-mesero">Meseros</a>
        <a href="{{ url('/cajero') }}" class="btn btn-cajero">Cajero</a>
    </div>

    <h1>Bienvenido a Tacos Tomi</h1>

    <div class="video-container">
        <!-- Reproductor de Video desde CloudFront -->
        <video id="welcomeVideo" class="home-video" autoplay controls preload="auto">
            <source src="{{ $videoUrl }}" type="video/mp4">
            Tu navegador no soporta la reproducción de video.
        </video>
        
        <!-- Mensaje de Fallback -->
        <div id="fallbackMessage" class="fallback-text">
            Welcome to Tacos Tomi Image/Video cannot be loaded right now.
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const video = document.getElementById("welcomeVideo");
            const fallback = document.getElementById("fallbackMessage");

            // --- 1. Lógica de Repetición (5 veces) ---
            let loopCount = 0;
            const MAX_LOOPS = 3;

            video.addEventListener("ended", () => {
                loopCount++;
                if (loopCount < MAX_LOOPS) {
                    video.currentTime = 0;
                    video.play();
                } else {
                    video.pause(); // Se detiene después de 3 repeticiones
                }
            });

            // Reiniciar repeticiones al dar click en el video
            video.addEventListener("click", () => {
                if (video.paused || loopCount >= MAX_LOOPS) {
                    loopCount = 0;
                    video.currentTime = 0;
                    video.play();
                }
            });

            // --- 2. Lógica de Protección Anti-Flood (100 clicks/reloads) ---
            const MAX_REQUESTS = 10;
            const TIME_WINDOW = 2000; // 2 segundos

            let now = Date.now();
            let requestLog = JSON.parse(localStorage.getItem("media_request_log") || "[]");

            requestLog = requestLog.filter(timestamp => now - timestamp < TIME_WINDOW);
            requestLog.push(now);

            localStorage.setItem("media_request_log", JSON.stringify(requestLog));

            if (requestLog.length > MAX_REQUESTS) {
                showFallback();
            }

            // Fallback si el video falla al cargar de CloudFront
            video.onerror = () => {
                showFallback();
            };

            function showFallback() {
                video.style.display = "none";
                fallback.style.display = "block";
            }
        });
    </script>
</body>
</html>