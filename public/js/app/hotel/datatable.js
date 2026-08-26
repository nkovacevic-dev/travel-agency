$('#datatable_hoteli').DataTable({
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
        url: $('#datatable_hoteli').data('url'),
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
                columns: [ 0, 1, 2, 3, 4 ],
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
                columns: [ 0, 1, 2, 3, 4 ],
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
                columns: [ 0, 1, 2, 3, 4 ],
                modifier: {
                    search: 'applied',
                    order: 'applied'
                }
            }
        }
    ],
    columns: [{
            data: 'id',
            name: 'hotels.id'
        },
        {
            data: 'naziv',
            name: 'hotels.naziv',
        },
        {
            data: 'naziv_drzave',
            name: 'drzavas.naziv'
        },
        {
            data: 'grad',
            name: 'hotels.grad'
        },
        {
            data: 'broj_zvezdica',
            name: 'hotels.broj_zvezdica'
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
        {
         targets: 4, 
        render: function (data, type, row) {
            let stars = '';
            for (let i = 0; i < data; i++) {
                stars += '<span class="material-icons-outlined" style="color: gold; font-size: 20px;">star</span>';
            }
            return stars;
        }
    }],
    order: [
        [0, "asc"]
    ],
    initComplete: function(settings, json) {
        $('#excel_btn').on('click', function() {
            $('#datatable_hoteli').DataTable().button('#excel_hidden_btn').trigger();
        });
        $('#pdf_btn').on('click', function() {
            $('#datatable_hoteli').DataTable().button('#pdf_hidden_btn').trigger();
        });
        $('#csv_btn').on('click', function() {
            $('#datatable_hoteli').DataTable().button('#csv_hidden_btn').trigger();
        });
    },
    drawCallback: function() {
        // $(document).off("vclick", ".button-delete")
        // $(document).on("vclick", ".button-delete", obrisi);
    },
    language: {
        url: datatable_lang
    }  
});

$(document).on('click', '.btn-delete-hotel', function () {
    const id = $(this).data('id');
    const naziv = $(this).closest('tr').find('td:nth-child(2)').text().trim();

    Swal.fire({
        title: 'Obriši hotel?',
        html: naziv ? '<b>' + naziv + '</b>' : '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Obriši',
        cancelButtonText: 'Otkaži',
        reverseButtons: true,
    }).then(function (result) {
        if (!result.isConfirmed) return;

        axios.delete('/admin/hoteli/' + id)
            .then(function (response) {
                if (response.data.success) {
                    Swal.fire({ icon: 'success', title: response.data.message, timer: 2000, showConfirmButton: false });
                    $('#datatable_hoteli').DataTable().ajax.reload();
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
