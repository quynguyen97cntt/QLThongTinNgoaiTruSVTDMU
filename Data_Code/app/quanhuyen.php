<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class quanhuyen extends Model
{
    protected $table='quanhuyen';
    protected $primaryKey = 'maqh';
    public $timestamps = false;
    public $incrementing = false;
}
