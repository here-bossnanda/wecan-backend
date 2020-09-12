<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes(['register' => false]);

Route::group(['middleware'=>'auth'],function(){
    Route::get('/', 'Backend\HomeController@index');
    Route::get('/home', 'Backend\HomeController@index');

            //  USERS ROUTE
            Route::get('users/data','Backend\UserController@listData')->name('users.data');
            Route::get('users/select2dosen','Backend\UserController@select2dosen')->name('users.select2dosen');
            Route::get('users/select2mahasiswa','Backend\UserController@select2mahasiswa')->name('users.select2mahasiswa');
            Route::get('users/select2role','Backend\UserController@select2role')->name('users.select2role');
            Route::resource('users', 'Backend\UserController');

            //  FAKULTAS ROUTE
            Route::get('fakultas/data','Backend\FakultasController@listData')->name('fakultas.data');
            Route::resource('fakultas', 'Backend\FakultasController');

            //  JURUSAN ROUTE
            Route::get('jurusan/data','Backend\JurusanController@listData')->name('jurusan.data');
            Route::get('jurusan/select2fakultas','Backend\JurusanController@select2fakultas')->name('jurusan.select2fakultas');
            Route::resource('jurusan', 'Backend\JurusanController');

            //  MASTER DATA DOSEN ROUTE
            Route::get('master-dosen/data','Backend\MasterPanitiaDosenController@listData')->name('master-dosen.data');
            Route::get('master-dosen/select2jurusan','Backend\MasterPanitiaDosenController@select2jurusan')->name('master-dosen.select2jurusan');
            Route::get('master-dosen/format-dosen-xlsx', 'Backend\MasterPanitiaDosenController@formatxlsx')->name('master-dosen.formatxlsx');
            Route::get('master-dosen/format-dosen-csv', 'Backend\MasterPanitiaDosenController@formatcsv')->name('master-dosen.formatcsv');
            Route::post('master-dosen/import', 'Backend\MasterPanitiaDosenController@import')->name('master-dosen.import');
            Route::resource('master-dosen', 'Backend\MasterPanitiaDosenController');

            //  MASTER DATA MAHASISWA ROUTE
            Route::get('master-mahasiswa/data','Backend\MasterPanitiaMahasiswaController@listData')->name('master-mahasiswa.data');
            Route::get('master-mahasiswa/select2jurusan','Backend\MasterPanitiaMahasiswaController@select2jurusan')->name('master-mahasiswa.select2jurusan');
            Route::get('master-mahasiswa/format-mahasiswa-xlsx', 'Backend\MasterPanitiaMahasiswaController@formatxlsx')->name('master-mahasiswa.formatxlsx');
            Route::get('master-mahasiswa/format-mahasiswa-csv', 'Backend\MasterPanitiaMahasiswaController@formatcsv')->name('master-mahasiswa.formatcsv');
            Route::post('master-mahasiswa/import', 'Backend\MasterPanitiaMahasiswaController@import')->name('master-mahasiswa.import');
            Route::resource('master-mahasiswa', 'Backend\MasterPanitiaMahasiswaController');

            //  DIVISI ROUTE
            Route::get('divisi/data','Backend\DivisiController@listData')->name('divisi.data');
            Route::resource('divisi', 'Backend\DivisiController');

            //  JABATAN ROUTE
            Route::get('jabatan/data','Backend\JabatanController@listData')->name('jabatan.data');
            Route::get('jabatan/select2divisi','Backend\JabatanController@select2divisi')->name('jabatan.select2divisi');
            Route::resource('jabatan', 'Backend\JabatanController');

            //  BERITA ROUTE
            Route::get('berita/data','Backend\BeritaController@listData')->name('berita.data');
            Route::resource('berita', 'Backend\BeritaController');

            // AKTIVASI ROUTE
            Route::get('aktivasi-wecan/data','Backend\AktivasiWecanController@listdata')->name('aktivasi-wecan.data');
            Route::post('aktivasi-wecan/{id}/aktivasi','Backend\AktivasiWecanController@aktivasi')->name('aktivasi-wecan.aktivasi');
            Route::resource('aktivasi-wecan','Backend\AktivasiWecanController');

           // PANITIA MAHASISWA ROUTE
            Route::get('panitia-mahasiswa/data','Backend\PanitiaMahasiswaController@listdata')->name('panitia-mahasiswa.data');
            Route::get('panitia-mahasiswa/{id}/getData','Backend\PanitiaMahasiswaController@getData')->name('panitia-mahasiswa.getData');
            Route::get('panitia-mahasiswa/{id}/detail','Backend\PanitiaMahasiswaController@detail')->name('panitia-mahasiswa.detail');
            Route::get('panitia-mahasiswa/select2panitia','Backend\PanitiaMahasiswaController@select2panitia')->name('panitia-mahasiswa.select2panitia');
            Route::get('panitia-mahasiswa/select2jabatan','Backend\PanitiaMahasiswaController@select2jabatan')->name('panitia-mahasiswa.select2jabatan');

            Route::get('panitia-mahasiswa/{id}/absensi','Backend\PanitiaMahasiswaController@absensi')->name('panitia-mahasiswa.absensi');
            Route::get('panitia-mahasiswa/{id}/presensi','Backend\PanitiaMahasiswaController@presensi')->name('panitia-mahasiswa.presensi');
            Route::get('panitia-mahasiswa-absensi/{id}/{awal}/{akhir}', 'Backend\PanitiaMahasiswaController@periode')->name('panitia-mahasiswa.periode');
            Route::get('panitia-mahasiswa-absensi/{id}/edit', 'Backend\PanitiaMahasiswaController@editAbsensi')->name('panitia-mahasiswa-absensi.edit');
            Route::post('panitia-mahasiswa-absensi', 'Backend\PanitiaMahasiswaController@storeAbsensi')->name('panitia-mahasiswa-absensi.store');
            Route::patch('panitia-mahasiswa-absensi/{id}', 'Backend\PanitiaMahasiswaController@updateAbsensi')->name('panitia-mahasiswa-absensi.update');
            Route::delete('panitia-mahasiswa-absensi/{id}', 'Backend\PanitiaMahasiswaController@destroyAbsensi')->name('panitia-mahasiswa-absensi.delete');
            Route::post('panitia-mahasiswa/refresh', 'Backend\PanitiaMahasiswaController@refresh')->name('panitia-mahasiswa.refresh');
            Route::resource('panitia-mahasiswa','Backend\PanitiaMahasiswaController');

            // PANITIA DOSEN ROUTE
            Route::get('panitia-dosen/data','Backend\PanitiaDosenController@listdata')->name('panitia-dosen.data');
            Route::get('panitia-dosen/{id}/getData','Backend\PanitiaDosenController@getData')->name('panitia-dosen.getData');
            Route::get('panitia-dosen/{id}/detail','Backend\PanitiaDosenController@detail')->name('panitia-dosen.detail');
            Route::get('panitia-dosen/select2panitia','Backend\PanitiaDosenController@select2panitia')->name('panitia-dosen.select2panitia');
            Route::get('panitia-dosen/select2jabatan','Backend\PanitiaDosenController@select2jabatan')->name('panitia-dosen.select2jabatan');
            Route::resource('panitia-dosen','Backend\PanitiaDosenController');
            
            // ATURAN ROUTE
            Route::get('aturan-wecan/data','Backend\AturanController@listdata')->name('aturan-wecan.data');
            Route::get('aturan-wecan/select2wecan','Backend\AturanController@select2wecan')->name('aturan-wecan.select2wecan');
            Route::post('aturan-wecan/{id}/aktivasi','Backend\AturanController@aktivasi')->name('aturan-wecan.aktivasi');
            Route::resource('aturan-wecan','Backend\AturanController');

            // ATRIBUT ROUTE
            Route::get('atribut-wecan/data','Backend\AtributController@listdata')->name('atribut-wecan.data');
            Route::get('atribut-wecan/select2wecan','Backend\AtributController@select2wecan')->name('atribut-wecan.select2wecan');
            Route::post('atribut-wecan/{id}/aktivasi','Backend\AtributController@aktivasi')->name('atribut-wecan.aktivasi');
            Route::resource('atribut-wecan','Backend\AtributController');

            // LAGU ROUTE
            Route::get('lagu-wecan/data','Backend\LaguController@listdata')->name('lagu-wecan.data');
            Route::get('lagu-wecan/select2wecan','Backend\LaguController@select2wecan')->name('lagu-wecan.select2wecan');
            Route::post('lagu-wecan/{id}/aktivasi','Backend\LaguController@aktivasi')->name('lagu-wecan.aktivasi');
            Route::resource('lagu-wecan','Backend\LaguController');

            // PERLENGKAPAN ROUTE
            Route::get('perlengkapan-wecan/data','Backend\PerlengkapanController@listdata')->name('perlengkapan-wecan.data');
            Route::get('perlengkapan-wecan/select2wecan','Backend\PerlengkapanController@select2wecan')->name('perlengkapan-wecan.select2wecan');
            Route::post('perlengkapan-wecan/{id}/aktivasi','Backend\PerlengkapanController@aktivasi')->name('perlengkapan-wecan.aktivasi');
            Route::resource('perlengkapan-wecan','Backend\PerlengkapanController');

            // PERLENGKAPAN ROUTE
            Route::get('tugas-wecan/data','Backend\TugasController@listdata')->name('tugas-wecan.data');
            Route::get('tugas-wecan/select2wecan','Backend\TugasController@select2wecan')->name('tugas-wecan.select2wecan');
            Route::post('tugas-wecan/{id}/aktivasi','Backend\TugasController@aktivasi')->name('tugas-wecan.aktivasi');
            Route::resource('tugas-wecan','Backend\TugasController');

            //ROLE
            Route::get('role-permission/data','Backend\RoleController@listData')->name('role-permission.data');
            Route::get('role-permission/data/permission', 'Backend\RoleController@listDataPermission')->name('role-permission.permission');
            Route::get('role/select2','Backend\RoleController@select2')->name('role.select2');
            Route::resource('role-permission','Backend\RoleController');

            


    Route::get('/clear-cache', function() {
        try {
        $configCache = Artisan::call('config:cache');
        $clearCache = Artisan::call('cache:clear');
    
        return response()->json(['status' => 'success','message' => 'berhasil menjalankan config:cache dan cache:clear'], 200);
        // return what you want
        } catch (\Throwable $th) {
            return response()->json(['status' => 'gagal'], 403);
        }
        
    });
});

