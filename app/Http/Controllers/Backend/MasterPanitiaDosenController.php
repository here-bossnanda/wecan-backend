<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Jurusan;
use App\MasterPanitiaDosen;
use App\PanitiaDosen;

use Illuminate\Http\Request;

use File;
use DB;
use Auth;
use DataTables;

use Excel;
use App\Imports\DosenImport;
use App\Exports\DosenExport;

class MasterPanitiaDosenController extends Controller
{
    public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('can:master-panitia-dosen.viewAny');
  }
  public function index(){
    return view('page.master-akademik.master-dosen.index');
  }

  public function select2jurusan(Request $request){
    $data = Jurusan::selectRaw('id,name')
    ->where('name','LIKE',"%$request->q%")
    ->orderBy('name','asc')
    ->paginate(10);
    return response()->json(['items' => $data->toArray()['data'], 'pagination' => $data->nextPageUrl() ? true : false]);
  }
  public function listData(){
    $datas = MasterPanitiaDosen::with('jurusan')->orderBy('created_at','desc')->get();
    $data = array();
    $no =0;
    foreach ($datas as $list) {
      $no++;
      $row = array();
      $row[]= $no;
      $row[]= $list->nip;
      $row[]= ($list->foto) ? '<img src="assets/images/dosen/'.$list->foto.'" alt="" class="rounded-circle header-profile-user" alt="Header Avatar">'. $list->name : '<img src="assets/images/users/default.png" alt="" class="rounded-circle header-profile-user" alt="Header Avatar">'. $list->name;
      $row[]= $list->email;
      $row[]= ($list->jenis_kelamin == "L") ? "Laki-Laki" : "Perempuan" ;
      $row[]= $list->jurusan->name;
      (Auth::user()->can('master-panitia-dosen.update') and Auth::user()->can('master-panitia-dosen.delete')) ?
      $row[]= '
      <div class="btn-group">
        <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
          <span class="fas fa-pencil-alt"></span></button></div>
          <div class="btn-group">
            <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
              <span class="far fa-trash-alt"></span></button></div>'
              : ((Auth::user()->can('master-panitia-dosen.delete')) ?
              $row[]= '
              <div class="btn-group">
              <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
              <span class="far fa-trash-alt"></span></button></div>'
              : ((Auth::user()->can('master-panitia-dosen.update')) ? 
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
              $count = MasterPanitiaDosen::where('nip',$request->nip)->exists();
              if($count){
                return response()->json(['status' => 'false'], 200);
              }

              $filename = NULL;
              if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move('assets/images/dosen', $filename);
              }

              MasterPanitiaDosen::create([
              'nip' => $request->nip, 
              'name' => $request->name,
              'no_telp' => $request->no_telp,
              'email' => $request->email,
              'jurusan_id' => $request->jurusan_id,
              'jenis_kelamin' => $request->jenis_kelamin,
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
            $dosen = MasterPanitiaDosen::with('jurusan')->findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
            return response()->json(['status' => 'success', 'dosen' => $dosen], 200);
          }
          public function update(Request $request, $id)
          {
            $count = MasterPanitiaDosen::where('nip',$request->nip)->where('id', '!=', $id)->exists();
            if($count){
              return response()->json(['status' => 'false'], 200);
            }

            DB::beginTransaction();
            try {
              $dosen = MasterPanitiaDosen::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
              $filename = $dosen->foto; //NAMA FILE FOTO SEBELUMNYA

              //JIKA ADA FILE BARU YANG DIKIRIMKAN
              if ($request->hasFile('foto')) {
                //MAKA FOTO YANG LAMA AKAN DIGANTI
                $file = $request->file('foto');
                //DAN FILE FOTO YANG LAMA AKAN DIHAPUS
                File::delete(public_path('assets/images/dosen/' . $filename));
                $filename = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
                $file->move('assets/images/dosen', $filename);
              }

              $dosen->update([
              'nip' => $request->nip, 
              'name' => $request->name,
              'email' => $request->email,              
              'no_telp' => $request->no_telp,
              'jurusan_id' => $request->jurusan_id,
              'jenis_kelamin' => $request->jenis_kelamin,
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
            $count = PanitiaDosen::where('master_panitia_dosen_id', $id)->exists();
            if($count) {
              return response()->json(['status' => 'failed'], 200);
            }
            $dosen = MasterPanitiaDosen::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
            File::delete(public_path('assets/images/dosen/' . $dosen->foto)); //MENGHAPUS FILE FOTO
            $dosen->delete(); //MENGHAPUS DATANYA
            return response()->json(['status' => 'success'], 200);
          }

          public function import(Request $request)
          {
            DB::beginTransaction();
            try {
              Excel::import(new dosenImport, request()->file('importDosen'));
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
              return Excel::download(new dosenExport(), 'format-dosen.xlsx');
            } catch (\Exception $e) {
              return response()->json(['status' => 'failed', 'data' => $e->getMessage()], 200);
            }
          }
          public function formatcsv()
          {
            DB::beginTransaction();
            try {
              return Excel::download(new dosenExport(), 'format-dosen.csv');
            } catch (\Exception $e) {
              return response()->json(['status' => 'failed', 'data' => $e->getMessage()], 200);
            }
          }
}
