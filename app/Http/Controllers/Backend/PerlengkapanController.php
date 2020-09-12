<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\AktivasiWecan;
use App\Perlengkapan;
use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;

class PerlengkapanController extends Controller
{
  public function __construct()
    {
    $this->middleware('auth');
    $this->middleware('can:perlengkapan.viewAny');
    }
    public function index(){
    return view('page.wecan.perlengkapan.index');
    }
    public function listData(){
    $datas = Perlengkapan::with('wecan','user')->orderBy('created_at','desc')->get();
    $data = array();
    $no =0;
    foreach ($datas as $list) {
    $no++;
    $row = array();
    $row[]= $no;
    $row[]= $list->wecan->name;
    $row[]= $list->user->username;
    $row[]= ($list->status) == 1 ? "<div class='badge badge-pill badge-success'>Aktif</div>" : "<div class='badge badge-pill badge-danger'>Tidak Aktif</div>";
    (Auth::user()->can('perlengkapan.update') and Auth::user()->can('perlengkapan.delete')) ?
    $row[]= ($list->status) == 0 ?
    '<div class="btn-group">
    <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
    <span class="fas fa-pencil-alt"></span></button></div>
    <div class="btn-group">
    <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
    <span class="far fa-trash-alt"></span></button></div>
    <div class="btn-group">
    <button onclick="perlengkapanWecan('.$list->id.')" class="btn btn-primary">
    <span class="fas fa-check"></span> Aktifkan</button></div>' :
    '<div class="btn-group">
    <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
    <span class="fas fa-pencil-alt"></span></button></div>
    <div class="btn-group">
    <button onclick="perlengkapanWecan('.$list->id.')" class="btn btn-success">
    <span class="fas fa-check"></span> Non Aktif</button></div>' 
    : ((Auth::user()->can('perlengkapan.delete')) ?
    $row[]= '
    <div class="btn-group">
    <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
    <span class="far fa-trash-alt"></span></button></div>'
    : ((Auth::user()->can('perlengkapan.update')) ? 
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
    //   dd($request->all());
    DB::beginTransaction();
    try {
      $count = Perlengkapan::where('aktivasi_wecan_id',$request->aktivasi_wecan_id)->exists();
      if($count){
        return response()->json(['status' => 'false'], 200);
      }
      Perlengkapan::create([
      'deskripsi' => $request->deskripsi,
      'aktivasi_wecan_id' => $request->aktivasi_wecan_id,
      'user_id' => Auth::user()->id,
      'status' => 0,
      ]);
      DB::commit();
      return response()->json(['status' => 'success'], 200);
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
    }
  }
  //SELECT2 SELECT WECAN
    public function select2wecan(Request $request){
        $data = AktivasiWecan::selectRaw('id,name')
        ->where('name','LIKE',"%$request->q%")
        ->orderBy('name','desc')
        ->paginate(10);
        return response()->json(['items' => $data->toArray()['data'], 'pagination' => $data->nextPageUrl() ? true : false]);
    }
    public function edit($id)
  {
    $perlengkapan = Perlengkapan::with('wecan')->findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
    return response()->json(['status' => 'success', 'perlengkapan' => $perlengkapan], 200);
  }
  public function update(Request $request, $id)
  {
    // dd($request->all());
    $count = Perlengkapan::where('aktivasi_wecan_id',$request->aktivasi_wecan_id)->where('id', '!=', $id)->exists();
    // dd($count);
    if($count){
      return response()->json(['status' => 'false'], 200);
    }
    DB::beginTransaction();
    try {
      $aktivasi = Perlengkapan::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
      $aktivasi->update([
      'deskripsi' => $request->deskripsi,
      'aktivasi_wecan_id' => $request->aktivasi_wecan_id,
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
    $perlengkapan = Perlengkapan::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
    $perlengkapan->delete(); //MENGHAPUS DATANYA
    return response()->json(['status' => 'success'], 200);
  }
  public function aktivasi(Request $request,$id)
  {
    DB::beginTransaction();
    try {
        $editperlengkapan = Perlengkapan::find($id);

        // ubah seluruh status menjadi 0
      if($editperlengkapan)
      {
        DB::table('perlengkapans')
        ->update(['status' => 0]);
      }
      
      // check jika status id yang di aktivasi = 0 atau tidak aktif
      // maka aktifkan aktivasi wecan
      if ($editperlengkapan->status === 0) {
          $editperlengkapan->update([
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
