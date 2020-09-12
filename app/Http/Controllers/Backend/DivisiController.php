<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Divisi;
use App\Jabatan;

use Illuminate\Http\Request;


use DB;
use Auth;
use DataTables;

class DivisiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:divisi.viewAny');
    }
    public function index(){
        return view('page.master-data.divisi.index');
      }
      public function listData(){
        $datas = Divisi::orderBy('created_at','desc')->get();
        $data = array();
        $no =0;
        foreach ($datas as $list) {
          $no++;
          $row = array();
          $row[]= $no;
          $row[]= $list->name;
          $row[]= tanggal_indonesia(substr($list->created_at, 0,10), false);
          (Auth::user()->can('divisi.update') and Auth::user()->can('divisi.delete')) ?
          $row[]= '
          <div class="btn-group">
            <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
              <span class="fas fa-pencil-alt"></span></button></div>
              <div class="btn-group">
                <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
                  <span class="far fa-trash-alt"></span></button></div>'
                  : ((Auth::user()->can('divisi.delete')) ?
                  $row[]= '
                  <div class="btn-group">
                  <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
                  <span class="far fa-trash-alt"></span></button></div>'
                  : ((Auth::user()->can('divisi.update')) ? 
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
          $count = Divisi::where('name',$request->name)->count();
          if($count >= 1){
            return response()->json(['status' => 'false'], 200);
          }
          Divisi::create([
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
        $divisi = Divisi::findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
        return response()->json(['status' => 'success', 'divisi' => $divisi], 200);
      }
      public function update(Request $request, $id)
      {
        $count = Divisi::where('name',$request->name)->where('id', '!=', $id)->exists();
        // dd($count);
        if($count){
          return response()->json(['status' => 'false'], 200);
        }
    
        DB::beginTransaction();
        try {
          $divisi = Divisi::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
          $divisi->update([
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
        $count = Jabatan::where('divisi_id', $id)->exists();
        if($count) {
          return response()->json(['status' => 'failed'], 200);
        }
        $divisi = Divisi::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
        $divisi->delete(); //MENGHAPUS DATANYA
        return response()->json(['status' => 'success'], 200);
      }
}
