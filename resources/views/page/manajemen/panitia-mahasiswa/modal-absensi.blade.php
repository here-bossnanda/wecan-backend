<div class="modal fade" id="modal-absensi" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <form class="form-absensi form-horizontal" data-toggle="validator" method="post" enctype="multipart/form-data">
        {{csrf_field()}} {{method_field('POST')}}
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true"> &times;</span> </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="absensi_id" name="absensi_id">
          <input type="hidden" id="wecan_id" name="wecan_id">
          <div class="goneTambah">
            <div class="form-group">
              <label for="tgl_absensi" class="col-md-5 control-label" >Tanggal Absen</label>
              <div class="col-md-12">
                <input type="date" id="tgl_absensi" class="form-control" name="tgl_absensi" autofocus required>
                <span class="help-block with-errors"></span>
              </div>
            </div>
          </div>
          <div class="goneUpdate">
            <div class="form-group">
              <label for="name" class="col-md-5 control-label">Nama</label>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-lg-12">
                    <input type="text" name="name" id="name" class="form-control" disabled>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="status" class="col-md-5 control-label" >Status Kehadiran</label>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-lg-12">
                    <select class="form-control" onchange="getComboA(this)" name="status" id="status">
                      <option value="A">Alfa</option>
                      <option value="H">Hadir</option>
                      <option value="I">Izin</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="detail-izin" style="display:none">
              <div class="form-group">
                <label for="keterangan" class="col-md-5 control-label">keterangan</label>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-lg-12">
                      <input type="text" name="keterangan" placeholder="keterangan" id="keterangan" class="form-control">
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="importKehadiran" class="col-md-8 control-label">Bukti Surat</label>
                <div class="col-md-12">
                  <input type="file" class="form-control dropify" id="file_bukti" data-allowed-file-extensions="pdf" data-show-remove="true" name="file_bukti">
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
