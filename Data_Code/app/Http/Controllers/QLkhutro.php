<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\khunhatro;
use App\khutrodaxoa;
use App\dangnhap;
use App\sinhvien;
use App\OTro;
use App\taikhoan;
use App\phuongxa;
use App\phuong;
use DB;
use Hash;
use Session;
use Excel;
use App\Exports\TestExport;
use App\Imports\TestImport;
use App\Exports\DSSVTroExport;
use App\Exports\KhuTroExport;
use App\Imports\KhuTroImport;
use GuzzleHttp\Client;
use Spatie\Geocoder\Facades\Geocoder as GeocoderFacade;
use Spatie\Geocoder\Geocoder;
use App\Mail\SendMailSignUp;
use App\Mail\KetQuaDuyet;
use App\Mail\TuChoiDuyet;
use Illuminate\Support\Facades\Mail;

class QLkhutro extends Controller
{
    public function NhaTroCoSVTC(Request $req){
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
            $lon = 106.6744565963745;
            $lat = 10.980469775348254;
            $sqlDistance = DB::raw("(3959 * acos( cos( radians($lat) ) 
            * cos( radians( ST_Y(geom) ) )  
            * cos( radians( ST_X(geom) ) - radians($lon) ) 
            + sin( radians($lat) ) 
            * sin( radians( ST_Y(geom) ) ) ) ) * 1.609344");

            $dsNhatro = DB::table('khunhatro_tdm_point')->join('otro', 'otro.makhutro', '=', 'khunhatro_tdm_point.gid')->whereNull('otro.ngaydi')->join('sinhvien', 'otro.mssv', '=', 'sinhvien.mssv')->select('gid', 'tienich', 'tennhatro', 'khunhatro_tdm_point.ho', 'khunhatro_tdm_point.ten', 'tenchutro', 'khunhatro_tdm_point.sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'khunhatro_tdm_point.diachi','capnhatlancuoi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('active','=',1)->where('daduyet','=',1)->get();
            $s = '';
            $s2 = '';
            foreach ($dsNhatro as $nhatro )
            {
                $s .= '{ "type": "Feature", "properties": { "marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "tennhatro": "'.$nhatro->tennhatro.'", "ten": "'.$nhatro->tenchutro.'","ngaycapnhat": "'.date('d-m-Y', strtotime($nhatro->capnhatlancuoi)).'", "tienich": "'.str_replace("\n","",$nhatro->tienich).'", "giaphong": "'.number_format($nhatro->giaphong).'", "dien": "'.number_format($nhatro->dien).'", "nuoc": "'.number_format($nhatro->nuoc).'", "soluong": "'.$nhatro->soluong.'", "x": "'.$nhatro->x.'", "y": "'.$nhatro->y.'", "trangthai": "'.$nhatro->trangthai.'", "dienthoai": "'.$nhatro->sodienthoai.'", "diachi": "'.$nhatro->diachi.'", "khoangcach": '.round($nhatro->distance,1).'}, "geometry": { "type": "Point", "coordinates": [ '.$nhatro->x.', '.$nhatro->y.' ] } },';
            }
            foreach ($arrNew as $px )
            {
                $s2 .= '{"type": "Feature", "properties": {"marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "gid": "'.$px['gid'].'", "fillColor": "'.$px['fillColor'].'", "color": "'.$px['color'].'", "tenphuong": "'.$px['tenphuong'].'" }, "geometry": { "type": "Polygon", "coordinates": [ '.$px['geom'].' ] } },';
            }
            return response()->json(['dsNhatro' => $dsNhatro, 'phuongxa' => $phuongxa, 'phuongxaload' => $arrNew, 'geojson' => $s, 'geojson2' => $s2], 200);
    }
    public function XemTheoLopTC(Request $req){
        if($req->lop === 'all')
        {
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
            $lon = 106.6744565963745;
            $lat = 10.980469775348254;
            $sqlDistance = DB::raw("(3959 * acos( cos( radians($lat) ) 
            * cos( radians( ST_Y(geom) ) )  
            * cos( radians( ST_X(geom) ) - radians($lon) ) 
            + sin( radians($lat) ) 
            * sin( radians( ST_Y(geom) ) ) ) ) * 1.609344");

            $dsNhatro = DB::table('khunhatro_tdm_point')->join('otro', 'otro.makhutro', '=', 'khunhatro_tdm_point.gid')->whereNull('otro.ngaydi')->join('sinhvien', 'otro.mssv', '=', 'sinhvien.mssv')->select('gid', 'tienich', 'tennhatro', 'khunhatro_tdm_point.ho', 'khunhatro_tdm_point.ten', 'tenchutro', 'khunhatro_tdm_point.sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'khunhatro_tdm_point.diachi','capnhatlancuoi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('active','=',1)->where('daduyet','=',1)->get();
            $s = '';
            $s2 = '';
            foreach ($dsNhatro as $nhatro )
            {
                $s .= '{ "type": "Feature", "properties": { "marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "tennhatro": "'.$nhatro->tennhatro.'", "ten": "'.$nhatro->tenchutro.'", "ngaycapnhat": "'.date('d-m-Y', strtotime($nhatro->capnhatlancuoi)).'","tienich": "'.str_replace("\n","",$nhatro->tienich).'", "giaphong": "'.number_format($nhatro->giaphong).'", "dien": "'.number_format($nhatro->dien).'", "nuoc": "'.number_format($nhatro->nuoc).'", "soluong": "'.$nhatro->soluong.'", "x": "'.$nhatro->x.'", "y": "'.$nhatro->y.'", "trangthai": "'.$nhatro->trangthai.'", "dienthoai": "'.$nhatro->sodienthoai.'", "diachi": "'.$nhatro->diachi.'", "khoangcach": '.round($nhatro->distance,1).'}, "geometry": { "type": "Point", "coordinates": [ '.$nhatro->x.', '.$nhatro->y.' ] } },';
            }
            foreach ($arrNew as $px )
            {
                $s2 .= '{"type": "Feature", "properties": {"marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "gid": "'.$px['gid'].'", "fillColor": "'.$px['fillColor'].'", "color": "'.$px['color'].'", "tenphuong": "'.$px['tenphuong'].'" }, "geometry": { "type": "Polygon", "coordinates": [ '.$px['geom'].' ] } },';
            }
            return response()->json(['dsNhatro' => $dsNhatro, 'phuongxa' => $phuongxa, 'phuongxaload' => $arrNew, 'geojson' => $s, 'geojson2' => $s2], 200);
        }
        else
        {
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
            $lon = 106.6744565963745;
            $lat = 10.980469775348254;
            $sqlDistance = DB::raw("(3959 * acos( cos( radians($lat) ) 
            * cos( radians( ST_Y(geom) ) )  
            * cos( radians( ST_X(geom) ) - radians($lon) ) 
            + sin( radians($lat) ) 
            * sin( radians( ST_Y(geom) ) ) ) ) * 1.609344");

            $dsNhatro = DB::table('khunhatro_tdm_point')->join('otro', 'otro.makhutro', '=', 'khunhatro_tdm_point.gid')->whereNull('otro.ngaydi')->join('sinhvien', 'otro.mssv', '=', 'sinhvien.mssv')->select('gid', 'tienich', 'tennhatro', 'khunhatro_tdm_point.ho', 'khunhatro_tdm_point.ten', 'tenchutro', 'khunhatro_tdm_point.sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'khunhatro_tdm_point.diachi','capnhatlancuoi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('active','=',1)->where('daduyet','=',1)->where('sinhvien.lop','=',$req->lop)->get();
            $s = '';
            $s2 = '';
            foreach ($dsNhatro as $nhatro )
            {
                $s .= '{ "type": "Feature", "properties": { "marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "tennhatro": "'.$nhatro->tennhatro.'", "ten": "'.$nhatro->tenchutro.'","ngaycapnhat": "'.date('d-m-Y', strtotime($nhatro->capnhatlancuoi)).'", "tienich": "'.str_replace("\n","",$nhatro->tienich).'", "giaphong": "'.number_format($nhatro->giaphong).'", "dien": "'.number_format($nhatro->dien).'", "nuoc": "'.number_format($nhatro->nuoc).'", "soluong": "'.$nhatro->soluong.'", "x": "'.$nhatro->x.'", "y": "'.$nhatro->y.'", "trangthai": "'.$nhatro->trangthai.'", "dienthoai": "'.$nhatro->sodienthoai.'", "diachi": "'.$nhatro->diachi.'", "khoangcach": '.round($nhatro->distance,1).'}, "geometry": { "type": "Point", "coordinates": [ '.$nhatro->x.', '.$nhatro->y.' ] } },';
            }
            foreach ($arrNew as $px )
            {
                $s2 .= '{"type": "Feature", "properties": {"marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "gid": "'.$px['gid'].'", "fillColor": "'.$px['fillColor'].'", "color": "'.$px['color'].'", "tenphuong": "'.$px['tenphuong'].'" }, "geometry": { "type": "Polygon", "coordinates": [ '.$px['geom'].' ] } },';
            }
            return response()->json(['dsNhatro' => $dsNhatro, 'phuongxa' => $phuongxa, 'phuongxaload' => $arrNew, 'geojson' => $s, 'geojson2' => $s2], 200);
        }
    }

    public function getDataIndex(Request $req){
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
            $lon = 106.6744565963745;
            $lat = 10.980469775348254;
            $sqlDistance = DB::raw("(3959 * acos( cos( radians($lat) ) 
            * cos( radians( ST_Y(geom) ) )  
            * cos( radians( ST_X(geom) ) - radians($lon) ) 
            + sin( radians($lat) ) 
            * sin( radians( ST_Y(geom) ) ) ) ) * 1.609344");

            $dsNhatro = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'khunhatro_tdm_point.ho', 'khunhatro_tdm_point.ten', 'tenchutro', 'khunhatro_tdm_point.sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'khunhatro_tdm_point.diachi','capnhatlancuoi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('active','=',1)->where('daduyet','=',1)->get();
            $s = '';
            $s2 = '';
            foreach ($dsNhatro as $nhatro )
            {
                $s .= '{ "type": "Feature", "properties": { "marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "tennhatro": "'.$nhatro->tennhatro.'", "ten": "'.$nhatro->tenchutro.'", "ngaycapnhat": "'.date('d-m-Y', strtotime($nhatro->capnhatlancuoi)).'","tienich": "'.str_replace("\n","",$nhatro->tienich).'", "giaphong": "'.number_format($nhatro->giaphong).'", "dien": "'.number_format($nhatro->dien).'", "nuoc": "'.number_format($nhatro->nuoc).'", "soluong": "'.$nhatro->soluong.'", "x": "'.$nhatro->x.'", "y": "'.$nhatro->y.'", "trangthai": "'.$nhatro->trangthai.'", "dienthoai": "'.$nhatro->sodienthoai.'", "diachi": "'.$nhatro->diachi.'", "khoangcach": '.round($nhatro->distance,1).'}, "geometry": { "type": "Point", "coordinates": [ '.$nhatro->x.', '.$nhatro->y.' ] } },';
            }
            foreach ($arrNew as $px )
            {
                $s2 .= '{"type": "Feature", "properties": {"marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "gid": "'.$px['gid'].'", "fillColor": "'.$px['fillColor'].'", "color": "'.$px['color'].'", "tenphuong": "'.$px['tenphuong'].'" }, "geometry": { "type": "Polygon", "coordinates": [ '.$px['geom'].' ] } },';
            }
            return response()->json(['dsNhatro' => $dsNhatro, 'phuongxa' => $phuongxa, 'phuongxaload' => $arrNew, 'geojson' => $s, 'geojson2' => $s2], 200);
    }

    public function TrangChinh(Request $req){
        if($req->session()->get('tenadmin'))
        {
            return redirect('trang-quan-tri');
        }
        else if($req->session()->get('quyenchutro') === 0)
        {
            return redirect('danh-sach-tro');
        }
        else if($req->session()->get('quyensv') === 2)
        {
            if(!$req->giaphong)
            {
                $output=[];
                $result=[];
                $phuongxa = phuong::select(["gid", "tenphuong", "fillColor", "color", DB::raw("ST_AsGeoJSON(geom) AS geom")])->get();
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
                    $arrNew[$i]["geom"] = $toado[$i];
                }

                $phuongxa = phuongxa::where('maquanhuyen','=',718)->get();
                $lon = 106.6744565963745;
                $lat = 10.980469775348254;
                $sqlDistance = DB::raw("(3959 * acos( cos( radians($lat) ) 
                * cos( radians( ST_Y(geom) ) )  
                * cos( radians( ST_X(geom) ) - radians($lon) ) 
                + sin( radians($lat) ) 
                * sin( radians( ST_Y(geom) ) ) ) ) * 1.609344");

                $dsNhatro = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi','capnhatlancuoi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('active','=',1)->where('daduyet','=',1)->get();
                $s = '';
                $s2 = '';
                foreach ($dsNhatro as $nhatro )
                {
                    $s .= '{ "type": "Feature", "properties": { "marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "tennhatro": "'.$nhatro->tennhatro.'", "ten": "'.$nhatro->tenchutro.'", "ngaycapnhat": "'.date('d-m-Y', strtotime($nhatro->capnhatlancuoi)).'","tienich": "'.str_replace("\n","",$nhatro->tienich).'", "giaphong": "'.number_format($nhatro->giaphong).'", "dien": "'.number_format($nhatro->dien).'", "nuoc": "'.number_format($nhatro->nuoc).'", "soluong": "'.$nhatro->soluong.'", "x": "'.$nhatro->x.'", "y": "'.$nhatro->y.'", "trangthai": "'.$nhatro->trangthai.'", "dienthoai": "'.$nhatro->sodienthoai.'", "diachi": "'.$nhatro->diachi.'", "khoangcach": '.round($nhatro->distance,1).'}, "geometry": { "type": "Point", "coordinates": [ '.$nhatro->x.', '.$nhatro->y.' ] } },';
                }
                foreach ($arrNew as $px )
                {
                    $s2 .= '{"type": "Feature", "properties": {"marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "gid": "'.$px['gid'].'", "fillColor": "'.$px['fillColor'].'", "color": "'.$px['color'].'", "tenphuong": "'.$px['tenphuong'].'" }, "geometry": { "type": "Polygon", "coordinates": [ '.$px['geom'].' ] } },';
                }

                return view('index',['dsNhatro'=>$dsNhatro, 'phuongxa'=>$phuongxa, 'phuongxaload'=>$arrNew, 'geojson' => $s, 'geojson2' => $s2]);
            }
            else if($req->giaphong === 'all')
            {
                $output=[];
                $result=[];
                $phuongxa = phuong::select(["gid", "tenphuong", "fillColor", "color", DB::raw("ST_AsGeoJSON(geom) AS geom")])->get();
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
                    $arrNew[$i]["geom"] = $toado[$i];
                }

                $phuongxa = phuongxa::where('maquanhuyen','=',718)->get();
                $lon = 106.6744565963745;
                $lat = 10.980469775348254;
                $sqlDistance = DB::raw("(3959 * acos( cos( radians($lat) ) 
                * cos( radians( ST_Y(geom) ) )  
                * cos( radians( ST_X(geom) ) - radians($lon) ) 
                + sin( radians($lat) ) 
                * sin( radians( ST_Y(geom) ) ) ) ) * 1.609344");

                $dsNhatro = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi','capnhatlancuoi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('active','=',1)->where('daduyet','=',1)->get();
                $s = '';
                $s2 = '';
                foreach ($dsNhatro as $nhatro )
                {
                    $s .= '{ "type": "Feature", "properties": { "marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "tennhatro": "'.$nhatro->tennhatro.'", "ten": "'.$nhatro->tenchutro.'", "ngaycapnhat": "'.date('d-m-Y', strtotime($nhatro->capnhatlancuoi)).'","tienich": "'.str_replace("\n","",$nhatro->tienich).'", "giaphong": "'.number_format($nhatro->giaphong).'", "dien": "'.number_format($nhatro->dien).'", "nuoc": "'.number_format($nhatro->nuoc).'", "soluong": "'.$nhatro->soluong.'", "x": "'.$nhatro->x.'", "y": "'.$nhatro->y.'", "trangthai": "'.$nhatro->trangthai.'", "dienthoai": "'.$nhatro->sodienthoai.'", "diachi": "'.$nhatro->diachi.'", "khoangcach": '.round($nhatro->distance,1).'}, "geometry": { "type": "Point", "coordinates": [ '.$nhatro->x.', '.$nhatro->y.' ] } },';
                }
                foreach ($arrNew as $px )
                {
                    $s2 .= '{"type": "Feature", "properties": {"marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "gid": "'.$px['gid'].'", "fillColor": "'.$px['fillColor'].'", "color": "'.$px['color'].'", "tenphuong": "'.$px['tenphuong'].'" }, "geometry": { "type": "Polygon", "coordinates": [ '.$px['geom'].' ] } },';
                }
                return response()->json(['dsNhatro' => $dsNhatro, 'phuongxa' => $phuongxa, 'phuongxaload' => $arrNew, 'geojson' => $s, 'geojson2' => $s2], 200);
            }
            else
            {
                $output=[];
                $result=[];
                $phuongxa = phuong::select(["gid", "tenphuong", "fillColor", "color", DB::raw("ST_AsGeoJSON(geom) AS geom")])->get();
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
                    $arrNew[$i]["geom"] = $toado[$i];
                }

                $phuongxa = phuongxa::where('maquanhuyen','=',718)->get();
                $lon = 106.6744565963745;
                $lat = 10.980469775348254;
                $sqlDistance = DB::raw("(3959 * acos( cos( radians($lat) ) 
                * cos( radians( ST_Y(geom) ) )  
                * cos( radians( ST_X(geom) ) - radians($lon) ) 
                + sin( radians($lat) ) 
                * sin( radians( ST_Y(geom) ) ) ) ) * 1.609344");

                $dsNhatro = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi','capnhatlancuoi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('giaphong','>=',($req->giaphong)-1000000)->where('giaphong','<=',$req->giaphong)->where('active','=',1)->where('daduyet','=',1)->get();
                $s = '';
                $s2 = '';
                foreach ($dsNhatro as $nhatro )
                {
                    $s .= '{ "type": "Feature", "properties": { "marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "tennhatro": "'.$nhatro->tennhatro.'", "ten": "'.$nhatro->tenchutro.'","ngaycapnhat": "'.date('d-m-Y', strtotime($nhatro->capnhatlancuoi)).'", "tienich": "'.str_replace("\n","",$nhatro->tienich).'", "giaphong": "'.number_format($nhatro->giaphong).'", "dien": "'.number_format($nhatro->dien).'", "nuoc": "'.number_format($nhatro->nuoc).'", "soluong": "'.$nhatro->soluong.'", "x": "'.$nhatro->x.'", "y": "'.$nhatro->y.'", "trangthai": "'.$nhatro->trangthai.'", "dienthoai": "'.$nhatro->sodienthoai.'", "diachi": "'.$nhatro->diachi.'", "khoangcach": '.round($nhatro->distance,1).'}, "geometry": { "type": "Point", "coordinates": [ '.$nhatro->x.', '.$nhatro->y.' ] } },';
                }

                foreach ($arrNew as $px )
                {
                    $s2 .= '{"type": "Feature", "properties": {"marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "gid": "'.$px['gid'].'", "fillColor": "'.$px['fillColor'].'", "color": "'.$px['color'].'", "tenphuong": "'.$px['tenphuong'].'" }, "geometry": { "type": "Polygon", "coordinates": [ '.$px['geom'].' ] } },';
                }

                return response()->json(['dsNhatro' => $dsNhatro, 'phuongxa' => $phuongxa, 'phuongxaload' => $arrNew, 'geojson' => $s, 'geojson2' => $s2], 200);
            }
        }
        else
        {
            return view('trangchu');
        }   
    }

    public function TrangChinhTimKiem(Request $req){
            $output=[];
            $result=[];
            $phuongxa = phuong::select(["gid", "tenphuong", "fillColor", "color", DB::raw("ST_AsGeoJSON(geom) AS geom")])->get();
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
                $arrNew[$i]["geom"] = $toado[$i];
            }

            $phuongxa = phuongxa::where('maquanhuyen','=',718)->get();
            $lon = 106.6744565963745;
            $lat = 10.980469775348254;
            $sqlDistance = DB::raw("(3959 * acos( cos( radians($lat) ) 
            * cos( radians( ST_Y(geom) ) )  
            * cos( radians( ST_X(geom) ) - radians($lon) ) 
            + sin( radians($lat) ) 
            * sin( radians( ST_Y(geom) ) ) ) ) * 1.609344");

            $dsNhatro = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi','capnhatlancuoi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('tenchutro','LIKE',"%$req->timkhutro")->orWhere('tennhatro','LIKE',"%$req->timkhutro")->orWhere('ten','LIKE',"%$req->timkhutro")->where('active','=',1)->where('daduyet','=',1)->get();
            $s = '';
            foreach ($dsNhatro as $nhatro )
            {
                $s .= '{ "type": "Feature", "properties": { "marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "tennhatro": "'.$nhatro->tennhatro.'", "ten": "'.$nhatro->tenchutro.'", "ngaycapnhat": "'.date('d-m-Y', strtotime($nhatro->capnhatlancuoi)).'","tienich": "'.str_replace("\n","",$nhatro->tienich).'", "giaphong": "'.number_format($nhatro->giaphong).'", "dien": "'.number_format($nhatro->dien).'", "nuoc": "'.number_format($nhatro->nuoc).'", "soluong": "'.$nhatro->soluong.'", "x": "'.$nhatro->x.'", "y": "'.$nhatro->y.'", "trangthai": "'.$nhatro->trangthai.'", "dienthoai": "'.$nhatro->sodienthoai.'", "diachi": "'.$nhatro->diachi.'", "khoangcach": '.round($nhatro->distance,1).'}, "geometry": { "type": "Point", "coordinates": [ '.$nhatro->x.', '.$nhatro->y.' ] } },';
            }

            return view('index',['dsNhatro'=>$dsNhatro, 'phuongxa'=>$phuongxa, 'phuongxaload'=>$arrNew, 'geojson' => $s]);
    }

    public function TrangAdminTimKiem(Request $req){
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
        $lon = 106.6744565963745;
        $lat = 10.980469775348254;
        $sqlDistance = DB::raw("(3959 * acos( cos( radians($lat) ) 
        * cos( radians( ST_Y(geom) ) )  
        * cos( radians( ST_X(geom) ) - radians($lon) ) 
        + sin( radians($lat) ) 
        * sin( radians( ST_Y(geom) ) ) ) ) * 1.609344");

        $dsNhatro = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi', 'masothue', 'hinhanhgpkd', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->orWhere('gid','=',$req->timkhutro)->orWhere('tennhatro','LIKE',"%$req->timkhutro")->orWhere('sodienthoai','=',$req->timkhutro)->orWhere('ten','LIKE',"%$req->timkhutro")->orWhere('tenchutro','LIKE',"%$req->timkhutro")->where('active','=',1)->where('daduyet','=',1)->get();
        $dsNhatroDuyet = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi', 'masothue', 'hinhanhgpkd', 'cmnd', 'email', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('active','=',1)->where('daduyet','=',0)->get();
        return view('pages.admin.QLKhuTroBanDo',['dsNhatro'=>$dsNhatro, 'chonphuongxa'=>$phuongxa, 'phuongxa'=>$arrNew,'DSDuyet'=>$dsNhatroDuyet]);
    }

    public function trangchu(){
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
        $lon = 106.6744565963745;
        $lat = 10.980469775348254;
        $sqlDistance = DB::raw("(3959 * acos( cos( radians($lat) ) 
        * cos( radians( ST_Y(geom) ) )  
        * cos( radians( ST_X(geom) ) - radians($lon) ) 
        + sin( radians($lat) ) 
        * sin( radians( ST_Y(geom) ) ) ) ) * 1.609344");

        $dsNhatro = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('active','=',1)->where('daduyet','=',1)->get();
        $s = '';
        foreach ($dsNhatro as $nhatro )
        {
            $s .= '{ "type": "Feature", "properties": { "marker-color": "#ff0000", "marker-size": "medium", "marker-symbol": "", "tennhatro": "'.$nhatro->tennhatro.'", "ten": "'.$nhatro->tenchutro.'", "tienich": "'.str_replace("\n","",$nhatro->tienich).'", "giaphong": "'.number_format($nhatro->giaphong).'", "dien": "'.number_format($nhatro->dien).'", "nuoc": "'.number_format($nhatro->nuoc).'", "soluong": "'.$nhatro->soluong.'", "x": "'.$nhatro->x.'", "y": "'.$nhatro->y.'", "trangthai": "'.$nhatro->trangthai.'", "dienthoai": "'.$nhatro->sodienthoai.'", "diachi": "'.$nhatro->diachi.'", "khoangcach": '.round($nhatro->distance,1).'}, "geometry": { "type": "Point", "coordinates": [ '.$nhatro->x.', '.$nhatro->y.' ] } },';
        }

        return view('index',['dsNhatro'=>$dsNhatro, 'phuongxa'=>$phuongxa, 'phuongxaload'=>$arrNew, 'geojson' => $s]);
    }

    public function QLDSKhuNhaTroKhongCoSV(){
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
        $lon = 106.6744565963745;
        $lat = 10.980469775348254;
        $sqlDistance = DB::raw("(3959 * acos( cos( radians($lat) ) 
        * cos( radians( ST_Y(geom) ) )  
        * cos( radians( ST_X(geom) ) - radians($lon) ) 
        + sin( radians($lat) ) 
        * sin( radians( ST_Y(geom) ) ) ) ) * 1.609344");

        $dsNhatro = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi', 'masothue', 'hinhanhgpkd', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('active','=',1)->where('daduyet','=',1)->get();
        $dsNhatroDuyet = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi', 'masothue', 'hinhanhgpkd', 'cmnd', 'email', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('active','=',1)->where('daduyet','=',0)->get();
        $trangthai = 1;
        session()->put('trangthaisv',$trangthai);
        return view('pages.admin.QLKhuTroBanDo',['dsNhatro'=>$dsNhatro, 'chonphuongxa'=>$phuongxa, 'phuongxa'=>$arrNew, 'trangthai'=>$trangthai,'DSDuyet'=>$dsNhatroDuyet]);
    }

    public function QLDSKhuNhaTro(){
        session()->forget('trangthaisv');
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
        $lon = 106.6744565963745;
        $lat = 10.980469775348254;
        $sqlDistance = DB::raw("(3959 * acos( cos( radians($lat) ) 
        * cos( radians( ST_Y(geom) ) )  
        * cos( radians( ST_X(geom) ) - radians($lon) ) 
        + sin( radians($lat) ) 
        * sin( radians( ST_Y(geom) ) ) ) ) * 1.609344");

        $dsNhatro = DB::table('khunhatro_tdm_point')->join('otro', 'otro.makhutro', '=', 'khunhatro_tdm_point.gid')->whereNull('otro.ngaydi')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi', 'masothue', 'hinhanhgpkd', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('active','=',1)->where('daduyet','=',1)->get();
        $dsNhatroDuyet = DB::table('khunhatro_tdm_point')->select('gid', 'tienich', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'giaphong','dien','nuoc', 'soluong', 'trangthai', 'diachi', 'masothue', 'hinhanhgpkd', 'cmnd', 'email', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->selectRaw("{$sqlDistance} AS distance")->where('active','=',1)->where('daduyet','=',0)->get();
        return view('pages.admin.QLKhuTroBanDo',['dsNhatro'=>$dsNhatro, 'chonphuongxa'=>$phuongxa, 'phuongxa'=>$arrNew,'DSDuyet'=>$dsNhatroDuyet]);
    }

    public function DsKhuTro(){
        $pageSize = 15;
        session()->forget('timkiemkhutro');
        session()->forget('idChuTro');
        $dsNhatro = DB::table('khunhatro_tdm_point')->select('gid', 'tennhatro', 'ho', 'ten', 'tenchutro', 'sodienthoai', 'diachi', DB::raw('ST_X(geom) as x'), DB::raw('ST_Y(geom) as y'))->where('daduyet','=',1)->paginate($pageSize);;
        return view('pages.admin.QLKhuTro',['dsNhatro'=>$dsNhatro, 'pageSize'=>$pageSize]);
    }

    public function ThemKhuTroBanDo(Request $request){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("Ymd");
        $file = $request->gpkd;
        $hinhanhgpkd = uniqid()."_".$date."_".$file->getClientOriginalName();
        $file->move('./images/gpkd/', $hinhanhgpkd);
        $khunhatro=DB::table('khunhatro_tdm_point')->insert(['gid'=>$request->txtCmnd,'tennhatro'=>$request->txtTennhatro,
         'ho'=>$request->txtHotenlot, 'ten'=>$request->txtTen,'cmnd'=>$request->txtCmnd,'sodienthoai'=>$request->txtSodienthoai,
         'diachi'=>$request->txtDiachi,'ngaydangky'=>date("Y-m-d H:i:s"), 'geom'=>DB::raw("ST_GeomFromText('POINT(".$request->x." ".$request->y.")', 4326)"),
         'active'=>1, 'masothue'=>$request->mathue, 'hinhanhgpkd'=>$hinhanhgpkd, 'email'=>$request->txtEmail,'daduyet'=>1, 'capnhatlancuoi'=>date("Y-m-d H:i:s")]);
        if($khunhatro){
            $taikhoan = new taikhoan();

            $taikhoan->tendangnhap = $request->txtCmnd;
            $taikhoan->matkhau = Hash::make($request->txtCmnd);
            $date = date("Y-m-d H:i:s");
            $taikhoan->ngaytao = $date;
            $taikhoan->quyen = 0;
            $taikhoan->trangthai = 1;
            $taikhoan->save();

            Session::flash('success', 'Thêm khu trọ thành công!');
        }
        else {
		    Session::flash('error', 'Thêm khu trọ thất bại!');
	    }
        return redirect()->route('QLDSKhuNhaTro');
    }

    public function TuChoiDuyet(Request $req){
        $id = $req->gid;
        $lydo = $req->lydotuchoi;
        $email = $req->email;
        unlink("./images/gpkd/".$req->hinhanhGpkd);
        khunhatro::destroy($id);
        DB::table('taikhoan')->where('tendangnhap', '=', $id)->delete();

        $content = "Kết quả xét duyệt đã bị từ chối. Lý do: ".$lydo;
        $details = [
            'title' => "Kết quả xét duyệt thông tin",
            'content'=> $content
        ];
        Mail::to($req->email)->send(new TuChoiDuyet($details));
        
        return redirect()->route('QLDSKhuNhaTro');
    }

    public function DuyetKhuTro(Request $req){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("Y-m-d H:i:s");

        $id = $req->gid;
        $email = $req->email;
        $khutro=khunhatro::find($id);
        $khutro->daduyet = 1;
        $khutro->capnhatlancuoi = $date;
        $khutro->save();

        $idtk=taikhoan::where('tendangnhap','=',$id)->select('id')->get();
        $taikhoan=taikhoan::find($idtk[0]->id);
        $taikhoan->trangthai = 1;
        $taikhoan->save();

        $content = "Thông tin đăng ký khu nhà trọ của bạn đã được xét duyệt thành công. Bạn vui lòng đăng nhập và đổi mật khẩu trước khi sử dụng hệ thống.";
        $details = [
            'title' => "Kết quả xét duyệt thông tin",
            'name' => $req->tenchutro,
            'phone' => $req->sodienthoai,
            'mail' => $req->email,
            'tendangnhap' => $req->cmnd,
            'tennhatro' => $req->tennhatro,
            'content'=> $content
        ];
        Mail::to($req->email)->send(new KetQuaDuyet($details));
        
        return redirect()->route('QLDSKhuNhaTro');
    }

    public function ActiveAccount(Request $req){
        $id = $req->id;
        $id2 = $req->id2;
        $code = $req->code;
        
        $khutro=khunhatro::find($id2);
        $khutro->active = 1;
        $khutro->save();

        if($khutro){
            return view('pages.user.resultactive');
        }
        else
        {
            return view('pages.user.resultactive2');
        }  
    }
    public function SignUpPost(Request $request){
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $date = date("Ymd");
        $file = $request->gpkd;
        $hinhanhgpkd = uniqid()."_".$date."_".$file->getClientOriginalName();
        $file->move('./images/gpkd/', $hinhanhgpkd);
        
        $khunhatro=DB::table('khunhatro_tdm_point')->insert(['gid'=>$request->txtCmnd,'tennhatro'=>$request->txtTennhatro,
         'ho'=>$request->txtHotenlot, 'ten'=>$request->txtTen,'cmnd'=>$request->txtCmnd,'sodienthoai'=>$request->txtSodienthoai,
         'diachi'=>$request->sonha.", ".$request->tenduong.", ".$request->phuongxa,'ngaydangky'=>date("Y-m-d H:i:s"), 'geom'=>DB::raw("ST_GeomFromText('POINT(".$request->kinhdo." ".$request->vido.")', 4326)"), 'active'=>0, 'daduyet'=>0, 'email'=>$request->txtEmail, 'masothue'=>$request->mathue, 'hinhanhgpkd'=>$hinhanhgpkd]);
        
         if($khunhatro){
            $taikhoan = new taikhoan();

            $code = uniqid();
            $date = date("Y-m-d H:i:s");

            $taikhoan = array(
                'tendangnhap'  => $request->txtCmnd,
                'matkhau'   => Hash::make($request->txtCmnd),
                'ngaytao' => $date,
                'trangthai' => 0,
                'code' => $code,
                'quyen' => 0
               );
            $getid = DB::table('taikhoan')->insertGetId($taikhoan);

            $content = "https://tdmu.quyken.com/sinhvienngoaitru/activeAccount"."?id=".$getid."&code=".$code."&id2=".$request->txtCmnd;
            $details = [
                'title' => "Kích hoạt tài khoản chủ nhà trọ",
                'name' => $request->txtHotenlot." ".$request->txtTen,
                'phone' => $request->txtSodienthoai,
                'mail' => $request->txtEmail,
                'tendangnhap' => $request->txtCmnd,
                'tennhatro' => $request->txtTennhatro,
                'content'=> $content
            ];
            Mail::to($request->txtEmail)->send(new SendMailSignUp($details));
            return view('pages.user.responesignup', ['details'=>$details]);

            $message = "Thêm khu trọ thành công!";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }
        else {
            $message = "Thêm khu trọ thất bại!";
            echo "<script type='text/javascript'>alert('$message');</script>";
	    }
        echo "<script>window.location='./'</script>";
    }

    public function DangKyKhuTro(Request $request){
        $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));
        $geocoder->setCountry(config('geocoder.country', 'Vietnam'));
        $result=$geocoder->getCoordinatesForAddress(trim($request->txtDiachi));

        $khunhatro=DB::table('khunhatro_tdm_point')->insert(['gid'=>$request->txtCmnd,'tennhatro'=>trim($request->txtTennhatro),
         'ho'=>trim($request->txtHotenlot), 'ten'=>trim($request->txtTen),'cmnd'=>$request->txtCmnd,'sodienthoai'=>$request->txtSodienthoai,
         'diachi'=>trim($request->txtDiachi),'ngaydangky'=>date("Y-m-d H:i:s"), 'geom'=>DB::raw("ST_GeomFromText('POINT(".$result["lng"]." ".$result["lat"].")', 4326)")]);
        if($khunhatro){
            $taikhoan = new taikhoan();

            $taikhoan->tendangnhap = $request->txtCmnd;
            $taikhoan->matkhau = Hash::make($request->txtCmnd);
            $date = date("Y-m-d H:i:s");
            $taikhoan->ngaytao = $date;
            $taikhoan->quyen = 0;
            $taikhoan->save();

            Session::flash('success', 'Thêm khu trọ thành công!');
        }
        else {
		    Session::flash('error', 'Thêm khu trọ thất bại!');
	    }
        return redirect()->route('quan-ly-khu-tro');
    }

    public function ThemKhuTro(Request $request){
        $khunhatro = new khunhatro();
        $khunhatro->tennhatro=$request->tennhatro;
        $khunhatro->diachi=$request->diachi;
        $khunhatro->ho=$request->ho;
        $khunhatro->ten=$request->ten;
        $khunhatro->sodienthoai=$request->sodienthoai;
        $khunhatro->save();
        if($khunhatro){
            Session::flash('success', 'Thêm khu trọ thành công!');
        }else {
		Session::flash('error', 'Thêm khu trọ thất bại!');
	}
        return redirect()->route('quan-ly-khu-tro');
    }
    public function SuaNhaTro($gid,Request $request){
        $dsNhatro=khunhatro::find($gid);
        $dsNhatro->tennhatro=$request->tennhatro;
        $dsNhatro->diachi=$request->diachi;
        $dsNhatro->ho=$request->ho;
        $dsNhatro->ten=$request->ten;
        $dsNhatro->sodienthoai=$request->sodienthoai;
        $dsNhatro->save();
        if($dsNhatro)
        {
            Session::flash('success', 'Cập nhật khu trọ thành công!');
        }
        else 
        {
		    Session::flash('error', 'Cập nhật thất bại!');
	    }
        return redirect()->route('quan-ly-khu-tro');
    }
    
    public function SuaNhaTroBanDo(Request $request){
        $gid = $request->idKhutroSua;
        $dsNhatro=khunhatro::find($gid);
        $dsNhatro->tennhatro=$request->tennhatro;
        $dsNhatro->diachi=$request->diachi;
        $dsNhatro->tenchutro=$request->ten;
        $dsNhatro->sodienthoai=$request->sodienthoai;
        $dsNhatro->save();
        if($dsNhatro)
        {
            Session::flash('success', 'Cập nhật khu trọ thành công!');
        }
        else 
        {
		    Session::flash('error', 'Cập nhật khu trọ thất bại!');
	    }
        return redirect()->back();
    }

    public function XoaNhaTro($gid){
        
        $otro=OTro::where('makhutro','=',$gid)->get();
        $taikhoan=taikhoan::where('tendangnhap','=',$gid)->get();
        if($otro)
        {
            DB::table('otro')->where('makhutro', '=', $gid)->delete();
            if($taikhoan)
            {
                DB::table('taikhoan')->where('tendangnhap', '=', $gid)->delete();
                $tro=khunhatro::destroy($gid);
                if($tro)
                {
                    Session::flash('success', 'Xoá khu trọ thành công!');
                }
                else 
                {
                    Session::flash('error', 'Xoá thất bại!');
                }
                return redirect()->route('quan-ly-khu-tro');
            }
            else
            {
                $tro=khunhatro::destroy($gid);
                if($tro)
                {
                    Session::flash('success', 'Xoá khu trọ thành công!');
                }
                else 
                {
                    Session::flash('error', 'Xoá thất bại!');
                }
                return redirect()->route('quan-ly-khu-tro');
            }
        }
        else if ($taikhoan)
        {
            DB::table('taikhoan')->where('tendangnhap', '=', $gid)->delete();
            $tro=khunhatro::destroy($gid);
            if($tro)
            {
                Session::flash('success', 'Xoá khu trọ thành công!');
            }
            else 
            {
                Session::flash('error', 'Xoá thất bại!');
            }
            return redirect()->route('quan-ly-khu-tro');
            }
        else
        {
            $tro=khunhatro::destroy($gid);
            if($tro)
            {
                Session::flash('success', 'Xoá khu trọ thành công!');
            }
            else 
            {
                Session::flash('error', 'Xoá thất bại!');
            }
            return redirect()->route('quan-ly-khu-tro');
        }
    }


    public function XoaNhaTroBanDo(Request $req){
        $idKhutro = $req->idKhutro;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $khutrodaxoa=DB::table('khutrodaxoa')->insert(['makhutro'=>$idKhutro,'lydo'=>$req->lydoxoa,'ngayxoa'=>date("Y-m-d H:i:s"), 'nguoixoa'=>$req->session()->get('tenadmin')]);
        unlink("./images/gpkd/".$req->hinhanhGpkd);
        $otro=OTro::where('makhutro','=',$idKhutro)->get();
        $taikhoan=taikhoan::where('tendangnhap','=',$idKhutro)->get();
        if($otro)
        {
            DB::table('otro')->where('makhutro', '=', $idKhutro)->delete();
            if($taikhoan)
            {
                DB::table('taikhoan')->where('tendangnhap', '=', $idKhutro)->delete();
                $tro=khunhatro::destroy($idKhutro);
                if($tro)
                {
                    Session::flash('success', 'Xoá khu trọ thành công!');
                }
                else 
                {
                    Session::flash('error', 'Xoá thất bại!');
                }
                return redirect()->route('QLDSKhuNhaTro');
            }
            else
            {
                $tro=khunhatro::destroy($idKhutro);
                if($tro)
                {
                    Session::flash('success', 'Xoá khu trọ thành công!');
                }
                else 
                {
                    Session::flash('error', 'Xoá thất bại!');
                }
                return redirect()->route('QLDSKhuNhaTro');
            }
        }
        else if ($taikhoan)
        {
            DB::table('taikhoan')->where('tendangnhap', '=', $idKhutro)->delete();
            $tro=khunhatro::destroy($idKhutro);
            if($tro)
            {
                Session::flash('success', 'Xoá khu trọ thành công!');
            }
            else 
            {
                Session::flash('error', 'Xoá thất bại!');
            }
            return redirect()->route('QLDSKhuNhaTro');
            }
        else
        {
            $tro=khunhatro::destroy($idKhutro);
            if($tro)
            {
                Session::flash('success', 'Xoá khu trọ thành công!');
            }
            else 
            {
                Session::flash('error', 'Xoá thất bại!');
            }
            return redirect()->route('QLDSKhuNhaTro');
        }
    }

    public function DsSinhVienOtro(Request $idChuTro){
        session()->put('idChuTro', $idChuTro->idChuTro);
        $pageSize = 15;
        $dsSVOtro=DB::table('otro')->
        join('khunhatro_tdm_point','otro.makhutro','=','khunhatro_tdm_point.gid')->
        join('sinhvien','otro.mssv','=','sinhvien.mssv')->
        where('khunhatro_tdm_point.gid','=',$idChuTro->idChuTro)->whereNull('otro.ngaydi')->
        select('sinhvien.ho','sinhvien.ten','sinhvien.mssv','otro.ngayden','otro.sophong',
        'sinhvien.gioitinh')->paginate($pageSize);

        $tenkhutro=DB::table('khunhatro_tdm_point')->where('khunhatro_tdm_point.gid','=',$idChuTro->idChuTro)->
        select('khunhatro_tdm_point.tennhatro')->first();
        return view('pages.admin.Dssvotro',['dsSVOtro'=>$dsSVOtro], compact('tenkhutro'));

    }

    public function DSSVOtroBanDo(Request $idChuTro){
        session()->put('idChuTro', $idChuTro->idChuTro);
        $pageSize = 15;
        $dsSVOtro=DB::table('otro')->
        join('khunhatro_tdm_point','otro.makhutro','=','khunhatro_tdm_point.gid')->
        join('sinhvien','otro.mssv','=','sinhvien.mssv')->
        where('khunhatro_tdm_point.gid','=',$idChuTro->idChuTro)->whereNull('otro.ngaydi')->
        select('sinhvien.ho','sinhvien.ten','sinhvien.mssv','otro.ngayden','otro.sophong',
        'sinhvien.gioitinh')->paginate($pageSize);

        $tenkhutro=DB::table('khunhatro_tdm_point')->where('khunhatro_tdm_point.gid','=',$idChuTro->idChuTro)->
        select('khunhatro_tdm_point.tennhatro')->first();
        return view('pages.admin.DSSVOTroBanDo',['dsSVOtro'=>$dsSVOtro], compact('tenkhutro'));

    }
    
    public function trangtin(){
        return view('pages.user.posts');
    }

    public function getDistanceBetweenPointsNew($latitude1, $longitude1, $latitude2, $longitude2){
        $theta = $longitude1 - $longitude2;
        $miles = (sin(deg2rad($latitude1)) * sin(deg2rad($latitude2))) + (cos(deg2rad($latitude1)) * cos(deg2rad($latitude2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);$miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('miles','feet','yards','kilometers','meters');
        //return compact('kilometers');
    }
    public function TinhKhoangCach()
    {
        $point1 = array('lat' => 10.980469775348254, 'long' => 106.6744565963745);//Đại học Thủ Dầu Một
        $point2 = array('lat' => 10.979719, 'long' => 106.688595);//Điểm khu trọ
        $distance = $this->getDistanceBetweenPointsNew($point1['lat'], $point1['long'], $point2['lat'], $point2['long']);
        foreach ($distance as $unit => $value) {
            echo $unit.': '.round($value,2).'<br />';
        }
    }

    public function search(Request $req){
        $pageSize = 15;
        $search = $req->get('timkhutro');
        if($search===null){
            $dsNhatro= khunhatro::where('tenchutro', 'LIKE', "%$req->session()->get('timkiemkhutro')%")->orWhere('tennhatro', 'LIKE', "%$req->session()->get('timkiemkhutro')%")->orWhere('gid', '=', $req->session()->get('timkiemkhutro'))->orWhere('sodienthoai', '=', $req->session()->get('timkiemkhutro'))->paginate($pageSize);
            return view('pages.admin.QLKhuTro',['dsNhatro'=>$dsNhatro, 'pageSize'=>$pageSize]);
        }
        else
        {
            $student= OTro::where('mssv', '=', $search)->whereNull('ngaydi')->first();
            $makhutro=0;
            if($student!= null)
            { 
                session()->put('timkiemkhutro', $search);
                $makhutro= $student->makhutro;
                $dsNhatro=$khutro= khunhatro::where('gid', '=', $makhutro)->get();
                return view('pages.admin.QLKhuTro',['dsNhatro'=>$dsNhatro, 'pageSize'=>$pageSize]);
            }  
            else
            {
                session()->put('timkiemkhutro', $search);
                $dsNhatro= khunhatro::where('tenchutro', 'LIKE', "%$search%")->orWhere('tennhatro', 'LIKE', "%$search%")->orWhere('gid', '=', $search)->orWhere('sodienthoai', '=', $search)->paginate($pageSize);
                return view('pages.admin.QLKhuTro',['dsNhatro'=>$dsNhatro, 'pageSize'=>$pageSize]);
            }    
        }
        
    }

    public function DataTest()
    {
        return view('datatest');
    }

    public function SignUp()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $ngayhientai= date("Y-m-d", time());
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
        return view('pages.user.signup',['phuongxa'=>$arrNew]);
    }

    function action(Request $request)
    {
     if($request->ajax())
     {
      $output = '';
      $query = $request->get('query');
      if($query != '')
      {
       $data = DB::table('sinhvien')
         ->where('ten', 'like', '%'.$query.'%')
         ->orderBy('mssv', 'desc')
         ->get();
         
      }
      else
      {
       $data = DB::table('sinhvien')
         ->orderBy('mssv', 'desc')
         ->get();
      }
      $total_row = $data->count();
      if($total_row > 0)
      {
       foreach($data as $row)
       {
        $output .= '
        <tr>
         <td>'.$row->ho.'</td>
         <td>'.$row->ten.'</td>
         <td>'.$row->ngaysinh.'</td>
         <td>'.$row->dienthoai.'</td>
         <td>'.$row->email.'</td>
         <td>'.$row->hokhau.'</td>
        </tr>
        ';
       }
      }
      else
      {
       $output = '
       <tr>
        <td align="center" colspan="5">No Data Found</td>
       </tr>
       ';
      }
      $data = array(
       'table_data'  => $output,
       'total_data'  => $total_row
      );

      echo json_encode($data);
     }
    }

    public function xuatdssvtro() 
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new DSSVTroExport, 'DanhSachSVOTro_TDMU.xlsx');
    }

    public function export() 
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new TestExport, 'DanhSachSVTamTru_TDMU.xlsx');
    }
   
    public function import() 
    {
        Excel::import(new TestImport,request()->file('file'));
           
        return redirect()->back();
    }

    public function export2() 
    {
        ob_end_clean();
        ob_start();
        return Excel::download(new KhuTroExport, 'DanhSachNhaTro.xlsx');
    }
   
    public function import2(Request $request) 
    {
        if($request->hasFile('file'))
        {
            $post_file = $request->file('file');
            if($post_file->getClientOriginalExtension('file')==='xlsx' ||
            $post_file->getClientOriginalExtension('file')==='xls' || $post_file->getClientOriginalExtension('file')==='csv')
            {
                Session::flash('success', 'Nhập danh sách sinh viên thành công!');
                Excel::import(new KhuTroImport,request()->file('file'));
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

    public function SoLuongSinhVien(){
        $id = $_POST["id"];

        $ds2 = DB::select("select tro.gid, tro.tennhatro, tro.diachi, count(*) sl 
        from otro left join khunhatro_tdm_point tro on otro.makhutro=tro.gid where otro.ngaydi is null and tro.gid='".$id."'
        group by tro.gid, tro.tennhatro");

        $soluong = 0;
        if($ds2)
        {
            $soluong = $ds2[0]->sl;
        }

        $output =  array('idNhan'=>$soluong);
        echo json_encode($output,JSON_FORCE_OBJECT);
    }

    public function CheckLocation(){
        $trangthai="";
        $kinhdo = $_POST["kinhdo"];
        $vido = $_POST["vido"];

        $ds2 = DB::select('select phuong.gid, phuong.tenphuong, count(ST_Contains(phuong.geom, '.\DB::raw("ST_GeomFromText('POINT(".$kinhdo." ".$vido.")', 4326)").')) as sl
        from vungranhgioiphuongtxtdm_region phuong where
        ST_Contains(phuong.geom, '.\DB::raw("ST_GeomFromText('POINT(".$kinhdo." ".$vido.")', 4326)").')=True
        group by phuong.gid, phuong.tenphuong');

        if($ds2)
        {
            $trangthai="1";
            $output =  array('trangthai'=>$trangthai, 'tenphuong' => $ds2[0]->tenphuong);
            echo json_encode($output,JSON_FORCE_OBJECT);
        }
        else
        {
            $trangthai="Điểm bạn chọn nằm ngoài khu vực Thủ Dầu Một. Vui lòng chọn lại!";
            $output =  array('trangthai'=>$trangthai);
            echo json_encode($output,JSON_FORCE_OBJECT);
        }
    }
}
