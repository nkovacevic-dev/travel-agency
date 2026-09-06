$('#datatable_korisnici').DataTable({
    stateSave: false,
    bProcessing: true,
    serverSide: true,
    responsive: {
        details: {
            type: 'column',
            target: 'tr'
        }
    },
    ajax: {
        url: $('#datatable_korisnici').data('url'),
        data: function(d) {
        },
    },
    buttons: [
        {
            extend: 'excelHtml5',
            className: 'excelButton',
            text: 'Excel',
            attr: {
                id: 'excel_hidden_btn'
            },
            exportOptions: {
                columns: [ 0, 1, 2 ],
                modifier: {
                    search: 'applied',
                    order: 'applied'
                }
            }
        },
        {
            extend: 'pdfHtml5',
            download: 'open',
            className: 'excelButton',
            text: 'PDF',
            attr: {
                id: 'pdf_hidden_btn'
            },
            exportOptions: {
                columns: [ 0, 1, 2 ],
                modifier: {
                    search: 'applied',
                    order: 'applied'
                },
            }
        },
        {
            extend: 'csvHtml5',
            className: 'excelButton',
            text: 'CSV',
            attr: {
                id: 'csv_hidden_btn'
            },
            exportOptions: {
                columns: [ 0, 1, 2 ],
                modifier: {
                    search: 'applied',
                    order: 'applied'
                }
            }
        }
    ],
    columns: [{
            data: 'id',
            name: 'korisnik.id'
        },
        {
            data: 'name',
            name: 'korisnik.name',
        },
        {
            data: 'email',
            name: 'korisnik.email'
        },
        {
            data: 'akcija',
            name: 'akcija',
            className: 'dt-right',
            orderable : false,
            searchable : false
        }
    ],
    columnDefs: [
    ],
    order: [
        [0, "asc"]
    ],
    initComplete: function(settings, json) {
        $('#excel_btn').on('click', function() {
            $('#datatable_korisnici').DataTable().button('#excel_hidden_btn').trigger();
        });
        $('#pdf_btn').on('click', function() {
            $('#datatable_korisnici').DataTable().button('#pdf_hidden_btn').trigger();
        });
        $('#csv_btn').on('click', function() {
            $('#datatable_korisnici').DataTable().button('#csv_hidden_btn').trigger();
        });
    },
    drawCallback: function() {
    },
    language: {
        url: datatable_lang
    }  
});

// Brisanje korisnika
$(document).on('click', '.btn-delete-korisnik', function () {
    const id = $(this).data('id');
    const naziv = $(this).closest('tr').find('td:nth-child(2)').text().trim();

    Swal.fire({
        title: 'Obriši korisnika?',
        html: naziv ? '<b>' + naziv + '</b>' : '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Obriši',
        cancelButtonText: 'Otkaži',
        reverseButtons: true,
    }).then(function (result) {
        if (!result.isConfirmed) return;

        axios.delete('/admin/korisnici/' + id)
            .then(function (response) {
                if (response.data.success) {
                    Swal.fire({ icon: 'success', title: response.data.message, timer: 2000, showConfirmButton: false });
                    $('#datatable_korisnici').DataTable().ajax.reload();
                } else {
                    Swal.fire({ icon: 'error', title: response.data.message });
                }
            })
            .catch(function (error) {
                const msg = error.response?.data?.message ?? 'Došlo je do greške pri brisanju.';
                Swal.fire({ icon: 'error', title: msg });
            });
    });
});
