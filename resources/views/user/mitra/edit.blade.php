 <div class="modal-body">
     <div class="row">
         <div class="col-md-12 col-sm-12">
             <form class="form-data">
                 @method('PATCH')
                 <div class="row mb-3">
                     <label for="email" class="col-sm-3 col-form-label">Nama</label>
                     <div class="col-sm-9">
                         <input class="form-control" type="text" id="nama_mitra" name="nama_mitra" value="{{ $data->nama_mitra }}">
                         <div class="invalid-feedback" id="nama_mitra-feedback"></div>
                     </div>
                 </div>
                 <div class="row mb-3">
                     <label for="jenis_identitas" class="col-md-3 col-sm-3 col-xs-12 col-form-label">Jenis
                         Identitas</label>
                     <div class="col">
                         <select class="form-control select-item" type="text" placeholder="Jenis Identitas" id="jenis_identitas_mitra" name="jenis_identitas_mitra">
                             <option value="">select item</option>
                             <option value="PASSPORT">PASSPORT</option>
                             <option value="KTP">KTP</option>
                             <option value="NPWP">NPWP 16 DIGIT</option>
                         </select>
                         <div class="invalid-feedback" id="jenis_identitas_mitra-feedback"></div>
                     </div>
                     <div class="col">
                         <input class="form-control" type="number" placeholder="Nomor Identitas" id="nomor_identitas_mitra" name="nomor_identitas_mitra" value="{{ $data->nomor_identitas_mitra }}">
                         <div class="invalid-feedback" id="nomor_identitas_mitra-feedback"></div>
                     </div>
                 </div>
                 <div class="row mb-3">
                     <label for="upt" class="col-sm-3 col-form-label">Telepon</label>
                     <div class="col-sm-9">
                         <input type="text" class="form-control" id="telepon_mitra" name="telepon_mitra" aria-describedby="inputGroupPrepend" required value="{{ $data->telepon_mitra }}">
                         <div class="invalid-feedback" id="telepon_mitra-feedback"></div>
                     </div>
                 </div>

                 <div class="row mb-3">
                     <label for="negara" class="col-md-3 col-form-label">Negara</label>
                     <div class="col-md-9">
                         <select class="form-control negara-select" type="text" placeholder="Negara" id="negara" name="negara"></select>
                         <div class="invalid-feedback" id="negara-feedback"></div>
                     </div>
                 </div>

                 <div class="row mb-3 d-none" id="provinsi-input-select">
                     <label for="provinsi" class="col-md-3 col-form-label">Provinsi</label>
                     <div class="col-md-9">
                         <select class="form-control provinsi-select" type="text" placeholder="Provinsi" id="provinsi" name="provinsi"></select>
                         <div class="invalid-feedback" id="provinsi-feedback"></div>
                     </div>
                 </div>

                 <div class="row mb-3 d-none" id="kabupaten-input-select">
                     <label for="kabupaten" class="col-md-3 col-form-label">Kabupaten</label>
                     <div class="col-md-9">
                         <select class="form-control kota-select" type="text" placeholder="Kabupaten" id="kabupaten_kota" name="kabupaten_kota"></select>
                         <div class="invalid-feedback" id="kabupaten_kota-feedback"></div>
                     </div>
                 </div>

                 <div class="row mb-3">
                     <label for="kabupaten" class="col-md-3 col-form-label">Alamat</label>
                     <div class="col-md-9">
                         <textarea class="form-control" type="text" placeholder="Alamat" id="alamat_mitra" name="alamat_mitra">{{ $data->alamat_mitra }}</textarea>
                         <div class="invalid-feedback" id="alamat_mitra-feedback"></div>
                     </div>
                 </div>

             </form>

         </div>
     </div>
 </div>
 <div class="modal-footer">
     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
     <button type="button" class="btn btn-success" id="button-submit" onclick="submit('{{ route('barantin.mitra.update', $data->id) }}',false)">Submit</button>
 </div>
 <script>
     NegaraSelect('{{ $data->master_negara_id }}', true)
     ProvinsiSelect('{{ $data->master_provinsi_id ?? null }}', true)
     KotaSelect('{{ $data->master_kota_kab_id ?? null }}', true)
     $('.select-item').select2({
         placeholder: 'select item',
         minimumResultsForSearch: -1,
         dropdownParent: $('#modal-data'),
     })
     $('#negara').change(function() {
         let _val = $(this).val();
         if (_val != 99) {
             $('.kota-select').empty();
             $('.provinsi-select').empty();
             $('#provinsi-input-select').addClass('d-none');
             $('#kabupaten-input-select').addClass('d-none');
         } else {
             $('.kota-select').empty();
             $('.provinsi-select').empty();
             $('#provinsi-input-select').removeClass('d-none');
             $('#kabupaten-input-select').removeClass('d-none');
         }
     });
     $('#jenis_identitas_mitra').val('{{ $data->jenis_identitas_mitra }}').trigger('change');
     var phoneInput = $('#telepon_mitra');
     IMask(phoneInput[0], {
         mask: '0000-0000-0000',
         lazy: false
     });
 </script>
