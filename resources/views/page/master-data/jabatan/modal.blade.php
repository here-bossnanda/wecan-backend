<div class="modal fade" id="modal-jabatan" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" data-toggle="validator" method="post">
          {{csrf_field()}} {{method_field('POST')}}
          <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true"> &times;</span> </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id_jabatan" name="id_jabatan" >
            <div class="form-group">
              <label for="name" class="col-md-5 control-label" >Nama Jabatan</label>
              <div class="col-md-12">
                <input type="text" id="name" class="form-control" placeholder="Nama jabatan" name="name" autofocus required>
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group">
                <label for="divisi_id" class="col-md-5 control-label">Pilih Divisi</label>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-lg-12">
                      <select class="form-control"  name="divisi_id" id="divisi_id" style="width:100%;"></select>
                      <span class="help-block with-errors"></span>
                    </div>
                  </div>
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
  