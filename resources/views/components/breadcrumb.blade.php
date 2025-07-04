<nav class="text-sm text-gray-600 mb-4" aria-label="Breadcrumb">
    <ol class="list-none p-0 inline-flex items-center space-x-2">
        <li>
            <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">Dashboard</a>
        </li>

        <li>/</li>

        <li>
            <a href="{{ route('categories.index', ['module' => $module ?? 1]) }}" class="text-blue-600 hover:underline">Categorias</a>
        </li>

        @if (isset($parentCategory))
            <li>/</li>
            <li>
                <a href="{{ route('categories.subcategories', $parentCategory->id) }}" class="text-blue-600 hover:underline">
                    {{ $parentCategory->name }}
                </a>
            </li>
        @endif

        @if (isset($editing) && $editing === true)
            <li>/</li>
            <li class="text-gray-800 font-semibold">Editar</li>
        @endif

        @if (isset($subview) && $subview === true)
            <li>/</li>
            <li class="text-gray-800 font-semibold">Subcategorias</li>
        @endif
    </ol>
</nav>
