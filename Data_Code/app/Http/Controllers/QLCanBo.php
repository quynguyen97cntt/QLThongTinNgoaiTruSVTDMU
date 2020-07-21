<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\sinhvien;
use App\ngoaitru;
use App\taikhoan;
use App\thoigian;
use App\OTro;
use App\lop;
use App\canbo;
use App\khoa;
use App\ctdaotao;
use Session;
use DB;
use Excel;

class QLCanBo extends Controller
{
    public function DanhsachCB(){
        session()->forget('timkiemcanbo');
        $pageSize = 15;
        $canbo = canbo::orderBy('CTDaoTao','asc')->paginate($pageSize);
        $khoa = khoa::all();
        $ctdaotao = ctdaotao::all();
        $tongsl = canbo::all()->count();

        return view('pages.admin.QLThongTinCB',['canbo'=>$canbo, 'pageSize'=>$pageSize, 'khoa'=>$khoa, 'ctdaotao'=>$ctdaotao, 'tongsl'=>$tongsl]);
    }

    public function XoaCanBo(Request $req)
    {
        $id = $req->id;
        $canbo = canbo::destroy($id);
        if($canbo)
        {
            Session::flash('success', 'Xoá thông tin cán bộ thành công!');
        }else 
        {
		    Session::flash('error', 'Xoá thông tin cán bộ thất bại!');
	    }
        return redirect()->back();
    }

    public function ThemCanBo(Request $req){
        $id = $req->id;
        $hoten = $req->hoten;
        $gioitinh = $req->gioitinh;
        $ngaysinh = $req->ngaysinh;
        $sodienthoai = $req->sodienthoai;
        $email = $req->email;
        $cmnd = $req->cmnd;
        $diachi = $req->diachi;
        $idKhoa = $req->idKhoa;
        $CTDaoTao = $req->CTDaoTao;

        $canbo = new canbo();
        $canbo->id = $id;
        $canbo->hoten = $hoten;
        $canbo->gioitinh = $gioitinh;
        $canbo->ngaysinh = $ngaysinh;
        $canbo->sodienthoai = $sodienthoai ;
        $canbo->email = $email;
        $canbo->cmnd = $cmnd;
        $canbo->diachi = $diachi;
        $canbo->idKhoa = $idKhoa;
        $canbo->CTDaoTao = $CTDaoTao;
        $canbo->save();

        if($canbo)
        {
            Session::flash('success', 'Thêm thông báo thành công!');
        }
        else 
        {
		    Session::flash('error', 'Thêm thông báo thất bại!');
	    }
        return redirect()->back();
    }

    public function SuaTTCanBo(Request $req){

        $id = $req->id;
        $hoten = $req->hoten;
        $gioitinh = $req->gioitinh;
        $ngaysinh = $req->ngaysinh;
        $sodienthoai = $req->sodienthoai;
        $email = $req->email;
        $cmnd = $req->cmnd;
        $diachi = $req->diachi;
        $idKhoa = $req->idKhoa;
        $CTDaoTao = $req->CTDaoTao;

        $canbo = canbo::find($id);
        $canbo->hoten = $hoten;
        $canbo->gioitinh = $gioitinh;
        $canbo->ngaysinh = $ngaysinh;
        $canbo->sodienthoai = $sodienthoai ;
        $canbo->email = $email;
        $canbo->cmnd = $cmnd;
        $canbo->diachi = $diachi;
        $canbo->idKhoa = $idKhoa;
        $canbo->CTDaoTao = $CTDaoTao;
        $canbo->save();

        if($canbo)
        {
            Session::flash('success', 'Cập nhật thông tin cán bộ thành công!');
        }
        else 
        {
		    Session::flash('error', 'Cập nhật thông tin cán bộ thất bại!');
	    }
        return redirect()->back();
    }

    //tìm kiếm theo mã hoặc tên cán bộ
    public function search(Request $req){
        $khoa = khoa::all();
        $ctdaotao = ctdaotao::all();

        $pageSize = 15;
        $search = $req->get('timkiemcb');
        if($search===null){    
            $canbo = canbo::where('id', '=', $req->session()->get('timkiemcanbo'))->orWhere('hoten', 'LIKE', "%$req->session()->get('timkiemcanbo')%")->orderBy('CTDaoTao','asc')->paginate($pageSize);
            $tongsl = $canbo->count();
            return view('pages.admin.QLThongTinCB',['canbo'=>$canbo, 'pageSize'=>$pageSize, 'khoa'=>$khoa, 'ctdaotao'=>$ctdaotao, 'tongsl'=>$tongsl]);
        }
        else
        {
            session()->put('timkiemcanbo', $search);
            $canbo = canbo::where('id', '=', $search)->orWhere('hoten', 'LIKE', "%$search%")->orderBy('CTDaoTao','asc')->paginate($pageSize);
            $tongsl = $canbo->count();
            return view('pages.admin.QLThongTinCB',['canbo'=>$canbo, 'pageSize'=>$pageSize, 'khoa'=>$khoa, 'ctdaotao'=>$ctdaotao, 'tongsl'=>$tongsl]);
        }
        
    }

    public function TTGiangVien(Request $req){
        return view('pages.user.thongtingiangvien');
    }
    
    public function TraCuuTTGiangVien(Request $req){
        $search = $req->timkiemcb;
        if($search===null){    
            $canbo = canbo::where('hoten', 'LIKE', "%$req->session()->get('timkiemcanbo')%")->orderBy('CTDaoTao','asc')->get();
            return Response($canbo);
        }
        else
        {
            session()->put('timkiemcanbo', $search);
            $canbo = canbo::where('hoten', 'LIKE', "%$search%")->orderBy('CTDaoTao','asc')->get();
            return Response($canbo);
        }
    }
}
