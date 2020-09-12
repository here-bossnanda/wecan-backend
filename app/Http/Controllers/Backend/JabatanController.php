<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Divisi;
use App\Jabatan;
use App\PanitiaMahasiswa;
use App\PanitiaDosen;

use DB;
use Auth;
use DataTables;

use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:jabatan.viewAny');
    }
    public function index(){
      return view('page.master-data.jabatan.index');
    }
    public function listData(){
      $datas = Jabatan::with('divisi')->orderBy('created_at','desc')->get();
      $data = array();
      $no =0;
      foreach ($datas as $list) {
        $no++;
        $row = array();
        $row[]= $no;
        $row[]= $list->name;
        $row[]= ($list->divisi) ? $list->divisi->name : '-';
        $row[]= tanggal_indonesia(substr($list->created_at, 0,10), false);
        (Auth::user()->can('jabatan.update') and Auth::user()->can('jabatan.delete')) ?
        $row[]= '
        <div class="btn-group">
          <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
            <span class="fas fa-pencil-alt"></span></button></div>
            <div class="btn-group">
              <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
                <span class="far fa-trash-alt"></span></button></div>'
                : ((Auth::user()->can('jabatan.delete')) ?
                $row[]= '
                <div class="btn-group">
                <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
                <span class="far fa-trash-alt"></span></button></div>'
                : ((Auth::user()->can('jabatan.update')) ? 
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

    //SELECT2 SELECT DIVISI
    public function select2divisi(Request $request){
        $data = Divisi::selectRaw('id,name')
        ->where('name','LIKE',"%$request->q%")
        ->orderBy('name','desc')
        ->paginate(10);
        return response()->json(['items' => $data->toArray()['data'], 'pagination' => $data->nextPageUrl() ? true : false]);
    }

    public function store(Request $request)
    {
      DB::beginTransaction();
      try {
        $count = Jabatan::where('name',$request->name)->exists();
        if($count){
          return response()->json(['status' => 'false'], 200);
        }
        Jabatan::create([
        'name' => $request->name,
        'divisi_id' => $request->divisi_id,
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
      $jabatan = Jabatan::with('divisi')->findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
      return response()->json(['status' => 'success', 'jabatan' => $jabatan], 200);
    }
    public function update(Request $request, $id)
    {
      $count = Jabatan::where('name',$request->name)->where('id', '!=', $id)->exists();

      if($count){
        return response()->json(['status' => 'false'], 200);
      }
  
      DB::beginTransaction();
      try {
        $jabatan = Jabatan::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
        $jabatan->update([
        'name' => $request->name,
        'divisi_id' => $request->divisi_id,
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
      $count = PanitiaMahasiswa::where('jabatan_id', $id)->exists();
      $count2 = PanitiaDosen::where('jabatan_id', $id)->exists();
      if($count  or $count2 ) {
        return response()->json(['status' => 'failed'], 200);
      }
      $jabatan = Jabatan::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
      $jabatan->delete(); //MENGHAPUS DATANYA
      return response()->json(['status' => 'success'], 200);
    }
}
