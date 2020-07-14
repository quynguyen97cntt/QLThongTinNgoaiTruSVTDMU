<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\khunhatro;
use App\dangnhap;
use App\sinhvien;
use App\OTro;
use App\taikhoan;
use App\phuongxa;
use App\thongbao;
use App\phuong;
use App\thoigian;
use App\ngoaitru;
use DB;
use Hash;
use Session;
use Excel;

class QLThongBao extends Controller
{
    public function ThongBao(){ 
        $pageSize = 15;
        $DSThongBao = DB::table('thongbao')->orderBy('ngaydang','desc')->paginate($pageSize);
        return view('pages.user.thongbao',['DSThongBao'=>$DSThongBao, 'pageSize'=>$pageSize]);
    }

    public function QuanLyThongBao()
    {
        $pageSize = 15;
        $DSThongBao = DB::table('thongbao')->orderBy('ngaydang','desc')->paginate($pageSize);
        return view('pages.admin.QLThongBao',['DSThongBao'=>$DSThongBao, 'pageSize'=>$pageSize]);
    }

    public function ChiTietThongBao(Request $req)
    {
        $id = $req->id;
        $pageSize = 15;
        $DSThongBao = DB::table('thongbao')->where('id','=',$id)->orderBy('ngaydang','desc')->paginate($pageSize);
        return view('pages.user.chitietthongbao',['DSThongBao'=>$DSThongBao, 'pageSize'=>$pageSize]);
    }

    public function XoaThongBao(Request $req)
    {
        $id = $req->id;
        $thongbao = thongbao::destroy($id);
        if($thongbao)
        {
            Session::flash('success', 'Xoá thông báo thành công!');
        }else 
        {
		    Session::flash('error', 'Xoá thông báo thất bại!');
	    }
        return redirect()->back();
    }

    public function ThemThongBao(Request $req){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("Y-m-d H:i:s", time());

        $tieude = $req->tieude;
        $noidung = $req->noidung;
        $thongbao = new thongbao();
        $thongbao->tieude = $tieude;
        $thongbao->noidung = $noidung;
        $thongbao->ngaydang = $date;
        $thongbao->nguoidang = $req->session()->get('tenadmin');
        $thongbao->save();

        if($thongbao)
        {
            Session::flash('success', 'Thêm thông báo thành công!');
        }
        else 
        {
		    Session::flash('error', 'Thêm thông báo thất bại!');
	    }
        return redirect()->back();
    }

    public function SuaThongBao(Request $req){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("Y-m-d H:i:s", time());

        $id = $req->id;
        $tieude = $req->tieude;
        $noidung = $req->noidung;
        
        $thongbao = thongbao::find($id);
        $thongbao->tieude = $tieude;
        $thongbao->noidung = $noidung;
        $thongbao->ngaycapnhat = $date;
        $thongbao->nguoidang = $req->session()->get('tenadmin');
        $thongbao->save();

        if($thongbao)
        {
            Session::flash('success', 'Cập nhật thông báo thành công!');
        }
        else 
        {
		    Session::flash('error', 'Cập nhật thông báo thất bại!');
	    }
        return redirect()->back();
    }
}
