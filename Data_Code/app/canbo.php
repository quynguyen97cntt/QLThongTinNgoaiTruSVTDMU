<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class canbo extends Model
{
    protected $table = 'canbo';
    public $timestamps = false;
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = ['id','ho','ten','hoten','ngaysinh','gioitinh','cmnd','sodienthoai','email','idKhoa','CTDaoTao'];
}
