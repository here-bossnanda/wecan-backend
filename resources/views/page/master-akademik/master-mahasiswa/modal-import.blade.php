<div class="modal fade" id="modal-import" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
          {{csrf_field()}}
          <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true"> &times;</span> </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="importMahasiswa" class="col-md-8 control-label">Silakan import data dibawah ini....</label>
              <div class="col-md-12">
                <input type="file" class="form-control dropify" data-allowed-file-extensions="xlsx csv" data-show-remove="true" name="importMahasiswa" required>
                <span class="help-block with-errors"></span>
              </div>
            </div>
          </div>
          <div class="modal-footer ">
            <button type="submit" class="btn btn-primary ">
              <span class='glyphicon glyphicon-check'></span> Import Data</button>
              <button type="button" class="btn btn-warning" data-dismiss="modal">
                <span class='glyphicon glyphicon-remove'></span> Tutup
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  