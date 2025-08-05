<div id="ageModal" class="hidden fixed inset-0 bg-black bg-opacity-80 backdrop-blur-sm items-center justify-center z-50">
    <div class="bg-white max-w-md w-full rounded-3xl shadow-2xl p-8 sm:p-10 text-center animate-fade-in-down relative border border-gray-200">
        
        <div class="mb-6">
            <svg class="mx-auto h-16 w-16 text-gray-900" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13401 2 5 5.13401 5 9C5 13.5 12 22 12 22C12 22 19 13.5 19 9C19 5.13401 15.866 2 12 2Z" />
                <circle cx="12" cy="9" r="2.5" fill="currentColor"/>
            </svg>
        </div>

        <h2 class="text-2xl sm:text-3xl font-light tracking-wide text-gray-900 mb-4">
            Informe sua <span class="font-semibold">data de nascimento</span>
        </h2>

        <p class="text-gray-600 text-base sm:text-lg mb-6 leading-relaxed">
            Este site é exclusivo para maiores de 18 anos. Verificamos isso através da sua data de nascimento.
        </p>

        <div class="mb-6">
            <input type="date" id="birthDate" class="w-full px-4 py-3 border border-gray-300 rounded-full text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900" max="{{ now()->format('Y-m-d') }}">
            <p id="ageError" class="text-red-600 text-sm mt-2 hidden transition-opacity duration-300"></p>
        </div>

        <div class="flex justify-center gap-4">
            <button id="verifyAgeBtn" class="bg-gray-900 text-white px-6 py-3 rounded-full text-sm tracking-wide hover:bg-gray-800 transition-all shadow-md">
                Confirmar idade
            </button>
        </div>
    </div>

</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const modal = document.getElementById("ageModal");
        const verifyBtn = document.getElementById("verifyAgeBtn");
        const birthInput = document.getElementById("birthDate");
        const errorMsg = document.getElementById("ageError");

        // Mostrar modal si no está verificado
        if (!localStorage.getItem("isAdult")) {
            modal.classList.remove("hidden");
            modal.classList.add("flex"); // Aquí se aplica flex SOLO si debe mostrarse
        }

        verifyBtn.addEventListener("click", () => {
            const birthDate = new Date(birthInput.value);
            const today = new Date();

            if (!birthInput.value) {
                errorMsg.textContent = "Por favor, selecione sua data de nascimento.";
                errorMsg.classList.remove("hidden");
                return;
            }

            const age = today.getFullYear() - birthDate.getFullYear();
            const m = today.getMonth() - birthDate.getMonth();
            const d = today.getDate() - birthDate.getDate();

            const is18 = (age > 18) || (age === 18 && (m > 0 || (m === 0 && d >= 0)));

            if (is18) {
                localStorage.setItem("isAdult", "true");
                modal.classList.remove("flex");
                modal.classList.add("hidden");
            } else {
                errorMsg.textContent = "Você deve ter mais de 18 anos para acessar este site.";
                errorMsg.classList.remove("hidden");
            }
        });
    });

</script>

