<div class="modal fade" id="modal-users" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form form-horizontal" data-toggle="validator"  method="post" enctype="multipart/form-data">
          {{csrf_field()}} {{method_field('POST')}}
          <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true"> &times;</span> </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id_users" name="id_users" >
            <div class="form-group">
              <label for="username" class="col-md-5 control-label" >Username</label>
              <div class="col-md-12">
                <input type="text" id="username" class="form-control" placeholder="Username" name="username" required>
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="email" class="col-md-5 control-label" >Email</label>
              <div class="col-md-12">
                <input type="text" id="email" class="form-control" placeholder="Email" name="email" required>
                <span class="help-block with-errors"></span>
              </div>
            </div>
          <div class="rolecreate" style="display:none">
            <div class="form-group" >
              <label for="role_register" class="col-md-5 control-label" >Role</label>
              <div class="col-md-12">
                <div class="row">
                  <div class="col-lg-12">
                    <select class="form-control" onchange="getComboA(this)" name="role_register" id="role_register">
                      <option selected disabled>--Pilih Role--</option>
                      <option value="admin">Admin</option>
                      <option value="mahasiswa">Mahasiswa</option>
                      <option value="dosen">Dosen</option>
                    </select>
                    <span class="help-block with-errors"></span>
                  </div>
                </div>
              </div>
            </div>
          </div>
              <div class="dosengone" style="display:none">
                <div class="form-group">
                  <label for="id_dosen_users" class="col-md-5 control-label">Pilih Dosen</label>
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-lg-12">
                        <select class="form-control"  name="id_dosen_users" id="id_dosen_users" style="width:100%;"></select>
                        <span class="help-block with-errors"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mahasiswagone" style="display:none">
              <div class="form-group">
                <label for="id_mahasiswa_users" class="col-md-5 control-label">Pilih Mahasiswa</label>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-lg-12">
                      <select class="form-control"  name="id_mahasiswa_users" id="id_mahasiswa_users" style="width:100%;"></select>
                      <span class="help-block with-errors"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="rolegone" style="display:none">
            <div class="form-group">
                <label for="id_roles_users" class="col-md-5 control-label" >Assign Role</label>
                <div class="col-md-12">
                  <select class="form-control" name="id_roles_users" id="id_roles_users" style="width:100%;" required></select>
                  <span class="help-block with-errors"></span>
                </div>
              </div>
              </div>
              <div class="form-group">
                <label for="status_aktif" class="col-md-5 control-label" >Status Aktif</label>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-lg-12">
                      <select class="form-control" name="status_aktif" id="status_aktif" required>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak Aktif</option>
                      </select>
                      <span class="help-block with-errors"></span>
                    </div>
                  </div>
                </div>
              </div>
            <div class="form-group">
              <label for="password" class="col-md-5 control-label">Password</label>
              <div class="col-md-12">
                <input type="password" id="password" class="form-control" placeholder="Password" name="password" autofocus required>
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="password1" class="col-md-5 control-label">Konfirmasi Password</label>
              <div class="col-md-12">
                <input type="password"  data-match="#password" id="password1" class="form-control" placeholder="Konfirmasi Password" name="password1" required autofocus>
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
  