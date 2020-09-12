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
        <h4 class="page-title mb-1">Lagu Wecan</h4>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Lagu Wecan</li>
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
            @if (Auth::user()->can('lagu.create'))
              <div class="float-left">
              <button onclick="addForm()" type="button" class="btn btn-primary btn-block"><i class="fa fa-plus-square"> Tambah Lagu</i> </button>
            </div>
            @endif
              <div class="float-left ml-2">
                <button onclick="refreshForm()" type="button" class="btn btn-info btn-flat "><i class="fas fa-recycle"> Refresh</i> </button>
              </div>
          </div>
          <div class="card-body">
            <h4 class="header-title">Lagu Wecan</h4>
            <table class="table table-bordered dt-responsive table-striped nowrap table-lagu-wecan" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Wecan</th>
                  <th>Jenis</th>
                  <th>Status</th>
                  <th>Dibuat</th>
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
@include('page.wecan.lagu.modal')
@endsection
@push('scripts')
<script type="text/javascript">
  var table, save_method;
  
  $(function(){
    table = $('.table-lagu-wecan').DataTable({
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
        "url" : "{{route('lagu-wecan.data')}}",
        "type" : "GET"
      }
    });
    $('#modal-lagu-wecan form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
        var id = $('#lagu_id').val();
        if (save_method == "add")
        url = "{!! route('lagu-wecan.store') !!}";
        else url = "lagu-wecan/"+id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($(".form")[0]),
          dataType : 'JSON',
          async: false,
          processData: false,
          contentType:false,
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
            $('#modal-lagu-wecan').modal('hide');
            table.ajax.reload( null, false );
          },
          error : function(){
            toastr.error('Tidak dapat menyimpan data!', 'Error Alert', {timeOut: 4000});
          }
        });
        return false;
      }
    });

    $("select#aktivasi_wecan_id").select2({
      allowClear: true,
      width: 'resolve', // need to override the changed default
      dropdownParent: $("#modal-lagu-wecan"),
      placeholder: 'Pilih Wecan',
      minimumInputLength: 1,
      ajax: {
        url: '{{route('lagu-wecan.select2wecan')}}',
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

    $('#deskripsi').summernote({
          height: 350,                 // set editor height
          minHeight: null,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor
          focus: false,                 // set focus to editable area after initializing summernote
    });


  });

  function addForm(){
    save_method = "add";
    $('input[name = _method]').val('POST');
    $('#modal-lagu-wecan').modal('show');
    $('#modal-lagu-wecan form')[0].reset();
    $('.modal-title').text('Tambah Data Atribut');
    $("#deskripsi").summernote("code", "");
    $('#aktivasi_wecan_id').empty();
  }
   function refreshForm(){
  table.ajax.reload( null, false );
  }

  function editForm(id){
    save_method = "edit";
    $('input[name = _method]').val('PATCH');
    $('#modal-lagu-wecan form')[0].reset();
    $.ajax({
      url: 'lagu-wecan/'+id+'/edit',
      type: "GET",
      dataType: "JSON",
      success : function(data){
        $('#modal-lagu-wecan').modal('show');
        $('.modal-title').text('Edit Data Atribut');
        $('#lagu_id').empty();
        $('#lagu_id').val(data.lagu.id);
        $('#jenis').val(data.lagu.jenis);
        $('#url').val(data.lagu.url);
        $('select#aktivasi_wecan_id').select2('trigger','select',{'data':{'id':data.lagu.aktivasi_wecan_id,'text':data.lagu.wecan.name}}); 
        $("#deskripsi").summernote("code", data.lagu.deskripsi);
      },
      error : function(){
        toastr.warning('Tidak dapat menampilkan data!', 'Error Alert', {timeOut: 3000});
      }
    });
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
          url: 'lagu-wecan/' + id,
          type: 'DELETE',
          data: {
            '_token': $('input[name=_token]').val(),
          },
          success: function(data){
            if(data.status == "failed"){
              swal("Error deleting!", "lagu wecan tidak bisa dihapus!","warning");
              toastr.warning('lagu wecan sedang digunakan tidak bisa dihapus!', 'Warning Alert', {timeOut: 4000});
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
  function laguWecan(id){
    swal({
      title: "Apakah anda yakin?",
      text: "anda akan mengubah Wecan!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: "Ya, Ubah!",
      closeOnConfirm: false
    }).then((result) => {
      if (result.value) {
        $.ajax({
          url: 'lagu-wecan/' + id + '/aktivasi',
          type: 'POST',
          data: {
            '_token': $('input[name=_token]').val(),
          },
          success: function(data){
            swal("Done!", "lagu wecan Berhasil diubah!", "success");
            toastr.success('lagu wecan Berhasil diubah!', 'Success Alert', {timeOut: 4000});
            table.ajax.reload();
          },
          error : function(data){
            swal("Gagal mengubah!", "Silakan Coba lagi", "error");
            toastr.warning('Tidak dapat mengubah aturan Wecan!', 'Error Alert', {timeOut: 3000});
          }
        });
      }
    })
  }
</script>
@endpush
