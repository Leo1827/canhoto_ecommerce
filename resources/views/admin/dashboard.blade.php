<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex">

    <!-- Preloader -->
    <div id="preloader" class="fixed inset-0 bg-white z-50 flex items-center justify-center">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-blue-500"></div>
    </div>

    @include('admin.layout.sidebar')

    <div class="flex-1 flex flex-col min-h-screen">

        @include('admin.layout.nav')

        <main class="p-6">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <p>Bienvenido al panel de administración.</p>
        </main>

        @include('admin.layout.footer')
    </div>

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