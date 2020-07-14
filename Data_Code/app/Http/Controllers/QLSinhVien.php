<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\sinhvien;
use App\ngoaitru;
use App\taikhoan;
use App\thoigian;
use App\OTro;
use App\lop;
use Session;
use DB;
use Excel;
use App\Exports\StudentsExport;
use App\Imports\StudentsImport;

class QLSinhVien extends Controller
{

    public function DanhsachSV(){
        session()->forget('timkiemtheolop');
        $pageSize = 15;
        $student = sinhvien::orderBy('lop','asc')->paginate($pageSize);
        $lop = lop::all();

        return view('pages.admin.QLThongTinSV',['student'=>$student, 'pageSize'=>$pageSize, 'lop'=>$lop]);
    }

    public function ThemSV(Request $req){
        $student = new sinhvien();

        $student->mssv = $req->mssv;
        $student->ho = $req->ho;
        $student->ten = $req->ten;
        $student->ngaysinh = $req->ngaysinh;
        $student->gioitinh = $req->gioitinh;
        $student->dienthoai = $req->dienthoai;
        $student->email = $req->email;
        $student->lop = $req->lop;
        $student->hokhau = $req->diachi;
        $student->tamtru = $req->tamtru;

        $student->save();

        if($student)
        {
            Session::flash('success', 'Thêm sinh viên thành công!');
        }
        else 
        {
		    Session::flash('error', 'Thêm thất bại!');
	    }
        return redirect()->route('danhsachSV');
    }
    public function SuaSV($mssv,Request $req){
        $student = sinhvien::find($mssv);
        $student->mssv = $req->mssv;
        $student->ho = $req->ho;
        $student->ten = $req->ten;
        $student->ngaysinh = $req->ngaysinh;
        $student->gioitinh = $req->gioitinh;
        $student->dienthoai = $req->dienthoai;
        $student->email = $req->email;
        $student->lop = $req->lop;
        $student->hokhau = $req->diachi;
        $student->tamtru = $req->tamtru;

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

    //tìm kiếm theo mssv, tensv
    public function search(Request $req){
        $lop = lop::all();
        $pageSize = 15;
        $search = $req->get('timkiemsv');
        if($search===null){
            if($req->session()->get('timkiemtheolop')==='D16HT01' ||
             $req->session()->get('timkiemtheolop')==='D16PM01' || $req->session()->get('timkiemtheolop')==='D16PM02')
            {
                $student= sinhvien::where('lop', '=', $req->session()->get('timkiemtheolop'))->paginate($pageSize);
                return view('pages.admin.QLThongTinSV',['student'=>$student, 'pageSize'=>$pageSize, 'lop'=>$lop]);
            }
            else
            {
                $student= sinhvien::where('ten', '=', $req->session()->get('timkiemtheolop'))->paginate($pageSize);
                return view('pages.admin.QLThongTinSV',['student'=>$student, 'pageSize'=>$pageSize, 'lop'=>$lop]);
            }    
        }
        else
        {
            session()->put('timkiemtheolop', $search);
            $student= sinhvien::where('mssv', '=', $search)->orWhere('ten', 'LIKE', "%$search%")->orWhere('lop', '=', $search)->paginate($pageSize);
            return view('pages.admin.QLThongTinSV',['student'=>$student, 'pageSize'=>$pageSize, 'lop'=>$lop]);
        }
        
    }

    public function XoaSV($mssv){
        $otro=DB::table('otro')->where('mssv', '=', $mssv)->get();
        $ngoaitru=DB::table('ngoaitru')->where('mssv', '=', $mssv)->get();
        $taikhoan=DB::table('taikhoan')->where('tendangnhap', '=', $mssv)->get();
        if(($otro->count())>0)
        {
            DB::table('otro')->where('mssv', '=', $mssv)->delete();
        }
        if(($ngoaitru->count())>0)
        {
            DB::table('ngoaitru')->where('mssv', '=', $mssv)->delete();
        }
        if(($taikhoan->count())>0)
        {
            DB::table('taikhoan')->where('tendangnhap', '=', $mssv)->delete();
        }

        $student=sinhvien::destroy($mssv);
        if($student)
        {
            Session::flash('success', 'Xoá sinh viên thành công!');
        }else 
        {
		    Session::flash('error', 'Xoá thất bại!');
	    }
        return redirect()->back();
    }

    public function xoasinhvientheolop(Request $req) 
    {
        $sinhvien=DB::table('sinhvien')->where('lop', '=', $req->xoasvlop)->get();
        if(($sinhvien->count())>0)
        {
            foreach($sinhvien as $sv)
            {
                $otro=DB::table('otro')->where('mssv', '=', $sv ->mssv)->get();
                $ngoaitru=DB::table('ngoaitru')->where('mssv', '=', $sv ->mssv)->get();
                $taikhoan=DB::table('taikhoan')->where('tendangnhap', '=', $sv ->mssv)->get();
                if(($otro->count())>0)
                {
                    DB::table('otro')->where('mssv', '=', $sv ->mssv)->delete();
                }
                if(($ngoaitru->count())>0)
                {
                    DB::table('ngoaitru')->where('mssv', '=', $sv ->mssv)->delete();
                }
                if(($taikhoan->count())>0)
                {
                    DB::table('taikhoan')->where('tendangnhap', '=', $sv ->mssv)->delete();
                }
            }
            $kq = DB::table('sinhvien')->where('lop', '=', $req->xoasvlop)->delete();
            if($kq)
            {
                Session::flash('success', 'Xoá sinh viên lớp '.$req->xoasvlop.' thành công!');
                return redirect()->back();
            }
            else
            {
                Session::flash('error', 'Xoá sinh viên lớp '.$req->xoasvlop.' thất bại!');
                return redirect()->back();
            }
        }
        else
        {
            Session::flash('error', 'Xoá sinh viên lớp '.$req->xoasvlop.' thất bại! Không có sinh viên nào trong lớp đã chọn!');
            return redirect()->back();
        }
    }

    public function xoatatcasinhvien() 
    {
        $sinhvien=DB::table('sinhvien')->get();
        if(($sinhvien->count())>0)
        {
            foreach($sinhvien as $sv)
            {
                $otro=DB::table('otro')->where('mssv', '=', $sv ->mssv)->get();
                $ngoaitru=DB::table('ngoaitru')->where('mssv', '=', $sv ->mssv)->get();
                $taikhoan=DB::table('taikhoan')->where('tendangnhap', '=', $sv ->mssv)->get();
                if(($otro->count())>0)
                {
                    DB::table('otro')->where('mssv', '=', $sv ->mssv)->delete();
                }
                if(($ngoaitru->count())>0)
                {
                    DB::table('ngoaitru')->where('mssv', '=', $sv ->mssv)->delete();
                }
                if(($taikhoan->count())>0)
                {
                    DB::table('taikhoan')->where('tendangnhap', '=', $sv ->mssv)->delete();
                }
            }
            $kq = DB::table('sinhvien')->delete();
            if($kq)
            {
                Session::flash('success', 'Xoá tất cả sinh viên thành công!');
                return redirect()->back();
            }
            else
            {
                Session::flash('error', 'Xoá tất cả sinh viên thất bại!');
                return redirect()->back();
            }
        }
        else
        {
            Session::flash('error', 'Xoá tất cả sinh viên thất bại! Không có sinh viên nào trong danh sách!');
            return redirect()->back();
        }
    }

    public function export() 
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new StudentsExport, 'DanhSachSVTamTru_TDMU.xlsx');
    }
   
    public function import(Request $request) 
    {
        if($request->hasFile('file'))
        {
            $post_file = $request->file('file');
            if($post_file->getClientOriginalExtension('file')==='xlsx' ||
            $post_file->getClientOriginalExtension('file')==='xls' || $post_file->getClientOriginalExtension('file')==='csv')
            {
                Session::flash('success', 'Nhập danh sách sinh viên thành công!');
                Excel::import(new StudentsImport,request()->file('file'));
                return redirect()->back();
            }
            else
            {
                Session::flash('error', 'Loại file đã chọn không đúng. Hỗ trợ định dạng *.xlsx, xls và csv');
                return redirect()->back();
            }
        }
        else
        {
            Session::flash('error', 'Chưa chọn file!');
            return redirect()->back();
        }
           
        
    }
}
