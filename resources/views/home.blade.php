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
        .nav-button {
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

        /* Contenedor de la Imagen */
        .image-container {
            max-width: 800px;
            margin: 0 auto;
            min-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .home-image {
            width: 100%;
            max-width: 720px;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
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

    <!-- Botones de Navegacion -->
    <div class="nav-button">
        <a href="/admin" class="btn btn-admin">INICIAR SESION</a>
    </div>

    <h1>Bienvenido a Tacos Tomi</h1>

    <div class="image-container">
        <!-- Imagen desde CloudFront -->
        <img id="welcomeImage" class="home-image" src="{{ $imageUrl }}" alt="Bienvenido a Tacos Tomi">
        
        <!-- Mensaje de Fallback -->
        <div id="fallbackMessage" class="fallback-text">
            IMAGEN NO PUEDE SER CARGADA AHORA CHIAVO.
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const img = document.getElementById("welcomeImage");
            const fallback = document.getElementById("fallbackMessage");

            // --- Lógica de Protección Anti-Flood (10 peticiones rápidas) ---
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

            // Fallback si la imagen falla al cargar de CloudFront
            img.onerror = () => {
                showFallback();
            };

            function showFallback() {
                img.style.display = "none";
                fallback.style.display = "block";
            }
        });
    </script>
</body>
</html>