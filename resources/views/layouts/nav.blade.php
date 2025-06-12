<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 fixed w-full">
    {{-- primary navigation menu --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                {{-- logo --}}
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ url('/') }}">
                        {{-- Logo --}}
                        <img src="{{ asset('img/logo.png') }}" alt="SETSP" class="w-[60px] rounded-xl shadow-md">

                    </a>
                </div>

                {{-- navigation links --}}
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="url('/')" :active="request()->routeIs('/')">
                        {{ __('Inicio') }}
                    </x-nav-link>

                    <x-nav-link :href="url('/about')" :active="request()->routeIs('about')">
                        {{ __('Acerca de SETSP') }}
                    </x-nav-link>

                    <x-nav-link :href="url('/contact')" :active="request()->routeIs('contact')">
                        {{ __('Contacto v') }}
                    </x-nav-link>
                </div>

                {{-- Hamburger --}}
                <div class="-me-2 flex items-center sm:hidden">
                    <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
            
            {{-- Settings dropdown --}}
            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">

                @auth
                    <x-nav-link :href="Auth::user()->usertype == 'admin' ? url('/admin/dashboard') : route('dashboard')" :active="Auth::user()->usertype == 'admin' ? request()->routeIs('admin.dashboard') : request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                @else

                <x-nav-link :href="url('/login')" :active="request()->routeIs('login')">
                    {{ __('Login') }}
                </x-nav-link>

                @if (Route::has('register'))
                    <x-nav-link :href="url('/register')" :active="request()->routeIs('register')">
                        {{ __('Register') }}
                    </x-nav-link>
                @endif

                @endauth
            </div>
        </div>

        {{-- responsive navigation menu --}}
        <div :class="{'block': open, 'hidden': !open }" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="url('/')" :active="request()->routeIs('home')">
                    {{ __('Inicio') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="url('/about')" :active="request()->routeIs('about')">
                    {{ __('Acerca de SETSP') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="url('/contact')" :active="request()->routeIs('contact')">
                    {{ __('Contacto') }}
                </x-responsive-nav-link>
            </div>


            <div class="pt-4 pb-1 border-t border-gray-200">

                <div class="mt-3 space-y-1">
                    @auth
                    <x-responsive-nav-link :href="Auth::user()->usertype == 'admin' ? url('/admin/dashboard') : route('dashboard')" :active="Auth::user()->usertype == 'admin' ? request()->routeIs('admin.dashboard') : request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    @else

                    <x-responsive-nav-link :href="url('/login')" :active="request()->routeIs('login')">
                        {{ __('Login') }}
                    </x-responsive-nav-link>

                    @if (Route::has('register'))
                        <x-responsive-nav-link :href="url('/register')" :active="request()->routeIs('register')">
                            {{ __('Register') }}
                        </x-responsive-nav-link>
                    @endif

                    @endauth
                </div>
            </div>
        </div>

    </div>
</nav>
