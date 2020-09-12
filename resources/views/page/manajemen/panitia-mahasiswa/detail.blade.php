<div id="detail-panitia-mahasiswa" style="display:none">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs nav-justified nav-tabs-custom" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" data-toggle="tab" id="btn-panitia" href="#custom-panitia-mahasiswa" role="tab">
          <i class="fas fa-address-card mr-1"></i> <span class="d-none d-md-inline-block">Panitia Mahasiswa</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" id="btn-absensi" href="#custom-absensi" role="tab">
          <i class="fas fa-address-card mr-1"></i> <span class="d-none d-md-inline-block">List Absensi</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="tab" id="btn-presensi" href="#custom-presensi" role="tab">
          <i class="mdi mdi-account-details mr-1 align-middle"></i> <span class="d-none d-md-inline-block">Presensi</span>
        </a>
      </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content p-3">
      <div class="tab-pane active" id="custom-panitia-mahasiswa" role="tabpanel">
        <h4 class="header-title title-mahasiswa">List Panitia Mahasiswa</h4>
        @if (Auth::user()->can('panitia-mahasiswa.create'))
        <button id="buttontambahpanitia" style="display:none;margin:15px 0px" onclick="tambahpanitia()" type="button" class="btn btn-primary"><i class="fa fa-plus"> Tambah Panitia</i> </button>
        @endif
        <button onclick="refreshFormPanitia()" type="button" class="btn btn-info btn-flat "><i class="fas fa-recycle"> Refresh</i> </button>
        
        <table class="table table-bordered dt-responsive table-striped nowrap table-panitia-mahasiswa" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
          <thead>
            <tr>
              <th>NPM</th>
              <th>Nama</th>
              <th>Nickname</th>
              <th>Jabatan</th>
              <th>Divisi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="tab-pane" id="custom-absensi" role="tabpanel">
        <h4 class="header-title title-absensi">List Absensi</h4>
        @if (Auth::user()->can('absensi.create'))
        <button id="buttontambahabsen" style="display:none;margin:15px 0px" onclick="tambahabsen()" type="button" class="btn btn-primary"><i class="fa fa-plus"> Tambah Absensi</i> </button>
        @endif
        <button id="buttonubahperiode"onclick="periodeabsen()" style="display:none;margin:5px 0px" type="button" class="btn btn-success"><i class="mdi mdi-update"> </i> Ubah Periode</button>
        <button onclick="refreshFormAbsensi()" type="button" class="btn btn-info btn-flat "><i class="fas fa-recycle"> Refresh</i> </button>
        
        <table class="table table-bordered dt-responsive table-striped nowrap table-absensi" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
          <thead>
            <tr>
              <th>Tanggal</th>
              <th>NPM</th>
              <th>Nama</th>
              <th>Absensi</th>
              <th>Keterangan</th>
              <th>File</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
      </div>
      <div class="tab-pane" id="custom-presensi" role="tabpanel">
        <h4 class="header-title title-presensi">Presensi</h4>
        <table class="table table-bordered dt-responsive table-striped nowrap table-presensi" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
          <thead>
            <tr>
              <th>NPM</th>
              <th>Nama</th>
              <th>Hadir</th>
              <th>Izin</th>
              <th>Alpha</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>

      </div>
    </div>
  </div>