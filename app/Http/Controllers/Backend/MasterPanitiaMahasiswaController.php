<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Jurusan;
use App\MasterPanitiaMahasiswa;
use App\PanitiaMahasiswa;

use Illuminate\Http\Request;

use File;
use DB;
use Auth;
use DataTables;

use Excel;
use App\Imports\MahasiswaImport;
use App\Exports\MahasiswaExport;

class MasterPanitiaMahasiswaController extends Controller
{
    public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('can:master-panitia-mahasiswa.viewAny');
  }
  public function index(){
    return view('page.master-akademik.master-mahasiswa.index');
  }

  public function select2jurusan(Request $request){
    $data = Jurusan::selectRaw('id,name')
    ->where('name','LIKE',"%$request->q%")
    ->orderBy('name','asc')
    ->paginate(10);
    return response()->json(['items' => $data->toArray()['data'], 'pagination' => $data->nextPageUrl() ? true : false]);
  }
  public function listData(){
    $datas = MasterPanitiaMahasiswa::with('jurusan')->orderBy('created_at','desc')->get();
    $data = array();
    $no =0;
    foreach ($datas as $list) {
      $no++;
      $row = array();
      $row[]= $no;
      $row[]= $list->npm;
      $row[]= ($list->foto) ? '<img src="assets/images/mahasiswa/'.$list->foto.'" alt="" class="rounded-circle header-profile-user" alt="Header Avatar">'. $list->name : '<img src="assets/images/users/default.png" alt="" class="rounded-circle header-profile-user" alt="Header Avatar">'. $list->name;
      $row[]= $list->email;
      $row[]= ($list->jenis_kelamin == "L") ? "Laki-Laki" : "Perempuan" ;
      $row[]= $list->angkatan;
      $row[]= $list->jurusan->name;
      (Auth::user()->can('master-panitia-mahasiswa.update') and Auth::user()->can('master-panitia-mahasiswa.delete')) ?
      $row[]= '
      <div class="btn-group">
        <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
          <span class="fas fa-pencil-alt"></span></button></div>
          <div class="btn-group">
            <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
              <span class="far fa-trash-alt"></span></button></div>'
              : ((Auth::user()->can('master-panitia-mahasiswa.delete')) ?
              $row[]= '
              <div class="btn-group">
              <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
              <span class="far fa-trash-alt"></span></button></div>'
              : ((Auth::user()->can('master-panitia-mahasiswa.update')) ? 
              $row[]= '<div class="btn-group">
              <button onclick="editForm(\''.$list->id.'\')" class=" btn btn-warning">
              <span class="fas fa-pencil-alt"></span></button></div>'
              : 
              $row[]= '<div class="btn-group">
              <button class=" btn btn-info">
              <span class="fas fa-pencil-alt"></span> Tidak ada aksi</button></div>'));
              $data[]=$row;
            }
            return DataTables::of($data)->escapeColumns([])->make(true);
          }
          public function store(Request $request)
          {
            DB::beginTransaction();
            try {
              $count = MasterPanitiaMahasiswa::where('npm',$request->npm)->exists();
              if($count){
                return response()->json(['status' => 'false'], 200);
              }

              $filename = NULL;
              if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move('assets/images/mahasiswa', $filename);
              }

              MasterPanitiaMahasiswa::create([
              'npm' => $request->npm, 
              'name' => $request->name,
              'no_telp' => $request->no_telp,
              'email' => $request->email,
              'jurusan_id' => $request->jurusan_id,
              'jenis_kelamin' => $request->jenis_kelamin,
              'angkatan' => $request->angkatan,
              'alamat' => $request->alamat,
              'foto' => $filename ,
              ]);

              DB::commit();
              return response()->json(['status' => 'success'], 200);
            } catch (\Exception $e) {
              DB::rollback();
              return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
            }
          }
          public function edit($id)
          {
            $mahasiswa = MasterPanitiaMahasiswa::with('jurusan')->findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
            return response()->json(['status' => 'success', 'mahasiswa' => $mahasiswa], 200);
          }
          public function update(Request $request, $id)
          {
            $count = MasterPanitiaMahasiswa::where('npm',$request->npm)->where('id', '!=', $id)->exists();
            if($count){
              return response()->json(['status' => 'false'], 200);
            }

            DB::beginTransaction();
            try {
              $Mahasiswa = MasterPanitiaMahasiswa::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
              $filename = $Mahasiswa->foto; //NAMA FILE FOTO SEBELUMNYA

              //JIKA ADA FILE BARU YANG DIKIRIMKAN
              if ($request->hasFile('foto')) {
                //MAKA FOTO YANG LAMA AKAN DIGANTI
                $file = $request->file('foto');
                //DAN FILE FOTO YANG LAMA AKAN DIHAPUS
                File::delete(public_path('assets/images/mahasiswa/' . $filename));
                $filename = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move('assets/images/mahasiswa', $filename);
              }

              $Mahasiswa->update([
              'npm' => $request->npm, 
              'name' => $request->name,
              'email' => $request->email,              
              'no_telp' => $request->no_telp,
              'jurusan_id' => $request->jurusan_id,
              'jenis_kelamin' => $request->jenis_kelamin,
              'angkatan' => $request->angkatan,
              'alamat' => $request->alamat,
              'foto' => $filename ,
              ]);
              DB::commit();
              return response()->json(['status' => 'success'], 200);
            } catch (\Exception $e) {
              DB::rollback();
              return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
            }
          }
          public function destroy($id)
          {
            $count = PanitiaMahasiswa::where('master_panitia_mahasiswa_id', $id)->exists();
            if($count) {
              return response()->json(['status' => 'failed'], 200);
            }
            $Mahasiswa = MasterPanitiaMahasiswa::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
            File::delete(public_path('assets/images/mahasiswa/' . $Mahasiswa->foto)); //MENGHAPUS FILE FOTO
            $Mahasiswa->delete(); //MENGHAPUS DATANYA
            return response()->json(['status' => 'success'], 200);
          }

          public function import(Request $request)
          {
            DB::beginTransaction();
            try {
              Excel::import(new MahasiswaImport, request()->file('importMahasiswa'));
              DB::commit();
              return response()->json(['status'=>'success'], 200);
            } catch (\Exception $e) {
              DB::rollback();
              return response()->json(['status' => 'failed', 'data' => $e->getMessage()], 200);
            }
          }
          public function formatxlsx()
          {
            DB::beginTransaction();
            try {
              return Excel::download(new MahasiswaExport(), 'format-mahasiswa.xlsx');
            } catch (\Exception $e) {
              return response()->json(['status' => 'failed', 'data' => $e->getMessage()], 200);
            }
          }
          public function formatcsv()
          {
            DB::beginTransaction();
            try {
              return Excel::download(new MahasiswaExport(), 'format-mahasiswa.csv');
            } catch (\Exception $e) {
              return response()->json(['status' => 'failed', 'data' => $e->getMessage()], 200);
            }
          }
}
