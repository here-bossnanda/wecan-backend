<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    protected $table = "divisis";
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:m:s',
        'updated_at' => 'datetime:d-m-Y H:m:s',
    ];
}
