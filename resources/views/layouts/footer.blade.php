<footer class="bg-white border-t border-gray-100 text-gray-600">
    <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-1 md:grid-cols-2 gap-8">
        
        {{-- Sección Izquierda --}}
        <div>
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Canhoto Premium</h2>
            <p class="text-gray-600 mb-4">
                Vinhos exclusivos, coleções limitadas e excelência em cada garrafa. Uma experiência única para os amantes do vinho.
            </p>
            <p class="text-sm text-gray-500">
                &copy; 2025 Canhoto Premium. Todos os direitos reservados.
            </p>
        </div>

        {{-- Sección Derecha --}}
        <div class="flex flex-col md:items-end">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Navegação</h3>
            
            <ul class="space-y-2 mb-6">
                <li><a href="#historia" class="hover:text-black">História</a></li>
                <li><a href="#contato" class="hover:text-black">Contato</a></li>
                <li><a href="{{ route('login') }}" class="hover:text-black">Iniciar Sessão</a></li>
                <li><a href="{{ route('register') }}" class="hover:text-black">Registrar</a></li>
            </ul>

            {{-- Redes Sociales --}}
            <div class="flex space-x-4">
                <a href="#" class="text-gray-600 hover:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M22 12a10 10 0 10-11 9.95V15.5h-2v-3h2v-2.3c0-2 1.19-3.1 3-3.1.87 0 1.78.15 1.78.15v2h-1c-1 0-1.32.63-1.32 1.27V12.5h2.25l-.36 3h-1.9v6.45A10 10 0 0022 12z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-600 hover:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M21.8 7.2a8.61 8.61 0 01-2.4.66 4.17 4.17 0 001.83-2.3 8.27 8.27 0 01-2.6 1 4.14 4.14 0 00-7.06 3.78A11.75 11.75 0 013 5.9a4.13 4.13 0 001.27 5.52A4.1 4.1 0 012 10.2v.05a4.14 4.14 0 003.32 4.05 4.1 4.1 0 01-1.86.07 4.15 4.15 0 003.87 2.88A8.3 8.3 0 012 19.54 11.69 11.69 0 008.29 21c7.55 0 11.68-6.24 11.68-11.65 0-.18-.01-.36-.02-.54a8.4 8.4 0 002.05-2.14z"/>
                    </svg>
                </a>
                <a href="#" class="text-gray-600 hover:text-black">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="w-5 h-5" viewBox="0 0 24 24">
                        <path d="M12 2.16C6.51 2.16 2.16 6.51 2.16 12S6.51 21.84 12 21.84 21.84 17.49 21.84 12 17.49 2.16 12 2.16zm5.43 8.45c.01.15.01.3.01.46 0 4.68-3.56 10.08-10.08 10.08a9.96 9.96 0 01-5.43-1.59c.21.03.42.05.63.05a7.07 7.07 0 004.37-1.5 3.53 3.53 0 01-3.29-2.45c.22.03.45.05.68.05.33 0 .66-.05.97-.13a3.52 3.52 0 01-2.83-3.45v-.05a3.5 3.5 0 001.6.44 3.52 3.52 0 01-1.09-4.71 10.01 10.01 0 007.26 3.69 3.98 3.98 0 01-.09-.81 3.52 3.52 0 016.09-2.41 7 7 0 002.23-.85 3.5 3.5 0 01-1.55 1.95 7 7 0 002.02-.55 7.19 7.19 0 01-1.76 1.81z"/>
                    </svg>
                </a>
            </div>
        </div>

    </div>
</footer>
