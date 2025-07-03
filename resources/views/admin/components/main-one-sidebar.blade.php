<!-- INÍCIO -->
<li>
    <a href="{{ route('admin.dashboard') }}"
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition 
                {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 12l9-9 9 9M4 10v10a1 1 0 001 1h3m10-11v11a1 1 0 001 1h3m-10 0v-4a1 1 0 011-1h2a1 1 0 011 1v4"/>
        </svg>
        <span>Início</span>
    </a>
</li>

<!-- GESTÃO DE ASSINATURAS -->
<li class="text-xs mx-3 py-2 font-bold uppercase text-gray-800 mt-6 mb-2 tracking-wide">
    <span class="p-4">Gestão de Assinaturas</span>
</li>

<li>
    <a href="{{ route('admin.plans.index') }}"
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
                {{ request()->routeIs('admin.plans.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 4c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
        </svg>
        <span>Planos</span>
    </a>
</li>

<li>
    <a href="{{ route('admin.payment_methods.index') }}"
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
                {{ request()->routeIs('admin.payment_methods.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 9V7a4 4 0 00-8 0v2H5v11h14V9h-2zM9 7a2 2 0 114 0v2H9V7z"/>
        </svg>
        <span>Métodos de Pagamento</span>
    </a>
</li>

<li>
    <a href="{{ route('admin.currencies.index') }}"
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
                {{ request()->routeIs('admin.currencies.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8c-4.418 0-8 1.79-8 4s3.582 4 8 4 8-1.79 8-4-3.582-4-8-4z"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 12c-4.418 0-8 1.79-8 4"/>
        </svg>
        <span>Moedas</span>
    </a>
</li>

<li>
    <a href="{{ route('admin.subscriptions.index') }}"
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
                {{ request()->routeIs('admin.subscriptions.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M20 13V6a2 2 0 00-2-2h-4l-2-2-2 2H6a2 2 0 00-2 2v7"/>
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8 21h8M12 17v4"/>
        </svg>
        <span>Assinaturas</span>
    </a>
</li>

<li>
    <a href="{{ route('admin.subscription_history.index') }}"
        class="flex items-center gap-3 px-4 py-2 rounded-md text-sm transition
                {{ request()->routeIs('admin.subscription_history.*') ? 'bg-gray-100 text-black font-semibold' : 'text-gray-700 hover:bg-gray-100 hover:text-black' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 8v4l3 3M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>Histórico</span>
    </a>
</li>