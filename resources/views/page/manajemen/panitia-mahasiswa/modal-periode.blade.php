<div class="modal fade" id="modal-periode" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-periode form-horizontal" data-toggle="validator" method="post">
        {{csrf_field()}} {{method_field('POST')}}
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true"> &times;</span> </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="periode_id" name="periode_id" >
          <div class="form-group">
            <label for="tgl_mulai" class="col-md-5 control-label" >Tanggal Mulai</label>
            <div class="col-md-12">
              <input type="date" id="tgl_mulai" class="form-control" name="tgl_mulai" autofocus required>
              <span class="help-block with-errors"></span>
            </div>
          </div>
          <div class="form-group">
            <label for="tgl_akhir" class="col-md-5 control-label" >Tanggal Akhir</label>
            <div class="col-md-12">
              <input type="date" id="tgl_akhir" class="form-control" name="tgl_akhir" autofocus required>
              <span class="help-block with-errors"></span>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <span class='glyphicon glyphicon-check'></span> Ubah</button>
            <button type="button" class="btn btn-danger" id="btnResetPeriode" onclick="resetPeriode()">
              <span class='glyphicon glyphicon-remove'></span> Reset
            </button>
            <button type="button" class="btn btn-warning" data-dismiss="modal">
              <span class='glyphicon glyphicon-remove'></span> Batal
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
