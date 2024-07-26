 <div class="modal-body">
     <div class="row">
         <div class="col-md-12 col-sm-12">
             <form class="form-data">
                 <div class="mb-3">
                     <label for="alasan_perubahan" class="form-label">Alasan Perubahan</label>
                     <textarea class="form-control" type="text" id="alasan_perubahan" name="alasan_perubahan"></textarea>
                     <div class="invalid-feedback" id="alasan_perubahan-feedback"></div>
                 </div>
             </form>
         </div>
     </div>
 </div>
 <div class="modal-footer">
     <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
     <button type="button" class="btn btn-success" id="button-submit" onclick="submit('{{ route('barantin.profile.update') }}',false)">Submit</button>
 </div>
