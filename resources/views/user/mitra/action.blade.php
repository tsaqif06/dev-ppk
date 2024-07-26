<a class="btn btn-outline-warning btn-sm"
    onclick="modal('Edit Mitra','modal-xl','static','{{ route('barantin.mitra.edit', $model->id) }}')" title="Edit"><i
        class="fas fa-edit"></i></a>
<a class="btn btn-outline-danger btn-sm mx-2"
    onclick="DeleteAlert('{{ route('barantin.mitra.destroy', $model->id) }}', '{{ $model->nama_mitra }}')"><i
        class="fas fa-trash"></i></a>
<a class="btn btn-outline-primary btn-sm"
    onclick="modal('Detail Mitra','modal-xl','static','{{ route('barantin.mitra.show', $model->id) }}')"><i
        class="fas fa-eye"></i></a>
