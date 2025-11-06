# 🛍️ Plataforma eCommerce con Suscripciones Mensuales – Laravel

Este proyecto es una **plataforma eCommerce monolítica** desarrollada con **Laravel**, que integra un sistema de **suscripciones mensuales**, **autenticación con roles**, **pasarelas de pago (PayPal y Stripe)** y un completo **panel de administración** para la gestión de productos, inventario, facturación y clientes.

---

## ⚙️ Tecnologías Utilizadas

- **Backend:** Laravel 10 (PHP 8+)
- **Frontend:** Blade + Tailwind CSS / Bootstrap
- **Base de Datos:** MySQL
- **Autenticación:** Laravel Breeze / Socialite (Google)
- **Pasarelas de Pago:** Stripe, PayPal, Mollie
- **Control de Versiones:** Git / GitHub

---

## ⚙️ Funcionalidades principales

### 🧍‍♂️ Usuarios y autenticación
- Registro e inicio de sesión con roles (Administrador y Usuario).
- Breeze implementado para seguridad, sesiones y middlewares.
- Al registrarse, el usuario es redirigido a una vista donde debe **comprar la suscripción** antes de acceder a los productos.

### 💳 Sistema de suscripción mensual
- Los usuarios deben tener una **suscripción activa** para ver y comprar productos.
- Control de estado de suscripción (activa, vencida, cancelada).
- Administración de **planes** desde el panel de control.
- Integración con **PayPal** y **Stripe** para pagos recurrentes o únicos.

### 🛒 Tienda online
- Catálogo de productos visible solo para usuarios con suscripción activa.
- **Carrito de compras funcional** con gestión de cantidades y total.
- Creación y seguimiento de órdenes con su respectiva factura.
- Gestión de envíos y estados de entrega.

### 🧾 Facturación
- Generación de facturas automáticas después del pago exitoso.
- Historial de facturación por usuario.
- Administración de métodos de pago y monedas.

### 🧠 Panel de administración
- Dashboard con **estadísticas globales** (ventas, suscripciones, productos, clientes).
- Módulos de gestión:
  - Planes de suscripción
  - Métodos de pago
  - Historial de pagos
  - Categorías, bodegas y tipos de vino
  - Productos e inventario
  - Clientes y facturación
  - Envíos y seguimiento de órdenes

---


## 🔄 Flujo funcional del sistema

1. **Registro del usuario**  
   El usuario se registra (Laravel Breeze) → se crea registro en `users`.  
   Luego, se le solicita adquirir un plan.

2. **Compra de suscripción**  
   El usuario selecciona un plan (`plans`) y paga con PayPal o Stripe.  
   Al confirmar el pago:
   - Se guarda en `user_payments`
   - Se crea/actualiza en `subscriptions`
   - Se genera una `invoice`
   - Se añade registro en `subscription_history`

3. **Acceso a la tienda**  
   - Solo usuarios con suscripción activa pueden ver productos.
   - Puede agregar productos al carrito, generar órdenes y pagar.

4. **Administración (panel admin)**  
   - El administrador puede gestionar todo el contenido desde un dashboard central.

---

## 💰 Pasarelas de pago integradas

| Pasarela | Descripción |
|-----------|-------------|
| **Stripe** | Pagos con tarjeta y suscripciones recurrentes. |
| **PayPal** | Pagos directos y gestión de órdenes. |
| **Mollie (en desarrollo)** | Compatible con MB Way y Multibanco. |

---

## 🧾 Facturación y Monedas

- **Invoices:** Se genera una factura por cada pago realizado.  
- **Currencies:** Módulo para gestionar monedas (USD, EUR, COP).  
- **Historial:** Consultable desde el panel admin y por usuario.

---

## 📦 Tienda e Inventario

- Gestión completa de:
  - Productos
  - Categorías
  - Bodegas
  - Tipos de vino
  - Variantes de inventario
  - Galerías de imágenes
- Control de stock y precios dinámicos.
- Reportes y estadísticas en el dashboard.

---

## ⚙️ Instalación y configuración

### 1️⃣ Clonar el repositorio
```bash
git clone https://github.com/tuusuario/tienda-suscripcion.git
cd tienda-suscripcion

2️⃣ Instalar dependencias
composer install
npm install && npm run dev

3️⃣ Configurar el entorno
Copia el archivo .env.example y renómbralo a .env:
cp .env.example .env
php artisan key:generate

4️⃣ Ejecutar migraciones y seeders
php artisan migrate --seed

5️⃣ Iniciar el servidor
php artisan serve

📊 Dashboard principal

Incluye:

Estadísticas de ventas y suscripciones.
Panel de control con métricas globales.
Gráficas dinámicas de ingresos, clientes y productos.

🧑‍💻 Autor
Mileer Duban León Rincón
💼 Desarrollador Backend & Full Stack
📍 Ibagué - Colombia
🔗 LinkedIn
 | GitHub

🏷️ Etiquetas

#Laravel #TailwindCSS #PHP #eCommerce #FullStack #Stripe #PayPal #MySQL #Breeze #MVC #BackendDevelopment