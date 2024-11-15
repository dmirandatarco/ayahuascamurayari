<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ReservaExports implements FromView, ShouldAutoSize, WithEvents, WithStyles, WithDrawings
{
    use Exportable;

    public function __construct(public $fechainicio,public $fechafin,public $counter,public $reservas,public $usuario2)
    {
    }

    public function drawings()
    {
        $imageUrl = public_path('img/logo2.png');

        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('Day Expeditions');
        $drawing->setPath($imageUrl);
        $drawing->setHeight(50);
        $drawing->setCoordinates('A1');
        return $drawing;
    }

    public function styles(Worksheet $sheet)
    {
        $lastRow        = $sheet->getHighestDataRow();
        $lastColumn     = $sheet->getHighestColumn();
        $headerColor    = '333F4F';
        $numDataColor   = '99FF33';
        $borderColor    = '000000';

        // Estilo de encabezado
        $headerStyle = [
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => $headerColor
                ]
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
            ],
        ];
        // Estilo de datos numéricos
        $numDataStyle = [
            'font' => [
                'color' => ['rgb' => '000000'],
            ],
            'fill' => [
                'fillType' => 'solid',
                'startColor' => [
                    'rgb' => $numDataColor,
                ],
            ],
        ];
        // Estilo de cuadrícula
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => $borderColor],
                ],
            ],
        ];

        // Aplicar estilo a los encabezados
        $sheet->getStyle("A8:{$lastColumn}8")->applyFromArray($headerStyle);
        // Negrita 
        $sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B1')->getFont()->setSize(12)->setBold(true)->applyFromArray($headerStyle);
        $sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('B2')->getFont()->setSize(12)->setBold(true)->applyFromArray($headerStyle);
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A3')->getFont()->setSize(14)->setBold(true)->applyFromArray($headerStyle);
        $sheet->getStyle('A5')->getFont()->setBold(true);
        $sheet->getStyle('A6')->getFont()->setBold(true);
        $sheet->getStyle('C5')->getFont()->setBold(true);
        $sheet->getStyle('C6')->getFont()->setBold(true);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $lastColumn = $event->sheet->getHighestColumn();
            }
        ];
    }

    public function view(): View
    {
        $fechainicio = $this->fechainicio;
        $fechafin = $this->fechafin;
        $counter = $this->counter;
        $reservas = $this->reservas;
        $usuario2 = $this->usuario2;
        return view('pages.excel.reservas', compact('fechainicio','fechafin','counter','reservas','usuario2'));
    }
}
