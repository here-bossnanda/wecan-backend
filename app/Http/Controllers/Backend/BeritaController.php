<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Berita;
use Illuminate\Http\Request;
use DB;
use Auth;
use DataTables;
use Str;
use File;


class BeritaController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
      $this->middleware('can:berita.viewAny');
    }
    public function index(){
      return view('page.master-data.berita.index');
    }
    public function listData(){
      $datas = Berita::with('user')->orderBy('created_at','desc')->get();
      $data = array();
      $no =0;
      foreach ($datas as $list) {
        $no++;
        $row = array();
        $row[]= $no;
        $row[]= ($list->img) ? '<img src="assets/images/berita/'.$list->img.'" alt="" class="rounded-circle header-profile-user" alt="Header Avatar">'. $list->judul : '<img src="assets/images/users/default.png" alt="" class="rounded-circle header-profile-user" alt="Header Avatar">'. $list->judul;
        $row[]= $list->slug;
        $row[]= ($list->status == "published") ? '<h5><span class="badge badge-success"><i class="fa fa-check-circle"> Published</i></span></h5>' : '<h5><span class="badge badge-info"><i class="fa fa-check-circle"> Draft</i></span></h5>' ;
        $row[]= $list->user->username;
        (Auth::user()->can('berita.update') and Auth::user()->can('berita.delete')) ?
        $row[]= '
        <div class="btn-group">
          <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
            <span class="fas fa-pencil-alt"></span></button></div>
            <div class="btn-group">
              <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
                <span class="far fa-trash-alt"></span></button></div>'
                : ((Auth::user()->can('berita.delete')) ?
                $row[]= '
                <div class="btn-group">
                <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
                <span class="far fa-trash-alt"></span></button></div>'
                : ((Auth::user()->can('berita.update')) ? 
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
                $count = Berita::where('judul',$request->judul)->exists();
                if($count){
                  return response()->json(['status' => 'false'], 200);
                }
  
                $filename = NULL;
                if ($request->hasFile('img')) {
                  $file = $request->file('img');
                  $filename = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
                  $file->move('assets/images/berita', $filename);
                }
  
                Berita::create([
                'judul' => $request->judul, 
                'slug' => Str::slug($request->judul),
                'status' => $request->status,
                'deskripsi' => $request->deskripsi,
                'user_id'=> Auth::user()->id,
                'img' => $filename ,
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
              $berita = Berita::findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
              return response()->json(['status' => 'success', 'berita' => $berita], 200);
            }
            public function update(Request $request, $id)
            {
              $count = Berita::where('judul',$request->judul)->where('id', '!=', $id)->exists();
              if($count){
                return response()->json(['status' => 'false'], 200);
              }
  
              DB::beginTransaction();
              try {
                $berita = Berita::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
                $filename = $berita->img; //NAMA FILE img SEBELUMNYA
  
                //JIKA ADA FILE BARU YANG DIKIRIMKAN
                if ($request->hasFile('img')) {
                  //MAKA img YANG LAMA AKAN DIGANTI
                  $file = $request->file('img');
                  //DAN FILE img YANG LAMA AKAN DIHAPUS
                  File::delete(public_path('assets/images/berita/' . $filename));
                  $filename = uniqid() . '-' . time() . '.' . $file->getClientOriginalExtension();
                  $file->move('assets/images/berita', $filename);
                }
  
                $berita->update([
                    'judul' => $request->judul, 
                    'slug' => Str::slug($request->judul),
                    'status' => $request->status,
                    'deskripsi' => $request->deskripsi,
                    'user_id'=> Auth::user()->id,
                    'img' => $filename ,
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
            //   $count = PanitiaMahasiswa::where('master_panitia_berita_id', $id)->exists();
            //   if($count) {
            //     return response()->json(['status' => 'failed'], 200);
            //   }
              $berita = Berita::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
              File::delete(public_path('assets/images/berita/' . $berita->img)); //MENGHAPUS FILE img
              $berita->delete(); //MENGHAPUS DATANYA
              return response()->json(['status' => 'success'], 200);
            }
}
