<section>
    <div class="bg-white rounded-2xl shadow p-6">
        <h3 class="text-lg font-bold mb-4 text-gray-800">Estado del inventario</h3>

        <p class="text-sm text-gray-600 mb-4">
            A continuación se muestra el estado actual del inventario.  
            Los colores indican el nivel de disponibilidad de cada producto:
        </p>

        <ul class="text-sm text-gray-600 mb-6 space-y-1">
            <li><span class="text-green-700 font-medium">🟩 Stock suficiente:</span> el producto tiene existencias adecuadas.</li>
            <li><span class="text-orange-700 font-medium">🟧 Stock bajo:</span> quedan pocas unidades (5 o menos), considera reabastecer pronto.</li>
            <li><span class="text-red-700 font-medium">🟥 Por debajo del mínimo:</span> el producto está por debajo del nivel mínimo establecido.</li>
            <li><span class="text-red-700 font-medium">❌ Sin stock:</span> no hay unidades disponibles en inventario.</li>
            <li><span class="text-blue-700 font-medium">🟦 Edición limitada:</span> producto con disponibilidad controlada o exclusiva.</li>
        </ul>

        @if($alertasInventario->isEmpty())
            <p class="text-gray-500 text-sm">No hay productos registrados en el inventario.</p>
        @else
            <div class="space-y-2">
                @foreach($alertasInventario as $alerta)
                    @php
                        if ($alerta->quantity <= 0) {
                            $colorFondo = 'bg-red-50';
                            $colorTexto = 'text-red-700';
                            $mensaje = 'Sin stock';
                        } elseif ($alerta->quantity <= $alerta->minimum) {
                            $colorFondo = 'bg-red-50';
                            $colorTexto = 'text-red-700';
                            $mensaje = 'Por debajo del mínimo';
                        } elseif ($alerta->quantity <= 5) {
                            $colorFondo = 'bg-orange-50';
                            $colorTexto = 'text-orange-700';
                            $mensaje = 'Stock bajo';
                        } elseif ($alerta->limited) {
                            $colorFondo = 'bg-blue-50';
                            $colorTexto = 'text-blue-700';
                            $mensaje = 'Edición limitada';
                        } else {
                            $colorFondo = 'bg-green-50';
                            $colorTexto = 'text-green-700';
                            $mensaje = 'Stock suficiente';
                        }
                    @endphp



                    <div class="flex items-center justify-between {{ $colorFondo }} p-3 rounded-lg">
                        <span class="{{ $colorTexto }} font-medium">
                            {{ $alerta->product_name }}
                            @if($alerta->variant_name)
                                – {{ $alerta->variant_name }}
                            @endif
                        </span>
                        <span class="{{ $colorTexto }} text-sm">
                            {{ $mensaje }} ({{ $alerta->quantity }})
                        </span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
