<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;

class RegistExport implements FromCollection, WithMapping, WithHeadings, WithStyles, WithColumnWidths
{
    protected $data;
    protected $createdFrom;
    protected $createdTo;
    private $row = 0;

    public function __construct($data,$createdFrom,$createdTo)
    {
        $this->data = $data;
        $this->createdFrom = $createdFrom;
        $this->createdTo = $createdTo;
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
            $data->no_regist,
            $data->name,
            $data->gender,
            $data->school_name,
            $data->phase,
            $data->grade,
            $data->major,
            $data->status,
            $data->created_at,
            $data->receive_created_at,
            $data->user,
            $data->updated_at,
        ];
    }

    public function headings(): array
    {
        return [
            [
                'DATA PENDAFTARAN',
            ],
            [' '],
            [
                $this->createdFrom.' s/d '.$this->createdTo,
            ],
            [' '],
            [
                'No',
                'Periode',
                'Nomor',
                'Nama',
                'JK',
                'Asal Sekolah',
                'Gelombang',
                'Kelompok',
                'Jurusan',
                'Status',
                'Tgl Daftar',
                'Tgl Diterima',
                'User',
                'Update',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->mergeCells('A1:N1');
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->mergeCells('A3:D3');
        $sheet->getStyle('A3')->getFont()->setBold(true);
        $sheet->getStyle('A5:N5')->getAlignment()->setHorizontal('center');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 7,
            'C' => 7,
            'D' => 50,
            'E' => 10,
            'F' => 50,
            'G' => 12,
            'H' => 11,
            'I' => 8,
            'J' => 15,
            'K' => 18,
            'L' => 18,
            'M' => 50,
            'N' => 18,
        ];
    }
}
