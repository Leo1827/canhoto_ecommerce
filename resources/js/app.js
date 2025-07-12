import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.store('cart', {
    openCart: false,
    cartItems: [],
    cartTotal: 0,

    loadingCart: false,
    loadingAdd: false,
    loadingRemoveId: null,
    loadingUpdateId: null,

    loadCart(fromAction = false) {
        if (!fromAction) this.loadingCart = true;

        return fetch('/cart/json')
            .then(res => res.json())
            .then(data => {
                this.cartItems = data.items;
                this.cartTotal = data.total;
            })
            .finally(() => {
                this.loadingCart = false;
            });
    },

    addToCart(productId, inventoryId, quantity = 1) {
        this.loadingAdd = true;

        fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ product_id: productId, inventory_id: inventoryId, quantity })
        })
            .then(res => {
                if (!res.ok) throw new Error('Error al agregar');
                return res.json();
            })
            .then(() => {
                return this.loadCart(true);
            })
            .then(() => {
                this.openCart = true;
            })
            .finally(() => {
                this.loadingAdd = false;
            });
    },

    updateQty(id, qty) {
        if (qty < 1) return;
        this.loadingUpdateId = id;

        fetch(`/cart/update/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ quantity: qty })
        })
            .then(() => this.loadCart(true))
            .finally(() => {
                this.loadingUpdateId = null;
            });
    },

    removeItem(id) {
        this.loadingRemoveId = id;

        fetch(`/cart/remove/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
            .then(() => this.loadCart(true))
            .finally(() => {
                this.loadingRemoveId = null;
            });
    }
});

Alpine.start();
