<?php

namespace App\Exports;

use App\sinhvien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class StudentsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return sinhvien::all();
    }

    public function headings(): array
    {
        return [
            'Mã SV',
            'Họ và tên lót',
            'Tên SV',
            'Ngày sinh',
            'Phái',
            'Điện thoại',
            'Email',
            'Lớp',
            'Chứng minh nhân dân',
            'Địa chỉ thường trú',
            'Địa chỉ tạm trú'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $soluong=sinhvien::all()->count()+1;
                $cellHeaders = 'A1:K1'; // All headers
                $cellContent = 'A2:J'.$soluong; // All content
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
                $event->sheet->getDelegate()->getStyle('A1:K1')->applyFromArray(array(
                    'font' => array(
                        'name'      =>  'Times New Roman',
                        'size'      =>  14,
                        'bold'      =>  true
                    )
                    ));
                $event->sheet->horizontalAlign('A1:K1' , \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:K'.$soluong)->applyFromArray($styleArray); //Border
                $event->sheet->setFontFamily('A1:K'.$soluong, 'Times New Roman');//Set Font
                $event->sheet->getStyle('A1:K1')->getFill()
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
