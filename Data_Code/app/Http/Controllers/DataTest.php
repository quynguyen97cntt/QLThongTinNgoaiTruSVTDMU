<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\khunhatro;
use App\dangnhap;
use App\sinhvien;
use App\OTro;
use App\taikhoan;
use App\phuong;
use DB;
use Hash;
use Session;
use Excel;
// use Maatwebsite\Excel\Concerns\FromCollection;
// use Maatwebsite\Excel\Concerns\Exportable;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithCustomStartCell;
// use Maatwebsite\Excel\Concerns\WithColumnFormatting;
// use PhpOffice\PhpSpreadsheet\Shared\Date;
// use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Exports\TestExport;
use App\Imports\TestImport;
use App\Exports\DSSVTroExport;
use Validator,Redirect,Response,File;
use GuzzleHttp\Client;
use Spatie\Geocoder\Facades\Geocoder as GeocoderFacade;
use Spatie\Geocoder\Geocoder;

class DataTest extends Controller
{
    public function index(){
        $client = new \GuzzleHttp\Client();
        $geocoder = new Geocoder($client);
        $geocoder->setApiKey(config('geocoder.key'));
        $geocoder->setCountry(config('geocoder.country', 'Vietnam'));
        $result=$geocoder->getCoordinatesForAddress('Số 6, Trần Văn Ơn, Thủ Dầu Một, Bình Dương');
        echo $result["lat"].', ';
        echo $result["lng"];
        //$geocoder->getCoordinatesForAddress('Infinite Loop 1, Cupertino')->setLanguage('it');
        //var_dump($result);
        //$geocoder->getAddressForCoordinates(40.714224, -73.961452);
        //Geocoder::getCoordinatesForAddress('Infinite Loop 1, Cupertino');
    }

    public function apitest(Request $request)
    {
        $filename =  $request->get('id');
        $output=[];
        $result=[];
        $phuongxa = phuong::select(["gid", "tenphuong", DB::raw("ST_AsGeoJSON(geom) AS geom")])->get();
        $arrNew =[];
        $toado = [];

        for($i=0; $i<$phuongxa->count(); $i++)
        {
            $output[$i] = $phuongxa[$i]->geom;
            $result[$i]=$output[$i]["coordinates"][0][0];
            
            $toado[$i]= "".json_encode($result[$i])."";
            $arrNew[$i]["gid"] = $phuongxa[$i]->gid;
            $arrNew[$i]["tenphuong"] = $phuongxa[$i]->tenphuong;
            $arrNew[$i]["geom"] = $toado[$i];
        }
        $object = json_encode($arrNew);

        foreach($arrNew as $obj)
        {
            echo $obj['gid'];
            echo $obj['tenphuong'];
            echo $obj['geom'];
            echo "<br>";
            echo "<br>";
        }
        

        
    }

    public function storeMedia(Request $request)
    {
        $path = storage_path('tmp/uploads');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function store(StoreProjectRequest $request)
    {
        $project = Project::create($request->all());

        foreach ($request->input('document', []) as $file) {
            $project->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('document');
        }

        return redirect()->route('projects.index');
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $project->update($request->all());

        if (count($project->document) > 0) {
            foreach ($project->document as $media) {
                if (!in_array($media->file_name, $request->input('document', []))) {
                    $media->delete();
                }
            }
        }

        $media = $project->document->pluck('file_name')->toArray();

        foreach ($request->input('document', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $project->addMedia(storage_path('tmp/uploads/' . $file))->toMediaCollection('document');
            }
        }

        return redirect()->route('admin.projects.index');
    }


    public function destroy(Request $request)
    {
        $filename =  $request->get('filename');
        //Photo::where('photo_name',$filename)->delete();
        $path=public_path('tmp/uploads/').$filename;
        if (file_exists($path)) {
            unlink($path);
        }
        return $filename;  
    }

    public function uploadSubmit(Request $request)
	{
        $image_code = '';
        $hinhdamahoa = '';
        $images = $request->file('file');
        // Thiết lập required cho cả 2 mục input
		$this->validate($request, [
			'file'=>'required',]
		);
        // kiểm tra có files sẽ xử lý
		if($request->hasFile('file')) {
			$allowedfileExtension=['jpg','png'];
			$files = $request->file('file');
            // flag xem có thực hiện lưu DB không. Mặc định là có
			$exe_flg = true;
			// kiểm tra tất cả các files xem có đuôi mở rộng đúng không
			foreach($files as $file) {
				$extension = $file->getClientOriginalExtension();
				$check=in_array($extension,$allowedfileExtension);

				if(!$check) {
                    // nếu có file nào không đúng đuôi mở rộng thì đổi flag thành false
					$exe_flg = false;
					break;
				}
			} 
			// nếu không có file nào vi phạm validate thì tiến hành lưu DB
			if($exe_flg) {
                // duyệt từng ảnh và thực hiện lưu
				foreach ($request->file('file') as $image) {
                    //$filename = $photo->storeAs('photos', $photo->getClientOriginalName());
					$filename = $image->store('photos');
                    $mahoa=base64_encode($image);
                    $new_name = $filename;
                    $image_code .= '<img src="storage/'.$new_name.'" name="'.$new_name.'" style="width: 100px; height: 100px;" class="img-thumbnail" width="100" height="100" />';
                    $hinhdamahoa .= '-------------'.$mahoa.'-------------';

				}
                //echo "Upload successfully";
                $output = array(
                    'success'  => $hinhdamahoa,
                    'image'   => $image_code
                );

                return response()->json($output);
                
			} else {
                $output = array(
                    'success'  => "Falied to upload. Only accept jpg, png photos.",
                    'image'   => "Falied to upload. Only accept jpg, png photos."
                );
                return response()->json($output);
			}
        }
        else
        {
            $output = array(
                'success'  => "File empty.",
                'image'   => "File empty."
            );
            return response()->json($output);
        }
	}
}
