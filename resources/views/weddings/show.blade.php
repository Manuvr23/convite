<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $wedding->groom_name }} &amp; {{ $wedding->bride_name }}
            </h2>
            <a href="{{ route('weddings.edit', $wedding) }}" class="text-sm text-blue-600">Editar boda</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('status'))
                <div class="p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif
            @if ($errors->any())
                <div class="p-3 bg-red-100 text-red-800 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg p-6 flex flex-wrap gap-4 items-center justify-between">
                <div class="text-sm text-gray-600">
                    <div><strong>Fecha:</strong> {{ optional($wedding->wedding_date)->format('d/m/Y') ?? 'Sin definir' }}</div>
                    <div><strong>Lugar:</strong> {{ $wedding->venue_name ?? 'Sin definir' }}</div>
                    <div><strong>Plantilla:</strong> {{ $wedding->template }}</div>
                </div>
                <a href="{{ route('guests.export', $wedding) }}" class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-md text-sm">
                    Exportar a Excel
                </a>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold mb-4">Contenido adicional de la invitacion</h3>

                <form method="POST" action="{{ route('weddings.content', $wedding) }}" class="space-y-4 mb-8">
                    @csrf
                    <div>
                        <x-input-label for="dress_code" value="Codigo de vestimenta" />
                        <x-text-input id="dress_code" name="dress_code" type="text" class="mt-1 block w-full" value="{{ $wedding->dressCode() }}" placeholder="Ej: Formal, colores tierra" />
                    </div>
                    <div>
                        <x-input-label for="love_story" value="Nuestra historia (love story)" />
                        <textarea id="love_story" name="love_story" rows="4" class="mt-1 block w-full border-gray-300 rounded-md">{{ $wedding->loveStory() }}</textarea>
                    </div>
                    <div>
                        <x-input-label for="itinerary" value="Itinerario (una linea por actividad, formato HH:MM - Actividad)" />
                        <textarea id="itinerary" name="itinerary" rows="4" class="mt-1 block w-full border-gray-300 rounded-md font-mono text-sm" placeholder="16:00 - Ceremonia&#10;18:00 - Recepcion&#10;20:00 - Fiesta">{{ collect($wedding->itinerary())->map(fn ($i) => trim(($i['time'] ? $i['time'].' - ' : '').$i['title']))->implode("\n") }}</textarea>
                    </div>
                    <div>
                        <x-input-label for="gift_bank_details" value="Mesa de regalos - datos bancarios (opcional)" />
                        <textarea id="gift_bank_details" name="gift_bank_details" rows="3" class="mt-1 block w-full border-gray-300 rounded-md" placeholder="Banco X, Cuenta 123456, a nombre de...">{{ $wedding->giftBankDetails() }}</textarea>
                    </div>
                    <div>
                        <x-input-label for="gift_registry_url" value="Mesa de regalos - link a lista de regalos (opcional)" />
                        <x-text-input id="gift_registry_url" name="gift_registry_url" type="url" class="mt-1 block w-full" value="{{ $wedding->giftRegistryUrl() }}" placeholder="https://..." />
                    </div>
                    <x-primary-button>Guardar contenido</x-primary-button>
                </form>

                <div class="grid md:grid-cols-2 gap-6 pt-6 border-t">
                    <div>
                        <h4 class="font-medium mb-2 text-sm text-gray-700">Musica de fondo</h4>
                        @if ($wedding->musicPath())
                            <div class="flex items-center gap-3 mb-3">
                                <audio controls src="{{ asset('storage/'.$wedding->musicPath()) }}" class="w-full"></audio>
                                <form method="POST" action="{{ route('weddings.music.destroy', $wedding) }}" onsubmit="return confirm('¿Quitar la musica?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 text-xs whitespace-nowrap">Quitar</button>
                                </form>
                            </div>
                        @else
                            <p class="text-sm text-gray-500 mb-3">Sin musica cargada.</p>
                        @endif
                        <form method="POST" action="{{ route('weddings.music.store', $wedding) }}" enctype="multipart/form-data" class="space-y-2">
                            @csrf
                            <input type="file" name="music" accept="audio/*" required class="block w-full text-sm">
                            <x-primary-button>{{ $wedding->musicPath() ? 'Reemplazar' : 'Subir musica' }}</x-primary-button>
                        </form>
                    </div>

                    <div>
                        <h4 class="font-medium mb-2 text-sm text-gray-700">Galeria de fotos</h4>
                        @if (count($wedding->gallery()))
                            <div class="grid grid-cols-4 gap-2 mb-3">
                                @foreach ($wedding->gallery() as $path)
                                    <div class="relative group">
                                        <img src="{{ asset('storage/'.$path) }}" class="w-full h-16 object-cover rounded">
                                        <form method="POST" action="{{ route('weddings.gallery.destroy', [$wedding, basename($path)]) }}" onsubmit="return confirm('¿Eliminar esta foto?');" class="absolute top-0 right-0">
                                            @csrf
                                            @method('DELETE')
                                            <button class="bg-red-600 text-white text-xs w-5 h-5 rounded-bl">×</button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500 mb-3">Sin fotos cargadas.</p>
                        @endif
                        <form method="POST" action="{{ route('weddings.gallery.store', $wedding) }}" enctype="multipart/form-data" class="space-y-2">
                            @csrf
                            <input type="file" name="images[]" accept="image/*" multiple required class="block w-full text-sm">
                            <x-primary-button>Agregar fotos</x-primary-button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Agregar invitado</h3>
                    <form method="POST" action="{{ route('guests.store', $wedding) }}" class="space-y-3">
                        @csrf
                        <div>
                            <x-input-label for="name" value="Nombre" />
                            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="passes_allocated" value="Pases asignados" />
                            <x-text-input id="passes_allocated" name="passes_allocated" type="number" min="1" max="20" value="1" class="mt-1 block w-full" required />
                        </div>
                        <x-primary-button>Agregar</x-primary-button>
                    </form>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg p-6">
                    <h3 class="font-semibold mb-4">Importar invitados (CSV)</h3>
                    <p class="text-sm text-gray-500 mb-3">Columnas: nombre, pases asignados. Sin encabezado.</p>
                    <form method="POST" action="{{ route('guests.import', $wedding) }}" enctype="multipart/form-data" class="space-y-3">
                        @csrf
                        <input type="file" name="csv" accept=".csv,.txt" required class="block w-full text-sm">
                        <x-primary-button>Importar</x-primary-button>
                    </form>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 text-gray-600">
                        <tr>
                            <th class="px-6 py-3">Invitado</th>
                            <th class="px-6 py-3">Pases</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Link</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($guests as $guest)
                            <tr>
                                <td class="px-6 py-4">{{ $guest->name }}</td>
                                <td class="px-6 py-4">{{ $guest->passes_confirmed }}/{{ $guest->passes_allocated }}</td>
                                <td class="px-6 py-4">
                                    <span @class([
                                        'px-2 py-1 text-xs rounded' => true,
                                        'bg-green-100 text-green-800' => $guest->rsvp_status === 'confirmed',
                                        'bg-red-100 text-red-800' => $guest->rsvp_status === 'declined',
                                        'bg-gray-100 text-gray-600' => $guest->rsvp_status === 'pending',
                                    ])>
                                        {{ ['pending' => 'Pendiente', 'confirmed' => 'Confirmado', 'declined' => 'No asiste'][$guest->rsvp_status] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <input type="text" readonly onclick="this.select()" value="{{ route('invitation.show', $guest) }}" class="text-xs w-48 border-gray-200 rounded">
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form method="POST" action="{{ route('guests.destroy', $guest) }}" onsubmit="return confirm('¿Eliminar invitado?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 text-xs">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">Todavia no hay invitados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
