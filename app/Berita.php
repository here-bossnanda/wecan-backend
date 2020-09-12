<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Berita extends Model
{
    protected $table = "beritas";
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:m:s',
        'updated_at' => 'datetime:d-m-Y H:m:s',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
    
    public function wecan(){
        return $this->belongsTo('App/AktivitasWecan');
    }
}
