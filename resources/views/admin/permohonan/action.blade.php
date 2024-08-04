@if (auth()->guard()->user()->upt_id != $uptPusatId)
    @if (!$model->status || $model->status === 'MENUNGGU')
        <a class="btn btn-outline-success btn-sm xe-2"
            onclick="ConfirmRegister('{{ route('admin.permohonan.confirm.register', $model->id) }}', '{{ $model->barantin->nama_perusahaan }}')">
            <i class="fas fa-check"></i></a>
    @else
        <button class="btn btn-outline-danger btn-sm" disabled><i class="fas fa-exclamation-triangle"></i></button>
    @endif
@endif
<a class="btn btn-outline-info btn-sm" onclick="ShowPage('{{ route('admin.permohonan.show', $model->id) }}')"><i
        class="fas fa-eye"></i>
</a>
<a href="{{route('admin.permohonan.print',$model->id)}}" class="btn btn-outline-info btn-sm print-btn" data-id="{{ $model->id }}">
    <i class="fas fa-print"></i>
</a>
