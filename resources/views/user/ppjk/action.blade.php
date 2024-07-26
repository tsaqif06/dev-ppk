<a class="btn btn-outline-warning btn-sm"
    onclick="modal('Edit PPJK','modal-xl','static','{{ route('barantin.ppjk.edit', $model->id) }}')" title="Edit"><i
        class="fas fa-edit"></i></a>
<a class="btn btn-outline-danger btn-sm mx-2"
    onclick="DeleteAlert('{{ route('barantin.ppjk.destroy', $model->id) }}', '{{ $model->nama_ppjk }}')">
    <i class="fas fa-trash"></i>
</a>
<a class="btn btn-outline-primary btn-sm"
    onclick="modal('Detail PPJK','modal-xl','static','{{ route('barantin.ppjk.show', $model->id) }}')"><i
        class="fas fa-eye"></i></a>
