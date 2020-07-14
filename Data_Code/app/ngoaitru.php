<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ngoaitru extends Model
{
    protected $table = 'ngoaitru';
    public $timestamps = false;
    protected $primaryKey = 'mssv';
    public $incrementing = false;
    protected $fillable = ['mssv','tenchungoaitru','dienthoaichungoaitru','diachingoaitru','loaicutru','ngaydangky','vido','kinhdo','geom'];
}
