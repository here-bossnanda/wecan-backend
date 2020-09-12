<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $table = 'roles';
  protected $primaryKey = 'id';
  protected $guarded = [];

  protected $casts = [
    'created_at' => 'datetime:d-m-Y H:m:s',
    'updated_at' => 'datetime:d-m-Y H:m:s',
];

  public function permissions(){
      return $this->belongsToMany(Permission::class);
  }
  public function users(){
    return $this->belongsToMany('App\User');
  }
}
