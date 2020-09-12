@extends('layouts.app')
@push('style')
<style media="screen">
.clock {
  top: 50%;
  left: 50%;
  font-size: 20px;
  font-family: Orbitron;
  letter-spacing: 5px;
}
</style>
@endpush
@section('content')
<!-- Page-Title -->
<div class="page-title-box">
  <div class="container-fluid">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h4 class="page-title mb-1">Dashboard</h4>
        <ol class="breadcrumb m-0">
          <li class="breadcrumb-item active">Welcome to WECAN Dashboard</li>
        </ol>
      </div>
    </div>

  </div>
</div>
<!-- end page title end breadcrumb -->

<div class="page-content-wrapper">
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <!-- <h5 class="header-title mb-4"></h5> -->
            <div class="media">
              <div class="media-body">
                <p class="text-muted mb-2">Panitia Dosen</p>
                <h4>{{ $dosen ?? 0 }} Dosen</h4>
              </div>
              <div class="col-6 ml-auto">
                <div>
                  <img src="{{asset('assets/images/asset-illustrator/undraw_professor_8lrt.svg')}}" alt="" class="img-fluid">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <div class="media">
              <div class="media-body">
                <p class="text-muted mb-2">Panitia Mahasiswa</p>
                <h4>{{ $mahasiswa ?? 0 }} Mahasiswa</h4>
              </div>
              <div class="col-7 ml-auto">
                <div>
                  <img src="{{asset('assets/images/asset-illustrator/undraw_playing_cards_cywn.svg')}}" alt="" class="img-fluid">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <div class="media">
              <div class="media-body">
                <div style="margin-top:30px">
                  <hr style=>
                  <h4 class="text-center" style="background-color:orange; color:white; border-width: 2px;border-radius: 0.5rem; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); border-color: #cbd5e0; max-width: 24rem;
                   overflow: hidden;">{{ $wecan->name ?? 'Wecan' }}</h4>
                <h5 class="border-rounded mb-2 text-center" > Tahun Akademik {{$wecan->tahun_akademik ?? 'Wecan'}}</h5> 
                <hr>
              </div>
                
              </div>
              <div class="col-6 ml-auto">
                <div>
                  <img src="{{asset('assets/images/asset-illustrator/undraw_to_the_moon_v1mv.svg')}}" alt="" class="img-fluid">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-8">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <div class="col-7">
                <h5>Welcome Back, {{Auth::user()->username }} !</h5>
                <p class="text-muted text-center">Selamat datang di dashboard Week of Creativity and Innovation. <br> {{Auth::user()->username}}, semoga harimu menyenangkan !!!</p>
                <!-- <p class="text-muted"></p> -->
              </div>

              <div class="col-5 ml-auto">
                <div>
                  <img src="{{asset('assets/images/asset-illustrator/undraw_mello_otq1.svg')}}" alt="" class="img-fluid">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xl-4">
        <div class="card">
          <div class="card-body">
            <div class="media">
              <div class="media-body">
                <!-- <p class="text-muted mb-2">Jumlah Siswa</p> -->
                <div id="MyClockDisplay" class="clock text-center" onload="showTime()"></div>
                <hr>
              </div>
              <hr>
            </div>
            <div class="col-12 ml-auto">
              <div>
                <img src="{{asset('assets/images/asset-illustrator/undraw_quite_town_mg2q.svg')}}" alt="" class="img-fluid">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- end row -->
  
  <!-- end row -->
</div> <!-- container-fluid -->
@endsection

@push('scripts')
<script type="text/javascript">
  function showTime(){
    var date = new Date();
    var h = date.getHours(); // 0 - 23
    var m = date.getMinutes(); // 0 - 59
    var s = date.getSeconds(); // 0 - 59
    var session = "AM";

    if(h == 0){
      h = 12;
    }

    if(h > 12){
      h = h - 12;
      session = "PM";
    }

    h = (h < 10) ? "0" + h : h;
    m = (m < 10) ? "0" + m : m;
    s = (s < 10) ? "0" + s : s;

    var time = h + ":" + m + ":" + s + " " + session;
    document.getElementById("MyClockDisplay").innerText = time;
    document.getElementById("MyClockDisplay").textContent = time;

    setTimeout(showTime, 1000);

  }

  showTime();
</script>
@endpush
