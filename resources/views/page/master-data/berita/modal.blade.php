<div class="modal fade" id="modal-berita" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <form class="form form-horizontal" data-toggle="validator"  method="post" enctype="multipart/form-data">
          {{csrf_field()}} {{method_field('POST')}}
          <div class="modal-header">
            <h4 class="modal-title"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true"> &times;</span> </button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="berita_id" name="berita_id" >
            <div class="form-group text-center">
              <div class="profile-image"> <img src="{{asset('assets/images/users/default.png')}}" id="previewfoto" class="rounded-circle header-profile-user-detail" alt=""> </div>
            </div>
            <div class="form-group">
              <label for="judul" class="col-md-5 control-label" >Judul</label>
              <div class="col-md-12">
                <input type="text" id="judul" class="form-control" placeholder="Judul" name="judul" autofocus required>
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group">
              <label for="img" class="col-md-5 control-label" >Foto</label>
              <div class="col-md-12">
                <input type="file" class="uploads form-control" id="img" name="img">
                <span class="help-block with-errors"></span>
              </div>
            </div>
            <div class="form-group">
                <label for="deskripsi" class="col-md-5 control-label" >Deskripsi</label>
                <div class="col-md-12">
                  <textarea name="deskripsi" id="deskripsi"></textarea>
                  <span class="help-block with-errors"></span>
                </div>
              </div>
              <div class="form-group">
                <label for="status" class="col-md-5 control-label" >Status</label>
                <div class="col-md-12">
                  <div class="row">
                    <div class="col-lg-12">
                      <select class="form-control" name="status" id="status" required>
                        <option selected disabled>--Pilih Status--</option>
                        <option value="draft">Draft</option>
                        <option value="published">Published</option>
                      </select>
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
  