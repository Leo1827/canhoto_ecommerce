{{-- Formulario para galería de imágenes con FilePond --}}
<div class="bg-white rounded-xl shadow-md p-6">
    <h3 class="text-xl font-semibold mb-4">Galería de Imágenes</h3>

    {{-- Dropzone --}}
    <form action="{{ route('products.gallery.upload', $product->id) }}" class="dropzone" id="productGalleryDropzone" enctype="multipart/form-data">
        @csrf
    </form>

    {{-- Miniaturas cargadas --}}
    <div id="gallery-thumbnails" class="mt-6 grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($product->galleries as $gallery)
            <div class="relative group">
                <img src="{{ asset('storage/' . $gallery->file_path) }}" class="w-full h-32 object-cover rounded shadow-sm" alt="">
                <button data-id="{{ $gallery->id }}" class="absolute top-2 right-2 bg-red-600 text-white rounded-full w-6 h-6 flex justify-center items-center text-xs delete-gallery-btn">×</button>
            </div>
        @endforeach
    </div>
</div>