<div class="modal fade" id="modal-mahasiswa" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <form class="form form-horizontal" data-toggle="validator"  method="post" enctype="multipart/form-data">
          {{csrf_field()}} {{method_field('POST')}}
          <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true"> &times;</span> </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="id_mahasiswa" name="id_mahasiswa" >
            <div class="form-group text-center">
              <div class="profile-image"> <img src="{{asset('assets/images/users/default.png')}}" id="previewfoto" class="rounded-circle header-profile-user-detail" alt=""> </div>
            </div>
            <div class="form-group">
              <label for="npm" class="col-md-5 control-label" >NPM</label>
              <div class="col-md-12">
                <input type="text" id="npm" class="form-control" placeholder="NPM" name="npm" autofocus required>
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-md-5 control-label" >Nama</label>
              <div class="col-md-12">
                <input type="text" id="name" class="form-control" placeholder="Nama" name="name" autofocus required>
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-md-5 control-label" >Email</label>
                <div class="col-md-12">
                  <input type="email" id="email" class="form-control" placeholder="Nama" name="email" autofocus required>
                  <span class="help-block with-errors"></span>
                </div>
              </div>
            <div class="form-group">
                <label for="no_telp" class="col-md-5 control-label" >No Handphone</label>
                <div class="col-md-12">
                  <input type="text" id="no_telp" class="form-control" placeholder="No Handphone" name="no_telp" autofocus required>
                  <span class="help-block with-errors"></span>
                </div>
              </div>
            <div class="form-group">
                <label for="jurusan_id" class="col-md-5 control-label">Pilih Jurusan</label>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-lg-12">
                      <select class="form-control"  name="jurusan_id" id="jurusan_id" style="width:100%;" required></select>
                      <span class="help-block with-errors"></span>
                    </div>
                  </div>
                </div>
              </div>
            <div class="form-group">
              <label for="jenis_kelamin" class="col-md-5 control-label" >Jenis Kelamin</label>
              <div class="col-md-12">
                <input type="radio" name="jenis_kelamin"
                @if (old('jenis_kelamin')== "L")
                checked
                @endif value="L" checked> Laki-Laki
                <input type="radio" name="jenis_kelamin"
                @if (old('jenis_kelamin')== "P")
                checked
                @endif value="P"> Perempuan
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="angkatan" class="col-md-5 control-label" >Angkatan</label>
              <div class="col-md-12">
                <input type="text" id="angkatan" class="form-control" placeholder="Angkatan" name="angkatan" data-min-view="years" data-view="years" data-date-format="yyyy" data-language="en" autofocus required/>
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="angkatan" class="col-md-5 control-label" >Foto</label>
              <div class="col-md-12">
                <input type="file" class="uploads form-control" id="foto" name="foto">
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group">
                <label for="alamat" class="col-md-5 control-label" >Alamat</label>
                <div class="col-md-12">
                  <textarea name="alamat" id="alamat"></textarea>
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
  