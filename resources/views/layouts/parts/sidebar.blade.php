 <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">
                <div data-simplebar class="h-100">
                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title">Menu</li>
                            <li>
                                <a href="{{url('/')}}" class="waves-effect">
                                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim-airplay"></i></div>
                                    <span>Dashboard</span>
                                </a>
                            </li>
                              @if (Auth::user()->can('fakultas.viewAny') or Auth::user()->can('jurusan.viewAny') or Auth::user()->can('master-panitia-dosen.viewAny') or Auth::user()->can('master-panitia-mahasiswa.viewAny'))
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim-document-layout-left"></i></div>
                                    <span>Master Akademik</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    @if (Auth::user()->can('jabatan.viewAny'))
                                    <li><a href="{{route('fakultas.index')}}">Fakultas</a></li>
                                    @endif
                                    @if (Auth::user()->can('jurusan.viewAny'))
                                    <li><a href="{{route('jurusan.index')}}">Jurusan</a></li>
                                    @endif
                                    @if (Auth::user()->can('master-panitia-dosen.viewAny'))
                                    <li><a href="{{route('master-dosen.index')}}">Dosen</a></li>
                                    @endif
                                    @if (Auth::user()->can('master-panitia-mahasiswa.viewAny'))
                                    <li><a href="{{route('master-mahasiswa.index')}}">Mahasiswa</a></li>
                                    @endif
                                </ul>
                            </li>
                            @endif
                            @if (Auth::user()->can('divisi.viewAny') or Auth::user()->can('jabatan.viewAny') or Auth::user()->can('berita.viewAny'))
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim-box"></i></div>
                                    <span>Master Data</span>
                                </a>
                                    <ul class="sub-menu" aria-expanded="false">
                                        @if (Auth::user()->can('jabatan.viewAny'))
                                        <li><a href="{{route('divisi.index')}}">Divisi</a></li>
                                        @endif
                                        @if (Auth::user()->can('jurusan.viewAny'))
                                        <li><a href="{{route('jabatan.index')}}">Jabatan</a></li>
                                        @endif
                                        @if (Auth::user()->can('berita.viewAny'))
                                        <li><a href="{{route('berita.index')}}">Berita</a></li>
                                        @endif
                                    </ul>
                            </li>
                            @endif
                            @if (Auth::user()->can('panitia-mahasiswa.viewAny') or Auth::user()->can('absensi.viewAny') or Auth::user()->can('panitia-dosen.viewAny'))
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim-layer-group"></i></div>
                                    <span>Manajemen</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                  @if (Auth::user()->can('panitia-dosen.viewAny'))
                                  <li><a href="{{route('panitia-dosen.index')}}">Panitia Dosen</a></li>
                                  @endif
                                  @if (Auth::user()->can('panitia-mahasiswa.viewAny') or Auth::user()->can('absensi.viewAny'))
                                  <li><a href="{{route('panitia-mahasiswa.index')}}">Panitia Mahasiswa</a></li>
                                  @endif
                                </ul>
                            </li>
                            @endif
                            @if (Auth::user()->can('aturan.viewAny') or Auth::user()->can('atribut.viewAny') or Auth::user()->can('lagu.viewAny') or Auth::user()->can('perlengkapan.viewAny') or Auth::user()->can('tugas.viewAny'))
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim uim-apps"></i></div>
                                    <span>Wecan</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                 @if (Auth::user()->can('aturan.viewAny'))
                                  <li><a href="{{route('aturan-wecan.index')}}">Aturan</a></li>
                                  @endif
                                  @if (Auth::user()->can('atribut.viewAny'))
                                  <li><a href="{{route('atribut-wecan.index')}}">Atribut</a></li>
                                  @endif
                                  @if (Auth::user()->can('lagu.viewAny'))
                                  <li><a href="{{route('lagu-wecan.index')}}">Lagu</a></li>
                                  @endif
                                  @if (Auth::user()->can('perlengkapan.viewAny'))
                                  <li><a href="{{route('perlengkapan-wecan.index')}}">Perlengkapan</a></li>
                                  @endif
                                  @if (Auth::user()->can('tugas.viewAny'))
                                  <li><a href="{{route('tugas-wecan.index')}}">Tugas</a></li>
                                  @endif
                                </ul>
                            </li>
                            @endif
                             {{-- <li>
                                <a href="#" class=" waves-effect">
                                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim-schedule"></i></div>
                                    <span>Absensi</span>
                                </a>
                            </li> --}}
                            <li>
                               <a href="#" class=" waves-effect">
                                   <div class="d-inline-block icons-sm mr-1"><i class="uim uim-favorite"></i></div>
                                   <span>Report</span>
                               </a>
                           </li>
                           @if (Auth::user()->can('role.viewAny') or Auth::user()->can('user.viewAny'))
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim-sign-in-alt"></i></div>
                                    <span>Authentication</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    @if (Auth::user()->can('role.viewAny'))
                                    <li><a href="{{route('role-permission.index')}}">Role & Permission</a></li>
                                    @endif
                                    @if (Auth::user()->can('users.viewAny'))
                                    <li><a href="{{route('users.index')}}">Users</a></li>
                                    @endif
                                </ul>
                            </li>
                            @endif

                            @if (Auth::user()->can('wecan.viewAny'))
                            <li>
                                <a href="{{route('aktivasi-wecan.index')}}" class=" waves-effect">
                                    <div class="d-inline-block icons-sm mr-1"><i class="uim uim-toggle-off"></i></div>
                                    <span>Aktivasi</span>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
