@if (!$model->temp_update)
    @if ($model->persetujuan === 'menunggu')
        <a class="btn btn-outline-success btn-sm xe-2" onclick="ConfirmUpdatePersetujuan('{{ route('admin.permohonan-update.confirm', $model->id) }}', '{{ $model->baratin->nama_perusahaan ?? ($model->barantincabang->nama_perusahaan ?? null) }}')">
            <i class="fas fa-check"></i>
        </a>
    @else
        <button class="btn btn-outline-danger btn-sm" disabled>
            <i class="fas fa-exclamation-triangle"></i>
        </button>
    @endif
@else
    <button class="btn btn-outline-primary btn-sm" onclick="ShowPage('{{ route('admin.permohonan-update.show', $model->id) }}')">
        <i class="fas fa-eye"></i>
    </button>
@endif
