<?php

namespace App\Exports;

use App\OTro;
use App\sinhvien;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use DB;
use Session;

class TKTheoKhuTroExport implements FromView, ShouldAutoSize, WithEvents
{
    public function view(): View
    {
        return view('pages.admin.xuattktheokhutro', [
            'ds' => DB::select('select tro.gid, tro.tennhatro, tro.diachi, count(*) sl 
            from otro left join khunhatro_tdm_point tro on otro.makhutro=tro.gid where otro.ngaydi is null 
            group by tro.gid, tro.tennhatro ORDER BY sl DESC')
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $thongke=DB::select('select tro.gid, tro.tennhatro, tro.diachi, count(*) sl 
                from otro left join khunhatro_tdm_point tro on otro.makhutro=tro.gid where otro.ngaydi is null 
                group by tro.gid, tro.tennhatro ORDER BY sl DESC');
                $soluong=0;
                foreach ($thongke as $item)
                {
                    $soluong++;
                }
                $soluong += 2;

                $cellHeaders = 'A2:C2'; // All headers
                $cellContent = 'A3:C'.$soluong; // All content
                $event->sheet->getDelegate()->getStyle($cellContent)->getFont()->setSize(13);
                $event->sheet->getDelegate()->getStyle('A1:L1')->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle('A2:L2')->getFont()->setSize(14);
                // Apply array of styles to B2:G8 cell range
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '333'],
                        ],
                        ],
                        
                ];
                $styleArray2 = [
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                            'color' => ['argb' => '333'],
                        ],
                        ],
                        
                ];
                $event->sheet->getDelegate()->getStyle('A2:L2')->applyFromArray(array(
                    'font' => array(
                        'name'      =>  'Times New Roman',
                        'size'      =>  14,
                        'bold'      =>  true
                    )
                    ));
                $event->sheet->horizontalAlign('A2:L2' , \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A2:L'.$soluong)->applyFromArray($styleArray); //Border
                $event->sheet->getDelegate()->getStyle('A2:L3')->applyFromArray($styleArray2);
                $event->sheet->setFontFamily('A3:L'.$soluong, 'Times New Roman');//Set Font
                $event->sheet->setFontFamily('A1:L3', 'Times New Roman');//Set Font
                $event->sheet->getStyle('A2:L2')->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()->setARGB('BDCFF8'); //Background Color
                 },
        ];
    }
}
