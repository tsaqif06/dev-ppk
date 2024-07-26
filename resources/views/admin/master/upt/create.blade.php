  <div class="modal-body">
      <form class="row g-3" id="form-data">
          @csrf
          <div class="col-md-3">
              <label for="kode_satpel" class="form-label">Kode Satpel</label>
              <input type="number" class="form-control" id="kode_satpel" name="kode_satpel" required>
              <div class="invalid-feedback" id="kode_satpel-feedback"></div>
          </div>
          <div class="col-md-3">
              <label for="kode_utp" class="form-label">Kode UPT</label>
              <input type="number" class="form-control" id="kode_upt" name="kode_upt" required>
              <div class="invalid-feedback" id="kode_upt-feedback"></div>
          </div>
          <div class="col-md-3">
              <label for="nama" class="form-label">Nama</label>
              <input type="text" class="form-control" id="nama" name="nama" required>
              <div class="invalid-feedback" id="nama-feedback"></div>
          </div>
          <div class="col-md-3">
              <label for="nama_en" class="form-label">Nama (English)</label>
              <input type="text" class="form-control" id="nama_en" name="nama_en" required>
              <div class="invalid-feedback" id="nama_en-feedback"></div>
          </div>
          <div class="col-md-6">
              <label for="wilayah_kerja" class="form-label">Wilayah Kerja</label>
              <input type="text" class="form-control" id="wilayah_kerja" name="wilayah_kerja" required>
              <div class="invalid-feedback" id="wilayah_kerja-feedback"></div>
          </div>
          <div class="col-md-6">
              <label for="kota" class="form-label">Kota</label>
              <input type="text" class="form-control" id="kota" name="kota" required>
              <div class="invalid-feedback" id="kota-feedback"></div>
          </div>
          <div class="col-md-4">
              <label for="nama_satpel" class="form-label">Nama Satpel</label>
              <input type="text" class="form-control" id="nama_satpel" name="nama_satpel" required>
              <div class="invalid-feedback" id="nama_satpel-feedback"></div>
          </div>

          <div class="col-md-4">
              <label for="kode_pelabuhan" class="form-label">Kode Pelabuhan</label>
              <input type="text" class="form-control" id="kode_pelabuhan" name="kode_pelabuhan" required>
              <div class="invalid-feedback" id="kode_pelabuhan-feedback"></div>
          </div>
          <div class="col-md-4">
              <label for="tembusan" class="form-label">Tembusan</label>
              <input type="text" class="form-control" id="tembusan" name="tembusan" required>
              <div class="invalid-feedback" id="tembusan-feedback"></div>
          </div>
          <div class="col-md-4">
              <label for="otoritas_pelabuhan" class="form-label">Otoritas Pelabuhan</label>
              <input type="text" class="form-control" id="otoritas_pelabuhan" name="otoritas_pelabuhan" required>
              <div class="invalid-feedback" id="otoritas_pelabuhan-feedback"></div>
          </div>
          <div class="col-md-4">
              <label for="syah_bandar_pelabuhan" class="form-label">Syah Bandar Pelabuhan</label>
              <input type="text" class="form-control" id="syah_bandar_pelabuhan" name="syah_bandar_pelabuhan"
                  required>
              <div class="invalid-feedback" id="syah_bandar_pelabuhan-feedback"></div>
          </div>
          <div class="col-md-4">
              <label for="kepala_kantor_bea_cukai" class="form-label">Kepala Kantor Bea Cukai</label>
              <input type="text" class="form-control" id="kepala_kantor_bea_cukai" name="kepala_kantor_bea_cukai"
                  required>
              <div class="invalid-feedback" id="kepala_kantor_bea_cukai-feedback"></div>
          </div>
          <div class="col-md-4">
              <label for="nama_pengelola" class="form-label">Nama Pengelola</label>
              <input type="text" class="form-control" id="nama_pengelola" name="nama_pengelola" required>
              <div class="invalid-feedback" id="nama_pengelola-feedback"></div>
          </div>
          <div class="col-md-4">
              <label for="stat_ppkol" class="form-label">Stat PPKOL</label>
              <select type="text" class="form-select" id="stat_ppkol" name="stat_ppkol" required>
                  <option value="Y">YA</option>
                  <option value="N">TIDAK</option>
              </select>
              <div class="invalid-feedback" id="stat_ppkol-feedback"></div>
          </div>
          <div class="col-md-4">
              <label for="stat_insw" class="form-label">Stat INSW</label>
              <select type="text" class="form-select" id="stat_insw" name="stat_insw" required>
                  <option value="Y">YA</option>
                  <option value="N">TIDAK</option>
              </select>
              <div class="invalid-feedback" id="stat_insw-feedback"></div>
          </div>
      </form>


  </div>
  <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" id="button-submit"
          onclick="submit('{{ route('admin.master-upt.store') }}', false)">Save changes</button>
  </div>
  <script>
      $('#stat_ppkol').val('Y').trigger('change')
      $('#stat_insw').val('N').trigger('change')
  </script>
