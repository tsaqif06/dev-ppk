@php
    $split_name_file = explode('.', explode('/', $model->file)[2]);
    $ext = $split_name_file[1];
@endphp
@if ($ext === 'pdf')
    <div class="text-center">
        <a class="btn btn-warning btn-sm" href="{{ asset('storage/' . $model->file) }}" target="_blank">
            <i class="far fa-file-pdf"></i></a>
    </div>
@else
    <div class="text-center">
        <a href="{{ asset('storage/' . $model->file) }}" target="_blank">
            <img src="{{ asset('storage/' . $model->file) }}" class="w-75">
        </a>
    </div>
@endif
