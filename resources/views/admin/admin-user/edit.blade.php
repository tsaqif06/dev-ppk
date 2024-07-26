<div class="modal-body">
    <form class="row g-3" id="form-data">
        @csrf
        @method('PATCH')
        <div class="col-md-6 mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" required value="{{ $data->nama }}">
            <div class="invalid-feedback" id="nama-feedback"></div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required
                value="{{ $data->email }}">
            <div class="invalid-feedback" id="email-feedback"></div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required
                value="{{ $data->username }}">
            <div class="invalid-feedback" id="username-feedback"></div>
        </div>
        <div class="col-md-6 mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="invalid-feedback" id="password-feedback"></div>
        </div>
        <div class="col-md-12 mb-3">
            <label for="upt_id" class="form-label">UPT</label>
            <select type="text" class="form-control upt-select" id="upt" name="upt" required></select>
            <div class="invalid-feedback" id="upt-feedback"></div>
        </div>

    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="button-submit"
        onclick="submit('{{ route('admin.admin-user.update', $data->id) }}', false)">Save changes</button>
</div>
<script>
    UptSelect('{{ $data->upt_id }}');
</script>
