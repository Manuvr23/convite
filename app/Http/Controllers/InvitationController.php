<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InvitationController extends Controller
{
    public function show(Guest $guest)
    {
        $wedding = $guest->wedding;

        return view('invitation.templates.'.$wedding->template, compact('wedding', 'guest'));
    }

    public function rsvp(Request $request, Guest $guest)
    {
        $data = $request->validate([
            'attending' => 'required|in:yes,no',
            'passes_confirmed' => 'required_if:attending,yes|integer|min:1',
            'dietary_notes' => 'nullable|string|max:500',
        ]);

        if ($data['attending'] === 'yes' && $data['passes_confirmed'] > $guest->passes_allocated) {
            throw ValidationException::withMessages([
                'passes_confirmed' => 'No puedes confirmar mas pases de los asignados ('.$guest->passes_allocated.').',
            ]);
        }

        $guest->update([
            'rsvp_status' => $data['attending'] === 'yes' ? 'confirmed' : 'declined',
            'passes_confirmed' => $data['attending'] === 'yes' ? $data['passes_confirmed'] : 0,
            'dietary_notes' => $data['dietary_notes'] ?? null,
            'responded_at' => now(),
        ]);

        return back()->with('status', 'Gracias por confirmar tu asistencia.');
    }
}
