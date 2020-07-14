<?php

namespace App\Http\Controllers;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Otro;
use App\baiviet;
use App\khunhatro;
use App\sinhvien;
use App\taikhoan;
use App\ngoaitru;
use App\lop;
use App\phuongxa;
use App\phuong;
use App\thoigian;
use Session;
use Hash;
class QLOTro extends Controller
{
 
    public function DsOtro(Request $req){
        $pageSize = 4;
        $dsOTro=DB::table('otro')->where('mssv', $req->getmssv)->join('khunhatro_tdm_point', 'otro.makhutro', '=', 'khunhatro_tdm_point.gid')->paginate($pageSize);
        $student = sinhvien::find($req->getmssv);

        return view('pages.admin.ThongTinTro',['dsOTro'=>$dsOTro, 'pageSize'=>$pageSize, 'student'=>$student]);
    }

    public function DSSVTro(Request $req)
    {
        $pageSize = 4;
        $idkhutro = $request->session()->get('makhutro');
        $SVOTro=DB::table('otro')->where('makhutro', $idkhutro, 'ngaydi', )->join('khunhatro_tdm_point', 'otro.makhutro', '=', 'khunhatro_tdm_point.gid')->paginate($pageSize);
        $SVOTro = OTro::paginate($pageSize);
        return view('pages.user.hostel',['SVOTro'=>$SVOTro, 'pageSize'=>$pageSize]);
    }

    public function ThemDSSVTro(Request $req)
    {
        if(sinhvien::where('cmnd', '=', $req->cmnd)->count()>0)
        {
            $sv= sinhvien::where('cmnd', '=', $req->cmnd)->first();
            $Otro = new OTro();
            $Otro->mssv = $sv->mssv;
            $Otro->ngayden = $req->ngayden;
            $Otro->makhutro = $req->session()->get('makhutro');
            $Otro->sophong = $req->sophong;

            $Otro->save();
            if($Otro){
                Session::flash('success', 'Thêm thành công!');
            }else {
                Session::flash('error', 'Thêm thất bại!');
            }
        }
        else
        {
            Session::flash('error', 'Sinh viên không tồn tại!');
        }
        
        return redirect()->back();
    }

    public function SuaDSSVTro($id,Request $req)
    {
        $Otro = OTro::find($id);
        $Otro->mssv=$req->mssv;
        $Otro->ngayden=$req->ngayden;
        $Otro->ngaydi=$req->ngaydi;
        $Otro->makhutro = $req->session()->get('makhutro');
        $Otro->sophong=$req->sophong;

        $Otro->save();
        if($Otro){
            Session::flash('success', 'Cập nhật thành công!');
        }else {
            Session::flash('error', 'Cập nhật thất bại!');
        }
        return redirect()->back();
    }

    public function XoaDSSVTro($id)
    {
        $OTro = OTro::destroy($id);
        if($OTro){
            Session::flash('success', 'Xóa thành công!');
        }else {
            Session::flash('error', 'Xóa thất bại!');
        }
        return redirect()->back();
    }

    public function SuaTTChuTro($gid,Request $req)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("Y-m-d H:i:s");
        $khutro = khunhatro::find($gid);
        $khutro->tennhatro = $req->tennhatro;
        $khutro->tenchutro = $req->tenchutro;
        $khutro->sodienthoai = $req->sodienthoai;
        $khutro->giaphong = $req->giaphong;
        $khutro->dien = $req->dien;
        $khutro->nuoc = $req->nuoc;
        $khutro->tienich = $req->tienich;
        $khutro->soluong = $req->songuoi;
        $khutro->trangthai = $req->trangthaiphong;
        $khutro->diachi = $req->diachi;
        $khutro->capnhatlancuoi = $date;
        $khutro->save();

        $khutrocapnhat=khunhatro::find($gid);
        session()->put('tennhatro',$khutrocapnhat->tennhatro);
        session()->put('tenchutro',$khutrocapnhat->tenchutro);
        session()->put('sodienthoai',$khutrocapnhat->sodienthoai);
        session()->put('diachi',$khutrocapnhat->diachi);
        session()->put('giaphong',$khutrocapnhat->giaphong);
        session()->put('dien',$khutrocapnhat->dien);
        session()->put('nuoc',$khutrocapnhat->nuoc);
        session()->put('tienich',$khutrocapnhat->tienich);
        session()->put('songuoi',$khutrocapnhat->soluong);
        session()->put('trangthaiphong',$khutrocapnhat->trangthai);

        return redirect()->back()->with('alert', 'Sửa thành công!');
    }

    public function SuaTTSinhVien($mssv,Request $req)
    {
        $sinhvien = sinhvien::find($mssv);
        $sinhvien->dienthoai = $req->dienthoai;
        $sinhvien->email = $req->email;
        $sinhvien->save();

        $sinhviencapnhat=sinhvien::find($mssv);
        session()->put('mssv',$sinhviencapnhat->mssv);
        session()->put('email',$sinhviencapnhat->email);
        session()->put('dienthoai',$sinhviencapnhat->dienthoai);

        return redirect()->back()->with('alert', 'Sửa thành công!');
    }

    public function capnhatthongtinsv(Request $req)
    {
        $lop = lop::all();
        if($req->session()->get('mssv'))
        {
            $sinhvien=sinhvien::where('mssv','=',$req->session()->get('mssv'))->get();
            return view('pages.user.capnhatthongtinsv',['lop'=>$lop, 'sinhvien'=>$sinhvien]);
        }
        else
        {
            return view('login');
        }
    }

    public function capnhatTTSV($mssv, Request $req)
    {
        $lop = lop::all();
        if($req->session()->get('mssv'))
        {
            $student = sinhvien::find($mssv);
            $student->ho = $req->hosv;
            $student->ten = $req->tensv;
            $student->ngaysinh = $req->ngaysinh;
            $student->gioitinh = $req->gioitinh;
            $student->dienthoai = $req->dienthoai;
            $student->email = $req->email;
            $student->lop = $req->lop;
            $student->hokhau = $req->diachi;
            $student->noisinh = $req->noisinh;
            $student->cmnd = $req->cmnd;

            $student->save();
            if($student)
            {
                Session::flash('success', 'Cập nhật sinh viên thành công!');
            }
            else 
            {
                Session::flash('error', 'Cập nhật thất bại!');
            }
            return redirect()->back();
        }
        else
        {
            return view('login');
        }
    }
    
    //Quản lý sinh viên trọ (chủ trọ)
    public function SinhVienTro(Request $request){
        $pageSize = 10;
        $idkhutro = $request->session()->get('makhutro');
        $khunhatro = khunhatro::find($idkhutro);
        $SVOTro = DB::table('otro')->where('makhutro', $idkhutro)->whereNull('ngaydi')->join('khunhatro_tdm_point', 'otro.makhutro', '=', 'khunhatro_tdm_point.gid')->join('sinhvien', 'otro.mssv', '=', 'sinhvien.mssv')->join('lop', 'sinhvien.lop', '=', 'lop.malop')->paginate($pageSize);
        $select = DB::table('otro')->whereNull('ngaydi')->select('mssv');
        $DSSV = DB::table('sinhvien')->whereNotIn('mssv',$select)->get();
        return view('pages.user.hostelstudent',['SVOTro'=>$SVOTro, 'pageSize'=>$pageSize,'khunhatro'=>$khunhatro,'DSSV'=>$DSSV]);
    }

    public function TimKiemSVTro(Request $request){
        $pageSize = 25;
        $tukhoa = $request->timkiemsvtro;
        $idkhutro = $request->session()->get('makhutro');
        $khunhatro = khunhatro::find($idkhutro);
        $SVOTro = DB::table('otro')->where('makhutro', $idkhutro)->whereNull('ngaydi')->join('khunhatro_tdm_point', 'otro.makhutro', '=', 'khunhatro_tdm_point.gid')->join('sinhvien', 'otro.mssv', '=', 'sinhvien.mssv')->join('lop', 'sinhvien.lop', '=', 'lop.malop')->where('sinhvien.hoten','LIKE',"%$tukhoa")->paginate($pageSize);
        $select = DB::table('otro')->whereNull('ngaydi')->select('mssv');
        $DSSV = DB::table('sinhvien')->whereNotIn('mssv',$select)->get();
        return view('pages.user.hostelstudent',['SVOTro'=>$SVOTro, 'pageSize'=>$pageSize,'khunhatro'=>$khunhatro,'DSSV'=>$DSSV]);
    }

    public function ThongTinChuTro(Request $request){
        $pageSize = 1;
        $idkhutro = $request->session()->get('makhutro');
        $khunhatro = khunhatro::find($idkhutro);
        return view('pages.user.hostelinfo',['khunhatro'=>$khunhatro]);
    }
}
