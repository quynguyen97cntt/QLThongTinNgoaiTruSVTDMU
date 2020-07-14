<?php

namespace App\Exports;

use App\sinhvien;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;

class TestExport implements FromView, ShouldAutoSize, WithEvents
{
    public function view(): View
    {
        return view('datatest', [
            'customers' => DB::table('otro')->
            join('khunhatro_tdm_point','otro.makhutro','=','khunhatro_tdm_point.gid')->
            join('sinhvien','otro.mssv','=','sinhvien.mssv')->
            where('khunhatro_tdm_point.gid','=',3)->whereNull('otro.ngaydi')->
            select('sinhvien.ho','sinhvien.ten','sinhvien.mssv','otro.ngayden','otro.sophong',
            'sinhvien.gioitinh')->orderBy('mssv', 'asc')->get()
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $soluong=DB::table('otro')->
                join('khunhatro_tdm_point','otro.makhutro','=','khunhatro_tdm_point.gid')->
                join('sinhvien','otro.mssv','=','sinhvien.mssv')->
                where('khunhatro_tdm_point.gid','=',3)->whereNull('otro.ngaydi')->
                select('sinhvien.ho','sinhvien.ten','sinhvien.mssv','otro.ngayden','otro.sophong',
                'sinhvien.gioitinh')->orderBy('mssv', 'desc')->get()->count()+2;
                $cellHeaders = 'A2:F2'; // All headers
                $cellContent = 'A3:F'.$soluong; // All content
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
                $event->sheet->getDelegate()->getStyle('A2:F2')->applyFromArray(array(
                    'font' => array(
                        'name'      =>  'Times New Roman',
                        'size'      =>  14,
                        'bold'      =>  true
                    )
                    ));
                $event->sheet->horizontalAlign('A2:F2' , \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A2:F'.$soluong)->applyFromArray($styleArray); //Border
                $event->sheet->setFontFamily('A3:F'.$soluong, 'Times New Roman');//Set Font
                $event->sheet->getStyle('A2:F2')->getFill()
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
