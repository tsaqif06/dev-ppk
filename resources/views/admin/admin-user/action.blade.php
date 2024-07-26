<a class="btn btn-outline-warning btn-sm me-2"
    onclick="modal('Edit Admin','modal-md','static','{{ route('admin.admin-user.edit', $model->id) }}')" title="Edit"><i
        class="fas fa-edit"></i></a>
<a class="btn btn-outline-danger btn-sm"
    onclick="DeleteAlert('{{ route('admin.admin-user.destroy', $model->id) }}','{{ $model->nama }}')"><i
        class="fas fa-trash"></i></a>
