<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //GATE DIVISI
        Gate::resource('divisi','App\Policies\DivisiPolicy');

        //GATE AKTIVITAS WECAN
        Gate::resource('wecan','App\Policies\AktivasiWecanPolicy');

        //GATE ATRIBUT
        Gate::resource('atribut','App\Policies\AtributPolicy');

        //GATE ATURAN
        Gate::resource('aturan','App\Policies\AturanPolicy');

        //GATE BERITA
        Gate::resource('berita','App\Policies\BeritaPolicy');

        //GATE FAKULTAS
        Gate::resource('fakultas','App\Policies\FakultasPolicy');

        //GATE JABATAN
        Gate::resource('jabatan','App\Policies\JabatanPolicy');

        //GATE JURUSAN
        Gate::resource('jurusan','App\Policies\JurusanPolicy');

        //GATE LAGU
        Gate::resource('lagu','App\Policies\LaguPolicy');

        //GATE MASTER PANITIA MAHASISWA
        Gate::resource('master-panitia-mahasiswa','App\Policies\MasterPanitiaMahasiswaPolicy');

        //GATE PANITIA MAHASISWA
        Gate::resource('panitia-mahasiswa','App\Policies\PanitiaMahasiswaPolicy');

        //GATE MASTER PANITIA DOSEN
        Gate::resource('master-panitia-dosen','App\Policies\MasterPanitiaDosenPolicy');

        //GATE PANITIA DOSEN
        Gate::resource('panitia-dosen','App\Policies\PanitiaDosenPolicy');

        //GATE PERLENGKAPAN
        Gate::resource('perlengkapan','App\Policies\PerlengkapanPolicy');

        //GATE PERMISSION
        Gate::resource('permission','App\Policies\PermissionPolicy');

        //GATE ROLE
        Gate::resource('role','App\Policies\RolePolicy');

        //GATE TUGAS
        Gate::resource('tugas','App\Policies\TugasPolicy');

        //GATE USER
        Gate::resource('users','App\Policies\UserPolicy');

        //GATE ABSENSI
        Gate::resource('absensi','App\Policies\AbsensiPolicy');
    }
}
