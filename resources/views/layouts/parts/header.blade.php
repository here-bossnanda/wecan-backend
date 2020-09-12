 <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="{{url('/')}}" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="{{asset('assets/images/logo.png')}}" alt="" height="20">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{asset('assets/images/logo.png')}}" alt="" height="100">
                                </span>
                            </a>

                            <a href="{{url('/')}}" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="{{asset('assets/images/logo.png')}}" alt="" height="42">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{asset('assets/images/logo.png')}}" alt="" height="40">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                            <i class="mdi mdi-backburger"></i>
                        </button>
                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ml-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                            {{-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-0"
                                aria-labelledby="page-header-search-dropdown">

                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div> --}}
                        </div>
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @if(Auth::user()->panitia_mahasiswa) <img src="{{asset('assets/images/mahasiswa/'. Auth::user()->panitia_mahasiswa->mahasiswa->foto)}}" alt="" class="rounded-circle header-profile-user" alt="Header Avatar">
                                @elseif(Auth::user()->panitia_dosen) <img src="{{asset('assets/images/dosen/'. Auth::user()->panitia_dosen->dosen->foto)}}" alt="" class="rounded-circle header-profile-user" alt="Header Avatar">
                                @else <img src="assets/images/users/default.png" alt="" class="rounded-circle header-profile-user" alt="Header Avatar">
                                @endif
                                <span class="d-none d-sm-inline-block ml-1">{{Auth::user()->username}}</span>
                                <i class="mdi mdi-chevron-down d-none d-sm-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right">
                                <!-- item-->
                                <a class="dropdown-item" href="#"><i class="mdi mdi-face-profile font-size-16 align-middle mr-1"></i> Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();"><i class="mdi mdi-logout font-size-16 align-middle mr-1"></i> Logout</a>
                                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                  </form>
                            </div>
                        </div>

                    </div>
                </div>

            </header>
