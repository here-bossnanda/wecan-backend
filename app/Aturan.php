<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aturan extends Model
{
    protected $table = "aturans";
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:m:s',
        'updated_at' => 'datetime:d-m-Y H:m:s',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function wecan(){
        return $this->belongsTo(AktivasiWecan::class,'aktivasi_wecan_id');
    }
}
