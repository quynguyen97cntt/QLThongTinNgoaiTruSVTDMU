<?php

namespace App\Exports;

use App\sinhvien;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class DaDKNgoaiTruExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $request;
    /**
    * @return \Illuminate\Support\Collection
    */
    function __construct($request) {
        $this->ngaybatdauxuat = $request->ngaybatdauxuat;
        $this->ngayketthucxuat = $request->ngayketthucxuat;
        $this->cbLop = $request->cbLop;
        $this->cbLoaicutru = $request->cbLoaicutru;
    }
    public function collection()
    {
        if($this->cbLoaicutru === 'alltype' && $this->cbLop != 'allclass')
        {
            $DSDKNgoaitru = DB::table('ngoaitru')->join('sinhvien', 'ngoaitru.mssv', '=', 'sinhvien.mssv')
            ->where('ngaydangky','>=',$this->ngaybatdauxuat)->where('ngaydangky','<=',$this->ngayketthucxuat)->where('sinhvien.lop','=',$this->cbLop)->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 
            DB::raw('(CASE WHEN loaicutru = 0 THEN N\'Thường trú\' ELSE N\'Tạm trú\' END) AS is_user'), 'ngaydangky', 'vido', 'kinhdo')->get();
        }
        else if($this->cbLop === 'allclass' && $this->cbLoaicutru != 'alltype')
        {
            $DSDKNgoaitru = DB::table('ngoaitru')->join('sinhvien', 'ngoaitru.mssv', '=', 'sinhvien.mssv')
            ->where('ngaydangky','>=',$this->ngaybatdauxuat)->where('ngaydangky','<=',$this->ngayketthucxuat)->where('loaicutru','=',$this->cbLoaicutru)->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 
            DB::raw('(CASE WHEN loaicutru = 0 THEN N\'Thường trú\' ELSE N\'Tạm trú\' END) AS is_user'), 'ngaydangky', 'vido', 'kinhdo')->get();
        }
        else if($this->cbLoaicutru != 'alltype' && $this->cbLop != 'allclass' )
        {
            $DSDKNgoaitru = DB::table('ngoaitru')->join('sinhvien', 'ngoaitru.mssv', '=', 'sinhvien.mssv')
            ->where('ngaydangky','>=',$this->ngaybatdauxuat)->where('ngaydangky','<=',$this->ngayketthucxuat)->where('sinhvien.lop','=',$this->cbLop)->where('loaicutru','=',$this->cbLoaicutru)->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 
             DB::raw('(CASE WHEN loaicutru = 0 THEN N\'Thường trú\' ELSE N\'Tạm trú\' END) AS is_user'), 'ngaydangky', 'vido', 'kinhdo')->get();
        }
        else if($this->cbLoaicutru === 'alltype' && $this->cbLop === 'allclass' )
        {
            $DSDKNgoaitru = DB::table('ngoaitru')->join('sinhvien', 'ngoaitru.mssv', '=', 'sinhvien.mssv')
            ->where('ngaydangky','>=',$this->ngaybatdauxuat)->where('ngaydangky','<=',$this->ngayketthucxuat)->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 
             DB::raw('(CASE WHEN loaicutru = 0 THEN N\'Thường trú\' ELSE N\'Tạm trú\' END) AS is_user'), 'ngaydangky', 'vido', 'kinhdo')->get();
        }

        return $DSDKNgoaitru;
    }

    public function headings(): array
    {
        return [
            'Mã sinh viên',
            'Tên chủ nhà/ chủ trọ',
            'Điện thoại (chủ nhà/ chủ trọ)',
            'Địa chỉ',
            'Loại cư trú',
            'Ngày đăng ký',
            'Vĩ độ',
            'Kinh độ'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                if($this->cbLoaicutru === 'alltype' && $this->cbLop != 'allclass')
                {
                    $soluong= DB::table('ngoaitru')->join('sinhvien', 'ngoaitru.mssv', '=', 'sinhvien.mssv')
                    ->where('ngaydangky','>=',$this->ngaybatdauxuat)->where('ngaydangky','<=',$this->ngayketthucxuat)->where('sinhvien.lop','=',$this->cbLop)->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 
                    DB::raw('(CASE WHEN loaicutru = 0 THEN N\'Thường trú\' ELSE N\'Tạm trú\' END) AS is_user'), 'ngaydangky', 'vido', 'kinhdo')->get()->count()+1;
                }
                else if($this->cbLop === 'allclass' && $this->cbLoaicutru != 'alltype')
                {
                    $soluong= DB::table('ngoaitru')->join('sinhvien', 'ngoaitru.mssv', '=', 'sinhvien.mssv')
                    ->where('ngaydangky','>=',$this->ngaybatdauxuat)->where('ngaydangky','<=',$this->ngayketthucxuat)->where('loaicutru','=',$this->cbLoaicutru)->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 
                    DB::raw('(CASE WHEN loaicutru = 0 THEN N\'Thường trú\' ELSE N\'Tạm trú\' END) AS is_user'), 'ngaydangky', 'vido', 'kinhdo')->get()->count()+1;
                }
                else if($this->cbLoaicutru != 'alltype' && $this->cbLop != 'allclass' )
                {
                    $soluong= DB::table('ngoaitru')->join('sinhvien', 'ngoaitru.mssv', '=', 'sinhvien.mssv')
                    ->where('ngaydangky','>=',$this->ngaybatdauxuat)->where('ngaydangky','<=',$this->ngayketthucxuat)->where('sinhvien.lop','=',$this->cbLop)->where('loaicutru','=',$this->cbLoaicutru)->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 
                    DB::raw('(CASE WHEN loaicutru = 0 THEN N\'Thường trú\' ELSE N\'Tạm trú\' END) AS is_user'), 'ngaydangky', 'vido', 'kinhdo')->get()->count()+1;
                }
                else if($this->cbLoaicutru === 'alltype' && $this->cbLop === 'allclass' )
                {
                    $soluong= DB::table('ngoaitru')->join('sinhvien', 'ngoaitru.mssv', '=', 'sinhvien.mssv')
                    ->where('ngaydangky','>=',$this->ngaybatdauxuat)->where('ngaydangky','<=',$this->ngayketthucxuat)->select('ngoaitru.mssv', 'tenchungoaitru', 'dienthoaichungoaitru', 'diachingoaitru', 
                    DB::raw('(CASE WHEN loaicutru = 0 THEN N\'Thường trú\' ELSE N\'Tạm trú\' END) AS is_user'), 'ngaydangky', 'vido', 'kinhdo')->get()->count()+1;
                }
                
                $cellHeaders = 'A1:H1'; // All headers
                $cellContent = 'A2:H'.$soluong; // All content
                $event->sheet->getDelegate()->getStyle($cellContent)->getFont()->setSize(13);
                // Apply array of styles to B2:G8 cell range
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '333'],
                        ],
                        ],
                        
                ];
                $event->sheet->getDelegate()->getStyle('A1:H1')->applyFromArray(array(
                    'font' => array(
                        'name'      =>  'Times New Roman',
                        'size'      =>  14,
                        'bold'      =>  true
                    )
                    ));
                $event->sheet->horizontalAlign('A1:H1' , \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:H'.$soluong)->applyFromArray($styleArray); //Border
                $event->sheet->setFontFamily('A1:H'.$soluong, 'Times New Roman');//Set Font
                $event->sheet->getStyle('A1:H1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('BDCFF8'); //Background Color
                // // Set first row to height 20
                // $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(20);

                // // Set A1:D4 range to wrap text in cells
                // $event->sheet->getDelegate()->getStyle('K2:K10')
                //     ->getAlignment()->setWrapText(true);          
                 },
        ];
    }
}
