<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\AktivasiWecan;
use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Validator;

class AktivasiWecanController extends Controller
{
public function __construct()
{
$this->middleware('auth');
$this->middleware('can:wecan.viewAny');
}
public function index(){
return view('page.aktivasi-wecan.index');
}
public function listData(){
$datas = AktivasiWecan::orderBy('created_at','desc')->get();
$data = array();
$no =0;
foreach ($datas as $list) {
$no++;
$row = array();
$row[]= $no;
$row[]= $list->name;
$row[]= $list->tahun_akademik;    
$row[]= tanggal_indonesia(substr($list->tgl_mulai, 0,10), false);
$row[]= tanggal_indonesia(substr($list->tgl_selesai, 0,10), false);
$row[]= ($list->status) == 1 ? "<div class='badge badge-pill badge-success'>Aktif</div>" : "<div class='badge badge-pill badge-danger'>Tidak Aktif</div>";
(Auth::user()->can('wecan.update') and Auth::user()->can('wecan.delete')) ?
$row[]= ($list->status) == 0 ?
'<div class="btn-group">
<button onclick="editForm('.$list->id.')" class=" btn btn-warning">
<span class="fas fa-pencil-alt"></span></button></div>
<div class="btn-group">
<button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
<span class="far fa-trash-alt"></span></button></div>
<div class="btn-group">
<button onclick="aktivasiWecan('.$list->id.')" class="btn btn-primary">
<span class="fas fa-check"></span> Aktifkan</button></div>' :
'<div class="btn-group">
<button onclick="editForm('.$list->id.')" class=" btn btn-warning">
<span class="fas fa-pencil-alt"></span></button></div>
  <div class="btn-group">
  <button onclick="aktivasiWecan('.$list->id.')" class="btn btn-success">
  <span class="fas fa-check"></span> Non Aktif</button></div>' 
: ((Auth::user()->can('wecan.delete')) ?
    $row[]= '
    <div class="btn-group">
    <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
    <span class="far fa-trash-alt"></span></button></div>'
    : ((Auth::user()->can('wecan.update')) ? 
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
      $validator = Validator::make($request->all(),[
        'tgl_mulai'         => 'required|date|before_or_equal:tgl_selesai',
        'tgl_selesai'           => 'required|date|after_or_equal:tgl_mulai',
      ],
      [
      'tgl_mulai.required' => 'Tanggal Mulai harus diisi !',
      'tgl_selesai.required' => 'Tanggal Akhir Jam harus dipilih !',
      'tgl_mulai.before_or_equal' => 'Tanggal Mulai harus sebelum tanggal Tanggal Akhir!',
      'tgl_selesai.after_or_equal' => 'Tanggal Akhir tidak boleh lebih dulu dari Tanggal Mulai!',
      ]);
      if ($validator->fails()) {
        $d['message'] = [];
        foreach ($validator->errors()->all() as $v) {
          array_push($d['message'], $v);
        }
        $d['status'] = 0;
        return response()->json($d);
      }
      $count = AktivasiWecan::where('tahun_akademik',$request->tahun_akademik)->exists();
      if($count){
        return response()->json(['status' => 'false'], 200);
      }
      AktivasiWecan::create([
      'name' => $request->name,
      'tgl_mulai' => $request->tgl_mulai,
      'tgl_selesai' => $request->tgl_selesai,
      'tahun_akademik' => $request->tahun_akademik,
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
    $aktivasi = AktivasiWecan::findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
    return response()->json(['status' => 'success', 'aktivasi' => $aktivasi], 200);
  }
  public function update(Request $request, $id)
  {
    $validator = Validator::make($request->all(),[
      'tgl_mulai'         => 'required|date|before_or_equal:tgl_selesai',
      'tgl_selesai'           => 'required|date|after_or_equal:tgl_mulai',
    ],
    [
    'tgl_mulai.required' => 'Tanggal Mulai harus diisi !',
    'tgl_selesai.required' => 'Tanggal Akhir Jam harus dipilih !',
    'tgl_mulai.before_or_equal' => 'Tanggal Mulai harus sebelum tanggal Tanggal Akhir!',
    'tgl_selesai.after_or_equal' => 'Tanggal Akhir tidak boleh lebih dulu dari Tanggal Mulai!',
    ]);
    if ($validator->fails()) {
      $d['message'] = [];
      foreach ($validator->errors()->all() as $v) {
        array_push($d['message'], $v);
      }
      $d['status'] = 0;
      return response()->json($d);
    }
    $count = AktivasiWecan::where('tahun_akademik',$request->tahun_akademik)->where('id', '!=', $id)->exists();
    // dd($count);
    if($count){
      return response()->json(['status' => 'false'], 200);
    }
    DB::beginTransaction();
    try {
      $aktivasi = AktivasiWecan::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
      $aktivasi->update([
      'name' => $request->name,
      'tgl_mulai' => $request->tgl_mulai,
      'tgl_selesai' => $request->tgl_selesai,
      'tahun_akademik' => $request->tahun_akademik,
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
  //   $count = Jadwal_Pelajaran::where('id_aktivasi', $id)->exists();
  //   $count2 = Info_Kelas::where('id_aktivasi', $id)->exists();
  //   $count3 = Absensi::where('id_aktivasi', $id)->exists();
  //   if($count >= 1 or $count2 >= 1 or $count3 >= 1) {
  //     return response()->json(['status' => 'failed'], 200);
  //   }
    $Aktivasi = AktivasiWecan::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
    $Aktivasi->delete(); //MENGHAPUS DATANYA
    return response()->json(['status' => 'success'], 200);
  }
  public function aktivasi(Request $request,$id)
  {
    DB::beginTransaction();
    try {
        $editSemester = AktivasiWecan::find($id);

      // ubah seluruh status menjadi 0
      if($editSemester)
      {
        DB::table('aktivasi_wecans')
        ->update(['status' => 0]);
      }
      
      // check jika status id yang di aktivasi = 0 atau tidak aktif
      // maka aktifkan aktivasi wecan
      if ($editSemester->status === 0) {
          $editSemester->update([
          'status' => 1
          ]);
      // jika aktivasi wecan aktif, maka ubah statusnya menjadi tidak aktif    
      }else{
          $editSemester->update([
              'status' => 0
              ]);
      }
      DB::commit();
      return response()->json(['status' => 'success'], 200);
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
    }
  }
}
