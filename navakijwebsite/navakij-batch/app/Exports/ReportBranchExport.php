<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
class ReportBranchExport implements FromArray, WithMultipleSheets
{
    public $results;
    public function __construct($results)
    {
       $this->results = $results;
    }
    public function array(): array
    {
        return $this->results;
    }

    public function sheets(): array
    {
        $sheets = [
            new ErrorReportSheet($this->results['errors']),
            new SuccessReportSheet($this->results['success']),
        ];

        return $sheets;
    }



}
