<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class thoigian extends Model
{
    protected $table = 'thoigian';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = ['ngaybatdau','ngayketthuc','loaiapdung'];
}
