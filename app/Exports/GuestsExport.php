<?php

namespace App\Exports;

use App\Models\Wedding;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GuestsExport implements FromCollection, WithHeadings
{
    public function __construct(protected Wedding $wedding)
    {
    }

    public function headings(): array
    {
        return ['Nombre', 'Pases asignados', 'Pases confirmados', 'Estado', 'Notas dieteticas', 'Respondido el'];
    }

    public function collection()
    {
        return $this->wedding->guests()->orderBy('name')->get()->map(fn ($guest) => [
            $guest->name,
            $guest->passes_allocated,
            $guest->passes_confirmed,
            $guest->rsvp_status,
            $guest->dietary_notes,
            optional($guest->responded_at)->format('d/m/Y H:i'),
        ]);
    }
}
