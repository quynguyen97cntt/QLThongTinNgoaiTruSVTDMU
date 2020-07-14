<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\taikhoan;
use App\khunhatro;
use App\sinhvien;
use App\OTro;
use App\ngoaitru;
use App\dangnhap;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Hash;
use Session;
use DB;
class QLtaikhoan extends Controller
{
    //
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function DanhsachTK(){
        $pageSize=15;
        $taikhoan = taikhoan::orderBy('quyen','asc')->paginate($pageSize);
        $khunhatro = khunhatro::all();
        return view('pages.admin.QLTaiKhoan',['taikhoan'=>$taikhoan, 'pageSize'=>$pageSize],['khunhatro'=>$khunhatro]);
    }

    // Them TK
    public function ThemTK(Request $req){
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $taikhoan = new taikhoan();

            $taikhoan->tendangnhap = $req->tendangnhap;
            $taikhoan->matkhau = Hash::make($req->matkhau);
            $date = date("Y-m-d H:i:s", time());
            $taikhoan->ngaytao = $date;
            $taikhoan->quyen = $req->quyen;
            $taikhoan->save();
            if($taikhoan){
                Session::flash('success', 'Thêm thành công!');
            }else {
                Session::flash('error', 'Thêm thất bại!');
            }
            return redirect()->back();


    }

    public function SuaQuyenTK($id, $tendangnhap, Request $req){
        $taikhoan = taikhoan::find($id);
        if($taikhoan->quyen===1)
        {
            $sinhvien = sinhvien::find($tendangnhap);
            if($sinhvien != null)
            {
                $taikhoan->quyen = 2;
                $taikhoan->save();
                Session::flash('success', 'Đã thay đổi thành quyền Sinh viên thành công!');
                return redirect()->back();
            }
            else
            {
                Session::flash('error', 'Thất bại! Tài khoản không thuộc loại tài khoản sinh viên!');
                return redirect()->back();
            }
        }
        if($taikhoan->quyen===2)
        {
            $taikhoan->quyen = 1;
            $taikhoan->save();
            Session::flash('success', 'Ủy quyền Admin thành công!');
            return redirect()->back();
        }
        else
        {
            Session::flash('error', 'Không thể thay đổi quyền truy cập cho chủ nhà trọ!');
            return redirect()->back();
        }
    }

    public function KichHoatTK($id, $tendangnhap, Request $req){
        $taikhoan=taikhoan::find($id);
        $taikhoan->trangthai = 1;
        $taikhoan->save();
        if($taikhoan){
            Session::flash('success', 'Kích hoạt tài khoản thành công!');
            return redirect()->back();
        }
        else
        {
            Session::flash('error', 'Kích hoạt tài khoản thất bại!');
            return redirect()->back();
        }
    }

    public function KhoaTK($id, $tendangnhap, Request $req){
        $taikhoan=taikhoan::find($id);
        $taikhoan->trangthai = 0;
        $taikhoan->save();
        if($taikhoan){
            Session::flash('success', 'Khóa tài khoản thành công!');
            return redirect()->back();
        }
        else
        {
            Session::flash('error', 'Khóa tài khoản thất bại!');
            return redirect()->back();
        }
    }

    public function SuaTK($id,Request $req){
        $taikhoan = taikhoan::find($id);
        $taikhoan->matkhau = Hash::make($req->matkhau);
        $taikhoan->save();
        if ($taikhoan) {
		    Session::flash('success', 'Khôi phục mật khẩu thành công!');
        }else {
            Session::flash('error', 'Khôi phục mật khẩu thất bại!');
        }

        return redirect()->back();
    }

    public function XoaTK($id){

        $taikhoan = taikhoan::find($id);

        if($taikhoan ->quyen===0)
        {
            $khutro = khunhatro::where('gid','=',$taikhoan->tendangnhap)->get();
            $otro=OTro::where('makhutro','=',$taikhoan->tendangnhap)->get();
            if($khutro != null)
            {
                if($otro != null)
                {
                    DB::table('otro')->where('makhutro', '=', $taikhoan->tendangnhap)->delete();
                    khunhatro::destroy($taikhoan->tendangnhap);   
                    $xoataikhoan = taikhoan::destroy($id);
                    if ($xoataikhoan) 
                    {
                        Session::flash('success', 'Xóa tài khoản thành công!');
                    }
                    else 
                    {
                        Session::flash('error', 'Xóa thất bại!');
                    }
                }
                else
                {
                    khunhatro::destroy($khutro ->gid);   
                    $xoataikhoan = taikhoan::destroy($id);
                    if ($xoataikhoan) 
                    {
                        Session::flash('success', 'Xóa tài khoản thành công!');
                    }
                    else 
                    {
                        Session::flash('error', 'Xóa thất bại!');
                    }
                } 
            }
            else
            {
                $xoataikhoan = taikhoan::destroy($id);
                    if ($xoataikhoan) 
                    {
                        Session::flash('success', 'Xóa tài khoản thành công!');
                    }
                    else 
                    {
                        Session::flash('error', 'Xóa thất bại!');
                    }
            }
        }
        elseif($taikhoan ->quyen===2)
        {
            $sinhvien = sinhvien::find($taikhoan ->tendangnhap);
            $otro=OTro::where('mssv',$sinhvien ->mssv)->get();
            $ngoaitru=ngoaitru::where('mssv',$sinhvien ->mssv)->get();

            if($otro != null && $ngoaitru != null)
            {
                DB::table('otro')->where('mssv', '=', $sinhvien ->mssv)->delete();
                ngoaitru::destroy($sinhvien ->mssv);
                sinhvien::destroy($sinhvien ->mssv);
                $xoataikhoan = taikhoan::destroy($id);
                if ($xoataikhoan) 
                {
                    Session::flash('success', 'Xóa tài khoản thành công!');
                }
                else 
                {
                    Session::flash('error', 'Xóa thất bại!');
                }
            }
            elseif($otro != null && $ngoaitru == null)
            {
                DB::table('otro')->where('mssv', '=', $sinhvien ->mssv)->delete();
                sinhvien::destroy($sinhvien ->mssv);
                $xoataikhoan = taikhoan::destroy($id);
                if ($xoataikhoan) 
                {
                    Session::flash('success', 'Xóa tài khoản thành công!');
                }
                else 
                {
                    Session::flash('error', 'Xóa thất bại!');
                }
            } 
            elseif($otro == null && $ngoaitru != null)
            {
                ngoaitru::destroy($sinhvien ->mssv);
                sinhvien::destroy($sinhvien ->mssv);
                $xoataikhoan = taikhoan::destroy($id);
                if ($xoataikhoan) 
                {
                    Session::flash('success', 'Xóa tài khoản thành công!');
                }
                else 
                {
                    Session::flash('error', 'Xóa thất bại!');
                }
            }
            else
            {
                sinhvien::destroy($sinhvien ->mssv);
                $xoataikhoan = taikhoan::destroy($id);
                if ($xoataikhoan) 
                {
                    Session::flash('success', 'Xóa tài khoản thành công!');
                }
                else 
                {
                    Session::flash('error', 'Xóa thất bại!');
                }
            } 
        }
        else
        {
            $xoataikhoan = taikhoan::destroy($id);
            if ($xoataikhoan) 
            {
                Session::flash('success', 'Xóa tài khoản thành công!');
            }
            else 
            {
                Session::flash('error', 'Xóa thất bại!');
            }
        }
        return redirect()->back();
    }

    public function TrangDoiMatKhau(){
        return view('pages.user.changepassword');
    }

    //tìm kiếm theo tendangnhap
    public function search(Request $req){
        $pageSize = 15;
        $search = $req->get('timkiemtk');
        $taikhoan= taikhoan::where('tendangnhap', '=', $search)->orderBy('quyen','asc')->paginate($pageSize);
        $khunhatro = khunhatro::all();
        return view('pages.admin.QLTaiKhoan',['taikhoan'=>$taikhoan, 'pageSize'=>$pageSize],['khunhatro'=>$khunhatro]);   
    }

    public function DoiMatKhau(Request $req){
        $tentaikhoan = session('tendn');
        $matkhaucu = $req->matkhaucu;
        $matkhaumoi = $req->matkhaumoi;
        $xacnhanmatkhaumoi = $req->xacnhanmatkhaumoi;
        $danhsachtaikhoan = taikhoan::all();
        foreach($danhsachtaikhoan as $item){
            if($item->tendangnhap == $tentaikhoan)
                $taikhoan = $item;
        }
        if($taikhoan!= null)
        {
            if(!Hash::check($matkhaumoi, $taikhoan->matkhau))
            {
                if(Hash::check($matkhaucu, $taikhoan->matkhau) && $matkhaumoi == $xacnhanmatkhaumoi)
                    {
                        $taikhoan->matkhau = Hash::make($matkhaumoi);
                        $taikhoan->save();
                        
                        session()->forget('tendn');
                        Session::flash('success', 'Đổi mật khẩu thành công!');
                        return redirect('./');
                    }
                else if($matkhaumoi != $xacnhanmatkhaumoi){
                    Session::flash('error', 'Mật khẩu mới và xác nhận mật khẩu mới không trùng nhau!');
                }
                else
                {
                    Session::flash('error', 'Mật khẩu cũ không hợp lệ!');
                }
                return redirect()->back();
            }
            else{
                Session::flash('error', 'Mật khẩu mới không được phép giống mật khẩu cũ!');
                return redirect()->back();
            }
        }
        else
            return ('pages.login');
    }

    public function DoiMatKhauAdmin(Request $req){
        $tentaikhoan = session('tenadmin');
        $matkhaucu = $req->matkhaucu;
        $matkhaumoi = $req->matkhaumoi;
        $xacnhanmatkhaumoi = $req->xacnhanmatkhaumoi;
        $danhsachtaikhoan = taikhoan::all();
        foreach($danhsachtaikhoan as $item){
            if($item->tendangnhap == $tentaikhoan)
                $taikhoan = $item;
        }
        if($taikhoan!= null)
        {
            if(!Hash::check($matkhaumoi, $taikhoan->matkhau))
            {
                if(Hash::check($matkhaucu, $taikhoan->matkhau) && $matkhaumoi == $xacnhanmatkhaumoi)
                    {
                        $taikhoan->matkhau = Hash::make($matkhaumoi);
                        $taikhoan->save();
                        
                        session()->forget('tenadmin');
                        Session::flash('success', 'Đổi mật khẩu thành công!');
                        return redirect('trang-quan-tri');
                    }
                else if($matkhaumoi != $xacnhanmatkhaumoi){
                    Session::flash('error', 'Mật khẩu mới và xác nhận mật khẩu mới không trùng nhau!');
                }
                else
                {
                    Session::flash('error', 'Mật khẩu cũ không hợp lệ!');
                }
                return redirect()->back();
            }
            else{
                Session::flash('error', 'Mật khẩu mới không được phép giống mật khẩu cũ!');
                return redirect()->back();
            }
        }
        else
            return ('pages.login');
    }

    public function login(Request $req){
        $tendangnhap=$req->inputEmail;
        $matkhau=$req->inputPassword;
        $dn=dangnhap::where('tendangnhap','=',$tendangnhap)->where('trangthai','=',1)->get();
        if($dn->count()>0)
        {
            foreach($dn as $lg)
            {
                if(Hash::check($matkhau, $lg->matkhau))
                {
                    if($lg->quyen==0)
                    {
                        session()->put('tendn',$lg->tendangnhap);
                        session()->put('quyenchutro',$lg->quyen);
                        session()->put('makhutro',$lg->tendangnhap);
                        $khutro=khunhatro::find($lg->tendangnhap);

                        session()->put('tennhatro',$khutro->tennhatro);
                        session()->put('tenchutro',$khutro->tenchutro);
                        session()->put('sodienthoai',$khutro->sodienthoai);
                        session()->put('giaphong',$khutro->giaphong);
                        session()->put('dien',$khutro->dien);
                        session()->put('nuoc',$khutro->nuoc);
                        session()->put('tienich',$khutro->tienich);
                        session()->put('songuoi',$khutro->soluong);
                        session()->put('trangthaiphong',$khutro->trangthai);
                        session()->put('diachi',$khutro->diachi);
                        return redirect('danh-sach-tro');
                    }
                    else if($lg->quyen==2)
                    {
                        session()->put('tendn',$lg->tendangnhap);
                        session()->put('quyensv',$lg->quyen);

                        $sinhvien=sinhvien::find($lg->tendangnhap);
                        session()->put('mssv',$sinhvien->mssv);
                        session()->put('hosv',$sinhvien->ho);
                        session()->put('tensv',$sinhvien->ten);
                        session()->put('email',$sinhvien->email);
                        session()->put('dienthoai',$sinhvien->dienthoai);
                        session()->put('diachi',$sinhvien->hokhau);
                        return redirect('/');
                    }
                    else if($lg->quyen==1)
                    {
                        session()->put('tenadmin',$lg->tendangnhap);
                        return redirect('trang-quan-tri');
                    }
                }
                else
                {
                    Session::flash('error', 'Mật khẩu không đúng!');
                    return redirect('login');
                }
            }
        }
        else
        {
            Session::flash('error', 'Tài khoản không tồn tại hoặc chưa kích hoạt!');
            return redirect('login');
        }
    }
    
    public function thoat(){
        if(session()->has('tendn'))
        {
            session()->forget('tendn');
        }
        if(session()->has('mssv'))
        {
            session()->forget('mssv');
        }
        if(session()->has('hosv'))
        {
            session()->forget('hosv');
        }
        if(session()->has('tensv'))
        {
            session()->forget('tensv');
        }
        if(session()->has('email'))
        {
            session()->forget('email');
        }
        if(session()->has('dienthoai'))
        {
            session()->forget('dienthoai');
        }
        if(session()->has('diachi'))
        {
            session()->forget('diachi');
        }
        if(session()->has('quyensv'))
        {
            session()->forget('quyensv');
        }

        if(session()->has('makhutro'))
        {
            session()->forget('makhutro');
        }
        if(session()->has('tennhatro'))
        {
            session()->forget('tennhatro');
        }
        if(session()->has('tenchutro'))
        {
            session()->forget('tenchutro');
        }
        if(session()->has('sodienthoai'))
        {
            session()->forget('sodienthoai');
        }
        if(session()->has('diachi'))
        {
            session()->forget('diachi');
        }
        if(session()->has('quyenchutro'))
        {
            session()->forget('quyenchutro');
        }

        return redirect('welcome');
    }
    public function thoatadmin(){
        session()->forget('tenadmin');
        return redirect('welcome');
    }
}
