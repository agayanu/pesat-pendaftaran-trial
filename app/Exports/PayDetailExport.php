<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PayDetailExport implements FromView
{
    protected $data;
    protected $dataHeader;

    public function __construct($data,$dataHeader)
    {
        $this->data = $data;
        $this->dataHeader = $dataHeader;
    }

    public function view(): View
    {
        return view('export.pay-detail', ['data' => $this->data,'dataHeader' => $this->dataHeader]);
    }
}
