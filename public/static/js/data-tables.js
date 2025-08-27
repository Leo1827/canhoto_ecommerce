$(document).ready(function () {
    const table = $('#products-table').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition',
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Imprimir',
                className: 'bg-gray-700 text-white px-3 py-1 rounded text-sm hover:bg-gray-800 transition'
            }
        ],
        initComplete: function () {
            // Mueve los botones al contenedor
            table.buttons().container().appendTo('#buttons-container');
        }
    });

    // table inventories
    const tableInventories = $('#inventories-table').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition',
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Imprimir',
                className: 'bg-gray-700 text-white px-3 py-1 rounded text-sm hover:bg-gray-800 transition'
            }
        ],
        initComplete: function () {
            // Mueve los botones al contenedor
            tableInventories.buttons().container().appendTo('#buttons-container');
        }
    });

    // table inventories
    const tableInvoices = $('#invoicesTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition',
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Imprimir',
                className: 'bg-gray-700 text-white px-3 py-1 rounded text-sm hover:bg-gray-800 transition'
            }
        ],
        initComplete: function () {
            // Mueve los botones al contenedor
            tableInvoices.buttons().container().appendTo('#buttons-container');
        }
    });

    // table shipments
    const tableShipments = $('#shipmentsTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition',
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Imprimir',
                className: 'bg-gray-700 text-white px-3 py-1 rounded text-sm hover:bg-gray-800 transition'
            }
        ],
        initComplete: function () {
            // Mueve los botones al contenedor
            tableShipments.buttons().container().appendTo('#buttons-container');
        }
    });

    // table shipments
    const tableOrderStatus = $('#orderStatusTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition',
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Imprimir',
                className: 'bg-gray-700 text-white px-3 py-1 rounded text-sm hover:bg-gray-800 transition'
            }
        ],
        initComplete: function () {
            // Mueve los botones al contenedor
            tableOrderStatus.buttons().container().appendTo('#buttons-container');
        }
    });

    // table customer
    const tableCustomer = $('#customerTable').DataTable({
        responsive: true,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json'
        },
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Excel',
                className: 'bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700 transition'
            },
            {
                extend: 'pdfHtml5',
                text: '<i class="fas fa-file-pdf"></i> PDF',
                className: 'bg-red-600 text-white px-3 py-1 rounded text-sm hover:bg-red-700 transition',
                orientation: 'landscape',
                pageSize: 'A4'
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Imprimir',
                className: 'bg-gray-700 text-white px-3 py-1 rounded text-sm hover:bg-gray-800 transition'
            }
        ],
        initComplete: function () {
            // Mueve los botones al contenedor
            tableCustomer.buttons().container().appendTo('#buttons-container');
        }
    });
});
