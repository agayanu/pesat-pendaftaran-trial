<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;

class TmSchoolsImport implements ToCollection, WithValidation, WithStartRow
{
    protected $province;
    protected $city;
    protected $distric;

    public function __construct($province, $city, $distric)
    {
        $this->province = $province;
        $this->city     = $city;
        $this->distric  = $distric;
    }

    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $collection)
    {
        foreach ($collection as $c) {
            DB::table('tm_schools')
                ->insert([
                    'code'          => trim($c[1]),
                    'name'          => trim($c[2]),
                    'address'       => trim($c[3]),
                    'status'        => trim($c[5]),
                    'code_province' => $this->province,
                    'code_city'     => $this->city,
                    'code_distric'  => $this->distric,
                    'created_at'    => now()
                ]);
        }
    }

    public function rules(): array
    {
        return [
            '1' => 'required|unique:tm_schools,code',
            '2' => 'required|string',
            '3' => 'required|string',
            '5' => 'required|in:NEGERI,SWASTA',
        ];
    }

    public function customValidationMessages()
    {
        return [
            '1.required' => 'NPSN wajib diisi',
            '1.unique'   => 'NPSN sudah ada',
            '2.required' => 'Nama wajib diisi',
            '2.string'   => 'Nama harus berupa string',
            '3.required' => 'Alamat wajib diisi',
            '3.string'   => 'Alamat harus berupa string',
            '5.required' => 'Status wajib diisi',
            '5.string'   => 'Status hanya bisa NEGERI atau SWASTA',
        ];
    }
}
