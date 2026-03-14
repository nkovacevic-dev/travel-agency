$("#datatable_rezervacije").DataTable({
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
            .post($("#datatable_rezervacije").data("url"), data)
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
            name: "rezervacijes.id",
        },
        {
            data: "naziv_putovanja",
            name: "putovanjas.naziv",
        },
        {
            data: "puno_ime",
            name: "rezervacijes.puno_ime",
        },
        {
            data: "email",
            name: "rezervacijes.email",
        },
        {
            data: "telefon",
            name: "rezervacijes.telefon",
        },
        {
            data: "termin",
            name: "rezervacijes.termin",
        },
        {
            data: "broj_odraslih",
            name: "rezervacijes.broj_odraslih",
        },
        {
            data: "broj_dece",
            name: "rezervacijes.broj_dece",
        },
        {
            data: "ukupna_cena",
            name: "rezervacijes.ukupna_cena",
            render: function (data, type, row) {
                return data ? parseFloat(data).toFixed(2) + ' €' : '0.00 €';
            }
        },
        {
            data: "status",
            name: "rezervacijes.status",
            render: function (data, type, row) {
                let badge = 'warning';
                if (data === 'potvrđena') badge = 'success';
                if (data === 'otkazana') badge = 'danger';
                return '<span class="badge bg-' + badge + '">' + (data || 'nova') + '</span>';
            }
        },
        {
            data: "created_at",
            name: "rezervacijes.created_at",
            render: function (data, type, row) {
                return data ? new Date(data).toLocaleDateString('sr-RS') : '';
            }
        },
        {
            data: "akcija",
            name: "akcija",
            orderable: false,
            searchable: false,
        },
    ],
    order: [[0, "desc"]],
    language: {
        url: datatable_lang,
    },
});

// Brisanje rezervacije
$(document).on('click', '.btn-delete', function() {
    const id = $(this).data('id');
    
    if (confirm('Da li ste sigurni da želite da obrišete ovu rezervaciju?')) {
        axios.delete('/rezervacije/' + id)
            .then(function (response) {
                if (response.data.success) {
                    alert(response.data.message);
                    $("#datatable_rezervacije").DataTable().ajax.reload();
                } else {
                    alert('Greška: ' + response.data.message);
                }
            })
            .catch(function (error) {
                alert('Došlo je do greške pri brisanju.');
                console.log(error);
            });
    }
});
