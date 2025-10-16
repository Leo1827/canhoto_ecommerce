<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="icon" href="https://garrafeiracanhoto.com/cdn/shop/files/WhatsApp_Image_2021-11-21_at_13.03.06_a15641b8-7c29-48f0-b038-ea89f98c0e4b.jpg?crop=center&height=32&v=1691946283&width=32" type="image/png">
    <title>Panel de administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex bg-gray-50">

    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
    </div>

    @include('admin.layout.sidebar')

    <div class="flex-1 flex flex-col min-h-screen">

        @include('admin.layout.nav')

        <main class="p-6 space-y-8">

            <div>
                <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-gray-500">Bienvenido al panel de administración.</p>
            </div>

            @include('admin.dashboard.cards')

            @include('admin.dashboard.charts')

            @include('admin.dashboard.recent_orders')

            @include('admin.dashboard.stock_alerts')

        </main>

        @include('admin.layout.footer')
    </div>

    <!-- Scripts -->
    <script>
        // Ocultar el preloader cuando el contenido esté listo
        window.addEventListener('load', () => {
            const loader = document.getElementById('preloader');
            loader.style.opacity = '0';
            setTimeout(() => loader.style.display = 'none', 300);
        });
    </script>

    <script src="https://unpkg.com/lucide@latest"></script>
    <script>
        lucide.createIcons();
    </script>

</body>
</html>
