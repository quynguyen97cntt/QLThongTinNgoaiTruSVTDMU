<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\khunhatro;
use App\dangnhap;
use App\sinhvien;
use App\OTro;
use App\taikhoan;
use App\phuongxa;
use App\phuong;
use App\thoigian;
use App\ngoaitru;
use DB;
use Hash;
use Session;
use Excel;
use App\Exports\ChuaDKNgoaiTruExport;
use App\Exports\DaDKNgoaiTruExport;
use GuzzleHttp\Client;
use Spatie\Geocoder\Facades\Geocoder as GeocoderFacade;
use Spatie\Geocoder\Geocoder;

class QLNgoaiTru extends Controller
{
    public function QuanLyNgoaiTru(){
        session()->forget('sapxepngoaitru');
        session()->forget('timkiemngoaitru');
        session()->forget('ngaybatdauxuat');
        session()->forget('ngayketthucxuat');

        $output=[];
        $result=[];
        $phuongxa = phuong::select(["gid", "tenphuong", "fillColor", "color", "toadodiem", DB::raw("ST_AsGeoJSON(geom) AS geom")])->get();
        $arrNew =[];
        $toado = [];

        for($i=0; $i<$phuongxa->count(); $i++)
        {
            $output[$i] = $phuongxa[$i]->geom;
            $result[$i]=$output[$i]["coordinates"][0][0];
            
            $toado[$i]= "".json_encode($result[$i])."";
            $arrNew[$i]["gid"] = $phuongxa[$i]->gid;
            $arrNew[$i]["tenphuong"] = $phuongxa[$i]->tenphuong;
            $arrNew[$i]["fillColor"] = $phuongxa[$i]->fillColor;
            $arrNew[$i]["color"] = $phuongxa[$i]->color;
            $arrNew[$i]["toadodiem"] = $phuongxa[$i]->toadodiem;
            $arrNew[$i]["geom"] = $toado[$i];
        }

        $phuongxa = phuongxa::where('maquanhuyen','=',718)->get();

        $pageSize = 15;
        
        $ktratg=thoigian::where('loaiapdung', '=', 1)->get();
        $trangthai = 0;
        if($ktratg->count()>0)
        {
            $ngaybatdau ="";
            $ngayketthuc ="";
            foreach ($ktratg as $key) {
                $ngaybatdau = $key->ngaybatdau;
                $ngayketthuc = $key->ngayketthuc;
            }

            $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$ngaybatdau)->where('ngaydangky','<=',$ngayketthuc)->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 'loaicutru', 'ngaydangky', 'vido', 'kinhdo', 'sinhvien.lop', 'sinhvien.ho','sinhvien.ten', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();
            $trangthai = 1;
            return view('pages.admin.QLNgoaiTru',['TTNgoaitru'=>$TTNgoaitru, 'pageSize'=>$pageSize, 'trangthai'=>$trangthai, 'thoigian'=>$ktratg,'phuongxa'=>$arrNew]);
        }
        else
        {
            $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 'loaicutru', 'ngaydangky', 'vido', 'kinhdo', 'sinhvien.lop','sinhvien.ho','sinhvien.ten', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();
            $trangthai = 0;
            return view('pages.admin.QLNgoaiTru',['TTNgoaitru'=>$TTNgoaitru, 'pageSize'=>$pageSize, 'trangthai'=>$trangthai,'phuongxa'=>$arrNew]);
        }
        
        //$TTNgoaitru = ngoaitru::orderBy('lop','asc')->paginate($pageSize);
        
    }

    public function thietlapTG(Request $req){
        $ktratg=DB::table('thoigian')->where('thoigian.loaiapdung','=',1)->select('thoigian.id')->first();
        if($ktratg)
        {
            $thoigian = thoigian::find($ktratg->id);
            $thoigian->ngaybatdau = $req->ngaybatdau;
            $thoigian->ngayketthuc = $req->ngayketthuc;
            $thoigian->loaiapdung = 1;
            $thoigian->save();
            if($thoigian)
            {
                Session::flash('success', 'Thiết lập thành công!');
            }
            else 
            {
                Session::flash('error', 'Thiết lập thất bại!');
            }
        }
        else
        {
            $thoigian = new thoigian();
            $thoigian->ngaybatdau = $req->ngaybatdau;
            $thoigian->ngayketthuc = $req->ngayketthuc;
            $thoigian->loaiapdung = 1;
            $thoigian->save();
            if($thoigian)
            {
                Session::flash('success', 'Thiết lập thành công!');
            }
            else 
            {
                Session::flash('error', 'Thiết lập thất bại!');
            }
        }
        
        return redirect()->route('quanlyngoaitru');
    }

    public function xuatdkngoaitru(Request $request) 
    {
        if($request->ngaybatdauxuat == null || $request->ngayketthucxuat == null)
        {
            Session::flash('error', 'Vui lòng chọn ngày xuất!');
            return redirect()->back();
        }
        else
        {
            ob_end_clean();
            ob_start();
            return Excel::download(new DaDKNgoaiTruExport($request), 'DSSV_DK_NgoaiTru_TDMU.xlsx');
        }

        
    }

    public function xuatchuadkngoaitru(Request $request) 
    {
        if($request->ngaybatdauxuat == null || $request->ngayketthucxuat == null)
        {
            Session::flash('error', 'Vui lòng chọn ngày xuất!');
            return redirect()->back();
        }
        else
        {
            ob_end_clean();
            ob_start();
            return Excel::download(new ChuaDKNgoaiTruExport($request), 'DSSV_ChuaDK_NgoaiTru_TDMU.xlsx');
        }   
    }

    public function search(Request $req){
        $output=[];
        $result=[];
        $phuongxa = phuong::select(["gid", "tenphuong", "fillColor", "color", "toadodiem", DB::raw("ST_AsGeoJSON(geom) AS geom")])->get();
        $arrNew =[];
        $toado = [];

        for($i=0; $i<$phuongxa->count(); $i++)
        {
            $output[$i] = $phuongxa[$i]->geom;
            $result[$i]=$output[$i]["coordinates"][0][0];
            
            $toado[$i]= "".json_encode($result[$i])."";
            $arrNew[$i]["gid"] = $phuongxa[$i]->gid;
            $arrNew[$i]["tenphuong"] = $phuongxa[$i]->tenphuong;
            $arrNew[$i]["fillColor"] = $phuongxa[$i]->fillColor;
            $arrNew[$i]["color"] = $phuongxa[$i]->color;
            $arrNew[$i]["toadodiem"] = $phuongxa[$i]->toadodiem;
            $arrNew[$i]["geom"] = $toado[$i];
        }

        $phuongxa = phuongxa::where('maquanhuyen','=',718)->get();

        $pageSize = 15;
        $search = $req->get('timkiemngoaitru');

        $ktratg=thoigian::where('loaiapdung', '=', 1)->get();
        $trangthai = 0;
        if($ktratg->count()>0)
        {
            $ngaybatdau ="";
            $ngayketthuc ="";
            foreach ($ktratg as $key) {
                $ngaybatdau = $key->ngaybatdau;
                $ngayketthuc = $key->ngayketthuc;
            }

            
            $trangthai = 1;
            if($search===null){
                $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngoaitru.mssv', '=', $req->session()->get('timkiemngoaitru'))->orWhere('sinhvien.lop', '=', $req->session()->get('timkiemngoaitru'))->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 'loaicutru', 'ngaydangky', 'vido', 'kinhdo', 'sinhvien.lop', 'sinhvien.ho','sinhvien.ten', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();
                return view('pages.admin.QLNgoaiTru',['TTNgoaitru'=>$TTNgoaitru, 'pageSize'=>$pageSize, 'trangthai'=>$trangthai, 'thoigian'=>$ktratg,'phuongxa'=>$arrNew]);
            }
            else
            {
                session()->forget('timkiemngoaitru');

                session()->put('timkiemngoaitru', $search);
                $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngoaitru.mssv', '=', $search)->orWhere('lop', '=', $search)->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 'loaicutru', 'ngaydangky', 'vido', 'kinhdo', 'sinhvien.lop', 'sinhvien.ho','sinhvien.ten', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();
                return view('pages.admin.QLNgoaiTru',['TTNgoaitru'=>$TTNgoaitru, 'pageSize'=>$pageSize, 'trangthai'=>$trangthai, 'thoigian'=>$ktratg,'phuongxa'=>$arrNew]); 
            }
        }
        else
        {
            
            $trangthai = 0;
            if($search===null){
                $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngoaitru.mssv', '=', "%$req->session()->get('timkiemngoaitru')%")->orWhere('lop', '=', "%$req->session()->get('timkiemngoaitru')%")->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 'loaicutru', 'ngaydangky', 'vido', 'kinhdo', 'sinhvien.lop', 'sinhvien.ho','sinhvien.ten', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();
                return view('pages.admin.QLNgoaiTru',['TTNgoaitru'=>$TTNgoaitru, 'pageSize'=>$pageSize, 'trangthai'=>$trangthai,'phuongxa'=>$arrNew]);
            }
            else
            {
                session()->forget('timkiemngoaitru');

                session()->put('timkiemngoaitru', $search);
                $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngoaitru.mssv', '=', $search)->orWhere('lop', '=', $search)->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 'loaicutru', 'ngaydangky', 'vido', 'kinhdo', 'sinhvien.lop', 'sinhvien.ho','sinhvien.ten', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();
                return view('pages.admin.QLNgoaiTru',['TTNgoaitru'=>$TTNgoaitru, 'pageSize'=>$pageSize, 'trangthai'=>$trangthai,'phuongxa'=>$arrNew]);  
            }
            
        } 
    }

    public function sapxepngoaitru(Request $req){
        $pageSize = 15;
        
        $ktratg=thoigian::where('loaiapdung', '=', 1)->get();
        $trangthai = 0;
        if($ktratg->count()>0)
        {
            $ngaybatdau ="";
            $ngayketthuc ="";
            foreach ($ktratg as $key) {
                $ngaybatdau = $key->ngaybatdau;
                $ngayketthuc = $key->ngayketthuc;
            }

            if($req->cotsxnt === null)
            {
                if($req->session()->get('timkiemngoaitru') && !$req->session()->get('ngaybatdauxuat'))
                {
                    if($req->cotsxnt === 'lop')
                    {
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$ngaybatdau)->where('ngaydangky','<=',$ngayketthuc)->where('ngoaitru.mssv', '=', $req->session()->get('timkiemngoaitru'))->orWhere('sinhvien.lop', '=', $req->session()->get('timkiemngoaitru'))->orderBy('sinhvien.'.$req->session()->get('sapxepngoaitru').'','asc')->paginate($pageSize);
                    }
                    else
                    {
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$ngaybatdau)->where('ngaydangky','<=',$ngayketthuc)->where('ngoaitru.mssv', '=', $req->session()->get('timkiemngoaitru'))->orWhere('sinhvien.lop', '=', $req->session()->get('timkiemngoaitru'))->orderBy('ngoaitru.'.$req->session()->get('sapxepngoaitru').'','asc')->paginate($pageSize);
                    }
                }
                else if(!$req->session()->get('timkiemngoaitru') && $req->session()->get('ngaybatdauxuat'))
                {
                    if($req->cotsxnt === 'lop')
                    {
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$req->session()->get('ngaybatdauxuat'))->where('ngaydangky','<=',$req->session()->get('ngayketthucxuat'))->orderBy('sinhvien.'.$req->session()->get('sapxepngoaitru').'','asc')->paginate($pageSize);
                    }
                    else
                    {
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$req->session()->get('ngaybatdauxuat'))->where('ngaydangky','<=',$req->session()->get('ngayketthucxuat'))->orderBy('ngoaitru.'.$req->session()->get('sapxepngoaitru').'','asc')->paginate($pageSize);
                    }
                }
                else if(!$req->session()->get('timkiemngoaitru') && !$req->session()->get('ngaybatdauxuat'))
                {
                    if($req->cotsxnt === 'lop')
                    {
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$ngaybatdau)->where('ngaydangky','<=',$ngayketthuc)->orderBy('sinhvien.'.$req->session()->get('sapxepngoaitru').'','asc')->paginate($pageSize);
                    }
                    else
                    {
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$ngaybatdau)->where('ngaydangky','<=',$ngayketthuc)->orderBy('ngoaitru.'.$req->session()->get('sapxepngoaitru').'','asc')->paginate($pageSize);
                    }
                }
                else if($req->session()->get('timkiemngoaitru') && $req->session()->get('ngaybatdauxuat'))
                {
                    if($req->cotsxnt === 'lop')
                    {
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$req->session()->get('ngaybatdauxuat'))->where('ngaydangky','<=',$req->session()->get('ngayketthucxuat'))->where('ngoaitru.mssv', '=', $req->session()->get('timkiemngoaitru'))->orWhere('sinhvien.lop', '=', $req->session()->get('timkiemngoaitru'))->orderBy('sinhvien.'.$req->session()->get('sapxepngoaitru').'','asc')->paginate($pageSize);
                    }
                    else
                    {
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$req->session()->get('ngaybatdauxuat'))->where('ngaydangky','<=',$req->session()->get('ngayketthucxuat'))->where('ngoaitru.mssv', '=', $req->session()->get('timkiemngoaitru'))->orWhere('sinhvien.lop', '=', $req->session()->get('timkiemngoaitru'))->orderBy('ngoaitru.'.$req->session()->get('sapxepngoaitru').'','asc')->paginate($pageSize);
                    }
                }
            }
            else
            {
                if($req->session()->get('timkiemngoaitru') && !$req->session()->get('ngaybatdauxuat'))
                {
                    if($req->cotsxnt === 'lop')
                    {
                        session()->forget('sapxepngoaitru');

                        session()->put('sapxepngoaitru', $req->cotsxnt);
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$ngaybatdau)->where('ngaydangky','<=',$ngayketthuc)->where('ngoaitru.mssv', '=', $req->session()->get('timkiemngoaitru'))->orWhere('sinhvien.lop', '=', $req->session()->get('timkiemngoaitru'))->orderBy('sinhvien.'.$req->cotsxnt.'','asc')->paginate($pageSize);
                    }
                    else
                    {
                        session()->forget('sapxepngoaitru');

                        session()->put('sapxepngoaitru', $req->cotsxnt);
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$ngaybatdau)->where('ngaydangky','<=',$ngayketthuc)->where('ngoaitru.mssv', '=', $req->session()->get('timkiemngoaitru'))->orWhere('sinhvien.lop', '=', $req->session()->get('timkiemngoaitru'))->orderBy('ngoaitru.'.$req->cotsxnt.'','asc')->paginate($pageSize);
                    }
                }
                else if(!$req->session()->get('timkiemngoaitru') && $req->session()->get('ngaybatdauxuat'))
                {
                    if($req->cotsxnt === 'lop')
                    {
                        session()->forget('sapxepngoaitru');

                        session()->put('sapxepngoaitru', $req->cotsxnt);
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$req->session()->get('ngaybatdauxuat'))->where('ngaydangky','<=',$req->session()->get('ngayketthucxuat'))->orderBy('sinhvien.'.$req->cotsxnt.'','asc')->paginate($pageSize);
                    }
                    else
                    {
                        session()->forget('sapxepngoaitru');

                        session()->put('sapxepngoaitru', $req->cotsxnt);
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$req->session()->get('ngaybatdauxuat'))->where('ngaydangky','<=',$req->session()->get('ngayketthucxuat'))->orderBy('ngoaitru.'.$req->cotsxnt.'','asc')->paginate($pageSize);
                    }
                }
                else if(!$req->session()->get('timkiemngoaitru') && !$req->session()->get('ngaybatdauxuat'))
                {
                    if($req->cotsxnt === 'lop')
                    {
                        session()->forget('sapxepngoaitru');

                        session()->put('sapxepngoaitru', $req->cotsxnt);
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$ngaybatdau)->where('ngaydangky','<=',$ngayketthuc)->orderBy('sinhvien.'.$req->cotsxnt.'','asc')->paginate($pageSize);
                    }
                    else
                    {
                        session()->forget('sapxepngoaitru');

                        session()->put('sapxepngoaitru', $req->cotsxnt);
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$ngaybatdau)->where('ngaydangky','<=',$ngayketthuc)->orderBy('ngoaitru.'.$req->cotsxnt.'','asc')->paginate($pageSize);
                    }
                }
                else if($req->session()->get('timkiemngoaitru') && $req->session()->get('ngaybatdauxuat'))
                {
                    if($req->cotsxnt === 'lop')
                    {
                        session()->forget('sapxepngoaitru');

                        session()->put('sapxepngoaitru', $req->cotsxnt);
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$req->session()->get('ngaybatdauxuat'))->where('ngaydangky','<=',$req->session()->get('ngayketthucxuat'))->where('ngoaitru.mssv', '=', $req->session()->get('timkiemngoaitru'))->orWhere('sinhvien.lop', '=', $req->session()->get('timkiemngoaitru'))->orderBy('sinhvien.'.$req->cotsxnt.'','asc')->paginate($pageSize);
                    }
                    else
                    {
                        session()->forget('sapxepngoaitru');

                        session()->put('sapxepngoaitru', $req->cotsxnt);
                        $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$req->session()->get('ngaybatdauxuat'))->where('ngaydangky','<=',$req->session()->get('ngayketthucxuat'))->where('ngoaitru.mssv', '=', $req->session()->get('timkiemngoaitru'))->orWhere('sinhvien.lop', '=', $req->session()->get('timkiemngoaitru'))->orderBy('ngoaitru.'.$req->cotsxnt.'','asc')->paginate($pageSize);
                    }
                }
            }
            
            $trangthai = 1;
            return view('pages.admin.QLNgoaiTru',['TTNgoaitru'=>$TTNgoaitru, 'pageSize'=>$pageSize, 'trangthai'=>$trangthai, 'thoigian'=>$ktratg]);
        }
        else
        {
            if($req->cotsxnt === null)
            {
                if($req->cotsxnt === 'lop')
                {
                    $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->orderBy('sinhvien.'.$req->session()->get('sapxepngoaitru').'','asc')->paginate($pageSize);
                }
                else
                {
                    $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->orderBy('ngoaitru.'.$req->session()->get('sapxepngoaitru').'','asc')->paginate($pageSize);
                }
            }
            else
            {
                if($req->cotsxnt === 'lop')
                {
                    session()->forget('sapxepngoaitru');

                    session()->put('sapxepngoaitru', $req->cotsxnt);
                    $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->orderBy('sinhvien.'.$req->cotsxnt.'','asc')->paginate($pageSize);
                }
                else
                {
                    session()->forget('sapxepngoaitru');

                    session()->put('sapxepngoaitru', $req->cotsxnt);
                    $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->orderBy('ngoaitru.'.$req->cotsxnt.'','asc')->paginate($pageSize);
                }
            }
            

            $trangthai = 0;
            return view('pages.admin.QLNgoaiTru',['TTNgoaitru'=>$TTNgoaitru, 'pageSize'=>$pageSize, 'trangthai'=>$trangthai]);
        }
        
    }

    public function XemDSNgoaiTru(Request $req){

        $output=[];
        $result=[];
        $phuongxa = phuong::select(["gid", "tenphuong", "fillColor", "color", "toadodiem", DB::raw("ST_AsGeoJSON(geom) AS geom")])->get();
        $arrNew =[];
        $toado = [];

        for($i=0; $i<$phuongxa->count(); $i++)
        {
            $output[$i] = $phuongxa[$i]->geom;
            $result[$i]=$output[$i]["coordinates"][0][0];
            
            $toado[$i]= "".json_encode($result[$i])."";
            $arrNew[$i]["gid"] = $phuongxa[$i]->gid;
            $arrNew[$i]["tenphuong"] = $phuongxa[$i]->tenphuong;
            $arrNew[$i]["fillColor"] = $phuongxa[$i]->fillColor;
            $arrNew[$i]["color"] = $phuongxa[$i]->color;
            $arrNew[$i]["toadodiem"] = $phuongxa[$i]->toadodiem;
            $arrNew[$i]["geom"] = $toado[$i];
        }

        $phuongxa = phuongxa::where('maquanhuyen','=',718)->get();

        $pageSize = 15;
        
        $ktratg=thoigian::where('loaiapdung', '=', 1)->get();
        $trangthai = 0;
        if($ktratg->count()>0)
        {
            if($req->ngaybatdauxuat === null || $req->ngayketthucxuat === null)
            {
                $ngaybatdau =$req->ngaybatdauxuat;
                $ngayketthuc =$req->ngayketthucxuat;
                $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$req->session()->get('ngaybatdauxuat'))->where('ngaydangky','<=',$req->session()->get('ngayketthucxuat'))->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 'loaicutru', 'ngaydangky', 'vido', 'kinhdo', 'sinhvien.lop', 'sinhvien.ho','sinhvien.ten', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();
            }
            else
            {
                session()->forget('ngaybatdauxuat');
                session()->forget('ngayketthucxuat');

                session()->put('ngaybatdauxuat', $req->ngaybatdauxuat);
                session()->put('ngayketthucxuat', $req->ngayketthucxuat);
                $ngaybatdau =$req->ngaybatdauxuat;
                $ngayketthuc =$req->ngayketthucxuat;
                $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->where('ngaydangky','>=',$ngaybatdau)->where('ngaydangky','<=',$ngayketthuc)->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 'loaicutru', 'ngaydangky', 'vido', 'kinhdo', 'sinhvien.lop', 'sinhvien.ho','sinhvien.ten', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();
            }
            
            $trangthai = 1;
            return view('pages.admin.QLNgoaiTru',['TTNgoaitru'=>$TTNgoaitru, 'pageSize'=>$pageSize, 'trangthai'=>$trangthai, 'thoigian'=>$ktratg,'phuongxa'=>$arrNew]);
        }
        else
        {
            $TTNgoaitru = DB::table('ngoaitru')->join('sinhvien','ngoaitru.mssv','=','sinhvien.mssv')->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 'loaicutru', 'ngaydangky', 'vido', 'kinhdo', 'sinhvien.lop', 'sinhvien.ho','sinhvien.ten', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();
            $trangthai = 0;
            return view('pages.admin.QLNgoaiTru',['TTNgoaitru'=>$TTNgoaitru, 'pageSize'=>$pageSize, 'trangthai'=>$trangthai,'phuongxa'=>$arrNew]);
        }  
    }

    public function getTTChutro(Request $req)
    {
        $getkhutro = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->where('gid','=',$req->makhutro)->get();
        return response()->json(['ttNhatro' => $getkhutro]);
    }

    public function capnhatngoaitru(Request $req)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $ngayhientai= date("Y-m-d", time());
        $checkstudent = DB::table('otro')->where('mssv','=',$req->session()->get('mssv'))->get();
        $checktime = DB::table('thoigian')->where('loaiapdung','=',1)->where('ngaybatdau','<=',$ngayhientai)->where('ngayketthuc','>=',$ngayhientai)->get()->count();
        $output=[];
        $result=[];
        $phuongxa = phuong::select(["gid", "tenphuong", "fillColor", "color", "toadodiem", DB::raw("ST_AsGeoJSON(geom) AS geom")])->get();
        $arrNew =[];
        $toado = [];

        for($i=0; $i<$phuongxa->count(); $i++)
        {
            $output[$i] = $phuongxa[$i]->geom;
            $result[$i]=$output[$i]["coordinates"][0][0];
            
            $toado[$i]= "".json_encode($result[$i])."";
            $arrNew[$i]["gid"] = $phuongxa[$i]->gid;
            $arrNew[$i]["tenphuong"] = $phuongxa[$i]->tenphuong;
            $arrNew[$i]["fillColor"] = $phuongxa[$i]->fillColor;
            $arrNew[$i]["color"] = $phuongxa[$i]->color;
            $arrNew[$i]["toadodiem"] = $phuongxa[$i]->toadodiem;
            $arrNew[$i]["geom"] = $toado[$i];
        }

        $getallkhutro = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->get();
        $trangthai=0;
        $thuocnhatro=0;
        if($req->session()->get('mssv'))
        {
            if( $checktime>0)
            {
                if(($checkstudent->count()) > 0)
                {
                    $thuocnhatro=1;
                    $makhutro = $checkstudent[0]->makhutro;
                    $getkhutro = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->where('gid','=',$makhutro)->get();
                    $tracuungoaitru = DB::table('ngoaitru')->where('mssv','=',$req->session()->get('mssv'))->get();
                    if($tracuungoaitru->count()>0)
                    {
                        $trangthai=1;
                        return view('pages.user.capnhatngoaitru',['SVNgoaiTru'=>$tracuungoaitru,'trangthai'=>$trangthai,'phuongxa'=>$arrNew,'thuocnhatro'=>$thuocnhatro,'khutro'=>$getkhutro,'khutro2'=>$getallkhutro]);
                    }
                    else
                    {
                        $trangthai=0;
                        return view('pages.user.capnhatngoaitru',['trangthai'=>$trangthai,'phuongxa'=>$arrNew,'thuocnhatro'=>$thuocnhatro,'khutro'=>$getkhutro,'khutro2'=>$getallkhutro]);
                    }
                }
                else
                {
                    $thuocnhatro=0;
                    $tracuungoaitru = DB::table('ngoaitru')->where('mssv','=',$req->session()->get('mssv'))->get();
                    if($tracuungoaitru->count()>0)
                    {
                        $trangthai=1;
                        return view('pages.user.capnhatngoaitru',['SVNgoaiTru'=>$tracuungoaitru,'trangthai'=>$trangthai,'phuongxa'=>$arrNew,'thuocnhatro'=>$thuocnhatro,'khutro2'=>$getallkhutro]);
                    }
                    else
                    {
                        $trangthai=0;
                        return view('pages.user.capnhatngoaitru',['trangthai'=>$trangthai,'phuongxa'=>$arrNew,'thuocnhatro'=>$thuocnhatro,'khutro2'=>$getallkhutro]);
                    }
                }
            }
            else
            {
                $message = "Ngoài thời gian cập nhật thông tin ngoại trú!";
                echo "<script type='text/javascript'>alert('$message');</script>";
                echo "<script>window.location='./'</script>";
            }
        }
        else
        {
            return view('login');
        }
    }

    public function capnhatTTNgoaitruSV($mssv,Request $req)
    {
        $loaicutru = $req->loaicutru;
        if($req->has('dangonharieng'))
        {
            $loaicutru = $req->loaicutru;
        }
        else
        {
            $loaicutru = 1;
        }

        $tracuungoaitru = ngoaitru::find($mssv);
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        if($tracuungoaitru === null)
        {
            $ngoaitru = new ngoaitru();
            $ngoaitru->mssv= $mssv;
            $ngoaitru->tenchungoaitru= $req->tenchungoaitru;
            $ngoaitru->dienthoaichungoaitru = $req->dienthoaichungoaitru;
            $ngoaitru->diachingoaitru= $req->diachi;
            $ngoaitru->loaicutru= $loaicutru;
            $ngoaitru->vido = $req->vido;
            $ngoaitru->kinhdo = $req->kinhdo;
            $ngoaitru->geom = \DB::raw("ST_GeomFromText('POINT(".$req->kinhdo." ".$req->vido.")', 4326)");
            $ngoaitru->ngaydangky= date("Y-m-d H:i:s", time());
            //$ngoaitru->ngaydangky= $req->ngaydangky;
            $ngoaitru->save();
            if($ngoaitru){
                Session::flash('success', 'Cập nhật thành công!');
            }else {
                Session::flash('error', 'Cập nhật thất bại!');
            }
            return redirect()->back();
        }
        else
        {
            $tracuungoaitru->mssv= $mssv;
            $tracuungoaitru->tenchungoaitru= $req->tenchungoaitru;
            $tracuungoaitru->dienthoaichungoaitru = $req->dienthoaichungoaitru;
            $tracuungoaitru->diachingoaitru= $req->diachi;
            $tracuungoaitru->loaicutru= $loaicutru;
            $tracuungoaitru->vido= $req->vido;
            $tracuungoaitru->kinhdo= $req->kinhdo;
            $tracuungoaitru->geom = \DB::raw("ST_GeomFromText('POINT(".$req->kinhdo." ".$req->vido.")', 4326)");
            $tracuungoaitru->ngaydangky= date("Y-m-d H:i:s", time());
            //$tracuungoaitru->ngaydangky= $req->ngaydangky;
            $tracuungoaitru->save();
            if($tracuungoaitru){
                Session::flash('success', 'Cập nhật thành công!');
            }else {
                Session::flash('error', 'Cập nhật thất bại!');
            }
            return redirect()->back();
        }  
    }
}
