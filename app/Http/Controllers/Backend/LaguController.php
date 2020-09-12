<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Lagu;
use App\AktivasiWecan;
use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;

class LaguController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    $this->middleware('can:lagu.viewAny');
    }
    public function index(){
    return view('page.wecan.lagu.index');
    }
    public function listData(){
    $datas = Lagu::with('wecan','user')->orderBy('created_at','desc')->get();
    $data = array();
    $no =0;
    foreach ($datas as $list) {
    $no++;
    $row = array();
    $row[]= $no;
    $row[]= $list->wecan->name;
    $row[]= $list->jenis;
    $row[]= ($list->status) == 1 ? "<div class='badge badge-pill badge-success'>Aktif</div>" : "<div class='badge badge-pill badge-danger'>Tidak Aktif</div>";
    $row[]= $list->user->username;
    (Auth::user()->can('lagu.update') and Auth::user()->can('lagu.delete')) ?
    $row[]= ($list->status) == 0 ?
    '<div class="btn-group">
    <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
    <span class="fas fa-pencil-alt"></span></button></div>
    <div class="btn-group">
    <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
    <span class="far fa-trash-alt"></span></button></div>
    <div class="btn-group">
    <button onclick="laguWecan('.$list->id.')" class="btn btn-primary">
    <span class="fas fa-check"></span> Aktifkan</button></div>' :
    '<div class="btn-group">
    <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
    <span class="fas fa-pencil-alt"></span></button></div>
    <div class="btn-group">
    <button onclick="laguWecan('.$list->id.')" class="btn btn-success">
    <span class="fas fa-check"></span> Non Aktif</button></div>' 
    : ((Auth::user()->can('lagu.delete')) ?
    $row[]= '
    <div class="btn-group">
    <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
    <span class="far fa-trash-alt"></span></button></div>'
    : ((Auth::user()->can('lagu.update')) ? 
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
      $count = Lagu::where('aktivasi_wecan_id',$request->aktivasi_wecan_id)->where('jenis',$request->jenis)->exists();
      if($count){
        return response()->json(['status' => 'false'], 200);
      }
      Lagu::create([
      'deskripsi' => $request->deskripsi,
      'jenis' => $request->jenis,
      'url' => $request->url,
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
    $lagu = Lagu::with('wecan')->findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
    return response()->json(['status' => 'success', 'lagu' => $lagu], 200);
  }
  public function update(Request $request, $id)
  {
    // dd($request->all());
    $count = Lagu::where('aktivasi_wecan_id',$request->aktivasi_wecan_id)->where('jenis',$request->jenis)->where('id', '!=', $id)->exists();
    // dd($count);
    if($count){
      return response()->json(['status' => 'false'], 200);
    }
    DB::beginTransaction();
    try {
      $aktivasi = Lagu::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
      $aktivasi->update([
      'deskripsi' => $request->deskripsi,
      'jenis' => $request->jenis,
      'url' => $request->url,
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
    $lagu = Lagu::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
    $lagu->delete(); //MENGHAPUS DATANYA
    return response()->json(['status' => 'success'], 200);
  }
  public function aktivasi(Request $request,$id)
  {
    DB::beginTransaction();
    try {
        $editlagu = Lagu::find($id);

        // ubah seluruh status menjadi 0
      if($editlagu)
      {
        DB::table('lagus')
        ->update(['status' => 0]);
      }
      
      // check jika status id yang di aktivasi = 0 atau tidak aktif
      // maka aktifkan aktivasi wecan
      if ($editlagu->status === 0) {
          $editlagu->update([
          'status' => 1
          ]);
      // jika aktivasi wecan aktif, maka ubah statusnya menjadi tidak aktif    
      }else{
          $editlagu->update([
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
