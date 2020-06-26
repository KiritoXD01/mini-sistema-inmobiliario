<?php

namespace App\Exports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CountryExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Country::all();
    }

    public function headings(): array
    {
        return [
            'name', 'iso', 'created_at'
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->iso,
            $row->created_at
        ];
    }
}
