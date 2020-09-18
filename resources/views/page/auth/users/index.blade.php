@extends('layouts.app')
@push('style')
<style media="screen">
.modal-body{
  max-height: calc(100vh - 200px);
  overflow-y: auto;
}
</style>
@endpush
@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<!-- Page-Title -->
<div class="page-title-box">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h4 class="page-title mb-1">Authentication Users</h4>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Authentication Users</li>
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
          <div class="card-body">
                <h4 class="header-title">Daftar Users</h4>
            @if (Auth::user()->can('users.create'))
              <button onclick="addForm()" type="button" style="margin:10px"class="btn btn-primary btn-flat"><i class="fa fa-plus-square"> Tambah Users</i> </button>
            @endif
                  <button onclick="refreshForm()" type="button" class="btn btn-info btn-flat "><i class="fas fa-recycle"> Refresh</i> </button>
                  <table class="table table-bordered dt-responsive table-striped nowrap table-users" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                  <thead>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Panitia</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Aktivasi</th>
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
@include('page.auth.users.modal')

@endsection
@push('scripts')
<script type="text/javascript">
  var table,table1,table2, save_method;
  $(function(){
    table = $('.table-users').DataTable({
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
        "url" : "{{route('users.data')}}",
        "type" : "GET"
      }
    });
    
    $('#modal-users form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
        var id = $('#id_users').val();
        if (save_method == "add")
        url = "{!! route('users.store') !!}";
        else url = "users/"+id;
        $.ajax({
          url : url,
          type : "POST",
          data : $('#modal-users form').serialize(),
          dataType : 'JSON',
          success : function(data){
            if(data.status == "false"){
              toastr.warning('Data sudah ada!', 'Warning Alert', {timeOut: 4000});
            }else if(data.status == 0){
              $.each( data.message, function(k,v) {
                toastr.warning(v, 'Warning Alert', {timeOut: 4000});
              });
            }else{
              if (save_method == "add"){
                toastr.success('Data Berhasil di Simpan!', 'Success Alert', {timeOut: 4000});
              }else{
                toastr.success('Data Berhasil di update!', 'Success Alert', {timeOut: 4000});
              }
            }
            $('#modal-users').modal('hide');
            table.ajax.reload( null, false );
          },
          error : function(){
            toastr.error('Tidak dapat menyimpan data!', 'Error Alert', {timeOut: 4000});
          }
        });
        return false;
      }
    });
    
    $("select#id_roles_users").select2({
      allowClear: true,
      width: 'resolve', // need to override the changed default
      dropdownParent: $("#modal-users"),
      placeholder: 'Pilih Roles',
      minimumInputLength: 1,
      ajax: {
        url: '{{route('users.select2role')}}',
        dataType: 'json',
        data: function (params) {
          return {
            q: $.trim(params.term),
            page: params.page || 1
          };
        },
        processResults: function (data) {
          data.page = data.page || 1;
          return {
            results: data.items.map(function (item) {
              return {
                id: item.id,
                text:item.name
              };
            }),
            pagination: {
              more: data.pagination
            }
          }
        },
        cache: true
      }
    });
    
    $("select#id_dosen_users").select2({
      allowClear: true,
      width: 'resolve', // need to override the changed default
      dropdownParent: $("#modal-users"),
      placeholder: 'Pilih Dosen',
      minimumInputLength: 1,
      ajax: {
        url: '{{route('users.select2dosen')}}',
        dataType: 'json',
        data: function (params) {
          return {
            q: $.trim(params.term),
            page: params.page || 1
          };
        },
        processResults: function (data) {
          data.page = data.page || 1;
          return {
            results: data.items.map(function (item) {
              return {
                id: item.id,
                text:item.dosen.nip + " " + item.dosen.name
              };
            }),
            pagination: {
              more: data.pagination
            }
          }
        },
        cache: true
      }
    });
    $("select#id_mahasiswa_users").select2({
      allowClear: true,
      width: 'resolve', // need to override the changed default
      dropdownParent: $("#modal-users"),
      placeholder: 'Pilih Mahasiswa',
      minimumInputLength: 1,
      ajax: {
        url: '{{route('users.select2mahasiswa')}}',
        dataType: 'json',
        data: function (params) {
          return {
            q: $.trim(params.term),
            page: params.page || 1
          };
        },
        processResults: function (data) {
          data.page = data.page || 1;
          return {
            results: data.items.map(function (item) {
              return {
                id: item.id,
                text:item.mahasiswa.npm + " " + item.mahasiswa.name
              };
            }),
            pagination: {
              more: data.pagination
            }
          }
        },
        cache: true
      }
    });
  });

  function refreshForm(){
  table.ajax.reload( null, false );
  }

  function addForm(){
    save_method = "add";
    $('input[name = _method]').val('POST');
    $('#modal-users').modal('show');
    $('#modal-users form')[0].reset();
    $('.modal-title').text('Tambah Data Users');
    $('.dosengone').hide();
    $('.mahasiswagone').hide();
    $('.rolegone').hide();
    $('.rolecreate').show();
    $('#password').attr("required",true);
    $('#password1').attr("required",true);
    $('select#id_roles_users').empty();
    $('select#id_dosen_users').empty();
    $('select#id_mahasiswa_users').empty();
    $('select#id_dosen_users').prop("required",false);
    $('select#id_mahasiswa_users').prop("required",false);
    $('#username_register').prop("readonly",false);
    $('#rolecreate').show();
    $('#roleedit').hide();
    $('#role_register_edit').prop("required",false);
  }

  function getComboA(selectObject) {
    var value = selectObject.value;
    if (value === "admin") {
      $('.dosengone').slideUp();
      $('.mahasiswagone').slideUp();
      $('.rolegone').slideDown();
      $('select#id_dosen_users').empty();
      $('select#id_roles_users').empty();
      $('select#id_mahasiswa_users').empty();
      $('select#id_dosen_users').prop("required",false);
      $('select#id_mahasiswa_users').prop("required",false);
      $('#username_register').prop("readonly",false);
      $('#username_register').empty();
    }else if (value === "dosen") {
      $('.dosengone').slideDown();
      $('.mahasiswagone').hide();
      $('.rolegone').slideDown();
      $('select#id_dosen_users').empty();
      $('select#id_roles_users').empty();
      $('select#id_mahasiswa_users').empty();
      $('select#id_dosen_users').prop("required",true);
      $('select#id_mahasiswa_users').prop("required",false);
    }else if (value === "mahasiswa"){
      $('.mahasiswagone').slideDown();
      $('.dosengone').hide();
      $('.rolegone').slideDown();
      $('select#id_dosen_users').empty();
      $('select#id_roles_users').empty();
      $('select#id_mahasiswa_users').empty();
      $('select#id_dosen_users').prop("required",false);
      $('select#id_mahasiswa_users').prop("required",true);
    }
  }
  
  function editForm(id){
    save_method = "edit";
    $('input[name = _method]').val('PATCH');
    $('#modal-users form')[0].reset();
    $.ajax({
      url: 'users/'+id+'/edit',
      type: "GET",
      dataType: "JSON",
      success : function(data){
        $('#modal-users').modal('show');
        $('.modal-title').text('Edit Data Users');
        $('.rolecreate').hide();
        $('.rolegone').show();
        $('.dosengone').hide();
        $('.mahasiswagone').hide();
        $('#id_users').val(data.users.id);
        $('#username').val(data.users.username);
        $('#email').val(data.users.email);
        $('#password').attr("required",false);
        $('#password1').attr("required",false);
        $('select#id_dosen_users').prop("required",false);
        $('select#id_mahasiswa_users').prop("required",false);
        $('select#id_roles_users').select2('trigger','select',{'data':{'id':data.users.roles[0].id,'text':data.users.roles[0].name}});
        if($.trim(data.users.panitia_mahasiswa)){
          $('.mahasiswagone').show();
          $('.dosengone').hide();
          $('select#id_dosen_users').empty();
          $('select#id_mahasiswa_users').select2('trigger','select',{'data':{'id':data.users.panitia_mahasiswa.id,'text':data.users.panitia_mahasiswa.mahasiswa.name}});
          $('select#id_dosen_users').prop("required",false);
          $('select#id_mahasiswa_users').prop("required",true);
        }

        if($.trim(data.users.panitia_dosen)){
          $('.dosengone').show();
          $('.mahasiswagone').hide();
          $('select#id_dosen_users').empty();
          $('select#id_dosen_users').select2('trigger','select',{'data':{'id':data.users.panitia_dosen.id,'text':data.users.panitia_dosen.dosen.name}});
          $('select#id_mahasiswa_users').prop("required",false);
          $('select#id_dosen_users').prop("required",true);
        }
      },
      error : function(){
        toastr.warning('Tidak dapat menampilkan data!', 'Error Alert', {timeOut: 3000});
      }
    });
  }
//   function registerSiswaForm(id){
//     $('input[name = _method]').val('POST');
//     $('#modal-siswa form')[0].reset();
//     $('.modal-title').text('Register Data Siswa');
//     $.ajax({
//       url: 'users/'+id+'/siswa',
//       type: "GET",
//       dataType: "JSON",
//       success : function(data){
//         $('#modal-siswa').modal('show');
//         $('#id_siswa').val(data.siswa.id);
//         $('#nis').val(data.siswa.nis);
//         $('#name').val(data.siswa.name);
//         $('#username').val(data.siswa.nis);
//       },
//       error : function(){
//         toastr.warning('Tidak dapat menampilkan data!', 'Error Alert', {timeOut: 3000});
//       }
//     });
//   }
//   function registerGuruForm(id){
//     $('input[name = _method]').val('POST');
//     $('#modal-guru form')[0].reset();
//     $('.modal-title').text('Register Data Guru');
//     $.ajax({
//       url: 'users/'+id+'/guru',
//       type: "GET",
//       dataType: "JSON",
//       success : function(data){
//         $('#modal-guru').modal('show');
//         $('#id_guru').val(data.guru.id);
//         $('#nip').val(data.guru.nip);
//         $('#name-guru').val(data.guru.name);
//         $('#username-guru').val(data.guru.nip);
//       },
//       error : function(){
//         toastr.warning('Tidak dapat menampilkan data!', 'Error Alert', {timeOut: 3000});
//       }
//     });
//   }
//   function unRegisterSiswaForm(id){
//     swal({
//       title: "Apakah anda yakin?",
//       text: "anda akan unregister akun ini!",
//       type: "warning",
//       showCancelButton: true,
//       confirmButtonColor: '#3085d6',
//       cancelButtonColor: '#d33',
//       confirmButtonText: "Ya, Ubah!",
//       closeOnConfirm: false
//     }).then((result) => {
//       if (result.value) {
//         $.ajax({
//           url: 'users/' + id + '/unreg',
//           type: 'POST',
//           data: {
//             '_token': $('input[name=_token]').val(),
//           },
//           success: function(data){
//             swal("Done!", "Akun Berhasil diunregister!", "success");
//             toastr.success('Akun Berhasil diunregister!', 'Success Alert', {timeOut: 4000});
//             table.ajax.reload();
//             table2.ajax.reload();
//           },
//           error : function(data){
//             swal("Gagal mengubah!", "Silakan Coba lagi", "error");
//             toastr.warning('Tidak dapat mengubah semester!', 'Error Alert', {timeOut: 3000});
//           }
//         });
//       }
//     })
//   }
 
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
    })
    .then((willDelete) => {
      if (willDelete) {
        $.ajax({
          url: 'users/' + id,
          type: 'DELETE',
          data: {
            '_token': $('input[name=_token]').val(),
          },
          success: function(data){
            if(data.status == "failed"){
              swal("Error deleting!", "Akun anda sendiri tidak bisa dihapus!","warning");
              toastr.warning('Akun anda sendiri tidak bisa dihapus!', 'Warning Alert', {timeOut: 4000});
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
    });
  }
</script>
@endpush
