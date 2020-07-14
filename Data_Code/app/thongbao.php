<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class thongbao extends Model
{
    protected $table = 'thongbao';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = ['id','tieude','noidung','ngaydang','nguoidang'];
}
