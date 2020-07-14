<?php

namespace App\Imports;

use App\khunhatro;
use Hash;
use DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use GuzzleHttp\Client;
use Spatie\Geocoder\Facades\Geocoder as GeocoderFacade;
use Spatie\Geocoder\Geocoder;

class KhuTroImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $result = "";
        $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));
        $geocoder->setCountry(config('geocoder.country', 'Vietnam'));
        

        if(isset($row['toado']))
        {
            $result=$geocoder->getCoordinatesForAddress(trim($row['toado']));
            
            $dsnhatroImport = new khunhatro([
                //
                'gid' => $row['cmnd'],
                'tennhatro' => $row['tennhatro'],
                'tenchutro' => $row['tenchutro'],
                'sodienthoai' => "0".$row['sodienthoai'],
                'sodienthoai2' => "0".$row['sodienthoai2'],
                'diachi' => $row['diachi'],
                'giaphong' => $row['giaphong'],
                'ngaydangky' => date("Y-m-d H:i:s"),
                'sophong' => $row['sophong'],
                'tienich' => $row['tienich'],
                'khoangcach' => $row['khoangcach'],
                'geom' => DB::raw("ST_GeomFromText('POINT(".$result["lng"]." ".$result["lat"].")', 4326)"),
            ]);

        }
        else
        {
            $result=$geocoder->getCoordinatesForAddress(trim($row['diachi']));

            $dsnhatroImport = new khunhatro([
                //
                'gid' => $row['cmnd'],
                'tennhatro' => $row['tennhatro'],
                'tenchutro' => $row['tenchutro'],
                'sodienthoai' => "0".$row['sodienthoai'],
                'sodienthoai2' => "0".$row['sodienthoai2'],
                'diachi' => $row['diachi'],
                'giaphong' => $row['giaphong'],
                'ngaydangky' => date("Y-m-d H:i:s"),
                'sophong' => $row['sophong'],
                'tienich' => $row['tienich'],
                'khoangcach' => $row['khoangcach'],
                'geom' => DB::raw("ST_GeomFromText('POINT(".$result["lng"]." ".$result["lat"].")', 4326)"),
            ]);
        }
        
        // $taikhoan = new taikhoan();
        // $taikhoan->tendangnhap= $row['cmnd'];
        // $taikhoan->matkhau= Hash::make($row['cmnd']);
        // $taikhoan->ngaytao= date("Y-m-d H:i:s");
        // $taikhoan->quyen= 0;
        // $taikhoan->save();
        return $dsnhatroImport;
    }
}
