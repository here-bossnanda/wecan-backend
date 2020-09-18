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
        <h4 class="page-title mb-1">Panitia Dosen</h4>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Panitia Dosen</li>
        </ol>
      </div>
      {{-- <div class="col-md-4">
        <div class="float-right d-none d-md-block">
          <div class="dropdown">
            <button class="btn btn-light btn-rounded dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="mdi mdi-settings-outline mr-1"></i> Settings
            </button>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated">
              <a class="dropdown-item" href="{{route('aktivasi-wecan.index')}}">Aktivasi Wecan</a>
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
          <div class="card-header" id="btnback" style="display:none">
            <div class="float-left">
              <button onclick="back()" type="button" class="btn btn-primary btn-block"><i class="mdi mdi-backburger"> Kembali</i> </button>
            </div>
        </div>
        <div class="card-body">
          <div id="hilang">
            <h4 class="header-title">List Wecan</h4>
            <table class="table table-bordered dt-responsive table-striped nowrap table-wecan" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Tahun Akademik</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
          @include('page.manajemen.panitia-dosen.detail')
          @include('page.manajemen.panitia-dosen.modal-dosen')

          
        </div>

      </div>
    </div>
  </div>
  <!-- end row -->

</div>
<!-- end container-fluid -->
</div>
@endsection
@push('scripts')
<script type="text/javascript">
  var table,table2, save_method;
  var i = 0;
  $(function(){
    // Initialize select2
  initailizeSelect2();
    table = $('.table-wecan').DataTable({
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
      "serverside" : true,
      "ajax":{
        "url" : "{{route('panitia-dosen.data')}}",
        "type" : "GET"
      }
    });

    table2 = $('.table-panitia-dosen').DataTable({
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
      "serverside" : true,
      'destroy': true,
      'paging': true,
      'lengthChange': true,
      'searching': true,
      'ordering': false,
      'info': true,
      'autoWidth': true,
      "processing" :true,
    });

    table3 = $('.table-absensi-perkelas').DataTable({
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
      "serverside" : true,
      'destroy': true,
      'paging': true,
      'lengthChange': true,
      'searching': true,
      'ordering': false,
      'info': true,
      'autoWidth': true,
      "processing" :true,
    });
    table4 = $('.table-presensi').DataTable({
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
      "serverside" : true,
      'destroy': true,
      'paging': true,
      'lengthChange': true,
      'searching': true,
      'ordering': false,
      'info': true,
      'autoWidth': true,
      "processing" :true,
    });

    $("#addPanitia").click(function(){
      // console.log('select#addh-'+i+'');
    if($('select#addp-'+i+'').val() == null){
        toastr.warning('Silakan Pilih Panitia!', 'Warning Alert', {timeOut: 3000});
      }else if($('select#addj-'+i+'').val() == null){
        toastr.warning('Silakan Pilih Jabatan!', 'Warning Alert', {timeOut: 3000});
      }else{
        ++i;
        $("#dynamicTable").append('<tr><td><select class="form-control dosen_id"  id="addp-'+i+'" name="addmore['+i+'][dosen_id]" style="width:100%;" required></select></td> <td><select class="form-control jabatan_id"  id="addj-'+i+'" name="addmore['+i+'][jabatan_id]" style="width:100%;" required></select></td> <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        // Initialize select2
         initailizeSelect2();
      }
    });
    $(document).on('click', '.remove-tr', function(){
      $(this).parents('tr').remove();
      i--;
    });


       $('#modal-dosen form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
        var id = $('#dosen_id').val();
        if (save_method == "add")
        url = "{!! route('panitia-dosen.store') !!}";
        else url = " panitia-dosen/"+id;
        $.ajax({
          url : url,
          type : "POST",
          data : $('#modal-dosen form').serialize(),
          dataType : 'JSON',
          success : function(data){
            if(data.status == "false"){
              toastr.warning('Data '+data.data+' sudah ada!', 'Warning Alert', {timeOut: 4000});
            }else if(data.status == 0){
              $.each( data.message, function(k,v) {
                toastr.warning(v, 'Warning Alert', {timeOut: 4000});
              });
            }
            else{
              if (save_method == "add"){
                toastr.success('Data Berhasil di Simpan!', 'Success Alert', {timeOut: 4000});
              }else{
                toastr.success('Data Berhasil di update!', 'Success Alert', {timeOut: 4000});
              }
              $('#modal-dosen').modal('hide');
              table2.ajax.reload( null, false );
            }
          },
          error : function(){
            toastr.error('Tidak dapat menyimpan data!', 'Error Alert', {timeOut: 4000});
          }
        });
        return false;
      }
    });

    });



// Initialize select2
function initailizeSelect2(){
    $(".dosen_id").select2({
      allowClear: true,
      width: 'resolve', // need to override the changed default
      dropdownParent: $("#modal-dosen"),
      placeholder: 'Pilih Dosen/Staff',
      width: 'resolve',
      ajax: {
        url: '{{route('panitia-dosen.select2panitia')}}',
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
                text:item.nip + " - " + item.name
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

    $(".jabatan_id").select2({
      allowClear: true,
      width: 'resolve', // need to override the changed default
      dropdownParent: $("#modal-dosen"),
      placeholder: 'Pilih Jabatan',
      width: 'resolve',
      ajax: {
        url: '{{route('panitia-dosen.select2jabatan')}}',
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
}

    function tambahdosen(id){
    save_method = "add";
    $('#modal-dosen #wecan_id').val(id);
    $('input[name = _method]').val('POST');
    $('#modal-dosen').modal('show');
    $('#modal-dosen form')[0].reset();
    $('.modal-title').text('Register Panitia Dosen');
    $('.goneTambah').show();
    $('.goneUpdate').hide();
    $('#dosen_id').val("");
    $('#addp-0').prop("required",true);
    $('#addpj-0').prop("required",true);
    $('#panitia_dosen_id').prop("required",false);
    $('#jabatan_id').prop("required",false);
    $('.dosen_id').empty();
    $('.jabatan_id').empty();

      for(var j = 0 ; j < i ; j++){
      $('.remove-tr').parents('tr').remove();
      i--;
      }
    }
    
  function back(){
    $('#hilang').show();
    $('#detail-panitia-dosen').hide();
    $('.header-title').text('List Wecan');
    $('#buttontambahpanitia').hide();
    $('#buttontambahabsen').hide();
    $('#buttonubahperiode').hide();
    $('#btnback').hide();
  }

  function refreshFormDosen(){
  table2.ajax.reload( null, false );
  }

  function detailComponent(id){
    $.ajax({
      url: 'panitia-dosen/'+id+'/getData',
      type: "GET",
      dataType: "JSON",
      success : function(data){
        $('#hilang').hide();
        // console.log(id);
        $('#detail-panitia-dosen').show();
        $('.title-panitia').text('Panitia Dosen '+ data.data.name);
        $('#buttontambahpanitia').show();
        $('#buttontambahpanitia').attr('onclick', 'tambahdosen('+id+')');
        $('#btnback').show();
        table2.ajax.url("panitia-dosen/"+id+"/detail");
        table2.ajax.reload();
      },
      error : function(){
        toastr.warning('Tidak dapat menampilkan data!', 'Error Alert', {timeOut: 3000});
      }
    });
  }
  function editForm(id){
    save_method = "edit";
    $('input[name = _method]').val('PATCH');
    $('#modal-dosen form')[0].reset();
    $('.goneTambah').hide();
    $('.goneUpdate').show();
    $('#addp-0').prop("required",false);
    $('#addpj-0').prop("required",false);
    $('#panitia_dosen_id').prop("required",true);
    $('#jabatan_id').prop("required",true);
    $.ajax({
      url: 'panitia-dosen/'+id+'/edit',
      type: "GET",
      dataType: "JSON",
      async: false,
      processData: false,
      contentType:false,
      success : function(data){
        $('#modal-dosen').modal('show');
        $('#modal-dosen .modal-title').text('Edit Panitia Dosen');
        $('#dosen_id').val(id);
        $('#wecan_id').val(data.panitia.aktivasi_wecan_id)
        $('select.dosen_id').select2('trigger','select',{'data':{'id':data.panitia.master_panitia_dosen_id,'text':data.panitia.dosen.name}}); 
        $('select.jabatan_id').select2('trigger','select',{'data':{'id':data.panitia.jabatan_id,'text':data.panitia.jabatan.name}}); 
        
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
          url: 'panitia-dosen/' + id,
          type: 'DELETE',
          data: {
            '_token': $('input[name=_token]').val(),
          },
          success: function(data){
            if(data.status == "failed"){
              swal("Error deleting!", "Jurusan tidak bisa dihapus!","warning");
              toastr.warning('Jurusan sedang digunakan tidak bisa dihapus!', 'Warning Alert', {timeOut: 4000});
            }else{
              swal("Done!", "Data Berhasil di hapus!", "success");
              toastr.success('Data Berhasil di hapus!', 'Success Alert', {timeOut: 4000});
              table2.ajax.reload();
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
