<?php

namespace App\Exports;

use App\Models\Measurement;
use App\Services\FormatterService;
use Faker\Core\Number;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class MeasurementsExport implements FromCollection, WithHeadings, WithColumnFormatting, WithMapping
{
    protected Collection $measurements;

    public function __construct(Collection $measurements)
    {
        $this->measurements = $measurements;
    }

    /**
    * @return Collection
    */
    public function collection(): Collection
    {
        return $this->measurements;
    }

    public function headings(): array
    {
        return ['Id', 'Temperatura', 'Vlaga', 'Čas'];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,
            'B' => NumberFormat::FORMAT_NUMBER_00,
            'C' => NumberFormat::FORMAT_PERCENTAGE_00,
            'D' => NumberFormat::FORMAT_DATE_DATETIME,
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            FormatterService::formatFloat($row->temperature),
            $row->humidity/100,
            $row->timestamp,
        ];
    }
}
