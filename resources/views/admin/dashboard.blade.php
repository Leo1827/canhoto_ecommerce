<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex">

    @include('admin.layout.sidebar')

    <div class="flex-1 flex flex-col min-h-screen">

        @include('admin.layout.nav')

        <main class="p-6">
            <h1 class="text-2xl font-bold">Dashboard</h1>
            <p>Bienvenido al panel de administración.</p>
        </main>

        @include('admin.layout.footer')
    </div>

</body>
</html>