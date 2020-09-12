<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables;
use App\Role;
use App\Permission;

class RoleController extends Controller
{
   public function __construct()
  {
    $this->middleware('auth');
    $this->middleware('can:role.viewAny');
  }
  public function index(){
    $Role = Role::with(['permissions'])->get(); //MENGAMBIL DATA BERDASARKAN ID
    $permissions = Permission::all();
    return view('page.auth.role-permission.index',compact('permissions'));
  }
  public function listData(){
    $datas = Role::orderBy('id','desc')->get();
    $no =0;
    $data = array();
    foreach ($datas as $list) {
      $no++;
      $row = array();
      $row[]= $no;
      $row[]= $list->name;
      $row[]= '
      <div class="btn-group">
      <button onclick="editForm('.$list->id.')" class=" btn btn-warning">
      <span class="fas fa-pencil-alt"></span></button></div>
      <div class="btn-group">
      <button onclick="deleteData('.$list->id.')" class=" btn btn-danger">
      <span class="far fa-trash-alt"></span></button></div>';
      $data[]=$row;
    }
    return DataTables::of($data)->escapeColumns([])->make(true);
  }
  public function select2(Request $request){
    $data = Role::selectRaw('id,name')
    ->where('name','LIKE',"%$request->q%")
    ->orderBy('name','asc')
    ->paginate(10);
    return response()->json(['items' => $data->toArray()['data'], 'pagination' => $data->nextPageUrl() ? true : false]);
  }
  public function listDataPermission(){
    $datas = DB::select("SELECT t.kategori,
      MAX(CASE WHEN t.for = 'Create' THEN t.id END) AS Permission_Create,
      MAX(CASE WHEN t.for = 'Read' THEN t.id END) AS Permission_Read,
      MAX(CASE WHEN t.for = 'Update' THEN t.id END) AS Permission_Update,
      MAX(CASE WHEN t.for = 'Delete' THEN t.id END) AS Permission_Delete,
      MAX(CASE WHEN t.for = 'CRUD' THEN t.id END) AS Permission_CRUD
      FROM permissions t
      GROUP BY t.kategori");

      $data = array();
      foreach ($datas as $list) {
        $row = array();
        $row[]= "<div class='custom-control custom-checkbox mb-2'>
          <input type='checkbox' id='perkategori_$list->kategori' value='1' class='custom-control-input'>
          <label class='custom-control-label' for='perkategori_$list->kategori'>$list->kategori</label>
        </div>";
        $row[] =
        "<div class='custom-control custom-checkbox mb-2'>
          <input type='checkbox' class='custom-control-input create_$list->kategori create select_$list->Permission_Create' id='create_$list->Permission_Create' name='permission[]' value='".$list->Permission_Create."'>
          <label class='custom-control-label' for='create_$list->Permission_Create'></label>
        </div>
        ";
        $row[] = "<div class='custom-control custom-checkbox mb-2'>
          <input type='checkbox' class='custom-control-input read_$list->kategori read select_$list->Permission_Read' id='create_$list->Permission_Read' name='permission[]' value='".$list->Permission_Read."'>
          <label class='custom-control-label' for='create_$list->Permission_Read'></label>
        </div>";
        $row[] = "<div class='custom-control custom-checkbox mb-2'>
          <input type='checkbox' class='custom-control-input update_$list->kategori update select_$list->Permission_Update' id='create_$list->Permission_Update' name='permission[]' value='".$list->Permission_Update."'>
          <label class='custom-control-label' for='create_$list->Permission_Update'></label>
        </div>";
        $row[] = "<div class='custom-control custom-checkbox mb-2'>
          <input type='checkbox' class='custom-control-input delete_$list->kategori delete select_$list->Permission_Delete' id='create_$list->Permission_Delete' name='permission[]' value='".$list->Permission_Delete."'>
          <label class='custom-control-label' for='create_$list->Permission_Delete'></label>
        </div>";
        $row[] = "<div class='custom-control custom-checkbox mb-2'>
          <input type='checkbox' class='custom-control-input crud_$list->kategori crud select_$list->Permission_CRUD' id='create_$list->Permission_CRUD' name='permission[]' value='".$list->Permission_CRUD."'>
          <label class='custom-control-label' for='create_$list->Permission_CRUD'></label>
        </div>";
        $data[]=$row;
      }
      // $output = array("data" => $data);
      return Datatables::of($data)->escapeColumns([])->make(true);
    }
    public function store(Request $request)
    {
      DB::beginTransaction();
      try {
        $count = Role::where('name',$request['name'])->count();
        if($count < 1){
          $data =  Role::create([
          'name' => $request->name,
          ]);
          $data->permissions()->sync($request->permission);
        }else{
          return response()->json(['status' => 'error'], 200);
        }
        DB::commit();
        return response()->json(['status' => 'success'], 200);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
      }
    }
    public function edit($id){
      $Role = Role::with(['permissions'])->findOrFail($id); //MENGAMBIL DATA BERDASARKAN ID
      $permissions = Permission::all();
      //   $data = HariNasional::findOrFail($id);
      // echo json_encode($kategori);
      return response()->json(['status' => 'success', 'role' => $Role, 'permission' => $permissions], 200);
    }
    public function update($id,Request $request){
      DB::beginTransaction();
      try {
        $Role = Role::findOrFail($id); //MENGAMBIL DATA YANG AKAN DI UBAH
        $Role->update([ //MODIFIKASI BAGIAN INI DENGAN MEMASUKKANYA KE DALAM VARIABLE $USER
        'name' => $request->name,
        ]);
        $Role->permissions()->sync($request->permission);
        DB::commit();
        return response()->json(['status' => 'success'], 200);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json(['status' => 'error', 'data' => $e->getMessage()], 200);
      }
    }
    public function destroy($id)
    {
      $Role = Role::find($id); //MENGAMBIL DATA YANG AKAN DIHAPUS
      $Role->delete(); //MENGHAPUS DATANYA
      return response()->json(['status' => 'success'], 200);
    }
}
