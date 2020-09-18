<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\PanitiaMahasiswa;
use App\PanitiaDosen;

use Auth;
use DB;
use DataTables;

class UserController extends Controller
{
  public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:users.viewAny');
    }
    public function listData(){
        $datas = User::with('panitia_mahasiswa.mahasiswa','panitia_dosen.dosen', 'roles')->orderBy('created_at','desc')->get();
        // dd($datas);
        $data = array();
        $no =0;
        $roles = "";
        foreach ($datas as $list) {
          $no++;
          $row = array();
          $row[]= $no;
          $row[]= $list->username;
          $row[]= (!empty($list->panitia_mahasiswa->mahasiswa)) ? $list->panitia_mahasiswa->mahasiswa->name : (!empty($list->panitia_dosen->dosen) ? $list->panitia_dosen->dosen->name : $list->username) ;
          foreach ($list['roles'] as $key) {
            $roles = " ".$key->name;
          }
          $row[]= '<h5><span class="badge badge-warning"><i class="fa fa-check-circle"> '.!empty($roles) ?  $roles : 'Role Error'.' </i></span></h5>';
          $row[]= (!empty($list->panitia_mahasiswa->mahasiswa)) ? '<h5><span class="badge badge-success">Mahasiswa </span></h5>' : (!empty($list->panitia_dosen->dosen) ? '<h5><span class="badge badge-success">Dosen</span></h5>' : '<h5><span class="badge badge-success">Admin</span></h5>') ;
          $row[]= ($list->status == 1) ? '<h5><span class="badge badge-success"><i class="fa fa-check-circle"> Aktif</i></span></h5>' : '<h5><span class="badge badge-danger"><i class="fa fa-check-circle"> Tidak Aktif</i></span></h5>' ;
          (Auth::user()->can('users.update') and Auth::user()->can('users.delete')) ?
          $row[]= '
          <div class="btn-group">
          <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
          <span class="fas fa-pencil-alt"></span></button></div>
          <div class="btn-group">
          <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
          <span class="far fa-trash-alt"></span></button></div>'
          : ((Auth::user()->can('users.delete')) ?
          $row[]= '
          <div class="btn-group">
          <button onclick="deleteData(\''.$list->id.'\')" class=" btn btn-danger">
          <span class="far fa-trash-alt"></span></button></div>'
          : ((Auth::user()->can('users.update')) ? 
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
      
    public function index(){
        return view('page.auth.users.index');
    }

    //SELECT2 SELECT ROLE
    public function select2role(Request $request){
        $data = Role::selectRaw('id,name')
        ->where('name','LIKE',"%$request->q%")
        ->orderBy('name','asc')
        ->paginate(10);
        return response()->json(['items' => $data->toArray()['data'], 'pagination' => $data->nextPageUrl() ? true : false]);
    }

    //SELECT2 SELECT DOSEN
    public function select2dosen(Request $request){
        $data = PanitiaDosen::with('dosen')->selectRaw('id,master_panitia_dosen_id')
        ->whereHas('dosen', function($q) use($request) {
            $q->where('name','LIKE',"%$request->q%")
            ->orderBy('name','asc');
        })
        ->paginate(10);
        return response()->json(['items' => $data->toArray()['data'], 'pagination' => $data->nextPageUrl() ? true : false]);
    }

    //SELECT2 SELECT MAHASISWA
    public function select2mahasiswa(Request $request){
        $data = PanitiaMahasiswa::with('mahasiswa')->selectRaw('id,master_panitia_mahasiswa_id')
        ->whereHas('mahasiswa', function($q) use($request) {
            $q->where('name','LIKE',"%$request->q%")
            ->orderBy('name','asc');
        })
        ->paginate(10);
        return response()->json(['items' => $data->toArray()['data'], 'pagination' => $data->nextPageUrl() ? true : false]);
    }

    public function store(Request $request)
   {
    //  dd($request->all());
    DB::beginTransaction();
    try {
      $count = User::where('username',$request->username)->count();
      if($count >= 1){
        return response()->json(['status' => 'false'], 200);
      }
      $user = User::create([
      'username' => $request->username,
      'password' => bcrypt($request->password),
      'email' => $request->email,
      'status' => $request->status_aktif,
      ]);
      $user->roles()->sync($request->id_roles_users);

      
      $mahasiswa = PanitiaMahasiswa::where('id',$request->id_mahasiswa_users)->first();
      $dosen = PanitiaDosen::where('id',$request->id_dosen_users)->first();
      // dd($guru);
      if (!empty($mahasiswa)) {
        DB::table('panitia_mahasiswas')
        ->where('id',$request->id_mahasiswa_users)
        ->update(['user_id'=> $user->id,
        'updated_at'=>now()
        ]);
      }else if(!empty($dosen)){
        DB::table('panitia_dosens')
        ->where('id',$request->id_dosen_users)
        ->update(['user_id'=> $user->id,
        'updated_at'=>now()
        ]);
      }
      DB::commit();
      return response()->json(['status' => 'success'], 200);
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
    }
  }

  public function edit($id){
    $user = User::with('roles','panitia_mahasiswa.mahasiswa','panitia_dosen.dosen')->findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
    return response()->json(['status' => 'success', 'users' => $user], 200);
  }
  public function update($id,Request $request){
    DB::beginTransaction();
    try {
      // dd($request->all());
      $User = User::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
      $User->username = $request['username'];
      $User->email = $request['email'];
      if(!empty($request['password'])) $User->password = bcrypt($request['password']);
      $User->update();
      $User->roles()->sync($request->id_roles_users);
      DB::commit();
      return response()->json(['status' => 'success'], 200);
    } catch (\Exception $e) {
      DB::rollback();
      return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
    }
  }

  public function destroy($id)
  {
   if(Auth::user()->id != $id) {
    $User = User::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
    $User->delete(); //MENGHAPUS DATANYA
    return response()->json(['status' => 'success'], 200);
  }else{
    return response()->json(['status' => 'failed'], 200);
   }
  }

}
