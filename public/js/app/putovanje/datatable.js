$("#datatable_putovanja").DataTable({
    stateSave: false,
    bProcessing: true,
    serverSide: true,
    responsive: {
        details: {
            type: "column",
            target: "tr",
        },
    },
    ajax: function (data, callback, settings) {
        axios
            .post($("#datatable_putovanja").data("url"), data)
            .then(function (response) {
                callback(response.data);
            })
            .catch(function (error) {
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    },
    lengthMenu: [
        [10, 25, 50, 100],
        [10, 25, 50, 100],
    ],
    columns: [
        {
            data: "id",
            name: "putovanje.id",
        },
        {
            data: "naziv",
            name: "putovanje.naziv",
        },
        {
            data: "naziv_drzave",
            name: "drzava.naziv",
        },
        {
            data: "grad",
            name: "putovanje.grad",
        },
        {
            data: "cena",
            name: "putovanje.cena",
        },
        {
            data: "termini",
            name: "termini",
            orderable: false,
            searchable: false,
        },
        {
            data: "broj_rezervacija",
            name: "putovanje.broj_rezervacija",
        },
        {
            data: 'akcija',
            name: 'akcija',
            className: 'dt-right',
            orderable : false,
            searchable : false
        }
    ],
    columnDefs: [],
    order: [[0, "asc"]],
    initComplete: function (settings, json) {
    
    },
    drawCallback: function () {
    },
    language: {
        url: datatable_lang,
    },
});

// Brisanje putovanja
$(document).on('click', '.btn-delete-putovanje', function() {
    const id = $(this).data('id');
    const naziv = $(this).closest('tr').find('td:nth-child(2)').text().trim();

    Swal.fire({
        title: 'Obriši putovanje?',
        html: naziv ? '<b>' + naziv + '</b>' : '',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Obriši',
        cancelButtonText: 'Otkaži',
        reverseButtons: true,
    }).then(function(result) {
        if (!result.isConfirmed) return;

        axios.delete('/admin/putovanja/' + id)
            .then(function(response) {
                if (response.data.success) {
                    Swal.fire({ icon: 'success', title: response.data.message, timer: 2000, showConfirmButton: false });
                    $("#datatable_putovanja").DataTable().ajax.reload();
                } else {
                    Swal.fire({ icon: 'error', title: response.data.message });
                }
            })
            .catch(function(error) {
                const msg = error.response?.data?.message ?? 'Došlo je do greške pri brisanju.';
                Swal.fire({ icon: 'error', title: msg });
            });
    });
});

