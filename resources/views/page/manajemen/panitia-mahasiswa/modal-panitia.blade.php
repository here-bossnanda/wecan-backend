<div class="modal fade" id="modal-panitia" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form class="form form-horizontal" data-toggle="validator"  method="post" enctype="multipart/form-data">
        {{csrf_field()}} {{method_field('POST')}}
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true"> &times;</span> </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="panitia_id" name="panitia_id" >
          <input type="hidden" id="wecan_id" name="wecan_id" >
          <div class="form-group goneTambah" >
            <div class="col-md-12">
              <div class="row">
                <div class="col-lg-12">
                  <table class="table table-bordered dt-responsive table-striped nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="dynamicTable">
                    <tr>
                      <th>Nickname</th>
                      <th>Panitia</th>
                      <th>Jabatan</th>
                      <th id="hideth">Action</th>
                    </tr>
                    <tr>
                        <td>
                            <input type="text" id="addn-0" class="form-control" placeholder="Nickname" name="addmore[0][nickname]" autofocus required>    
                        </td>
                        <td>
                          <div class="col-lg-12">
                              <select class="form-control panitia_id"  name="addmore[0][panitia_id]" id="addp-0" style="width:100%;" required></select>
                          </div>
                        </td>
                        <td>
                          <div class="col-lg-12">
                              <select class="form-control jabatan_id"  name="addmore[0][jabatan_id]" id="addj-0" style="width:100%;" required></select>
                          </div> 
                        </td>
                      <td id="hidebutton"><button type="button" name="add" id="addPanitia" class="btn btn-success"><i class="fa fa-plus-square"> Tambah</i></button></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="goneUpdate" style="display: none">
            <div class="form-group">
              <label for="nicknameEdit" class="col-md-5 control-label" >Nickname</label>
              <div class="col-md-12">
                <input type="text" id="nicknameEdit" class="form-control" placeholder="Nickname" name="nicknameEdit" autofocus>
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group">
                <label for="panitia_mahasiswa_id" class="col-md-5 control-label">Pilih Panitia</label>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-lg-12">
                      <select class="form-control panitia_id"  name="panitia_mahasiswa_id" id="panitia_mahasiswa_id" style="width:100%;"></select>
                      <span class="help-block with-errors"></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label for="jabatan_id" class="col-md-5 control-label">Pilih Jabatan</label>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-lg-12">
                      <select class="form-control jabatan_id"  name="jabatan_id" id="jabatan_id" style="width:100%;"></select>
                      <span class="help-block with-errors"></span>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <span class='glyphicon glyphicon-check'></span> Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
