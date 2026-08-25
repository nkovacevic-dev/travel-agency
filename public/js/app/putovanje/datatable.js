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
            name: "putovanjas.id",
        },
        {
            data: "naziv",
            name: "putovanjas.naziv",
        },
        {
            data: "naziv_drzave",
            name: "drzavas.naziv",
        },
        {
            data: "grad",
            name: "putovanjas.grad",
        },
        {
            data: "cena",
            name: "putovanjas.cena",
        },
        {
            data: "termini",
            name: "termini",
            orderable: false,
            searchable: false,
        },
        {
            data: "broj_rezervacija",
            name: "putovanjas.broj_rezervacija",
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
    
    if (confirm('Da li ste sigurni da želite da obrišete ovo putovanje?')) {
        axios.delete('/admin/putovanja/' + id)
            .then(function (response) {
                if (response.data.success) {
                    alert(response.data.message);
                    $("#datatable_putovanja").DataTable().ajax.reload();
                } else {
                    alert('Greška: ' + response.data.message);
                }
            })
            .catch(function (error) {
                if (error.response && error.response.data && error.response.data.message) {
                    alert('Greška: ' + error.response.data.message);
                } else {
                    alert('Došlo je do greške pri brisanju.');
                }
                console.log(error);
            });
    }
});

