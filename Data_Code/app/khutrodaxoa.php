<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class khutrodaxoa extends Model
{
    protected $table='khutrodaxoa';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['id','makhutro','lydo','ngayxoa','nguoixoa'];
}
