<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterPanitiaMahasiswa extends Model
{
    protected $table = 'master_panitia_mahasiswas';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:m:s',
        'updated_at' => 'datetime:d-m-Y H:m:s',
    ];

    public function panitiaMahasiswa(){
        return $this->hasMany('App/PanitiaMahasiswa');
    }

    public function jurusan(){
        return $this->belongsTo(Jurusan::class);
    }
}
