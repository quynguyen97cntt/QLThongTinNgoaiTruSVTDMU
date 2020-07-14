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

class DSSVTroExport implements FromView, ShouldAutoSize, WithEvents
{
    public function view(): View
    {
        return view('pages.admin.xuatdssvotro', [
            'customers' => DB::table('otro')->
            join('khunhatro_tdm_point','otro.makhutro','=','khunhatro_tdm_point.gid')->
            join('sinhvien','otro.mssv','=','sinhvien.mssv')->
            where('khunhatro_tdm_point.gid','=',session()->get('idChuTro'))->whereNull('otro.ngaydi')->
            select('sinhvien.ho','sinhvien.ten','sinhvien.mssv','otro.ngayden','otro.sophong',
            'sinhvien.gioitinh')->orderBy('mssv', 'asc')->get(),
            'chutro'=>DB::table('khunhatro_tdm_point')->where('khunhatro_tdm_point.gid','=',session()->get('idChuTro'))->get()
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $soluong=DB::table('otro')->
                join('khunhatro_tdm_point','otro.makhutro','=','khunhatro_tdm_point.gid')->
                join('sinhvien','otro.mssv','=','sinhvien.mssv')->
                where('khunhatro_tdm_point.gid','=',session()->get('idChuTro'))->whereNull('otro.ngaydi')->
                select('sinhvien.ho','sinhvien.ten','sinhvien.mssv','otro.ngayden','otro.sophong',
                'sinhvien.gioitinh')->orderBy('mssv', 'desc')->get()->count()+12;
                $cellHeaders = 'A12:G12'; // All headers
                $cellContent = 'A13:G'.$soluong; // All content
                $event->sheet->getDelegate()->getStyle($cellContent)->getFont()->setSize(13);
                $event->sheet->getDelegate()->getStyle('A2:G9')->getFont()->setSize(13);
                $event->sheet->getDelegate()->getStyle('A1:G1')->getFont()->setSize(14);
                $event->sheet->getDelegate()->getStyle('A11:G11')->getFont()->setSize(14);
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
                $event->sheet->getDelegate()->getStyle('A12:G12')->applyFromArray(array(
                    'font' => array(
                        'name'      =>  'Times New Roman',
                        'size'      =>  14,
                        'bold'      =>  true
                    )
                    ));
                $event->sheet->horizontalAlign('A12:G12' , \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $event->sheet->getDelegate()->getStyle('A12:G'.$soluong)->applyFromArray($styleArray); //Border
                $event->sheet->getDelegate()->getStyle('A2:G9')->applyFromArray($styleArray2);
                $event->sheet->setFontFamily('A13:G'.$soluong, 'Times New Roman');//Set Font
                $event->sheet->setFontFamily('A1:G11', 'Times New Roman');//Set Font
                $event->sheet->getStyle('A12:G12')->getFill()
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
