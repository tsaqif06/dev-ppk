 <div class="modal-body">
     <div class="row">
         <div class="col-md-12 col-sm-12">
             <form class="form-data">
                 @method('PATCH')
                 <div class="row mb-3">
                     <label for="email" class="col-sm-3 col-form-label">Nama</label>
                     <div class="col-sm-9">
                         <input class="form-control" disabled value="{{ $data->nama_mitra }}">
                     </div>
                 </div>
                 <div class="row mb-3">
                     <label for="jenis_identitas" class="col-md-3 col-sm-3 col-xs-12 col-form-label">Jenis
                         Identitas</label>
                     <div class="col">
                         <input class="form-control select-item" disabled value="{{ $data->jenis_identitas_mitra }}">
                     </div>
                     <div class="col">
                         <input class="form-control" type="number" disabled value="{{ $data->nomor_identitas_mitra }}">
                     </div>
                 </div>
                 <div class="row mb-3">
                     <label for="upt" class="col-sm-3 col-form-label">Telepon</label>
                     <div class="col-sm-9">
                         <input type="text" class="form-control" disabled value="{{ $data->telepon_mitra }}">
                     </div>
                 </div>

                 <div class="row mb-3">
                     <label for="negara" class="col-md-3 col-form-label">Negara</label>
                     <div class="col-md-9">
                         <input class="form-control negara-select" disabled value="@negara($data->master_negara_id)"></input>
                     </div>
                 </div>
                 @if ($data->master_negara_id == 99)
                     <div class="row mb-3">
                         <label for="provinsi" class="col-md-3 col-form-label">Provinsi</label>
                         <div class="col-md-9">
                             <input class="form-control " disabled type="text" value="@provinsi($data->master_provinsi_id)">
                             <div class="invalid-feedback" id="provinsi-feedback"></div>
                         </div>
                     </div>

                     <div class="row mb-3">
                         <label for="kabupaten" class="col-md-3 col-form-label">Kabupaten</label>
                         <div class="col-md-9">
                             <input class="form-control " disabled value="@kota($data->master_kota_kab_id)" type="text"></input>
                         </div>
                     </div>
                 @endif

                 <div class="row mb-3">
                     <label for="kabupaten" class="col-md-3 col-form-label">Alamat</label>
                     <div class="col-md-9">
                         <textarea class="form-control" type="text" disabled id="alamat_mitra" name="alamat_mitra">{{ $data->alamat_mitra }}</textarea>
                     </div>
                 </div>

             </form>

         </div>
     </div>
 </div>
 <div class="modal-footer">
     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
 </div>
