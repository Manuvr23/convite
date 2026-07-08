<?php

namespace App\Http\Controllers;

use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WeddingController extends Controller
{
    public function index()
    {
        $weddings = Wedding::withCount('guests')->latest()->get();

        return view('weddings.index', compact('weddings'));
    }

    public function create()
    {
        return view('weddings.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'wedding_date' => 'nullable|date',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string|max:255',
            'template' => 'required|string|in:classic,elegant,pastel',
        ]);

        $wedding = Wedding::create($data);

        return redirect()->route('weddings.show', $wedding)->with('status', 'Boda creada.');
    }

    public function show(Wedding $wedding)
    {
        $guests = $wedding->guests()->orderBy('name')->get();

        return view('weddings.show', compact('wedding', 'guests'));
    }

    public function edit(Wedding $wedding)
    {
        return view('weddings.edit', compact('wedding'));
    }

    public function update(Request $request, Wedding $wedding)
    {
        $data = $request->validate([
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'wedding_date' => 'nullable|date',
            'venue_name' => 'nullable|string|max:255',
            'venue_address' => 'nullable|string|max:255',
            'template' => 'required|string|in:classic,elegant,pastel',
            'is_active' => 'sometimes|boolean',
        ]);

        $data['is_active'] = $request->boolean('is_active');

        $wedding->update($data);

        return redirect()->route('weddings.show', $wedding)->with('status', 'Boda actualizada.');
    }

    public function destroy(Wedding $wedding)
    {
        $wedding->delete();

        return redirect()->route('weddings.index')->with('status', 'Boda eliminada.');
    }

    public function updateContent(Request $request, Wedding $wedding)
    {
        $data = $request->validate([
            'love_story' => 'nullable|string|max:5000',
            'dress_code' => 'nullable|string|max:255',
            'itinerary' => 'nullable|string|max:2000',
            'gift_bank_details' => 'nullable|string|max:1000',
            'gift_registry_url' => 'nullable|url|max:500',
        ]);

        $wedding->update([
            'config' => array_merge($wedding->config ?? [], [
                'love_story' => $data['love_story'] ?: null,
                'dress_code' => $data['dress_code'] ?: null,
                'itinerary' => $this->parseItinerary($data['itinerary'] ?? ''),
                'gift_bank_details' => $data['gift_bank_details'] ?: null,
                'gift_registry_url' => $data['gift_registry_url'] ?: null,
            ]),
        ]);

        return back()->with('status', 'Contenido actualizado.');
    }

    protected function parseItinerary(string $raw): array
    {
        $items = [];

        foreach (preg_split('/\r\n|\r|\n/', $raw) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }

            if (preg_match('/^(\d{1,2}:\d{2})\s*-\s*(.+)$/', $line, $m)) {
                $items[] = ['time' => $m[1], 'title' => $m[2]];
            } else {
                $items[] = ['time' => null, 'title' => $line];
            }
        }

        return $items;
    }

    public function storeGalleryImages(Request $request, Wedding $wedding)
    {
        $request->validate([
            'images' => 'required|array',
            'images.*' => 'image|max:5120',
        ]);

        $gallery = $wedding->gallery();

        foreach ($request->file('images') as $image) {
            $filename = Str::random(20).'.'.$image->getClientOriginalExtension();
            $image->storeAs("weddings/{$wedding->id}/gallery", $filename, 'public');
            $gallery[] = "weddings/{$wedding->id}/gallery/{$filename}";
        }

        $wedding->update(['config' => array_merge($wedding->config ?? [], ['gallery' => $gallery])]);

        return back()->with('status', 'Fotos agregadas.');
    }

    public function destroyGalleryImage(Wedding $wedding, string $file)
    {
        $path = "weddings/{$wedding->id}/gallery/{$file}";
        Storage::disk('public')->delete($path);

        $gallery = array_values(array_filter($wedding->gallery(), fn ($p) => $p !== $path));
        $wedding->update(['config' => array_merge($wedding->config ?? [], ['gallery' => $gallery])]);

        return back()->with('status', 'Foto eliminada.');
    }

    public function storeMusic(Request $request, Wedding $wedding)
    {
        $request->validate([
            'music' => 'required|file|mimes:mp3,wav,ogg|max:10240',
        ]);

        if ($wedding->musicPath()) {
            Storage::disk('public')->delete($wedding->musicPath());
        }

        $filename = Str::random(20).'.'.$request->file('music')->getClientOriginalExtension();
        $request->file('music')->storeAs("weddings/{$wedding->id}/music", $filename, 'public');

        $wedding->update(['config' => array_merge($wedding->config ?? [], [
            'music' => "weddings/{$wedding->id}/music/{$filename}",
        ])]);

        return back()->with('status', 'Musica actualizada.');
    }

    public function destroyMusic(Wedding $wedding)
    {
        if ($wedding->musicPath()) {
            Storage::disk('public')->delete($wedding->musicPath());
        }

        $wedding->update(['config' => array_merge($wedding->config ?? [], ['music' => null])]);

        return back()->with('status', 'Musica eliminada.');
    }
}
