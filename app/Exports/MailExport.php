<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class MailExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithColumnWidths
{
    protected $data;
    private $row = 0;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function map($data): array
    {
        return [
            ++$this->row,
            $data->period,
            $data->phase,
            $data->no_regist,
            $data->name,
            $data->grade,
            $data->major,
            $data->type,
            $data->response,
            $data->created_at,
        ];
    }

    public function headings(): array
    {
        return [
            [
                'DATA EMAIL',
            ],
            [' '],
            [
                'No',
                'Periode',
                'Gelombang',
                'Nomor',
                'Nama',
                'Kelompok',
                'Jurusan',
                'Jenis',
                'Keterangan',
                'Update',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A3:J3')->getFont()->setBold(true);
        $sheet->mergeCells('A1:J1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('I')->getAlignment()->setWrapText(true);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 7,
            'C' => 12,
            'D' => 7,
            'E' => 50,
            'F' => 12,
            'G' => 12,
            'H' => 12,
            'I' => 50,
            'J' => 20,
        ];
    }
}
