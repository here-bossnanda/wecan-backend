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
        <h4 class="page-title mb-1">Aktivasi Wecan</h4>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Aktivasi Wecan</li>
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
            <div class="float-left">
            @if (Auth::user()->can('wecan.create'))
              <button onclick="addForm()" type="button" class="btn btn-primary btn-block"><i class="fa fa-plus-square"> Tambah Wecan</i> </button>
            @endif
            </div>
          </div>
          <div class="card-body">
            <h4 class="header-title">Aktivasi Wecan</h4>
            <table class="table table-bordered dt-responsive table-striped nowrap table-aktivasi-wecan" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Name</th>
                  <th>Tahun Akademik</th>
                  <th>Tanggal Mulai</th>
                  <th>Tanggal Selesai</th>
                  <th>Status</th>
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
@include('page.aktivasi-wecan.modal')
@endsection
@push('scripts')
<script type="text/javascript">
  var table, save_method;
  @if (Session::has('message'))
  $(function() {
    toastr.options.timeOut = "10000";
    toastr.options.closeButton = true;
    toastr.options.positionClass = 'toast-top-right';
    toastr['info']('{!! Session::get('message') !!}');
    $('.btn-toastr').on('click', function() {
      $context = $(this).data('context');
      $message = $(this).data('message');
      $position = $(this).data('position');
      if ($context === '') {
        $context = 'info';
      }
      if ($position === '') {
        $positionClass = 'toast-bottom-right';
      } else {
        $positionClass = 'toast-' + $position;
      }
      toastr.remove();
      toastr[$context]($message, '', {
        positionClass: $positionClass
      });
    });
  });
  @endif
  $(function(){
    table = $('.table-aktivasi-wecan').DataTable({
      "processing" :true,
      "serverside" : true,
      "ajax":{
        "url" : "{{route('aktivasi-wecan.data')}}",
        "type" : "GET"
      }
    });
    $('#modal-aktivasi-wecan form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
        var id = $('#id_aktivasi-wecan').val();
        if (save_method == "add")
        url = "{!! route('aktivasi-wecan.store') !!}";
        else url = "aktivasi-wecan/"+id;
        $.ajax({
          url : url,
          type : "POST",
          data : $('#modal-aktivasi-wecan form').serialize(),
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
            $('#modal-aktivasi-wecan').modal('hide');
            table.ajax.reload( null, false );
          },
          error : function(){
            toastr.error('Tidak dapat menyimpan data!', 'Error Alert', {timeOut: 4000});
          }
        });
        return false;
      }
    });


  });

  function addForm(){
    save_method = "add";
    $('input[name = _method]').val('POST');
    $('#modal-aktivasi-wecan').modal('show');
    $('#modal-aktivasi-wecan form')[0].reset();
    $('.modal-title').text('Tambah Data Aktivasi Wecan');
  }

  function editForm(id){
    save_method = "edit";
    $('input[name = _method]').val('PATCH');
    $('#modal-aktivasi-wecan form')[0].reset();
    $.ajax({
      url: 'aktivasi-wecan/'+id+'/edit',
      type: "GET",
      dataType: "JSON",
      success : function(data){
        $('#modal-aktivasi-wecan').modal('show');
        $('.modal-title').text('Edit Data Semester');
        $('#aktivasi-wecan').empty();
        $('#id_aktivasi-wecan').val(data.aktivasi.id);
        $('#tgl_mulai').val(data.aktivasi.tgl_mulai);
        $('#tgl_selesai').val(data.aktivasi.tgl_selesai);
        $('#tahun_akademik').val(data.aktivasi.tahun_akademik);
        $('#name').val(data.aktivasi.name);
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
          url: 'aktivasi-wecan/' + id,
          type: 'DELETE',
          data: {
            '_token': $('input[name=_token]').val(),
          },
          success: function(data){
            if(data.status == "failed"){
              swal("Error deleting!", "Aktivasi Wecan tidak bisa dihapus!","warning");
              toastr.warning('Aktivasi Wecan sedang digunakan tidak bisa dihapus!', 'Warning Alert', {timeOut: 4000});
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
  function aktivasiWecan(id){
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
          url: 'aktivasi-wecan/' + id + '/aktivasi',
          type: 'POST',
          data: {
            '_token': $('input[name=_token]').val(),
          },
          success: function(data){
            swal("Done!", "Aktivasi Wecan Berhasil diubah!", "success");
            toastr.success('Aktivasi Wecan Berhasil diubah!', 'Success Alert', {timeOut: 4000});
            table.ajax.reload();
          },
          error : function(data){
            swal("Gagal mengubah!", "Silakan Coba lagi", "error");
            toastr.warning('Tidak dapat mengubah Aktivasi Wecan!', 'Error Alert', {timeOut: 3000});
          }
        });
      }
    })
  }
</script>
@endpush
