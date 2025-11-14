<nav class="text-sm text-gray-600 mb-4 bg-white border rounded-xl p-3 shadow-sm" aria-label="Breadcrumb">
    <ol class="list-none inline-flex items-center space-x-2">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
        </li>
        <li>/</li>
        <li>
            <a href="{{ route('admin.setting.index') }}" class="text-blue-600 hover:underline">Configuração</a>
        </li>
        @if (!empty($editing))
            <li>/</li>
            <li class="text-gray-800 font-semibold">Editar</li>
        @endif
    </ol>
</nav>
