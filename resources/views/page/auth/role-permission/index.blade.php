@extends('layouts.app')
@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- Page-Title -->
<div class="page-title-box">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h4 class="page-title mb-1">Role Permission</h4>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Role Permission</li>
        </ol>
      </div>
      {{-- <div class="col-md-4">
        <div class="float-right d-none d-md-block">
          <div class="dropdown">
            <button class="btn btn-light btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="mdi mdi-settings-outline mr-1"></i> Settings
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
                <a class="dropdown-item" href="">Aktivasi Wecan</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#">Separated link</a>
              </div>
          </div>
        </div>
      </div> --}}
    </div>

  </div>
</div>
<!-- end page title end breadcrumb -->

<div class="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-12">
        <div class="card">
          <div class="card-header">
            @if (Auth::user()->can('atribut.create'))
              <div class="float-left">
              <button onclick="addForm()" type="button" class="btn btn-primary btn-block"><i class="fa fa-plus-square"> Tambah Role</i> </button>
            </div>
            @endif
              <div class="float-left ml-2">
                <button onclick="refreshForm()" type="button" class="btn btn-info btn-flat "><i class="fas fa-recycle"> Refresh</i> </button>
              </div>
          </div>
          <div class="card-body">
            <h4 class="header-title">Role Permission</h4>
            <table class="table table-bordered dt-responsive table-striped nowrap table-role-permission" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama Role</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
          </div>
        </div>
      </div>
    </div>
    <!-- end row -->

  </div>
  <!-- end container-fluid -->
</div>
@include('page.auth.role-permission.modal')
@endsection
@push('scripts')
<script type="text/javascript">
  var table,save_method;
  $(function(){
    table = $('.table-role-permission').DataTable({
      "language": {
        "processing": '<div class="spinner-border text-info m-2" role="status"><span class="sr-only"></span></div></br><div>Tunggu Sebentar yaa...</div>',
        "paginate": {
          "previous": "<i class='uil uil-angle-left'>",
            "next": "<i class='uil uil-angle-right'>"
            }
          },
          "buttons":[ 'colvis' ],
          "drawCallback": function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
          },
      "processing" :true,
      "serverSide" : true,
      "ajax":{
        "url" : "{{route('role-permission.data')}}",
        "type" : "GET"
      }
    });
    table1 = $('.table-detail').DataTable({
      "processing" :true,
      "lengthMenu": [[50, 75, 100, -1], [50, 75, 100, "All"]],
      "columnDefs": [ {
          "targets": 'no-sort',
          "orderable": false,
    } ],
      "ajax":{
        "url" : "{{route('role-permission.permission')}}",
        "type" : "GET"
      }
    });
    $('#modal-role-permission form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
        var id = $('#id_role_permission').val();
        if (save_method == "add")
        url = "{!! route('role-permission.store') !!}";
        else url = "role-permission/"+id;
        $.ajax({
          url : url,
          type : "POST",
          data : $('#modal-role-permission form').serialize(),
          dataType : 'JSON',
          success : function(data){
            if(data.status == "false"){
              toastr.warning('Data sudah ada!', 'Warning Alert', {timeOut: 4000});
            }else{
              if (save_method == "add"){
                toastr.success('Data Berhasil di Simpan!', 'Success Alert', {timeOut: 4000});
              }else{
                toastr.success('Data Berhasil di update!', 'Success Alert', {timeOut: 4000});
              }
            }
            $('#modal-role-permission').modal('hide');
            table.ajax.reload( null, false );
          },
          error : function(){
            toastr.error('Tidak dapat menyimpan data!', 'Error Alert', {timeOut: 4000});
          }
        });
        return false;
      }
    });

    $('#perkategori_Akun').click(function(){
      $('input[type="checkbox"].create_Akun').prop('checked', this.checked);
    });

    $('#create_func').click(function(){
      $('input[type="checkbox"].create').prop('checked', this.checked);
    });
    $('#read_func').click(function(){
      $('input[type="checkbox"].read').prop('checked', this.checked);
    });
    $('#update_func').click(function(){
      $('input[type="checkbox"].update').prop('checked', this.checked);
    });
    $('#delete_func').click(function(){
      $('input[type="checkbox"].delete').prop('checked', this.checked);
    });
    $('#crud_func').click(function(){
      $('input[type="checkbox"].crud').prop('checked', this.checked);
    });
  });
  function addForm(){
    save_method = "add";
    $('input[name = _method]').val('POST');
    $('#modal-role-permission').modal('show');
    $('#modal-role-permission form')[0].reset();
    $('.modal-title').text('Tambah Rule');
    table1.ajax.reload();
  }
  function editForm(id){
    save_method = "edit";
    $('input[name = _method]').val('PATCH');
    $('#modal-role-permission form')[0].reset();
    $.ajax({
      url: 'role-permission/'+id+'/edit',
      type: "GET",
      dataType: "JSON",
      success : function(data){
        $('#modal-role-permission').modal('show');
        $('.modal-title').text('Edit Rule');
        $('#id_role_permission').val(data.role.id);
        $('#name').val(data.role.name);
        $('modal#modal-role-permission input[type="checkbox"].create').val(data.permission.id);
        if(data.role.permissions.id == data.permission.id){
          $.each(data.role.permissions , function (index, value) {
            $('.select_' + value['id']).prop('checked', 'checked');
          });
        }
      },
      error : function(){
        toastr.warning('Tidak dapat menampilkan data!', 'Error Alert', {timeOut: 3000});
      }
    });
  }
  function refreshForm(){
  table.ajax.reload( null, false );
  }
  function deleteData(id){
    swal({
      title: "Apakah anda yakin?",
      text: "data yang terhapus tidak bisa dikembalikan!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: "Yes, delete it!",
      closeOnConfirm: false
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: 'role-permission/' + id,
          type: 'DELETE',
          data: {
            '_token': $('input[name=_token]').val(),
          },
          success: function(data){
            if(data.status == "failed"){
              swal("Error deleting!", "Role Permission tidak bisa dihapus!","warning");
              toastr.warning('Role Permission sedang digunakan tidak bisa dihapus!', 'Warning Alert', {timeOut: 4000});
            }else{
              swal("Done!", "Data Berhasil di hapus!", "success");
              toastr.success('Data Berhasil di hapus!', 'Success Alert', {timeOut: 4000});
              table.ajax.reload();
            }
          },
          error : function(data){
            swal("Error deleting!", "Please try again", "error");
            toastr.warning('Tidak dapat menghapus data!', 'Error Alert', {timeOut: 3000});
          }
        });
      }
    })
  }
</script>
@endpush
