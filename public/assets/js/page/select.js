
function UptSelect(upt_id, pre_register_id, parent) {
    $('.upt-select').select2({
        dropdownParent: parent ? $('#modal-data') : $('body'),
        placeholder: 'select item',
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
                return {
                    results: $.map(data, function (obj) {
                        return { id: obj.id, text: obj.nama_satpel + ' - ' + obj.nama }
                    })
                }
            }
        }
    })
    if (pre_register_id) {
        $.ajax({
            type: 'GET',
            url: '/select/upt/',
            data: {
                pre_register_id: pre_register_id
            }
        }).then(function (response) {


            var select2Element = $('.upt-select');
            select2Element.empty();

            response.forEach(function (item) {
                var option = new Option(item.nama_satpel + ' - ' + item.nama, item.id, true, true);
                select2Element.append(option);
            });
            select2Element.trigger('change');

        });
    }

    if (upt_id) {
        $.ajax({
            type: 'GET',
            url: '/select/upt/',
            data: {
                upt_id: upt_id
            }
        }).then(function (response) {
            var option = new Option(response.nama_satpel + ' - ' + response.nama, response.id, true, true);
            $('.upt-select').append(option).trigger('change');

            $('.upt-select').trigger({
                type: 'select2:select',
                params: {
                    results: response
                }
            });
        });
    }
}
function ProvinsiSelect(provinsi_id, parent) {
    $('.provinsi-select').select2({
        placeholder: 'select item',
        dropdownParent: parent ? $('#modal-data') : $('body'),
        minimumResultsForSearch: -1,
        ajax: {
            type: 'GET',
            url: '/select/provinsi',
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return { id: obj.id, text: obj.nama }
                    })
                }
            }
        }
    })
    if (provinsi_id) {
        $.ajax({
            type: 'GET',
            url: '/select/provinsi/',
            data: {
                provinsi_id: provinsi_id
            }
        }).then(function (response) {
            var option = new Option(response.nama, response.id, true, true);
            $('.provinsi-select').append(option).trigger('change');

            $('.provinsi-select').trigger({
                type: 'select2:select',
                params: {
                    results: response
                }
            });
        });
    }
}
function NegaraSelect(negara_id, parent) {
    $('.negara-select').select2({
        placeholder: 'select item',
        dropdownParent: parent ? $('#modal-data') : $('body'),
        minimumResultsForSearch: -1,
        ajax: {
            type: 'GET',
            url: '/select/negara',
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return { id: obj.id, text: obj.kode + ' - ' + obj.nama }
                    })
                }
            }
        }
    })


    if (negara_id) {
        $.ajax({
            type: 'GET',
            url: '/select/negara/',
            data: {
                negara_id: negara_id
            }
        }).then(function (response) {
            var option = new Option(response.kode + ' - ' + response.nama, response.id, true, true);
            $('.negara-select').append(option).trigger('change');
            $('.negara-select').trigger({
                type: 'select2:select',
                params: {
                    results: response
                }
            });
        });
    }

}
function KotaSelect(kota_id, parent) {
    $('.kota-select').select2({
        placeholder: "select item",
        dropdownParent: parent ? $('#modal-data') : $('body'),
        minimumResultsForSearch: -1,
        //
    });
    $('.provinsi-select').change(function () {
        $('.kota-select').empty()
        var provinsi = $(this).val();
        $('.kota-select').select2({
            placeholder: "Select Item",
            dropdownParent: parent ? $('#modal-data') : $('body'),
            minimumResultsForSearch: -1,
            //
            ajax: {
                url: '/select/kota/' + provinsi,
                type: "GET",
                dataType: "json",
                data: function (params) {
                    return {
                        q: params.term
                    }
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (obj) {
                            return { id: obj.id, text: obj.nama }
                        })
                    }
                }

            }
        })
        if (kota_id) {
            $.ajax({
                type: 'GET',
                url: '/select/kota/' + provinsi,
                data: {
                    kota_id: kota_id
                }
            }).then(function (response) {
                var option = new Option(response.nama, response.id, true, true);
                $('.kota-select').append(option).trigger('change');

                $('.kota-select').trigger({
                    type: 'select2:select',
                    params: {
                        results: response
                    }
                });
            });
        }
    })
}

function PerusahaanIndukSelect(baratin_id) {
    $('.induk-select').select2({
        // dropdownParent: $('#modal-data').length ? $('#modal-data') : $('body'),
        placeholder: 'select item',
        ajax: {
            type: 'GET',
            url: '/select/perusahaan',
            dataType: 'json',
            data: function (params) {
                return {
                    q: params.term
                }
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (obj) {
                        return { id: obj.id, text: obj.nama_perusahaan }
                    })
                }
            }
        }
    })
    if (baratin_id) {
        $.ajax({
            type: 'GET',
            url: '/select/perusahaan',
            data: {
                baratin_id: baratin_id
            }
        }).then(function (response) {
            var option = new Option(response.nama_perusahaan, response.id, true, true);
            $('.induk-select').append(option).trigger('change');

            $('.induk-select').trigger({
                type: 'select2:select',
                params: {
                    results: response
                }
            });
        });
    }
}


// $('#negara').change(function () {
//     let val = $(this).val();
//     console.log(val);
//     if (val === 99) {
//         $('.kota-select').addClass('d-none');
//         $('.provinsi-select').addClass('d-none');
//     } else {
//         $('.kota-select').empty().addClass('d-none');
//         $('.provinsi-select').empty().addClass('d-none');
//         $('.kota-select').empty();
//         $('.provinsi-select').empty();
//     }
// });
