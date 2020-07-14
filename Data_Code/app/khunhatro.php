<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class khunhatro extends Model
{
    //
    protected $table='khunhatro_tdm_point';
    protected $primaryKey = 'gid';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = ['gid','tennhatro','tenchutro','sodienthoai','sodienthoai2','diachi','giaphong','ngaydangky','sophong','tienich','khoangcach','geom'];
}
