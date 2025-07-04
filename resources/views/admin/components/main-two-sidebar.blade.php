<li>
    <a href="{{ route('categories.index') }}"
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
            {{ request()->routeIs('categories.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 9a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1H4a1 1 0 01-1-1v-3zM14 4a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1V4zm0 9a1 1 0 011-1h3a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-3z"/>
        </svg>
        <span>Categorias</span>
    </a>
</li>

<li>
    <a href="{{ route('wineries.index') }}"
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
            {{ request()->routeIs('wineries.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 4h16v16H4V4z"/>
        </svg>
        <span>Bodegas</span>
    </a>
</li>

<li>
    <a href="{{ route('regions.index') }}"
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
            {{ request()->routeIs('regions.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 01.553-.894L9 2m0 18l6-3m-6 3V2m6 15l5.447 2.724A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 2" />
        </svg>

        <span>Região</span>
    </a>
</li>

<li>
    <a href="{{ route('wine_types.index')}} "
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
            {{ request()->routeIs('wine_types.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 10h18M3 6h18M3 14h18M3 18h18"/>
        </svg>
        <span>Tipos de vinho</span>
    </a>
</li>

<li>
    <a href="{{ route('vintages.index') }}"
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
            {{ request()->routeIs('vintages.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 8v4l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>Añadas</span>
    </a>
</li>

<li>
    <a href="{{ route('conditions.index') }}"
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
            {{ request()->routeIs('conditions.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 17v-2h6v2a2 2 0 01-2 2H11a2 2 0 01-2-2zM9 13V7h6v6"/>
        </svg>
        <span>Condiciones</span>
    </a>
</li>

<li>
    <a href=""
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
            {{ request()->routeIs('admin.products.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M20 13V6a2 2 0 00-2-2h-4l-2-2-2 2H6a2 2 0 00-2 2v7"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8 21h8M12 17v4"/>
        </svg>
        <span>Produtos</span>
    </a>
</li>

<li>
    <a href=""
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
            {{ request()->routeIs('admin.inventories.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
        </svg>
        <span>Inventário</span>
    </a>
</li>


<!-- FACTURACIÓN -->
<li class="text-xs mx-3 py-2 font-bold uppercase text-gray-800 mt-6 mb-2 tracking-wide">
    <span class="p-4">Facturación</span>
</li>

<li>
    <a href=""
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
            {{ request()->routeIs('admin.orders.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 3h18v2H3zM3 7h18v2H3zM3 11h18v10H3z"/>
        </svg>
        <span>Pedidos</span>
    </a>
</li>

<li>
    <a href=""
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
            {{ request()->routeIs('admin.users.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M16 14c1.657 0 3 1.343 3 3v3H5v-3c0-1.657 1.343-3 3-3h8zM12 7a4 4 0 110-8 4 4 0 010 8z"/>
        </svg>
        <span>Clientes</span>
    </a>
</li>

<li>
    <a href=""
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
            {{ request()->routeIs('admin.orders.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M3 3h18v2H3zM3 7h18v2H3zM3 11h18v10H3z"/>
        </svg>
        <span>Órdenes</span>
    </a>
</li>

<li>
    <a href=""
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
            {{ request()->routeIs('admin.invoices.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M9 17v-2h6v2a2 2 0 01-2 2H11a2 2 0 01-2-2zM9 13V7h6v6"/>
        </svg>
        <span>Facturas</span>
    </a>
</li>
