<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AktivasiWecan extends Model
{
    protected $table = "aktivasi_wecans";
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:m:s',
        'updated_at' => 'datetime:d-m-Y H:m:s',
    ];

    public function panitiaMahasiswa(){
        return $this->hasMany(PanitiaMahasiswa::class);
    }

    public function panitiaDosen(){
        return $this->hasMany(PanitiaDosen::class);
    }
}
