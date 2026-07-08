<?php

namespace App\Http\Controllers;

use App\Exports\GuestsExport;
use App\Models\Guest;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuestController extends Controller
{
    public function store(Request $request, Wedding $wedding)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'passes_allocated' => 'required|integer|min:1|max:20',
        ]);

        $wedding->guests()->create($data);

        return back()->with('status', 'Invitado agregado.');
    }

    public function import(Request $request, Wedding $wedding)
    {
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt',
        ]);

        $handle = fopen($request->file('csv')->getRealPath(), 'r');
        $imported = 0;

        while (($row = fgetcsv($handle)) !== false) {
            $name = trim($row[0] ?? '');
            $passes = (int) ($row[1] ?? 1);

            if ($name === '') {
                continue;
            }

            $wedding->guests()->create([
                'name' => $name,
                'passes_allocated' => max(1, $passes),
            ]);
            $imported++;
        }
        fclose($handle);

        return back()->with('status', "Se importaron {$imported} invitados.");
    }

    public function destroy(Guest $guest)
    {
        $wedding = $guest->wedding;
        $guest->delete();

        return redirect()->route('weddings.show', $wedding)->with('status', 'Invitado eliminado.');
    }

    public function export(Wedding $wedding)
    {
        $filename = str($wedding->groom_name.'-'.$wedding->bride_name)->slug().'-invitados.xlsx';

        return Excel::download(new GuestsExport($wedding), $filename);
    }
}
