<a class="btn btn-outline-warning btn-sm me-2" onclick="modal('Edit UPT','modal-xl','static','{{ route('admin.master-upt.edit', $model->id) }}')" title="Edit"><i class="fas fa-edit"></i></a>
<a class="btn btn-outline-danger btn-sm" onclick="DeleteAlert('{{ route('admin.master-upt.destroy', $model->id) }}','{{ $model->nama }}')"><i class="fas fa-trash"></i></a>
