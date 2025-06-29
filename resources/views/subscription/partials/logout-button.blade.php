<div class="max-w-7xl mx-auto px-6 pt-6 flex justify-end">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-900 transition">
            Cerrar sesión
        </button>
    </form>
</div>
