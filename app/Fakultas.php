<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = "fakultas";
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:m:s',
        'updated_at' => 'datetime:d-m-Y H:m:s',
    ];
}
