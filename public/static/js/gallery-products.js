Dropzone.autoDiscover = false;

    const myDropzone = new Dropzone("#productGalleryDropzone", {
        paramName: "gallery_image",
        maxFilesize: 5, // MB
        acceptedFiles: 'image/*',
        success: function (file, response) {
            const imageElement = `
                <div class=\"relative group\">
                    <img src=\"/storage/${response.file_path}\" class=\"w-full h-32 object-cover rounded shadow-sm\" alt=\"\">
                    <button data-id=\"${response.id}\" class=\"absolute top-2 right-2 bg-red-600 text-white rounded-full w-6 h-6 flex justify-center items-center text-xs delete-gallery-btn\">×</button>
                </div>
            `;
            document.getElementById('gallery-thumbnails').insertAdjacentHTML('beforeend', imageElement);
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('delete-gallery-btn')) {
            const id = e.target.dataset.id;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (confirm('¿Eliminar esta imagen?')) {
                fetch(`/admin/products/gallery/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        e.target.parentElement.remove();
                    } else {
                        console.error('Error al eliminar la imagen');
                    }
                })
                .catch(error => console.error('Error de red:', error));
            }
        }
    });
