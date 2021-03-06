<div class="modal fade" id="modal-atribut-wecan" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <form class="form form-horizontal" data-toggle="validator" method="post">
          {{csrf_field()}} {{method_field('POST')}}
          <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true"> &times;</span> </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="atribut_id" name="atribut_id" >
            <div class="form-group">
                <label for="aktivasi_wecan_id" class="col-md-5 control-label">Pilih Wecan</label>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-lg-12">
                      <select class="form-control"  name="aktivasi_wecan_id" id="aktivasi_wecan_id" style="width:100%;"></select>
                      <span class="help-block with-errors"></span>
                    </div>
                  </div>
                </div>
              </div>
            <div class="form-group">
                <label for="deskripsi" class="col-md-5 control-label" >Deskripsi</label>
                <div class="col-md-12">
                  <textarea name="deskripsi" id="deskripsi"></textarea>
                  <span class="help-block with-errors"></span>
                </div>
              </div>
            
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">
              <span class='glyphicon glyphicon-check'></span> Simpan</button>
              <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class='glyphicon glyphicon-remove'></span> Batal
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  