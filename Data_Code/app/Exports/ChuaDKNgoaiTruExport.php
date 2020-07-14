<?php

namespace App\Exports;

use App\sinhvien;
use App\ngoaitru;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ChuaDKNgoaiTruExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $request;
    /**
    * @return \Illuminate\Support\Collection
    */
    function __construct($request) {
        $this->ngaybatdauxuat = $request->ngaybatdauxuat;
        $this->ngayketthucxuat = $request->ngayketthucxuat;
        $this->cbLop = $request->cbLop;
    }
    public function collection()
    {
        if($this->cbLop === 'allclass')
        {
            $DSChuaDKNgoaitru = sinhvien::whereNotExists(function($query)
            {
                $query->select(DB::raw('*'))
                      ->from('ngoaitru')
                      ->whereRaw("sinhvien.mssv = ngoaitru.mssv AND (ngoaitru.ngaydangky >= '{$this->ngaybatdauxuat}' 
                      AND ngoaitru.ngaydangky <= '{$this->ngayketthucxuat}')");
            })
            ->select('sinhvien.mssv', 'sinhvien.ho', 'sinhvien.ten', 'sinhvien.gioitinh', 'sinhvien.email', 'sinhvien.lop')->orderBy('sinhvien.lop', 'asc')->get();

            
        }
        else
        {
            $DSChuaDKNgoaitru = sinhvien::whereNotExists(function($query)
            {
                $query->select(DB::raw('*'))
                      ->from('ngoaitru')
                      ->whereRaw("sinhvien.mssv = ngoaitru.mssv AND (ngoaitru.ngaydangky >= '{$this->ngaybatdauxuat}' 
                      AND ngoaitru.ngaydangky <= '{$this->ngayketthucxuat}')");
            })->where('sinhvien.lop','=',$this->cbLop)
            ->select('sinhvien.mssv', 'sinhvien.ho', 'sinhvien.ten', 'sinhvien.gioitinh', 'sinhvien.email', 'sinhvien.lop')->orderBy('sinhvien.lop', 'asc')->get();
        }
        

        return $DSChuaDKNgoaitru;
    }

    public function headings(): array
    {
        return [
            'Mã sinh viên',
            'Họ',
            'Tên',
            'Giới tính',
            'Email',
            'Lớp'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                if($this->cbLop === 'allclass')
                {
                    $soluong= sinhvien::whereNotExists(function($query)
                    {
                        $query->select(DB::raw('*'))
                              ->from('ngoaitru')
                              ->whereRaw("sinhvien.mssv = ngoaitru.mssv AND (ngoaitru.ngaydangky >= '{$this->ngaybatdauxuat}' 
                              AND ngoaitru.ngaydangky <= '{$this->ngayketthucxuat}')");
                    })
                    ->select('sinhvien.mssv', 'sinhvien.ho', 'sinhvien.ten', 'sinhvien.gioitinh', 'sinhvien.email', 'sinhvien.lop')->orderBy('sinhvien.lop', 'asc')->get()->count()+1;
                }
                else
                {
                    $soluong= sinhvien::whereNotExists(function($query)
                    {
                        $query->select(DB::raw('*'))
                              ->from('ngoaitru')
                              ->whereRaw("sinhvien.mssv = ngoaitru.mssv AND (ngoaitru.ngaydangky >= '{$this->ngaybatdauxuat}' 
                              AND ngoaitru.ngaydangky <= '{$this->ngayketthucxuat}')");
                    })->where('sinhvien.lop','=',$this->cbLop)
                    ->select('sinhvien.mssv', 'sinhvien.ho', 'sinhvien.ten', 'sinhvien.gioitinh', 'sinhvien.email', 'sinhvien.lop')->orderBy('sinhvien.lop', 'asc')->get()->count()+1;
                }
                
                $cellHeaders = 'A1:F1'; // All headers
                $cellContent = 'A2:F'.$soluong; // All content
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
                $event->sheet->getDelegate()->getStyle('A1:F1')->applyFromArray(array(
                    'font' => array(
                        'name'      =>  'Times New Roman',
                        'size'      =>  14,
                        'bold'      =>  true
                    )
                    ));
                $event->sheet->horizontalAlign('A1:F1' , \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:F'.$soluong)->applyFromArray($styleArray);
                $event->sheet->setFontFamily('A1:F'.$soluong, 'Times New Roman');
                $event->sheet->getStyle('A1:F1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('BDCFF8');         
                 },
        ];
    }
}
