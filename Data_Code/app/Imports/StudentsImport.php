<?php

namespace App\Imports;

use App\sinhvien;
use App\taikhoan;
use Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StudentsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $dssvImport = new sinhvien([
            //
            'mssv' => $row['mssv'],
            'ho' => $row['ho'],
            'ten' => $row['ten'],
            'ngaysinh' => gmdate("Y-m-d",(((25569 +((($row['ngaysinh']- 25569) * 86400)/ 86400))- 25569)* 86400)),
            'gioitinh' => $row['gioitinh'],
            'dienthoai' => $row['dienthoai'],
            'email' => $row['email'],
            'lop' => $row['lop'],
            'cmnd' => $row['cmnd'],
            'hokhau' => $row['hokhau'],
            'tamtru' => $row['tamtru'],
            'hoten' => $row['hoten'],
        ]);
        $taikhoan = new taikhoan();
        $taikhoan->tendangnhap= $row['mssv'];
        $taikhoan->matkhau= Hash::make($row['mssv']);
        $taikhoan->ngaytao= date("Y-m-d H:i:s");
        $taikhoan->quyen= 2;
        $taikhoan->save();
        return $dssvImport;
    }
}
