<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UserExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'firstname',
            'lastname',
            'email',
            'code',
            'created_at'
        ];
    }

    public function map($row): array
    {
        return [
            $row->firstname,
            $row->lastname,
            $row->email,
            $row->code,
            $row->created_at
        ];
    }
}
