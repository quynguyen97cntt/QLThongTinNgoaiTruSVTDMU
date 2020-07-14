<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tinhthanh extends Model
{
    protected $table='tinhthanh';
    protected $primaryKey = 'matp';
    public $timestamps = false;
    public $incrementing = false;
}
