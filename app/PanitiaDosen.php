<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PanitiaDosen extends Model
{
    protected $table = 'panitia_dosens';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:m:s',
        'updated_at' => 'datetime:d-m-Y H:m:s',
    ];

    public function jurusan(){
        return $this->belongsTo('App/Jurusan');
    }

    public function jabatan(){
        return $this->belongsTo(Jabatan::class);
    }

    public function user(){
        return $this->belongsTo('App/User');
    }

    public function wecan(){
        return $this->belongsTo(AktivasiWecan::class);
    }

    public function dosen(){
        return $this->belongsTo(MasterPanitiaDosen::class,'master_panitia_dosen_id');
    }
}
