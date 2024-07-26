@if ($model->barantin->user_id)
    <a class="btn btn-sm me-2 {{ $model->blockir ? 'btn-outline-success' : 'btn-outline-danger' }}" onclick="{{ $model->blockir ? 'Open' : 'Block' }}('{{ route('admin.pendaftar.' . ($model->blockir ? 'open' : 'block') . '.akses', $model->id) }}', '{{ $model->barantin->nama_perusahaan }}')">
        <i class="fas fa-user{{ $model->blockir ? '-check' : '-slash' }}"></i>
    </a>
@else
    <a class="btn btn-outline-secondary btn-sm me-2" onclick="alertBlockirUser()"><i class="fas fa-user-slash"></i></a>
@endif
<a class="btn btn-outline-info btn-sm" onclick="ShowPage('{{ route('admin.pendaftar.show', $model->id) }}')"><i class="fas fa-eye"></i></a>
@if (auth()->guard('admin')->user()->upt_id == $uptPusatId)
    <a class="btn btn-sm ms-2 {{ $model->barantin->user_id ? 'btn-outline-primary' : 'btn-outline-warning' }}"
        onclick="{{ $model->barantin->user_id ? 'UserSetting' : 'CreateUser' }}('{{ route('admin.pendaftar.' . ($model->barantin->user_id ? 'send.user' : 'create.user'), $model->barantin->user_id ? $model->barantin->user_id : $model->id) }}', '{{ $model->barantin->nama_perusahaan }}')">
        <i class="fas fa-user{{ $model->barantin->user_id ? '-cog' : '-edit' }}"></i>
    </a>
@endif
