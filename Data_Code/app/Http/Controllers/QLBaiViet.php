<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\baiviet;
use DB;
use App\khunhatro;
use App\dangnhap;
use App\sinhvien;
use App\OTro;
use App\taikhoan;
use App\anhbaiviet;
use App\anhtam;
use App\phuongxa;
use App\quanhuyen;
use App\tinhthanh;
use Session;
use Validator,Redirect,Response,File;

class QLBaiViet extends Controller
{
    //
    public function DsBaiViet(){
        session()->forget('teams');
        $pageSize = 15;
        $dsBaiViet=DB::table('baiviet')->join('phuongxa','baiviet.vitri','=','phuongxa.mapx')->orderBy('ngaytao', 'desc')->orderBy('trangthaiduyet', 'ASC')->paginate($pageSize);
        $anhbaiviet=DB::table('baiviet')->join('anhbaiviet','baiviet.id','=','anhbaiviet.mabaiviet')->select('anhbaiviet.name','anhbaiviet.mabaiviet')->get();
        return view('pages.admin.QLBaiViet',['dsBaiViet'=>$dsBaiViet, 'pageSize'=>$pageSize,'anhbaiviet'=>$anhbaiviet]);
    }

    public function SuaTrangThai(Request $req, $id){
        $baiviet = baiviet::find($id);
        if($req->trangthai ==2)
        {
            $baiviet->chuthich = $req->lydotuchoi;
            $baiviet->trangthaiduyet = $req->trangthai;
            $baiviet->save();
        }
        else
        {
            $baiviet->trangthaiduyet = $req->trangthai;
            $baiviet->save();
        }
        
        if($baiviet){
            Session::flash('success', 'Cập nhật trạng thái thành công!');
        }else {
		Session::flash('error', 'Cập nhật thất bại!');
	}
        return redirect()->back();
    }

    public function XoaBV(Request $req, $id){
        $anhbaiviet=anhbaiviet::where('mabaiviet',$id)->get();
        if($anhbaiviet)
        {
            DB::table('anhbaiviet')->where('mabaiviet',$id)->delete();
        }

        $baivietxoa=baiviet::destroy($id);
        if ($baivietxoa) {
		    Session::flash('success', 'Xóa bài viết thành công!');
        }else {
            Session::flash('error', 'Xóa thất bại!');
        }
        return redirect()->route('quan-ly-bai-viet');
    }

    public function BaiVietChuTro(Request $request){
        session()->forget('maphien');
        session()->put('maphien',uniqid());

        $checktemp=DB::table('anhtam')->where('maphien','!=',$request->session()->get('maphien'))->orWhere('idchutro','=',$request->session()->get('makhutro'))->get();
        if($checktemp)
        {
            DB::table('anhtam')->where('maphien','!=',$request->session()->get('maphien'))->orWhere('idchutro','=',$request->session()->get('makhutro'))->delete();
        }
        
        $pageSize = 10;
        $idkhutro = $request->session()->get('makhutro');
        $khunhatro = khunhatro::find($idkhutro);
        $anhtam = anhtam::all();
        $phuongxa = phuongxa::where('maquanhuyen','=',718)->get();

        $baiviet=DB::table('baiviet')->join('phuongxa','baiviet.vitri','=','phuongxa.mapx')->where('makhutro', $idkhutro)->orderBy('ngaytao', 'desc')->paginate($pageSize);
        $anhbaiviet=DB::table('baiviet')->join('anhbaiviet','baiviet.id','=','anhbaiviet.mabaiviet')->select('anhbaiviet.name','anhbaiviet.mabaiviet')->get();
        return view('pages.user.hostelposts',['pageSize'=>$pageSize,'baiviet'=>$baiviet, 'khunhatro'=>$khunhatro, 'anhtam'=>$anhtam, 'phuongxa'=>$phuongxa,'anhbaiviet'=>$anhbaiviet]);
    }

    //trang bai viet
    public function BaiViet(Request $request){
        $pageSize = 10;
        $dsBaiViet=DB::table('baiviet')->join('phuongxa','baiviet.vitri','=','phuongxa.mapx')->where('trangthaiduyet', 1)->orderBy('ngaytao', 'desc')->paginate($pageSize);
        $anhbaiviet=DB::table('baiviet')->join('anhbaiviet','baiviet.id','=','anhbaiviet.mabaiviet')->where('trangthaiduyet', 1)
        ->select('anhbaiviet.name','anhbaiviet.mabaiviet')->get();
        $dsKhuTro =khunhatro::all();

        return view('pages.user.posts',['dsBaiViet'=>$dsBaiViet,'dsKhuTro'=>$dsKhuTro, 'pageSize'=>$pageSize, 'anhbaiviet'=>$anhbaiviet]);
    }

    public function ChiTietBaiViet(Request $request){
        $pageSize = 10;
        $id = $request->id;
        $dsBaiViet=DB::table('baiviet')->join('phuongxa','baiviet.vitri','=','phuongxa.mapx')->where('trangthaiduyet', 1)->where('baiviet.id','=',$id)->orderBy('ngaytao', 'desc')->paginate($pageSize);
        $anhbaiviet=DB::table('baiviet')->join('anhbaiviet','baiviet.id','=','anhbaiviet.mabaiviet')->where('trangthaiduyet', 1)->where('baiviet.id','=',$id)
        ->select('anhbaiviet.name','anhbaiviet.mabaiviet')->get();
        $dsKhuTro =khunhatro::all();

        return view('pages.user.chitietbaiviet',['dsBaiViet'=>$dsBaiViet,'dsKhuTro'=>$dsKhuTro, 'pageSize'=>$pageSize, 'anhbaiviet'=>$anhbaiviet]);
    }

    public function GetAnhBaiViet(Request $request){
        $id = $request->idbaiviet;
        $anhbaiviet=DB::table('baiviet')->join('anhbaiviet','baiviet.id','=','anhbaiviet.mabaiviet')->where('trangthaiduyet', 1)->where('baiviet.id','=',$id)
        ->select('anhbaiviet.name','anhbaiviet.mabaiviet')->get();
        $soluong = $anhbaiviet->count();
        return response()->json(['anhbaiviet' => $anhbaiviet,'soluong' => $soluong]);
    }

    public function ThemBaiViet(Request $req)
    {
        $anhtam=DB::table('anhtam')->where('maphien','=',$req->session()->get('maphien'))->orWhere('idchutro','=',$req->session()->get('makhutro'))->get();
        $date = date("Y-m-d H:i:s");

        $baiviet = array(
            'tieude'  => $req->tieude,
            'noidung'   => $req->noidung,
            'ngaytao' => $date,
            'giaphong' => $req->giaphong,
            'vitri' => $req->vitri,
            'dienthoai' => $req->sdt,
            'diachi' => $req->diachi,
            'makhutro' => $req->session()->get('makhutro'),
            'trangthaiduyet' => 0
           );
        $getid = DB::table('baiviet')->insertGetId($baiviet);

        if($getid){
            $path = storage_path('tmp/uploads');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            if($anhtam)
            {
                foreach($anhtam as $temp)
                {
                    $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $temp->image));
                    $tmpFilePath=sys_get_temp_dir().'/'.uniqid(); 
                    file_put_contents($tmpFilePath, $image_data); 
                    $f = finfo_open();
                    $mime_type = finfo_buffer($f, $image_data, FILEINFO_MIME_TYPE);
                    //$imageName = $temp->name.'.'.str_replace("image/","",$mime_type);
                    $imageName = $temp->name;
                    File::move($tmpFilePath, public_path("images/$imageName"));

                    $anhbaiviet = new anhbaiviet();
                    $anhbaiviet->name = $imageName;
                    $anhbaiviet->mabaiviet = $getid;
                    $anhbaiviet->save();
                }

                DB::table('anhtam')->where('maphien','=',$req->session()->get('maphien'))->orWhere('idchutro','=',$req->session()->get('makhutro'))->delete();
            }
              
            Session::flash('success', 'Thêm thành công!');
        }
        else 
        {
            Session::flash('error', 'Thêm thất bại!');
        }
        return redirect()->back();

    }

    public function SuaBaiViet($id,Request $req)
    {
        $baiviet = baiviet::find($id);
        $baiviet->tieude= $req->tieude;
        $baiviet->noidung= $req->noidung;
        $baiviet->makhutro= $req->makhutro;

        $baiviet->save();
        if($baiviet){
            Session::flash('success', 'Cập nhật thành công!');
        }else {
            Session::flash('error', 'Cập nhật thất bại!');
        }
        return redirect()->back();
    }

    public function XoaBaiViet($id)
    {
        $baiviet = baiviet::destroy($id);
        if($baiviet){
            Session::flash('success', 'Xóa thành công!');
        }else {
            Session::flash('error', 'Xóa thất bại!');
        }
        return redirect()->back();
    }

    public function storeMedia(Request $request)
    {
        $path = storage_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');
        $i=0;
        $filename = [];
        $imagename = [];

        foreach ($request->file('file') as $image) {
            $name = uniqid() . '_' . trim($image->getClientOriginalName());
            $imgname = $image->getClientOriginalName();

            $imagedata = file_get_contents($image);
            $base64 = base64_encode($imagedata);
            //$image->move($path, $name);
            $anhtam = new anhtam();
            $anhtam->name = $name;
            $anhtam->idchutro = $request->session()->get('makhutro');
            $anhtam->maphien = $request->session()->get('maphien');
            $anhtam->image = $base64;
            $anhtam->save();
            
            $filename[$i]=$name;
            $imagename[$i]=$imgname;
            $i++;
        }
        return response()->json([
            'name'          => '',
            'original_name' => '',
            'imagename' => $imagename,
            'filename'          => $filename,
        ]);
    }


    public function destroy(Request $request)
    {
        $filename =  $request->get('filename');
        //Photo::where('photo_name',$filename)->delete();
        $path=storage_path('tmp/uploads/').$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;  
    }
}
