<?php

namespace App\Exports;

use App\Models\City;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CityExport implements FromCollection, WithMapping, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return City::all();
    }

    public function headings(): array
    {
        return [
            'name',
            'country',
            'created_at'
        ];
    }

    public function map($row): array
    {
        return [
            $row->name,
            $row->country->name,
            $row->created_at
        ];
    }
}
