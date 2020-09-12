<?php

namespace App\Exports;

use App\MasterPanitiaMahasiswa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Sheet;

Sheet::macro('styleCells', function (Sheet $sheet, string $cellRange, array $style) {
     $sheet->getDelegate()->getStyle($cellRange)->applyFromArray($style);
 });

class MahasiswaExport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
  /**
  * @return \Illuminate\Support\Collection
  */
  public function collection()
  {
    return collect([
    ]);
  }
  public function headings(): array
  {
    return [
      '#',
      'NPM',
      'Nama Lengkap',
      'Email',
      'No Telp',
      'Jenis Kelamin',
      'Alamat',
      'Angkatan',
      'Jurusan',
    ];
  }
  public function registerEvents(): array
  {
    return [
      AfterSheet::class    => function(AfterSheet $event) {
        $cellRange = 'A1:G1'; // All headers
        $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
        // $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $event->sheet->getDelegate()->getStyle('A1:'.$event->sheet->getDelegate()->getHighestColumn().'1')
                    ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('31869b');
            $sheet=   $event->sheet->styleCells(
                   'A1:I1',
                   [
                       'borders' => [
                           'outline' => [
                               'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                               'color' => ['argb' => 'FFFF0000'],
                           ],
                       ]
                   ]
               );

        // $event->sheet->getDelegate()->getStyle($cellRange)->getFill()->setFillType(sFill::FILL_SOLID)->getStartColor()->setARGB('ffff15');;
      },
    ];
  }
}
