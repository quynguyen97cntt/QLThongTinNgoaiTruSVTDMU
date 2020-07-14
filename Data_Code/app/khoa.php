<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class khoa extends Model
{
    protected $table='khoa';
    protected $primaryKey = 'makhoa';
    public $timestamps = false;
    public $incrementing = false;
}
