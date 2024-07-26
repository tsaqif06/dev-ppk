  <div class="modal-body">
      <div class="row">
          <div class="col-md-6 col-sm-12">
              <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
              <label for="" class="form-label fw-bold h6 mt-0 mb-0">Registrasi PPJK</label>
              <hr class="mt-0 mb-3">
              <form>
                  <div class="row mb-3">
                      <label for="jenis_identitas" class="col-md-3 col-sm-3 col-xs-12 col-form-label">Jenis
                          Identitas</label>
                      <div class="col">
                          <input class="form-control select-item" type="text" id="jenis_identitas_ppjk" name="jenis_identitas_ppjk" value="{{ $data->jenis_identitas_ppjk }}" disabled>
                      </div>
                      <div class="col">
                          <input class="form-control" type="number" disabled placeholder="Nomor Identitas" id="nomor_identitas_ppjk" name="nomor_identitas_ppjk" value="{{ $data->nomor_identitas_ppjk }}">
                      </div>
                  </div>

                  <div class="row mb-3">
                      <label for="nama" class="col-md-3 col-form-label">Nama</label>
                      <div class="col-md-9">
                          <input class="form-control" type="text" disabled placeholder="Nama" id="nama_ppjk" name="nama_ppjk" value="{{ $data->nama_ppjk }}">
                      </div>
                  </div>

                  <div class="row mb-3">
                      <label for="email" class="col-md-3 col-form-label">Email</label>
                      <div class="col-md-9">
                          <input class="form-control" disabled type="email" placeholder="Email" id="email_ppjk" name="email_ppjk" value="{{ $data->email_ppjk }}">
                      </div>
                  </div>

                  <div class="row mb-3">
                      <label for="tanggal_kerjasama" class="col-md-3 col-form-label">Tgl
                          Kerjasama</label>
                      <div class="col-md-9">
                          <input class="form-control" type="date" disabled placeholder="Tanggal Kerjasama" id="tanggal_kerjasama_ppjk" name="tanggal_kerjasama_ppjk" value="{{ $data->tanggal_kerjasama_ppjk }}">

                      </div>
                  </div>


                  <div class="row mb-3">
                      <label for="provinsi" class="col-md-3 col-form-label">Provinsi</label>
                      <div class="col-md-9">
                          <input class="form-control provinsi-select" type="text" id="provinsi" disabled name="provinsi" value="@provinsi($data->master_provinsi_id)">

                      </div>
                  </div>

                  <div class="row mb-3">
                      <label for="kabupaten" class="col-md-3 col-form-label">Kabupaten/Kota</label>
                      <div class="col-md-9">
                          <input class="form-control kota-select" disabled type="text" id="kabupaten_kota" value="@kota($data->master_kota_kab_id)">

                      </div>
                  </div>

                  <div class="row mb-3">
                      <label for="alamat" class="col-md-3 col-form-label">Alamat</label>
                      <div class="col-md-9">
                          <textarea class="form-control" disabled type="text" placeholder="Alamat" id="alamat_ppjk" name="alamat_ppjk">{{ $data->alamat_ppjk }}</textarea>

                      </div>
                  </div>
                  <div class="row mb-3">
                      <label for="kabupaten" class="col-md-3 col-form-label">Status PPJK</label>
                      <div class="col-md-9">
                          <input class="form-control kota-select" disabled type="text" id="kabupaten_kota" value="{{ $data->status_ppjk }}">

                      </div>
                  </div>
              </form>
          </div>

          <div class="col-md-6 col-sm-12">
              <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
              <label for="" class="form-label fw-bold h6 mt-0 mb-0">Kontak Person PPJK</label>
              <hr class="mt-0 mb-3">
              <form>
                  <div class="row mb-3">
                      <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                      <div class="col-sm-9">
                          <input class="form-control" disabled type="text" placeholder="Nama" id="nama_cp_ppjk" name="nama_cp_ppjk"value="{{ $data->nama_cp_ppjk }}">

                      </div>
                  </div>

                  <div class="row mb-3">
                      <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                      <div class="col-sm-9">
                          <textarea class="form-control" disabled type="text" id="alamat_cp_ppjk" name="alamat_cp_ppjk">{{ $data->alamat_cp_ppjk }}</textarea>

                      </div>
                  </div>

                  <div class="row mb-3">
                      <label for="telepon" class="col-sm-3 col-form-label">Telepon</label>
                      <div class="col-sm-9">
                          <input class="form-control" disabled type="tel" id="telepon_cp_ppjk" name="telepon_cp_ppjk" value="{{ $data->telepon_cp_ppjk }}">


                      </div>
                  </div>
              </form>
              <hr style="border-top: 3px solid rgb(119, 59, 3);" class="mb-1" />
              <label for="" class="form-label fw-bold h6 mt-0 mb-0">Penandatangan</label>
              <hr class="mt-0 mb-3">
              <form>
                  <div class="row mb-3">
                      <label for="nama" class="col-sm-3 col-form-label">Nama</label>
                      <div class="col-sm-9">
                          <input class="form-control" type="text" placeholder="Nama" id="nama_tdd_ppjk" name="nama_tdd_ppjk" disabled value="{{ $data->nama_tdd_ppjk }}">

                      </div>
                  </div>

                  <div class="row mb-3">
                      <label for="jenis_identitas" class="col-md-3 col-sm-3 col-xs-12 col-form-label">Jenis
                          Identitas</label>
                      <div class="col">
                          <input class="form-control select-item" type="text" disabled id="jenis_identitas_tdd_ppjk" value="{{ $data->jenis_identitas_tdd_ppjk }}">

                      </div>
                      <div class="col">
                          <input class="form-control" disabled type="number" id="nomor_identitas_tdd_ppjk" name="nomor_identitas_tdd_ppjk" value="{{ $data->nomor_identitas_tdd_ppjk }}">

                      </div>
                  </div>

                  <div class="row mb-3">
                      <label for="jabatan" class="col-sm-3 col-form-label">Jabatan</label>
                      <div class="col-sm-9">
                          <input class="form-control" disabled type="text" placeholder="Jabatan" id="jabatan_tdd_ppjk" name="jabatan_tdd_ppjk" value="{{ $data->jabatan_tdd_ppjk }}">

                      </div>
                  </div>

                  <div class="row mb-3">
                      <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                      <div class="col-sm-9">
                          <textarea class="form-control" type="text" disabled placeholder="Alamat" id="alamat_tdd_ppjk" name="alamat_tdd_ppjk">{{ $data->alamat_tdd_ppjk }}</textarea>

                      </div>
                  </div>
              </form>
          </div>

      </div>
  </div>
  <div class="modal-footer">
      <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
  </div>
