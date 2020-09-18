<?php

namespace App\Http\Controllers\Backend;

use App\Absensi;
use App\Http\Controllers\Controller;
use App\PanitiaMahasiswa;
use App\MasterPanitiaMahasiswa;
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

class PanitiaMahasiswaController extends Controller
{
    public function __construct()
  {
    $this->middleware('auth');
    $this->middleware(function ($request, $next) {  
      if (Auth::check() && Auth::user()->can('panitia-mahasiswa.viewAny')) {
        $this->middleware('can:panitia-mahasiswa.viewAny');
      }else if(Auth::check() && Auth::user()->can('absensi.viewAny')){
        $this->middleware('can:absensi.viewAny');
      }else{
          abort(401);
        $this->middleware('can:panitia-mahasiswa.viewAny');
        $this->middleware('can:absensi.viewAny');
      }
    return $next($request);
    });
  }
  public function index(){
    // dd(Auth::check());
    $wecan = AktivasiWecan::where('status',1)->exists();
    if ($wecan) {
      // $wecan = AktivasiWecan::where('status',1)->exists();  
      return view('page.manajemen.panitia-mahasiswa.index');
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
    $datas = PanitiaMahasiswa::with(['wecan','mahasiswa','jabatan.divisi'])->where('aktivasi_wecan_id', $id)->orderBy('created_at','desc')->get();
    $data = array();
    foreach ($datas as $list) {
      $row = array();
      $row[]= $list->mahasiswa->npm;
      $row[]= $list->mahasiswa->name;
      $row[]= $list->nickname;
      $row[]= $list->jabatan->name;
      $row[]= ($list->jabatan->divisi) ? $list->jabatan->divisi->name : '-';
      (Auth::user()->can('panitia-mahasiswa.update') and Auth::user()->can('panitia-mahasiswa.delete')) ?
      $row[]= '
      <div class="btn-group">
      <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
      <span class="fas fa-pencil-alt"></span></button></div>
      <div class="btn-group">
      <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
      <span class="far fa-trash-alt"></span></button></div>'
      : ((Auth::user()->can('panitia-mahasiswa.delete')) ?
      $row[]= '
      <div class="btn-group">
      <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
      <span class="far fa-trash-alt"></span></button></div>'
      : ((Auth::user()->can('panitia-mahasiswa.update')) ? 
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

    public function absensi($id){
    $datas = Absensi::with('mahasiswa.mahasiswa')->whereHas('mahasiswa',function($query) use($id){
      $query->where('aktivasi_wecan_id', $id);
    })->orderBy('created_at','desc')->get();
    // dd($datas);
    $data = array();
    foreach ($datas as $list) {
      $row = array();
      $row[]= tanggal_indonesia(substr($list->tgl_absensi,0,10), true);
      $row[]= $list->mahasiswa->mahasiswa->npm;
      $row[]= $list->mahasiswa->mahasiswa->name;
      $row[]= ($list->status_absen == "H") ? '<h5><div class="badge badge-pill badge-success">HADIR</div></h5>' : (($list->status_absen == "I") ? '<h5><div class="badge badge-pill badge-warning">IZIN</div></h5>' : '<h5><div class="badge badge-pill badge-danger">ALPHA</div></h5>');
      $row[]= ($list->keterangan ?? "-") ;
      $row[]= ($list->file) ? '<strong><a href="assets/file/file_bukti/'.$list->file.'"> '.$list->file.' </a> </strong>' : "-" ;
      (Auth::user()->can('absensi.update') and Auth::user()->can('absensi.delete')) ?
      $row[]= '
      <div class="btn-group">
        <button onclick="editFormAbsensi('.$list->id.')" class=" btn btn-warning">
          <span class="fas fa-pencil-alt"></span></button></div>
          <div class="btn-group">
          <button onclick="deleteDataAbsensi('.$list->id.')" class=" btn btn-danger">
          <span class="far fa-trash-alt"></span></button></div>'
          : ((Auth::user()->can('absensi.delete')) ?
          $row[]= '
          <div class="btn-group">
          <button onclick="deleteDataAbsensi(\''.$list->id.'\')" class=" btn btn-danger">
          <span class="far fa-trash-alt"></span></button></div>'
          : ((Auth::user()->can('absensi.update')) ? 
          $row[]= '<div class="btn-group">
          <button onclick="editFormAbsensi(\''.$list->id.'\')" class=" btn btn-warning">
          <span class="fas fa-pencil-alt"></span></button></div>'
          : 
          $row[]= '<div class="btn-group">
          <button class=" btn btn-info">
          <span class="fas fa-pencil-alt"></span> Tidak ada aksi</button></div>'));
        $data[]=$row;
        }
    return DataTables::of($data)->escapeColumns([])->make(true);
    }

    public function presensi($id){
    $datas = Absensi::with('mahasiswa.mahasiswa')->selectRaw('panitia_mahasiswa_id,count(case status_absen when "H" then 1 else null end) as jumlah_hadir,count(case status_absen when "I" then 1 else null end) as jumlah_izin,count(case status_absen when "A" then 1 else null end) as jumlah_alpha,count(status_absen) as jumlah')
    ->whereHas('mahasiswa', function($query) use($id){
      $query->where('aktivasi_wecan_id',$id);
    })->orderBy('panitia_mahasiswa_id','asc')->groupBy('panitia_mahasiswa_id')->get();
    $data = array();
    foreach ($datas as $list) {
      $row = array();
      $row[]= $list->mahasiswa->mahasiswa->npm;
      $row[]= $list->mahasiswa->mahasiswa->name;
      $row[]= $list->jumlah_hadir;
      $row[]= $list->jumlah_izin;
      $row[]= $list->jumlah_alpha;
      $row[]= $list->jumlah;
      $data[]=$row;
    }
    return DataTables::of($data)->escapeColumns([])->make(true);
  }

    public function refresh(Request $request){
    $awal = $request['tgl_mulai'];
    $akhir = $request['tgl_akhir'];
    $data = AktivasiWecan::where('id',$request['periode_id'])->first();
    return response()->json(['status' => 'success','data'=>$data,'waktu_awal' => $awal, 'waktu_akhir' => $akhir, 'awal' => tanggal_indonesia(substr($awal,0,10), true), 'akhir' => tanggal_indonesia(substr($akhir,0,10), true)], 200);
    }
    public function periode($id,$awal,$akhir){
      $datas = Absensi::with('mahasiswa.mahasiswa')
      ->whereHas('mahasiswa', function($query) use($id){
        $query->where('aktivasi_wecan_id',$id);
      })
      ->where('tgl_absensi', '>=', $awal)
      ->where('tgl_absensi', '<=', $akhir)
      ->orderBy('created_at','asc')->get();
      $data = array();
      foreach ($datas as $list) {
        $row = array();
        $row[]= tanggal_indonesia(substr($list->tgl_absensi,0,10), true);
        $row[]= $list->mahasiswa->mahasiswa->npm;
        $row[]= $list->mahasiswa->mahasiswa->name;
        $row[]= ($list->status_absen == "H") ? '<h5><div class="badge badge-pill badge-success">HADIR</div></h5>' : (($list->status_absen == "I") ? '<h5><div class="badge badge-pill badge-warning">IZIN</div></h5>' : '<h5><div class="badge badge-pill badge-danger">ALPHA</div></h5>');
        $row[]= $list->keterangan;
        $row[]= '<strong><a href="assets/file/file_bukti/'.$list->file.'"> '.$list->file.' </a> </strong>' ;
        (Auth::user()->can('absensi.update') and Auth::user()->can('absensi.delete')) ?
        $row[]= '
        <div class="btn-group">
        <button onclick="editFormAbsensi('.$list->id.')" class=" btn btn-warning">
          <span class="fas fa-pencil-alt"></span></button></div>
          <div class="btn-group">
          <button onclick="deleteDataAbsensi('.$list->id.')" class=" btn btn-danger">
          <span class="far fa-trash-alt"></span></button></div>'
          : ((Auth::user()->can('absensi.delete')) ?
          $row[]= '
          <div class="btn-group">
          <button onclick="deleteDataAbsensi(\''.$list->id.'\')" class=" btn btn-danger">
          <span class="far fa-trash-alt"></span></button></div>'
          : ((Auth::user()->can('absensi.update')) ? 
          $row[]= '<div class="btn-group">
          <button onclick="editFormAbsensi(\''.$list->id.'\')" class=" btn btn-warning">
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
    $data = MasterPanitiaMahasiswa::selectRaw('id,name,npm')
    ->where('name','LIKE',"%$request->q%")
    ->orWhere('npm','LIKE',"%$request->q%")
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
          'addmore.*.panitia_id' => 'required',
          'addmore.*.jabatan_id' => 'required',
          'wecan_id' => 'required',
          'addmore.*.nickname' => 'required',
          ],
          [
          'addmore.*.panitia_id.required' => 'Panitia harus diisi !',
          'addmore.*.jabatan_id.required' => 'Jabatan harus dipilih !',
          'addmore.*.nickname.required' => 'Nickname harus diisi !',
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
            $count = PanitiaMahasiswa::where('aktivasi_wecan_id',$request->wecan_id)->where('master_panitia_mahasiswa_id',$value['panitia_id'])->exists();
            $first = MasterPanitiaMahasiswa::where('id',$value['panitia_id'])->first();
            if($count){
              return response()->json(['status' => 'false', 'data' => $first->name], 200);
            }
            // dd($value);
            PanitiaMahasiswa::create([
              'nickname' => $value['nickname'],
              'aktivasi_wecan_id' => $request->wecan_id,
              'jabatan_id' => $value['jabatan_id'],
              'master_panitia_mahasiswa_id' => $value['panitia_id'],
            ]);
          }
          DB::commit();
          return response()->json(['status' => 'success'], 200);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => 'false', 'data' => $e->getMessage()], 403);
      }
          
    }

    public function storeAbsensi(Request $request)
    {
      DB::beginTransaction();
      try {
        $panitia_exists = PanitiaMahasiswa::where('aktivasi_wecan_id',$request->wecan_id)->exists();


        if(!$panitia_exists){
            return response()->json(['status' => 'exists', 'message' => 'Belum ada panitia teregistrasi']);
        }


        $panitia = PanitiaMahasiswa::where('aktivasi_wecan_id',$request->wecan_id)->get();
        // dd($panitia);
        foreach ($panitia as $key => $value) {
          $mahasiswa_id = $value['id'];
          // $count = Absensi::where('panitia_mahasiswa_id',$mahasiswa_id)->where('tgl_absensi',$request->tgl_absensi)->count();
          // $nama = MasterPanitiaMahasiswa::where('id',$value['master_panitia_mahasiswa_id'])->first();
          // if($count >= 1){
          //   return response()->json(['status' => 'false', 'name' => $nama->name, 'tanggal' => tanggal_indonesia(substr($request->tgl_absensi, 0,10), false) ], 200);
          // }else{

            
            Absensi::firstOrCreate(['panitia_mahasiswa_id' => $mahasiswa_id,'tgl_absensi' => $request->tgl_absensi],[
              'panitia_mahasiswa_id' => $mahasiswa_id,
              'status_absen' => "A",
              'tgl_absensi' => $request->tgl_absensi,
              ]);
            // }
          
        }
        // dd($request->all(),$data_siswa);

        DB::commit();
        return response()->json(['status' => 'success'], 200);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
      }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Panitia_Mahasiswa  $panitia_Mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $panitia_mahasiswa = PanitiaMahasiswa::with('jabatan','mahasiswa')->findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
        return response()->json(['status' => 'success', 'panitia' => $panitia_mahasiswa], 200);
    }

    public function editAbsensi($id)
    {
      $absensi = Absensi::with('mahasiswa.mahasiswa')->findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
      return response()->json(['status' => 'success', 'absensi' => $absensi], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Panitia_Mahasiswa  $panitia_Mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      // dd($request->all());
        $count = PanitiaMahasiswa::where('master_panitia_mahasiswa_id',$request->panitia_mahasiswa_id)->where('aktivasi_wecan_id',$request->wecan_id)->where('id', '!=', $id)->exists();
        $first = MasterPanitiaMahasiswa::where('id',$request->panitia_mahasiswa_id)->first();    
        if($count){
              return response()->json(['status' => 'false', 'data' => $first->name ], 200);
            }

            DB::beginTransaction();
            try {
              $Mahasiswa = PanitiaMahasiswa::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH

              $Mahasiswa->update([
              'nickname' => $request->nicknameEdit,
              'jabatan_id' => $request->jabatan_id,
              'master_panitia_mahasiswa_id' => $request->panitia_mahasiswa_id,
              ]);
              DB::commit();
              return response()->json(['status' => 'success'], 200);
            } catch (\Exception $e) {
              DB::rollback();
              return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
            }
    }

    public function updateAbsensi(Request $request, $id)
    {
      DB::beginTransaction();
      try {
        $Absensi = Absensi::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
        $filename = $Absensi->file; //NAMA FILE FOTO SEBELUMNYA
        //JIKA ADA FILE BARU YANG DIKIRIMKAN
        if ($request->hasFile('file_bukti')) {
          //MAKA FOTO YANG LAMA AKAN DIGANTI
          $file = $request->file('file_bukti');
          //DAN FILE FOTO YANG LAMA AKAN DIHAPUS
          File::delete(public_path('assets/file/file_bukti/' . $filename));
          $filename = Str::random(10) . '-' . time() . '.' . $file->getClientOriginalExtension();
          $file->move('assets/file/file_bukti', $filename);
        }
        if ($Absensi->status_absen === "I" ) {
          if ($request->status === "I") {
            $Absensi->update([
            'status_absen' => $request->status,
            'keterangan' => $request->keterangan,
            'file' => $filename,
            ]);
          }else{
            File::delete(public_path('assets/file/file_bukti/' . $filename));
            $Absensi->update([
            'status_absen' => $request->status,
            'keterangan' => null,
            'file' => null,
            ]);
          }
        }else{
          $Absensi->update([
          'status_absen' => $request->status,
          'keterangan' => $request->keterangan,
          'file' => $filename,
          ]);
        }
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
     * @param  \App\Panitia_Mahasiswa  $panitia_Mahasiswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $mahasiswa = PanitiaMahasiswa::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
      $mahasiswa->delete(); //MENGHAPUS DATANYA
      return response()->json(['status' => 'success'], 200);  
    }

    public function destroyAbsensi($id)
    {
      $Absensi = Absensi::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
      $filename = $Absensi->file;
      if($filename){
        File::delete(public_path('assets/file/file_bukti/' . $filename));
      }
      $Absensi->delete(); //MENGHAPUS DATANYA
      return response()->json(['status' => 'success'], 200);  
    }
}
