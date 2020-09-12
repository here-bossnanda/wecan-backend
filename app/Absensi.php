<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensis';
    protected $guarded = [];

    protected $cast = [ 
        'created_at' => 'datetime:d-m-Y H:m:s',
        'updated_at' => 'datetime:d-m-Y H:m:s',
    ];

    public function mahasiswa(){
        return $this->belongsTo(PanitiaMahasiswa::class,'panitia_mahasiswa_id');
    }
}
