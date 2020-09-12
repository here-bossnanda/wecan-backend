<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Fakultas;
use App\Jurusan;

use DB;
use Auth;
use DataTables;

use Illuminate\Http\Request;

class FakultasController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:fakultas.viewAny');
    }
    public function index(){
        return view('page.master-akademik.fakultas.index');
      }
      public function listData(){
        $datas = Fakultas::orderBy('created_at','desc')->get();
        $data = array();
        $no =0;
        foreach ($datas as $list) {
          $no++;
          $row = array();
          $row[]= $no;
          $row[]= $list->name;
          $row[]= tanggal_indonesia(substr($list->created_at, 0,10), false);
          (Auth::user()->can('fakultas.update') and Auth::user()->can('fakultas.delete')) ?
          $row[]= '
          <div class="btn-group">
            <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
              <span class="fas fa-pencil-alt"></span></button></div>
              <div class="btn-group">
                <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
                  <span class="far fa-trash-alt"></span></button></div>'
                  : ((Auth::user()->can('fakultas.delete')) ?
                  $row[]= '
                  <div class="btn-group">
                  <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
                  <span class="far fa-trash-alt"></span></button></div>'
                  : ((Auth::user()->can('fakultas.update')) ? 
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
          $count = Fakultas::where('name',$request->name)->count();
          if($count >= 1){
            return response()->json(['status' => 'false'], 200);
          }
          Fakultas::create([
          'name' => $request->name,
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
        $Fakultas = Fakultas::findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
        return response()->json(['status' => 'success', 'fakultas' => $Fakultas], 200);
      }
      public function update(Request $request, $id)
      {
        $count = Fakultas::where('name',$request->name)->where('id', '!=', $id)->exists();
        // dd($count);
        if($count){
          return response()->json(['status' => 'false'], 200);
        }
    
        DB::beginTransaction();
        try {
          $Fakultas = Fakultas::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
          $Fakultas->update([
          'name' => $request->name,
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
        $count = Jurusan::where('fakultas_id', $id)->exists();
        if($count) {
          return response()->json(['status' => 'failed'], 200);
        }
        $Fakultas = Fakultas::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
        $Fakultas->delete(); //MENGHAPUS DATANYA
        return response()->json(['status' => 'success'], 200);
      }
}
