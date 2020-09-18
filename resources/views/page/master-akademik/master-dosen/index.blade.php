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
        <h4 class="page-title mb-1">Master Data Dosen</h4>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Master Data Dosen</li>
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
            @if (Auth::user()->can('master-panitia-dosen.create'))
            <div class="float-left">
              <button onclick="addForm()" type="button" class="btn btn-primary btn-block"><i class="fa fa-plus-square"> Tambah Dosen</i> </button>
            </div>
            @endif
            <div class="float-left ml-2">
                <button onclick="refreshForm()" type="button" class="btn btn-info btn-flat "><i class="fas fa-recycle"> Refresh</i> </button>
              </div>
            <div class="float-right ml-2">
              <div class="dropdown">
                <button class="btn btn-success btn-block dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-file-excel mr-1"></i> Import/Export Excel <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-left p-0 dropdown-menu-animated pull-right">
                  <a class="dropdown-item" href="javascript:void(0);" onclick="importForm()"><i class="fas fa-file-import font-size-16 align-middle mr-1"></i> Import Excel</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="{{route('master-dosen.formatxlsx')}}" ><i class="fas fa-file-export font-size-16 align-middle mr-1"></i>Export Format Import .xlsx</a>
                  <a class="dropdown-item" href="{{route('master-dosen.formatcsv')}}"><i class="fas fa-file-export font-size-16 align-middle mr-1"></i>Export Format Import .csv</a>
                </div>
              </div>
            </div>
            
          </div>
          <div class="card-body">
            <h4 class="header-title">Master Data Dosen</h4>
            <table class="table table-bordered dt-responsive table-striped nowrap table-dosen" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
              <thead>
                <tr>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Email</th>
                  <th>Jenis Kelamin</th>
                  <th>Jurusan</th>
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
@include('page.master-akademik.master-dosen.modal')
@include('page.master-akademik.master-dosen.modal-import')
@endsection
@push('scripts')
<script type="text/javascript">
  var table, save_method;
  $(function(){
    table = $('.table-dosen').DataTable({
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
        "url" : "{{route('master-dosen.data')}}",
        "type" : "GET"
      }
    });
    $('#modal-dosen form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
        var id = $('#id_dosen').val();
        if (save_method == "add")
        url = "{!! route('master-dosen.store') !!}";
        else url = "master-dosen/"+id;
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
            $('#modal-dosen').modal('hide');
            table.ajax.reload( null, false );
          },
          error : function(){
            toastr.error('Tidak dapat menyimpan data!', 'Error Alert', {timeOut: 4000});
          }
        });
        return false;
      }
    });

    $('#modal-import form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
        url = "{!! route('master-dosen.import') !!}";
        swal({
          title: "Import Data",
          text: "Silakan Tunggu...",
          imageUrl: "{{asset('assets/images/200.gif')}}",
          showConfirmButton: false,
          allowOutsideClick: false,
        });
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData(this),
          dataType : 'JSON',
          contentType: false,
          cache: false,
          processData: false,
          async: true,
          success : function(data){
            if(data.status == "failed"){
              swal("Gagal!", "Opss, terjadi kesalahan!", "error");  
              $('#modal-import').modal('hide');
              toastr.error('Tidak dapat mengimport data!', 'Error Alert', {timeOut: 4000});
            }else{
              swal("Done!", "Data Berhasil di Import!", "success");
              $('#modal-import').modal('hide');
              table.ajax.reload( null, false );
            }
          },
          error : function(){
            swal("Gagal!", "Opss, terjadi kesalahan!", "error");
            $('#modal-import').modal('hide');
            toastr.error('Tidak dapat mengimport data!', 'Error Alert', {timeOut: 4000});
          }
        });
        return false;
      }
    });
    $("select#jurusan_id").select2({
      allowClear: true,
      width: 'resolve', // need to override the changed default
      dropdownParent: $("#modal-dosen"),
      placeholder: 'Pilih Jurusan',
      minimumInputLength: 1,
      ajax: {
        url: '{{route('master-dosen.select2jurusan')}}',
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
    $('#modal-import .dropify').dropify({
      messages: {
        'default': 'Drag and drop a file disini atau klik',
        'replace': 'Drag and drop or click to replace',
        'remove':  'Hapus',
        'error':   'Ooops, something wrong happended.'
      }
    });

    $('#alamat').summernote({
          airMode: true,
          height: 150,                 // set editor height
          minHeight: null,             // set minimum height of editor
          maxHeight: null,             // set maximum height of editor
          focus: false                 // set focus to editable area after initializing summernote
    });
  });

//   function readURL() {
//     var input = this;
//     if (input.files && input.files[0]) {
//       var reader = new FileReader();
//       reader.onload = function (e) {
//         $(input).prev().attr('src', e.target.result);
//       }
//       reader.readAsDataURL(input.files[0]);
//     }
//   }

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
    $('#modal-dosen').modal('show');
    $('#modal-dosen form')[0].reset();
    $('.modal-title').text('Tambah Data Dosen');
    $('#jurusan_id').empty();
    $('#previewfoto').attr('src', '{{asset('assets/images/users/default.png')}}');
  }
  function importForm(){
    $('input[name = _method]').val('POST');
    $('#modal-import').modal('show');
    $('.modal-title').text('Import Data Dosen');
    $('.dropify-clear').click();
  }

  function editForm(id){
    save_method = "edit";
    $('input[name = _method]').val('PATCH');
    $('#modal-dosen form')[0].reset();
    $.ajax({
      url: 'master-dosen/'+id+'/edit',
      type: "GET",
      dataType: "JSON",
      success : function(data){
        $('#modal-dosen').modal('show');
        $('.modal-title').text('Edit Data Dosen');
        $('#Dosen').empty();
        $('#id_dosen').val(data.dosen.id);
        $('#nip').val(data.dosen.nip);
        $('#name').val(data.dosen.name);
        $('#email').val(data.dosen.email);
        $('#no_telp').val(data.dosen.no_telp);
        $('select#jurusan_id').select2('trigger','select',{'data':{'id':data.dosen.jurusan_id,'text':data.dosen.jurusan.name}}); 
        $('#angkatan').val(data.dosen.angkatan);
        $("#alamat").summernote("code", data.dosen.alamat);
        $('input:radio[name=jenis_kelamin][value='+data.dosen.jenis_kelamin+']')[0].checked = true;
        $('#status').val(data.dosen.status);
        if ($.trim(data.dosen.foto)) {
          $("#previewfoto").attr('src','{{asset('assets/images/dosen')}}/'+data.dosen.foto);
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
          url: 'master-dosen/' + id,
          type: 'DELETE',
          data: {
            '_token': $('input[name=_token]').val(),
          },
          success: function(data){
            if(data.status == "failed"){
              swal("Error deleting!", "Data dosen tidak bisa dihapus!","warning");
              toastr.warning('Data dosen sedang digunakan tidak bisa dihapus!', 'Warning Alert', {timeOut: 4000});
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
