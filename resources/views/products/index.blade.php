<!-- Catálogo -->
<section class="md:col-span-3">
    <div class="mb-8">
        <h2 class="text-4xl font-bold text-[#4B0D0D]">Colección Privada</h2>
        <p class="text-[#6B4F4F] mt-2 text-lg italic">Vinos de prestigio, elegancia y carácter.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">

        <!-- Producto 1 -->
        <div class="relative rounded-3xl overflow-hidden group h-[450px] shadow-xl">
            <img src="{{ asset('img/product1.jpeg') }}" 
                class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 brightness-[.65]"
                alt="Verídico 1900">

            <!-- Etiquetas -->
            <div class="absolute top-4 left-4 bg-[#9B1C1C] text-white text-xs px-4 py-1 rounded-full shadow">
                Vino de Autor
            </div>

            <div class="absolute top-4 right-4 bg-[#4B0D0D] text-white text-xs px-4 py-1 rounded-full">
                Disponible
            </div>

            <!-- Contenido -->
            <div class="relative z-10 flex flex-col justify-end h-full p-5 bg-gradient-to-t from-black/60 via-black/30 to-transparent">

                <h3 class="text-2xl font-serif font-bold text-white">Verídico 1900</h3>
                <p class="text-xs text-gray-200 mb-2">
                    <span class="font-semibold">Very Very Old Tawny Port</span> · <span class="italic">Douro - Portugal</span>
                </p>

                <div class="grid grid-cols-2 gap-2 text-[11px] text-gray-200 mb-3">
                    <div><span class="font-bold">Embotellado:</span> 2023</div>
                    <div><span class="font-bold">Región:</span> Douro</div>
                    {{-- <div><span class="font-bold">Temp. ideal:</span> 10-14°C</div>
                    <div><span class="font-bold">País:</span> Portugal</div>
                    <div><span class="font-bold">Grado alcohólico:</span> 20.5%</div>
                    <div><span class="font-bold">Capacidad:</span> 75cl</div>
                    <div><span class="font-bold">Casta:</span> Viñas Viejas</div>
                    <div><span class="font-bold">Certificado:</span> IVDP</div> --}}
                </div>

                <div class="flex items-center justify-between">
                    <span class="text-3xl font-bold text-[#FCD9D9]">$1.200</span>
                    <a href="{{ route('products.show', 'veridico-1900') }}"
                    class="inline-flex items-center px-5 py-1.5 bg-[#9B1C1C] hover:bg-[#7C1616] rounded-xl text-sm text-white font-semibold transition">
                        Ver Detalles
                    </a>
                </div>
            </div>
        </div>

        <!-- Producto 2 -->
        <div class="relative rounded-3xl overflow-hidden group h-[450px] shadow-xl">
            <img src="{{ asset('img/product2.jpeg') }}" 
                class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 brightness-[.65]"
                alt="Sassicaia Bolgheri">

            <div class="absolute top-4 left-4 bg-[#9B1C1C] text-white text-xs px-4 py-1 rounded-full shadow">
                Edición Limitada
            </div>

            <div class="absolute top-4 right-4 bg-[#4B0D0D] text-white text-xs px-4 py-1 rounded-full">
                Disponible
            </div>

            <div class="relative z-10 flex flex-col justify-end h-full p-5 bg-gradient-to-t from-black/60 via-black/30 to-transparent">
                <h3 class="text-2xl font-serif font-bold text-white">Pangaea</h3>
                <p class="text-xs text-gray-200 mb-2">
                    <span class="font-semibold">Toscana</span> · <span class="italic">2015</span> · <span class="uppercase tracking-wide">Tenuta San Guido</span>
                </p>

                <div class="flex items-center justify-between">
                    <span class="text-3xl font-bold text-[#FCD9D9]">$950</span>
                    <a href="#"
                    class="inline-flex items-center px-5 py-1.5 bg-[#9B1C1C] hover:bg-[#7C1616] rounded-xl text-sm text-white font-semibold transition">
                        Ver Detalles
                    </a>
                </div>
            </div>
        </div>

    </div>

</section>