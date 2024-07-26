function UptSelectFilter(parent) {
    $('.upt-select-filter').select2({
        dropdownParent: parent ? $('#modal-data') : $('body'),
        placeholder: 'Semua Data UPT',
        ajax: {
            type: 'GET',
            url: '/select/upt',
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term
                }
            },
            processResults: function (data) {
                // Menambahkan opsi "All Data" di awal hasil pencarian
                let results = [{ id: 'all', text: 'Semua Data UPT' }];

                // Menggabungkan hasil pencarian dari data ke dalam array results
                results = results.concat($.map(data, function (obj) {
                    return { id: obj.id, text: obj.nama_satpel + ' - ' + obj.nama };
                }));

                return {
                    results: results
                };
            }
        }
    })
}
