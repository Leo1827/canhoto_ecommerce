    function addressListComponent() {
        return {
            showAddressSection: true,
            openAddressModal: false,
            selectedId: null,

            setSelected(id) {
                this.selectedId = id;
            },

            isSelected(id) {
                return this.selectedId === id;
            },

            refreshAddresses() {
                fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newList = doc.querySelector('[x-ref="addressList"]');
                    if (newList) {
                        this.$refs.addressList.innerHTML = newList.innerHTML;
                        // Reinicia Alpine en los nuevos elementos
                        Alpine.discoverUninitializedComponents(el => {
                            Alpine.initializeComponent(el);
                        });
                    }
                });
            }
        };
    }

    function addressComponent(id, parent) {
        return {
            editing: false,
            loading: false, // ✅ importante

            select() {
                parent.setSelected(id); // ✅ asegúrate que parent fue pasado correctamente
                document.getElementById(`address_${id}`).checked = true;

                // ✅ Aquí actualizas el campo hidden en el formulario principal
                const hiddenInput = document.getElementById('selected_address_id');
                if (hiddenInput) {
                    hiddenInput.value = id;
                }
            },

            get selected() {
                return parent.isSelected(id); // ✅ parent accedido correctamente
            },

            updateAddress(e) {
                const form = e.target;
                const formData = new FormData(form);
                const action = form.getAttribute('action');

                this.loading = true;

                fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(res => {
                    if (!res.ok) throw new Error('Erro ao atualizar endereço');
                    return res.text();
                })
                .then(() => {
                    window.location.reload();
                })
                .catch(err => alert(err.message))
                .finally(() => {
                    this.loading = false;
                });
            },

            deleteAddress(e) {
                e.preventDefault();
                this.loading = true;

                const form = e.target;
                const action = form.getAttribute('action');

                fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    },
                    body: new URLSearchParams({ _method: 'DELETE' })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Erro ao excluir');
                    document.getElementById(`address-card-${id}`).remove();
                })
                .catch(err => alert(err.message))
                .finally(() => {
                    this.loading = false;
                });
            }
        };
    }