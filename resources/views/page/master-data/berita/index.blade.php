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
        <h4 class="page-title mb-1">Master Data Berita</h4>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Master Data Berita</li>
        </ol>
      </div>
      {{-- <div class="col-md-4">
        <div class="float-right d-none d-md-block">
          <div class="dropdown">
            <button class="btn btn-light btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="mdi mdi-settings-outline mr-1"></i> Settings 
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
              <a class="dropdown-item" href="#">Aktivasi Wecan</a>
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
            @if (Auth::user()->can('berita.create'))
            <div class="float-left">
              <button onclick="addForm()" type="button" class="btn btn-primary btn-block"><i class="fa fa-plus-square"> Tambah Berita</i> </button>
            </div>
            @endif
            <div class="float-left ml-2">
                <button onclick="refreshForm()" type="button" class="btn btn-info btn-flat "><i class="fas fa-recycle"> Refresh</i> </button>
              </div>
            
          </div>
          <div class="card-body">
            <h4 class="header-title">Master Data Berita</h4>
            <table class="table table-bordered dt-responsive table-striped nowrap table-berita" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Judul</th>
                  <th>Slug</th>
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
@include('page.master-data.berita.modal')
@endsection
@push('scripts')
<script type="text/javascript">
  var table, save_method;
  $(function(){
    table = $('.table-berita').DataTable({
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
        "url" : "{{route('berita.data')}}",
        "type" : "GET"
      }
    });
    $('#modal-berita form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
        var id = $('#berita_id').val();
        if (save_method == "add")
        url = "{!! route('berita.store') !!}";
        else url = "berita/"+id;
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
            $('#modal-berita').modal('hide');
            table.ajax.reload( null, false );
          },
          error : function(){
            toastr.error('Tidak dapat menyimpan data!', 'Error Alert', {timeOut: 4000});
          }
        });
        return false;
      }
    });

    $('#deskripsi').summernote({
          height: 150,                 // set editor height
          minHeight: null,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor
          focus: false                 // set focus to editable area after initializing summernote
    });
  });


  function readURL() {
    var input = this;
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        $('#previewfoto').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

  $(".uploads").change(function() {
    readURL(this);
  });

  function refreshForm(){
  table.ajax.reload( null, false );
  }


  function addForm(){
    save_method = "add";
    $('input[name = _method]').val('POST');
    $('#modal-berita').modal('show');
    $('#modal-berita form')[0].reset();
    $('.modal-title').text('Tambah Data Berita');
    $('#previewfoto').attr('src', '{{asset('assets/images/users/default.png')}}');
  }

  function editForm(id){
    save_method = "edit";
    $('input[name = _method]').val('PATCH');
    $('#modal-berita form')[0].reset();
    $.ajax({
      url: 'berita/'+id+'/edit',
      type: "GET",
      dataType: "JSON",
      success : function(data){
        $('#modal-berita').modal('show');
        $('.modal-title').text('Edit Data Berita');
        $('#berita').empty();
        $('#berita_id').val(data.berita.id);
        $('#judul').val(data.berita.judul);
        $("#deskripsi").summernote("code", data.berita.deskripsi);
        $('#status').val(data.berita.status);
        if ($.trim(data.berita.img)) {
          $("#previewfoto").attr('src','{{asset('assets/images/berita')}}/'+data.berita.img);
        }else{
          $('#previewfoto').attr('src', '{{asset('assets/images/users/default.png')}}');
        }
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
          url: 'berita/' + id,
          type: 'DELETE',
          data: {
            '_token': $('input[name=_token]').val(),
          },
          success: function(data){
            if(data.status == "failed"){
              swal("Error deleting!", "Data berita tidak bisa dihapus!","warning");
              toastr.warning('Data berita sedang digunakan tidak bisa dihapus!', 'Warning Alert', {timeOut: 4000});
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
