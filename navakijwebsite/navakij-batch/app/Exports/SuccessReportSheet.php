<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithTitle;

class SuccessReportSheet implements FromArray, WithHeadings, ShouldAutoSize, WithStyles, WithTitle
{
    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    public function array(): array
    {
        return $this->result;
    }
    public function headings(): array
    {
        if(count($this->result) > 0){
            return [
                array_keys($this->result[0])
            ];
        }
        return [
            "รูปภาพ",
            "ชื่อ (ไทย)",
            "ชื่อ (En)",
            "เบอร์โทรศัพท์",
            "เบอร์แฟ็กซ์",
            "อีเมล",
            "เว็บไซต์",
            "ที่อยู่",
            "Latitute",
            "Longitude",
            "Google Map",
            "จังหวัด",
            "อำเภอ/เขต",
            "ตำบล/แขวง",
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => [
                        'bold' => true,
                        'size' => 16
                        ]
                    ],
        ];
    }

    public function title(): string
    {
        return 'Success Report';
    }
}
