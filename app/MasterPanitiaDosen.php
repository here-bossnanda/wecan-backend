<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterPanitiaDosen extends Model
{
    protected $table = 'master_panitia_dosens';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:m:s',
        'updated_at' => 'datetime:d-m-Y H:m:s',
    ];

    public function panitiaDosen(){
        return $this->hasMany('App/PanitiaDosen');
    }

    public function jurusan(){
        return $this->belongsTo(Jurusan::class);
    }
    
}
