<div class="modal fade" id="modal-role-permission" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form class="form-horizontal" data-toggle="validator" method="post">
        {{csrf_field()}} {{method_field('POST')}}
        <div class="modal-header">
          <h4 class="modal-title"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true"> &times;</span> </button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="id_role_permission" name="id_role_permission" >
          <div class="form-group">
            <label for="name" class="col-md-5 control-label">Nama Rule</label>
            <div class="col-md-12">
              <input type="text" id="name" class="form-control" placeholder="name" name="name" autofocus required>
              <span class="help-block with-errors"></span>
            </div>
          </div>
          <div class="form-group">
            <label for="name" class="col-md-5 control-label">Set Permission</label>
            <div class="col-md-12">
              <div class="table-rep-plugin">
                <div class="table-responsive b-0" data-pattern="priority-columns">

                  <table  class="table table-striped nowrap table-detail" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                      <tr>
                        <th>Nama Permission</th>
                        <th class="no-sort" >
                          <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="create_func" value="1">
                            <label class="custom-control-label" for="create_func">Create</label>
                          </div>
                        </th>
                        <th class="no-sort" >
                          <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="read_func" value="1">
                            <label class="custom-control-label" for="read_func">Read</label>
                          </div>
                        </th>
                        <th class="no-sort" >
                          <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="update_func" value="1">
                            <label class="custom-control-label" for="update_func">Update</label>
                          </div>
                        </th>
                        <th class="no-sort" >
                          <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="delete_func" value="1">
                            <label class="custom-control-label" for="delete_func">Delete</label>
                          </div>
                        </th>
                        <th class="no-sort" >
                          <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="crud_func" value="1">
                            <label class="custom-control-label" for="crud_func">CRUD</label>
                          </div>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>

                  </table>
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
