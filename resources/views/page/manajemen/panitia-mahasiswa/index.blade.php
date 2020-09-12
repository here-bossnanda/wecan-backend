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
        <h4 class="page-title mb-1">Panitia Mahasiswa</h4>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item"><a href="{{url('/')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">Panitia Mahasiswa</li>
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
          @include('page.manajemen.panitia-mahasiswa.detail')
          @include('page.manajemen.panitia-mahasiswa.modal-panitia')
          @include('page.manajemen.panitia-mahasiswa.modal-absensi')
          @include('page.manajemen.panitia-mahasiswa.modal-periode')          

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
  var table,table2,table3,table4, save_method;
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
      "serverSide" : true,
      "ajax":{
        "url" : "{{route('panitia-mahasiswa.data')}}",
        "type" : "GET"
      }
    });

    table2 = $('.table-panitia-mahasiswa').DataTable({
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
    });

    table3 = $('.table-absensi').DataTable({
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
    });

    $("#addPanitia").click(function(){
      // console.log('select#addh-'+i+'');
      if($('#addn-'+i+'').val() == ""){
        toastr.warning('Silakan isi nickname!', 'Warning Alert', {timeOut: 3000});
      }else if($('select#addp-'+i+'').val() == null){
        toastr.warning('Silakan Pilih Panitia!', 'Warning Alert', {timeOut: 3000});
      }else if($('select#addj-'+i+'').val() == null){
        toastr.warning('Silakan Pilih Jabatan!', 'Warning Alert', {timeOut: 3000});
      }else{
        ++i;
        $("#dynamicTable").append('<tr> <td><input type="text" id="addn-'+i+'" name="addmore['+i+'][nickname]" class="form-control" placeholder="Nickname" name="addmore[0][nickname]" autofocus required> </td> <td><select class="form-control panitia_id"  id="addp-'+i+'" name="addmore['+i+'][panitia_id]" style="width:100%;" required></select></td> <td><select class="form-control jabatan_id"  id="addj-'+i+'" name="addmore['+i+'][jabatan_id]" style="width:100%;" required></select></td> <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        // Initialize select2
         initailizeSelect2();
      }
    });
    $(document).on('click', '.remove-tr', function(){
      $(this).parents('tr').remove();
      i--;
    });

       $('#modal-panitia form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
        var id = $('#panitia_id').val();
        if (save_method == "add")
        url = "{!! route('panitia-mahasiswa.store') !!}";
        else url = " panitia-mahasiswa/"+id;
        $.ajax({
          url : url,
          type : "POST",
          data : $('#modal-panitia form').serialize(),
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
              $('#modal-panitia').modal('hide');
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

    $('#modal-absensi form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
        var id = $('#absensi_id').val();
        if (save_method == "add")
        url = "{!! route('panitia-mahasiswa-absensi.store') !!}";
        else url = "panitia-mahasiswa-absensi/"+id;
        $.ajax({
          url : url,
          type : "POST",
          data : new FormData($(".form-absensi")[0]),
          dataType : 'JSON',
          async: false,
          processData: false,
          contentType:false,
          success : function(data){
            if(data.status == "false"){
              toastr.warning('Absensi pada tanggal '+ data.tanggal +' sudah ada!', 'Warning Alert', {timeOut: 4000});
            }else if(data.status == "exists"){
              toastr.warning(data.message, 'Warning Alert', {timeOut: 4000});
            }else{
              if (save_method == "add"){
                toastr.success('Data Berhasil di Simpan!', 'Success Alert', {timeOut: 4000});
              }else{
                toastr.success('Data Berhasil di update!', 'Success Alert', {timeOut: 4000});
              }
            }
            $('#modal-absensi').modal('hide');
            table3.ajax.reload( null, false );
            table4.ajax.reload( null, false );
          },
          error : function(){
            toastr.error('Tidak dapat menyimpan data!', 'Error Alert', {timeOut: 4000});
          }
        });
        return false;
      }
    });
    $('#modal-periode form').validator().on('submit', function(e){
      if(!e.isDefaultPrevented()){
        var id = $('#periode_id').val();
        url = "{!! route('panitia-mahasiswa.refresh') !!}";
        $.ajax({
          url : url,
          type : "POST",
          data : $('#modal-periode form').serialize(),
          dataType : 'JSON',
          success : function(data){
            toastr.success('Berhasil mengubah periode absensi!', 'Success Alert', {timeOut: 4000});
            $('.header-title').text('Absensi Wecan '+ data.data.name +' - Periode ' + data.awal + ' s/d ' + data.akhir);
            $('#modal-periode').modal('hide');
            table3.ajax.url("panitia-mahasiswa-absensi/"+id+"/"+data.waktu_awal+"/"+data.waktu_akhir);
            table3.ajax.reload( null, false );
          },
          error : function(){
            toastr.error('Tidak Dapat Mencetak Report!', 'Error Alert', {timeOut: 4000});
          }
        });
        return false;
      }
    });
    
    $('#modal-absensi .dropify').dropify({
      messages: {
        'default': 'Drag and drop a file disini atau klik',
        'replace': 'Drag and drop or click to replace',
        'remove':  'Hapus',
        'error':   'Ooops, something wrong happended.'
      }
    });

  });

  function getComboA(selectObject) {
    var value = selectObject.value;
    if (value === "I") {
      $('.detail-izin').slideDown();
      $('#keterangan').prop("required",true);
      $('#file_bukti').prop("required",true);
    }else{
      $('.detail-izin').slideUp();
      $('#keterangan').prop("required",false);
      $('#file_bukti').prop("required",false);
    }
  }


// Initialize select2
function initailizeSelect2(){
    $(".panitia_id").select2({
      allowClear: true,
      width: 'resolve', // need to override the changed default
      dropdownParent: $("#modal-panitia"),
      placeholder: 'Pilih Mahasiswa',
      width: 'resolve',
      ajax: {
        url: '{{route('panitia-mahasiswa.select2panitia')}}',
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
                text:item.npm + " - " + item.name
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
      dropdownParent: $("#modal-panitia"),
      placeholder: 'Pilih Jabatan',
      width: 'resolve',
      ajax: {
        url: '{{route('panitia-mahasiswa.select2jabatan')}}',
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
                text:item.name + " - " + item.divisi.name
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

    function tambahpanitia(id){
    save_method = "add";
    $('#modal-panitia #wecan_id').val(id);
    $('input[name = _method]').val('POST');
    $('#modal-panitia').modal('show');
    $('#modal-panitia form')[0].reset();
    $('.modal-title').text('Register Panitia Mahasiswa');
    $('.goneTambah').show();
    $('.goneUpdate').hide();
    $('#panitia_id').val("");
    $('#addn-0').prop("required",true);
    $('#addp-0').prop("required",true);
    $('#addpj-0').prop("required",true);
    $('#nicknameEdit').prop("required",false)
    $('#panitia_mahasiswa_id').prop("required",false);
    $('#jabatan_id').prop("required",false);
    $('.panitia_id').empty();
    $('.jabatan_id').empty();

    // $('.remove-tr').click(function(){
      for(var j = 0 ; j < i ; j++){
      $('.remove-tr').parents('tr').remove();
      i--;
      }
    // });
    }
        
  function tambahabsen(id){
    save_method = "add";
    $('input[name = _method]').val('POST');
    $('#modal-absensi').modal('show');
    $('#modal-absensi form')[0].reset();
    $('.modal-title').text('Tambah Absensi');
    $('#modal-absensi #wecan_id').val(id);
    $('.goneUpdate').hide();
    $('.goneTambah').show();
    $('#tgl_absensi').prop("required",true);
    $('#status').prop("required",false);
    $('#keterangan').prop("required",false);
    $('#file_bukti').prop("required",false);
    $('.dropify-clear').click();
  }
  function periodeabsen(id){
    $('input[name = _method]').val('POST');
    $('#modal-periode').modal('show');
    $('#modal-periode form')[0].reset();
    $('#modal-periode .modal-title').text('Periode Absensi');
    $('#modal-periode #periode_id').val(id);
    $('#modal-periode #btnResetPeriode').attr('onclick', 'resetPeriode('+id+')');
  }
  function resetPeriode(id){
    $.ajax({
      url: 'panitia-mahasiswa/'+id+'/getData',
      type: "GET",
      dataType: "JSON",
      success : function(data){
        $('.title-absensi').text('Absensi Panitia Mahasiswa '+ data.data.name);
        $('#modal-periode').modal('hide');
        table2.ajax.url("panitia-mahasiswa/"+id+"/detail");
        table2.ajax.reload();
        toastr.success('Periode absensi direset!', 'Success Alert', {timeOut: 3000});
      },
      error : function(){
        toastr.warning('Tidak dapat menampilkan data!', 'Error Alert', {timeOut: 3000});
      }
    });
  }
  function back(){
    $('#hilang').show();
    $('#detail-panitia-mahasiswa').hide();
    $('.header-title').text('List Wecan');
    $('#buttontambahpanitia').hide();
    $('#buttontambahabsen').hide();
    $('#buttonubahperiode').hide();
    $('#btnback').hide();
  }

  function refreshFormPanitia(){
  table2.ajax.reload( null, false );
  }

  function refreshFormAbsensi(){
  table3.ajax.reload( null, false );
  }

  function detailComponent(id){
    $.ajax({
      url: 'panitia-mahasiswa/'+id+'/getData',
      type: "GET",
      dataType: "JSON",
      success : function(data){
        $('#hilang').hide();
        // console.log(id);
        $('#detail-panitia-mahasiswa').show();
        $('.title-panitia').text('Panitia Mahasiswa '+ data.data.name);
        $('.title-absensi').text('Absensi Panitia Mahasiswa '+ data.data.name);
        $('.title-presensi').text('Presensi Kelas '+ data.data.name);
        $('#buttontambahabsen').show();
        $('#buttonubahperiode').show();
        $('#buttontambahpanitia').show();
        $('#buttontambahpanitia').attr('onclick', 'tambahpanitia('+id+')');

        $('#buttontambahabsen').attr('onclick', 'tambahabsen('+id+')');
        $('#buttonubahperiode').attr('onclick', 'periodeabsen('+id+')');
        $('#btnback').show();
        $('#btn-panitia').click();
        table2.ajax.url("panitia-mahasiswa/"+id+"/detail");
        table2.ajax.reload();
        table3.ajax.url("panitia-mahasiswa/"+id+"/absensi");
        table3.ajax.reload();
        table4.ajax.url("panitia-mahasiswa/"+id+"/presensi");
        table4.ajax.reload();
      },
      error : function(){
        toastr.warning('Tidak dapat menampilkan data!', 'Error Alert', {timeOut: 3000});
      }
    });
  }
  function editForm(id){
    save_method = "edit";
    $('input[name = _method]').val('PATCH');
    $('#modal-panitia form')[0].reset();
    $('.goneTambah').hide();
    $('.goneUpdate').show();
    $('#addn-0').prop("required",false);
    $('#addp-0').prop("required",false);
    $('#addpj-0').prop("required",false);
    $('#nicknameEdit').prop("required",true)
    $('#panitia_mahasiswa_id').prop("required",true);
    $('#jabatan_id').prop("required",true);
    $.ajax({
      url: 'panitia-mahasiswa/'+id+'/edit',
      type: "GET",
      dataType: "JSON",
      async: false,
      processData: false,
      contentType:false,
      success : function(data){
        $('#modal-panitia').modal('show');
        $('#modal-panitia .modal-title').text('Edit Panitia Mahasiswa');
        $('#panitia_id').val(id);
        $('#wecan_id').val(data.panitia.aktivasi_wecan_id)
        $('#nicknameEdit').val(data.panitia.nickname)
        $('select.panitia_id').select2('trigger','select',{'data':{'id':data.panitia.master_panitia_mahasiswa_id,'text':data.panitia.mahasiswa.name}}); 
        $('select.jabatan_id').select2('trigger','select',{'data':{'id':data.panitia.jabatan_id,'text':data.panitia.jabatan.name}}); 
        
      },
      error : function(){
        toastr.warning('Tidak dapat menampilkan data!', 'Error Alert', {timeOut: 3000});
      }
    });
  }

  function editFormAbsensi(id){
    save_method = "edit";
    $('input[name = _method]').val('PATCH');
    $('#modal-absensi form')[0].reset();
    $('.goneTambah').hide();
    $('.goneUpdate').show();
    $('#tgl_absensi').prop("required",false);
    $('#status').prop("required",true);
    $('.dropify-clear').click();
    $.ajax({
      url: 'panitia-mahasiswa-absensi/'+id+'/edit',
      type: "GET",
      dataType: "JSON",
      async: false,
      processData: false,
      contentType:false,
      success : function(data){
        $('#modal-absensi').modal('show');
        $('#modal-absensi .modal-title').text('Edit Absensi');
        $('#absensi_id').val(id);
        $('#status').val(data.absensi.status_absen);
        $('#keterangan').val(data.absensi.keterangan);
        $('#name').val(data.absensi.mahasiswa.mahasiswa.name);
        if (data.absensi.status_absen == "I") {
          $('.detail-izin').show();
        }else{
          $('.detail-izin').hide();
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
          url: 'panitia-mahasiswa/' + id,
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

  function deleteDataAbsensi(id){
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
          url: 'panitia-mahasiswa-absensi/' + id,
          type: 'DELETE',
          data: {
            '_token': $('input[name=_token]').val(),
          },
          success: function(data){
            if(data.status == "failed"){
              swal("Error deleting!", "Absensi tidak bisa dihapus!","warning");
              toastr.warning('Absensi sedang digunakan tidak bisa dihapus!', 'Warning Alert', {timeOut: 4000});
            }else{
              swal("Done!", "Data Berhasil di hapus!", "success");
              toastr.success('Data Berhasil di hapus!', 'Success Alert', {timeOut: 4000});
              table3.ajax.reload();
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
