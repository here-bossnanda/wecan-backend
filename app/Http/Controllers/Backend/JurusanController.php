<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Fakultas;
use App\Jurusan;
use App\MasterPanitiaMahasiswa;
use App\MasterPanitiaDosen;

use DB;
use Auth;
use DataTables;

use Illuminate\Http\Request;

class JurusanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:jurusan.viewAny');
    }
    public function index(){
      return view('page.master-akademik.jurusan.index');
    }
    public function listData(){
      $datas = Jurusan::with('fakultas')->orderBy('created_at','desc')->get();
      $data = array();
      $no =0;
      foreach ($datas as $list) {
        $no++;
        $row = array();
        $row[]= $no;
        $row[]= $list->name;
        $row[]= ($list->fakultas) ? $list->fakultas->name : 'Fakultas tidak ditemukan';
        $row[]= tanggal_indonesia(substr($list->created_at, 0,10), false);
        (Auth::user()->can('jurusan.update') and Auth::user()->can('jurusan.delete')) ?
        $row[]= '
        <div class="btn-group">
          <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
            <span class="fas fa-pencil-alt"></span></button></div>
            <div class="btn-group">
              <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
                <span class="far fa-trash-alt"></span></button></div>'
                : ((Auth::user()->can('jurusan.delete')) ?
                $row[]= '
                <div class="btn-group">
                <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
                <span class="far fa-trash-alt"></span></button></div>'
                : ((Auth::user()->can('jurusan.update')) ? 
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

    //SELECT2 SELECT FAKULTAS
    public function select2fakultas(Request $request){
        $data = Fakultas::selectRaw('id,name')
        ->where('name','LIKE',"%$request->q%")
        ->orderBy('name','desc')
        ->paginate(10);
        return response()->json(['items' => $data->toArray()['data'], 'pagination' => $data->nextPageUrl() ? true : false]);
    }

    public function store(Request $request)
    {
      DB::beginTransaction();
      try {
        $count = Jurusan::where('name',$request->name)->exists();
        if($count){
          return response()->json(['status' => 'false'], 200);
        }
        Jurusan::create([
        'name' => $request->name,
        'fakultas_id' => $request->fakultas_id,
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
      $jurusan = Jurusan::with('fakultas')->findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
      return response()->json(['status' => 'success', 'jurusan' => $jurusan], 200);
    }
    public function update(Request $request, $id)
    {
      $count = Jurusan::where('name',$request->name)->where('id', '!=', $id)->exists();

      if($count){
        return response()->json(['status' => 'false'], 200);
      }
  
      DB::beginTransaction();
      try {
        $Jurusan = Jurusan::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
        $Jurusan->update([
        'name' => $request->name,
        'fakultas_id' => $request->fakultas_id,
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
      $count = MasterPanitiaMahasiswa::where('jurusan_id', $id)->exists();
      $count2 = MasterPanitiaDosen::where('jurusan_id', $id)->exists();
      if($count  or $count2 ) {
        return response()->json(['status' => 'failed'], 200);
      }
      $Jurusan = Jurusan::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
      $Jurusan->delete(); //MENGHAPUS DATANYA
      return response()->json(['status' => 'success'], 200);
    }
}
