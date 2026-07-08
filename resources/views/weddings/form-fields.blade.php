@php $wedding = $wedding ?? null; @endphp

<div class="grid grid-cols-2 gap-4">
    <div>
        <x-input-label for="groom_name" value="Nombre del novio" />
        <x-text-input id="groom_name" name="groom_name" type="text" class="mt-1 block w-full" :value="old('groom_name', $wedding?->groom_name)" required />
        <x-input-error :messages="$errors->get('groom_name')" class="mt-1" />
    </div>
    <div>
        <x-input-label for="bride_name" value="Nombre de la novia" />
        <x-text-input id="bride_name" name="bride_name" type="text" class="mt-1 block w-full" :value="old('bride_name', $wedding?->bride_name)" required />
        <x-input-error :messages="$errors->get('bride_name')" class="mt-1" />
    </div>
</div>

<div class="grid grid-cols-2 gap-4 mt-4">
    <div>
        <x-input-label for="wedding_date" value="Fecha de la boda" />
        <x-text-input id="wedding_date" name="wedding_date" type="date" class="mt-1 block w-full" :value="old('wedding_date', optional($wedding?->wedding_date)->format('Y-m-d'))" />
        <x-input-error :messages="$errors->get('wedding_date')" class="mt-1" />
    </div>
    <div>
        <x-input-label for="template" value="Plantilla" />
        <select id="template" name="template" class="mt-1 block w-full border-gray-300 rounded-md">
            <option value="classic" @selected(old('template', $wedding?->template) === 'classic')>Clasica (crema y dorado)</option>
            <option value="elegant" @selected(old('template', $wedding?->template) === 'elegant')>Elegante (oscura y dorada)</option>
            <option value="pastel" @selected(old('template', $wedding?->template) === 'pastel')>Pastel Romantica (rosa y salvia)</option>
        </select>
        <x-input-error :messages="$errors->get('template')" class="mt-1" />
    </div>
</div>

<div class="grid grid-cols-2 gap-4 mt-4">
    <div>
        <x-input-label for="venue_name" value="Lugar" />
        <x-text-input id="venue_name" name="venue_name" type="text" class="mt-1 block w-full" :value="old('venue_name', $wedding?->venue_name)" />
        <x-input-error :messages="$errors->get('venue_name')" class="mt-1" />
    </div>
    <div>
        <x-input-label for="venue_address" value="Direccion" />
        <x-text-input id="venue_address" name="venue_address" type="text" class="mt-1 block w-full" :value="old('venue_address', $wedding?->venue_address)" />
        <x-input-error :messages="$errors->get('venue_address')" class="mt-1" />
    </div>
</div>

@if ($wedding)
    <div class="mt-4 flex items-center">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', $wedding->is_active))>
        <label for="is_active" class="ms-2 text-sm text-gray-600">Boda activa (pagina de invitacion visible)</label>
    </div>
@endif
