@extends('layouts.front')

@section('meta')
    <meta name="description" content="Loja exclusiva de vinhos finos - Garrafeira Canhoto - Canhoto Black">
@endsection

@section('title')
    <title>Garrafeira Canhoto - Vinhos Exclusivos</title>
@endsection

@section('style')
    <style>
        /* Preloader CSS elegante */
        #preloader {
            position: fixed;
            top: 0; left: 0;
            width: 100%; height: 100vh;
            background: #1a1a1a;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        #preloader .loader {
            border: 6px solid #8b0000;
            border-top: 6px solid transparent;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            animation: spin 1.2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Redes sociais flutuantes */
        .social-icons {
            position: fixed;
            top: 50%;
            left: 20px;
            transform: translateY(-50%);
            z-index: 1000;
        }

        .social-icons a {
            display: block;
            margin-bottom: 12px;
            color: white;
            background-color: #7b1e1e;
            padding: 12px;
            border-radius: 50%;
            box-shadow: 0 0 10px rgba(0,0,0,0.4);
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            background-color: #e11d48;
            transform: scale(1.1);
        }

        html {
            scroll-behavior: smooth;
        }
    </style>

    {{-- AOS Animations --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
@endsection

@section('content')
    {{-- Preloader --}}
    <div id="preloader">
        <div class="loader"></div>
    </div>

    {{-- Redes sociais flutuantes --}}
    <div class="social-icons">
        <a href="https://facebook.com" target="_blank" aria-label="Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 320 512">
                <path d="M279.14 288l14.22-92.66h-88.91V117.33c0-25.35 12.42-50.06 52.24-50.06h40.42V3.12S269.56 0 240.36 0c-73.22 0-121.14 44.38-121.14 124.72v70.62H80v92.66h39.22V512h96.58V288z"/>
            </svg>
        </a>
        <a href="https://instagram.com" target="_blank" aria-label="Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 448 512">
                <path d="M224,202.66A53.34,53.34,0,1,0,277.34,256,53.38,53.38,0,0,0,224,202.66Zm124.71-41a54.13,54.13,0,0,0-30.18-30.18C293.73,118.13,225.75,116,224,116s-69.73,2.13-94.53,15.47A54.13,54.13,0,0,0,99.29,161.71C86,186.51,83.87,254.49,83.87,256s2.13,69.73,15.47,94.53a54.13,54.13,0,0,0,30.18,30.18c24.8,13.34,92.78,15.47,94.53,15.47s69.73-2.13,94.53-15.47a54.13,54.13,0,0,0,30.18-30.18c13.34-24.8,15.47-92.78,15.47-94.53S362.05,186.51,348.71,161.71ZM224,338.66A82.66,82.66,0,1,1,306.66,256,82.75,82.75,0,0,1,224,338.66Zm85.33-148A19.33,19.33,0,1,1,328.66,171,19.36,19.36,0,0,1,309.33,190.66Z"/>
            </svg>
        </a>
        <a href="https://wa.me/5511999999999" target="_blank" aria-label="WhatsApp">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 458 512">
                <path d="M380.9 97.1C339-13.2 234.8-29.5 152.6 35.3 91 85.7 64 170.3 89.1 244.3l-34.2 106.1c-4.6 14.3 8.7 27.5 23.1 22.9l108.1-36.4c61.4 33.5 136.6 17.2 185.2-41.3 55.1-66.7 45.6-167.5-16.4-198.5zM224 354.7c-28.4 0-56.5-7.7-81.2-22.2l-8.2-4.9-64.5 21.7 20.7-64.2-5.3-8.5c-14.7-23.5-22.3-50.7-22.3-78.5 0-81.3 66.2-147.5 147.5-147.5S371.5 116.2 371.5 197.5 305.3 354.7 224 354.7zm93.8-108.3c-3.4-1.7-20.1-9.9-23.2-11-3.1-1.2-5.3-1.7-7.5 1.7-2.1 3.4-8.6 11-10.5 13.2-1.9 2.1-3.8 2.4-7.1.8-3.4-1.7-14.4-5.3-27.5-16.9-10.2-9.1-17.1-20.3-19.1-23.7-2-3.4-.2-5.3 1.5-7.1 1.5-1.5 3.4-3.8 5-5.7 1.7-1.9 2.3-3.4 3.4-5.6 1.1-2.3.6-4.2-.3-5.9-.9-1.7-7.5-18.1-10.3-24.8-2.7-6.5-5.5-5.6-7.5-5.7-1.9-.1-4.1-.1-6.3-.1s-5.9.8-9 3.8c-3.1 3.1-11.8 11.5-11.8 28 0 16.5 12.1 32.4 13.8 34.6 1.7 2.3 23.7 36.2 57.5 50.8 8 3.4 14.2 5.4 19 6.9 8 2.5 15.2 2.2 20.9 1.3 6.4-1 20.1-8.2 22.9-16.1 2.8-7.9 2.8-14.6 2-16.1-1.1-1.5-3.1-2.4-6.5-4.1z"/>
            </svg>
        </a>
    </div>


    {{-- Hero principal --}}
    <section class="relative h-screen bg-center bg-cover text-white" style="background-image: url('/images/hero-vino.jpg');">
        <div class="absolute inset-0 bg-black bg-opacity-70 backdrop-blur-sm"></div>
        <div class="relative z-10 flex items-center justify-center h-full">
            <div class="text-center px-6 max-w-3xl" data-aos="zoom-in">
                <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mb-6 drop-shadow-xl">
                    Vinhos Exclusivos para Paladares Sofisticados
                </h1>
                <p class="text-xl text-gray-300 mb-8">
                    Torne-se parte da nossa comunidade privada e viva uma experiência sensorial inigualável.
                </p>
                <a href="{{ route('register') }}"
                   class="bg-red-700 hover:bg-red-800 text-white font-bold py-3 px-10 rounded-full shadow-lg transition duration-300">
                    Junte-se Agora
                </a>
            </div>
        </div>
    </section>

    {{-- Benefícios --}}
    <section class=" py-24 px-6 md:px-0" data-aos="fade-up">
        <div class="max-w-6xl mx-auto text-center mb-16">
            <h2 class="text-4xl font-bold text-gray-900 mb-4">Por que escolher a Garrafeira Canhoto?</h2>
            <p class="text-gray-600">Descubra uma loja onde cada garrafa conta uma história.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-10 max-w-6xl mx-auto">
            <div class="bg-gray-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition" data-aos="fade-up" data-aos-delay="100">
                <h3 class="text-xl font-semibold text-red-700 mb-3">Seleção Privada</h3>
                <p class="text-gray-600">Acesso a vinhos raros e refinados, escolhidos por sommeliers renomados.</p>
            </div>

            <div class="bg-gray-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition" data-aos="fade-up" data-aos-delay="200">
                <h3 class="text-xl font-semibold text-yellow-700 mb-3">Conteúdo Exclusivo</h3>
                <p class="text-gray-600">Histórias, harmonizações e vídeos especiais sobre cada vinho.</p>
            </div>

            <div class="bg-gray-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition" data-aos="fade-up" data-aos-delay="300">
                <h3 class="text-xl font-semibold text-purple-700 mb-3">Segurança Total</h3>
                <p class="text-gray-600">Login com Google, dados criptografados e métodos de pagamento confiáveis.</p>
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="text-center py-20 bg-gradient-to-br from-red-50 to-yellow-100 rounded-xl mx-6 md:mx-32 shadow-xl" data-aos="zoom-in-up">
        <h3 class="text-3xl font-bold text-gray-900 mb-4">Pronto para brindar conosco?</h3>
        <p class="text-gray-700 mb-6">Crie sua conta ou entre agora para começar essa jornada aromática.</p>
        <div class="space-x-4">
            <a href="{{ route('login') }}"
               class="bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-6 rounded-full shadow-md transition">
                Entrar
            </a>
            <a href="{{ route('register') }}"
               class="bg-white hover:bg-gray-100 text-gray-800 font-semibold py-3 px-6 rounded-full shadow-md border transition">
                Registrar-se
            </a>
        </div>
    </section>
@endsection

@section('script')
    {{-- FontAwesome Icons --}}
    <script src="https://kit.fontawesome.com/yourkitcode.js" crossorigin="anonymous"></script>

    {{-- Preloader --}}
    <script>
        window.addEventListener('load', function () {
            const preloader = document.getElementById('preloader');
            preloader.style.display = 'none';
        });
    </script>

    {{-- AOS Animation --}}
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });
    </script>
@endsection
