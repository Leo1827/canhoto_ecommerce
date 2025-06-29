@extends('layouts.front')

@section('meta')
    <meta name="description" content="Suscríbete a Garrafeira Canhoto">
@endsection

@section('title')
    <title>Suscripción Premium | Garrafeira Canhoto</title>
@endsection

@section('content')

@include('subscription.partials.logout-button')

<form method="POST" action="" class="max-w-4xl mx-auto px-4 py-32 bg-white text-gray-800 rounded-xl ">
    @csrf

    <div x-data="checkout" class="grid md:grid-cols-2 gap-12">
        <!-- Columna derecha: Planes -->
        <div class="space-y-6">
            @include('subscription.partials.plans-list')
            @include('subscription.partials.total-display')

        </div>
        <!-- Columna izquierda: Métodos exprés + datos personales -->
        <div class="space-y-10">
            

            <div class="space-y-4" x-show="plan !== ''">
                @include('subscription.partials.express-payment')

            </div>
        </div>

    </div>
</form>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/css/intlTelInput.min.css"/>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/js/intlTelInput.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/js/utils.js"></script>
    <script src="https://js.stripe.com/v3/"></script>

    {{-- Init teléfono internacional --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const input = document.querySelector("#phoneInput");
            if (input) {
                window.intlTelInput(input, {
                    initialCountry: "auto",
                    geoIpLookup: callback => {
                        fetch('https://ipapi.co/json')
                            .then(res => res.json())
                            .then(data => callback(data.country_code))
                            .catch(() => callback("pt"));
                    },
                    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18/build/js/utils.js"
                });
            }
        });
    </script>

    {{-- Componente checkout de Alpine --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('checkout', () => ({
                metodo: '',
                plan: '',
                planes: @json($planesData),
                metodosConfig: @json($metodos->mapWithKeys(fn($m) => [$m['driver'] => $m['config']])),

                get planSelected() {
                    return this.planes.find(p => p.id == this.plan);
                },

                init() {
                    this.$watch('metodo', (value) => {
                        // Oculta todos los contenedores expresivos
                        document.querySelectorAll('[id^="express-"][id$="-container"]').forEach(div => {
                            div.innerHTML = '';
                        });

                        const config = this.metodosConfig[value];
                        const container = document.getElementById(`express-${value}-container`);
                        if (!config || !container) return;

                        // PAYPAL
                        if (value === 'paypal' && config.client_id) {
                            if (!container.querySelector('iframe')) {
                                if (!document.querySelector('script[src*="paypal.com/sdk/js"]')) {
                                    const script = document.createElement('script');
                                    script.src = `https://www.paypal.com/sdk/js?client-id=${config.client_id}&currency=EUR`;
                                    script.onload = () => this.renderPaypal(container);
                                    document.body.appendChild(script);
                                } else {
                                    this.renderPaypal(container);
                                }
                            }
                        }

                        // STRIPE
                        if (value === 'stripe' && config.public_key) {
                            container.innerHTML = `
                                <div id="stripe-button-container" class="text-center">
                                    <a href="#" 
                                    id="stripe-button" 
                                    class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-xl inline-block">
                                        Pagar con tarjeta (Stripe)
                                    </a>
                                </div>
                            `;

                            document.getElementById('stripe-button').addEventListener('click', (e) => {
                                e.preventDefault(); // ⚠️ Detiene el submit del form principal

                                const plan = this.planSelected;
                                if (!plan) return alert("Por favor selecciona un plan");

                                fetch('{{ route('stripe.checkout') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ plan_id: plan.id })
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.error) return alert(data.error);

                                    return Stripe('{{ $metodos->firstWhere("driver", "stripe")->config["public_key"] ?? "" }}')
                                        .redirectToCheckout({ sessionId: data.id });
                                })
                                .catch(err => console.error('Error al iniciar Stripe:', err));
                            });

                        }

                        // MOLLIE
                        if (value === 'mollie' && config.api_key && config.profile_id) {
                            container.innerHTML = `
                                <div id="mollie-button-container" class="text-center">
                                    <a href="#" 
                                    id="mollie-button" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl inline-block">
                                        Pagar com Mollie
                                    </a>
                                </div>
                            `;

                            document.getElementById('mollie-button').addEventListener('click', (e) => {
                                e.preventDefault();

                                const plan = this.planSelected;
                                if (!plan) return alert("Por favor selecciona un plan");

                                fetch('{{ route('mollie.checkout') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({ plan_id: plan.id })
                                })
                                .then(async res => {
                                    const contentType = res.headers.get("content-type");
                                    if (!res.ok) {
                                        const errorText = await res.text();
                                        throw new Error(errorText);
                                    }
                                    if (contentType && contentType.includes("application/json")) {
                                        return res.json();
                                    } else {
                                        const errorText = await res.text();
                                        throw new Error('Expected JSON, got HTML: ' + errorText);
                                    }
                                })
                                .then(data => {
                                    if (data.error) return alert(data.error);
                                    window.location.href = data.checkout_url;
                                })
                                .catch(err => {
                                    console.error('Error:', err);
                                    alert('Ocurrió un error procesando el pago: ' + err.message);
                                });
                            });
                        }

                    });
                },

                renderPaypal(container, config) {
                    const plan = this.planSelected;
                    const price = plan?.price || '9.99';

                    paypal.Buttons({
                        createOrder: (data, actions) => {
                            return actions.order.create({
                                purchase_units: [{
                                    amount: { value: price }
                                }]
                            });
                        },
                        onApprove: (data, actions) => {
                            return actions.order.capture().then(details => {
                                const orderData = {
                                    order_id: data.orderID,
                                    payer_id: details.payer.payer_id,
                                    payer_name: details.payer.name.given_name + ' ' + details.payer.name.surname,
                                    payer_email: details.payer.email_address,
                                    amount: details.purchase_units[0].amount.value,
                                    currency: details.purchase_units[0].amount.currency_code,
                                    status: details.status,
                                    plan_id: plan?.id // ✅ AQUÍ el cambio
                                };

                                fetch('{{ route('paypal.capture') }}', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify(orderData)
                                })
                                .then(res => res.json())
                                .then(data => {
                                    window.location.href = '{{ route('checkout.thanks') }}'; // o redirigir a una página de gracias
                                })
                                .catch(error => {
                                    console.error("❌ Error al guardar la orden:", error);
                                });
                            });
                        }
                    }).render(container);
                }

            }));
        });
    </script>


@endpush

