<?php

namespace App\Exports;

use App\khunhatro;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class KhuTroExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return khunhatro::select(["tennhatro", "tenchutro", "cmnd", "sodienthoai", "diachi", "giaphong", "khoangcach", "soluongphong", "dien", "nuoc", "soluong", "tienich"])->get();
    }

    public function headings(): array
    {
        return [
            'Tên nhà trọ',
            'Tên chủ trọ',
            'Chứng minh nhân dân',
            'Số điện thoại',
            'Địa chỉ',
            'Giá phòng',
            'Khảng cách đến TDMU',
            'Số lượng phòng',
            'Tiền điện',
            'Tiền nước',
            'Số lượng',
            'Tiện ích'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $soluong=khunhatro::all()->count()+1;
                $cellHeaders = 'A1:L1';
                $cellContent = 'A2:L'.$soluong;
                $event->sheet->getDelegate()->getStyle($cellContent)->getFont()->setSize(13);
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '333'],
                        ],
                        ],
                        
                ];
                $event->sheet->getDelegate()->getStyle('A1:L1')->applyFromArray(array(
                    'font' => array(
                        'name'      =>  'Times New Roman',
                        'size'      =>  14,
                        'bold'      =>  true
                    )
                    ));
                $event->sheet->horizontalAlign('A1:L1' , \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A1:L'.$soluong)->applyFromArray($styleArray);
                $event->sheet->setFontFamily('A1:L'.$soluong, 'Times New Roman');
                $event->sheet->getStyle('A1:L1')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('BDCFF8');     
                 },
        ];
    }

}
