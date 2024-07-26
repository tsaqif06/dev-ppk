 <div class="modal-body">
     <div class="row">
         <div class="col-md-12 col-sm-12">
             <form id="form-data">
                 <div class="row mb-3">
                     <label for="jenis_identitas" class="col-md-12 col-form-label">Pilih UPT</label>
                     <div class="col-md-12">
                         <select class="form-control upt-select" multiple type="text" placeholder="" id="upt"
                             name="upt[]"></select>
                         <div class="invalid-feedback" id="upt-feedback"></div>
                     </div>
                 </div>
             </form>

         </div>
     </div>
 </div>
 <div class="modal-footer">
     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
     <button type="button" class="btn btn-success" id="button-submit"
         onclick="submit('{{ route('barantin.upt.store') }}', false)">Simpan</button>
 </div>
 <script>
     UptSelect(null, null, true);
 </script>
