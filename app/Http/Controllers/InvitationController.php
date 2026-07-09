<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Wedding;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class InvitationController extends Controller
{
    public function show(Guest $guest)
    {
        $wedding = $guest->wedding;

        return view('invitation.templates.'.$wedding->template, compact('wedding', 'guest'));
    }

    /**
     * Imagen de vista previa (Open Graph) que se muestra al compartir el link
     * por WhatsApp/redes. 1200x630 PNG generada al vuelo con GD, en la paleta
     * de la plantilla elegida.
     */
    public function ogImage(Wedding $wedding)
    {
        $palettes = [
            'classic' => ['bg' => '#fbf6f1', 'ink' => '#47373d', 'accent' => '#96703e', 'soft' => '#b08d57'],
            'elegant' => ['bg' => '#14181f', 'ink' => '#ede7d9', 'accent' => '#cba45c', 'soft' => '#8a7f66'],
            'pastel' => ['bg' => '#fbf6f1', 'ink' => '#47373d', 'accent' => '#b76e79', 'soft' => '#8ca38b'],
        ];
        $p = $palettes[$wedding->template] ?? $palettes['classic'];

        $w = 1200;
        $h = 630;
        $img = imagecreatetruecolor($w, $h);

        $bg = $this->allocHex($img, $p['bg']);
        $ink = $this->allocHex($img, $p['ink']);
        $accent = $this->allocHex($img, $p['accent']);
        $soft = $this->allocHex($img, $p['soft']);
        imagefilledrectangle($img, 0, 0, $w, $h, $bg);

        $serif = resource_path('fonts/PlayfairDisplay-SemiBold.ttf');
        $script = resource_path('fonts/GreatVibes-Regular.ttf');

        // Marco decorativo doble
        imagesetthickness($img, 2);
        imagerectangle($img, 40, 40, $w - 40, $h - 40, $soft);
        imagerectangle($img, 48, 48, $w - 48, $h - 48, $soft);

        // Monograma (circulo + iniciales)
        $cx = $w / 2;
        $cy = 155;
        imagesetthickness($img, 3);
        imageellipse($img, (int) $cx, $cy, 118, 118, $accent);
        $this->centeredText($img, 34, $cy + 12, $accent, $serif, $wedding->initials(), $w);

        // Eyebrow "N O S   C A S A M O S"
        $this->centeredText($img, 20, 275, $soft, $serif, $this->spaced('NOS CASAMOS'), $w);

        // Nombres (script, auto-ajuste de tamaño para que entren)
        $names = $wedding->groom_name.' & '.$wedding->bride_name;
        $size = 108;
        while ($size > 44) {
            $bbox = imagettfbbox($size, 0, $script, $names);
            if (($bbox[2] - $bbox[0]) <= ($w - 200)) {
                break;
            }
            $size -= 4;
        }
        $this->centeredText($img, $size, 415, $accent, $script, $names, $w);

        // Divisor con rombo
        imagesetthickness($img, 2);
        imageline($img, (int) ($cx - 140), 470, (int) ($cx - 24), 470, $soft);
        imageline($img, (int) ($cx + 24), 470, (int) ($cx + 140), 470, $soft);
        imagefilledpolygon($img, [(int) $cx, 462, (int) $cx + 9, 470, (int) $cx, 478, (int) $cx - 9, 470], $accent);

        // Fecha
        if ($wedding->wedding_date) {
            $fecha = $wedding->wedding_date->locale('es')->isoFormat('D [de] MMMM, YYYY');
            $this->centeredText($img, 30, 540, $ink, $serif, $fecha, $w);
        }

        ob_start();
        imagepng($img);
        $data = ob_get_clean();
        imagedestroy($img);

        return response($data, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    private function allocHex($img, string $hex): int
    {
        $hex = ltrim($hex, '#');
        return imagecolorallocate(
            $img,
            hexdec(substr($hex, 0, 2)),
            hexdec(substr($hex, 2, 2)),
            hexdec(substr($hex, 4, 2))
        );
    }

    private function centeredText($img, float $size, int $y, int $color, string $font, string $text, int $canvasW): void
    {
        $bbox = imagettfbbox($size, 0, $font, $text);
        $textW = $bbox[2] - $bbox[0];
        $x = (int) (($canvasW - $textW) / 2 - $bbox[0]);
        imagettftext($img, $size, 0, $x, $y, $color, $font, $text);
    }

    private function spaced(string $text): string
    {
        return trim(implode(' ', mb_str_split($text)));
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
