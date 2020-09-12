<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\PanitiaDosen;

use App\MasterPanitiaDosen;
use App\Jabatan;

use App\AktivasiWecan;

use Illuminate\Http\Request;

use Auth;
use DB;
use Illuminate\Support\Facades\Redirect;
use DataTables;
use Validator;
use File;
use Illuminate\Support\Str;

class PanitiaDosenController extends Controller
{
    public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('can:panitia-dosen.viewAny');
  }
  public function index(){
    $wecan = AktivasiWecan::where('status',1)->exists();
    if ($wecan) {
      return view('page.manajemen.panitia-dosen.index');
    }
    return Redirect::to('aktivasi-wecan')->with('message', 'Tidak ada WECAN yang aktif, silakan aktifkan WECAN terlebih dahulu');
  }

  public function listdata(Request $request){
    $datas = AktivasiWecan::orderBy('status','asc')->get();
    $no=0;
    $data = array();
    foreach ($datas as $list) {
      $no++;
      $row = array();
      $row[]= $no;
      $row[]= $list->name;
      $row[]= $list->tahun_akademik;
      $row[]= ($list->status == 1)  ? "<div class='badge badge-pill badge-success'>Aktif</div>" : "<div class='badge badge-pill badge-danger'>Tidak Aktif</div>";
      $row[]= '<div class="btn-group">
      <button onclick="detailComponent('.$list->id.')" class=" btn btn-primary">
      <span class="mdi mdi-clipboard-list-outline"></span></button></div>
      <div class="btn-group">';
      $data[]=$row;
    }
    return DataTables::of($data)->escapeColumns([])->make(true);
  }

  public function getData($id){
    $data = AktivasiWecan::where('id',$id)->first();
    return response()->json(['status' => 'success', 'data'=> $data], 200);
  }

  public function detail($id){
    $datas = PanitiaDosen::with(['wecan','dosen','jabatan.divisi'])->where('aktivasi_wecan_id', $id)->orderBy('created_at','desc')->get();
    $data = array();
    foreach ($datas as $list) {
      $row = array();
      $row[]= $list->dosen->nip;
      $row[]= $list->dosen->name;
      $row[]= $list->jabatan->name;
      $row[]= ($list->jabatan->divisi) ? $list->jabatan->divisi->name : '-';
      (Auth::user()->can('panitia-dosen.update') and Auth::user()->can('panitia-dosen.delete')) ?
      $row[]= '
      <div class="btn-group">
        <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
          <span class="fas fa-pencil-alt"></span></button></div>
          <div class="btn-group">
            <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
              <span class="far fa-trash-alt"></span></button></div>'
              : ((Auth::user()->can('panitia-dosen.delete')) ?
              $row[]= '
              <div class="btn-group">
              <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
              <span class="far fa-trash-alt"></span></button></div>'
              : ((Auth::user()->can('panitia-dosen.update')) ? 
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

    public function select2panitia(Request $request){
    $data = MasterPanitiaDosen::selectRaw('id,name,nip')
    ->where('name','LIKE',"%$request->q%")
    ->orWhere('nip','LIKE',"%$request->q%")
    ->orderBy('name','asc')
    ->paginate(10);
    return response()->json(['items' => $data->toArray()['data'], 'pagination' => $data->nextPageUrl() ? true : false]);
  }

  public function select2jabatan(Request $request){
    $data = Jabatan::with('divisi')->selectRaw('id,name')
    ->where('name','LIKE',"%$request->q%")
    ->orderBy('name','asc')
    ->paginate(10);
    return response()->json(['items' => $data->toArray()['data'], 'pagination' => $data->nextPageUrl() ? true : false]);
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
      DB::beginTransaction();
      try {
        $validator = Validator::make($request->all(),[
          'addmore.*.dosen_id' => 'required',
          'addmore.*.jabatan_id' => 'required',
          'wecan_id' => 'required',
          ],
          [
          'addmore.*.dosen_id.required' => 'Panitia harus diisi !',
          'addmore.*.jabatan_id.required' => 'Jabatan harus dipilih !',
          ]);
          if ($validator->fails()) {
            $d['message'] = [];
            foreach ($validator->errors()->all() as $v) {
              array_push($d['message'], $v);
            }
            $d['status'] = 0;
            return response()->json($d);
          }

        foreach ($request->addmore as $key => $value) {
            $count = PanitiaDosen::where('aktivasi_wecan_id',$request->wecan_id)->where('master_panitia_dosen_id',$value['dosen_id'])->exists();
            $first = MasterPanitiaDosen::where('id',$value['dosen_id'])->first();
            if($count){
              return response()->json(['status' => 'false', 'data' => $first->name], 200);
            }
            // dd($value);
            PanitiaDosen::create([
              'aktivasi_wecan_id' => $request->wecan_id,
              'jabatan_id' => $value['jabatan_id'],
              'master_panitia_dosen_id' => $value['dosen_id'],
            ]);
          }
          DB::commit();
          return response()->json(['status' => 'success'], 200);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => 'false', 'data' => $e->getMessage()], 403);
      }
          
        }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Panitia_Dosen  $panitia_Dosen
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $panitia_dosen = PanitiaDosen::with('jabatan','dosen')->findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
        return response()->json(['status' => 'success', 'panitia' => $panitia_dosen], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Panitia_Dosen  $panitia_Dosen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // dd($request->all());
        $count = PanitiaDosen::where('master_panitia_dosen_id',$request->panitia_dosen_id)->where('aktivasi_wecan_id',$request->wecan_id)->where('id', '!=', $id)->exists();
        $first = MasterPanitiaDosen::where('id',$request->panitia_dosen_id)->first();    
        if($count){
              return response()->json(['status' => 'false', 'data' => $first->name ], 200);
            }

            DB::beginTransaction();
            try {
              $dosen = PanitiaDosen::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH

              $dosen->update([
              'jabatan_id' => $request->jabatan_id,
              'master_panitia_dosen_id' => $request->panitia_dosen_id,
              ]);
              DB::commit();
              return response()->json(['status' => 'success'], 200);
            } catch (\Exception $e) {
              DB::rollback();
              return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Panitia_dosen  $panitia_dosen
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $dosen = PanitiaDosen::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
      $dosen->delete(); //MENGHAPUS DATANYA
      return response()->json(['status' => 'success'], 200);  
    }
}
