<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\phuong;
use App\khunhatro;
use DB;
use Hash;
use Session;
use Excel;
use App\CHarts\ChartTheoPhuong;
use Illuminate\Support\Collection;
use App\Exports\TKTheoPhuongExport;
use App\Exports\TKSVPhuongExport;
use App\Exports\TKTheoKhuTroExport;

class ThongKe extends Controller
{
    //
    public function ThongKeTheoPhuong(){
        $ds = DB::select('select phuong.gid, phuong.tenphuong, count(ST_Contains(phuong.geom, tro.geom)) as sl
        from vungranhgioiphuongtxtdm_region phuong join khunhatro_tdm_point tro
        on ST_Contains(phuong.geom, tro.geom)=True
        group by phuong.gid, phuong.tenphuong ORDER BY sl DESC');

        return view('pages.admin.ThongKeTheoPhuong',['ds'=>$ds]);
    }

    public function ThongKeTheoTro(){
        $ds2 = DB::select('select tro.gid, tro.tennhatro, tro.diachi, count(*) sl 
        from otro left join khunhatro_tdm_point tro on otro.makhutro=tro.gid where otro.ngaydi is null 
        group by tro.gid, tro.tennhatro ORDER BY sl DESC');
        return view('pages.admin.ThongKeTheoChuTro',['ds2'=>$ds2]);
    }

    public function ThongKeSinhVienPhuong(){
        $ds2 = DB::select('select phuong.gid, phuong.tenphuong, count(ST_Contains(phuong.geom, tro.geom)) as sl
        from vungranhgioiphuongtxtdm_region phuong join ngoaitru tro
        on ST_Contains(phuong.geom, tro.geom)=True
        group by phuong.gid, phuong.tenphuong ORDER BY sl DESC');
        return view('pages.admin.ThongKeSVPhuong',['ds'=>$ds2]);
    }

    public function xuattktheophuong() 
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new TKTheoPhuongExport, 'Thong_Ke_Nha_Tro_Theo_Phuong.xlsx');
    }

    public function xuattktheokhutro() 
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new TKTheoKhuTroExport, 'Thong_Ke_Sinh_Vien_Theo_Khu_Tro.xlsx');
    }

    public function xuattksvphuong() 
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new TKSVPhuongExport, 'Thong_Ke_Sinh_Vien_Theo_Phuong.xlsx');
    }
}
