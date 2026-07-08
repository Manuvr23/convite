<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Bodas</h2>
            <a href="{{ route('weddings.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md text-sm">Nueva boda</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('status') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-sm text-gray-600">
                        <tr>
                            <th class="px-6 py-3">Pareja</th>
                            <th class="px-6 py-3">Fecha</th>
                            <th class="px-6 py-3">Invitados</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse ($weddings as $wedding)
                            <tr>
                                <td class="px-6 py-4">{{ $wedding->groom_name }} &amp; {{ $wedding->bride_name }}</td>
                                <td class="px-6 py-4">{{ optional($wedding->wedding_date)->format('d/m/Y') ?? '-' }}</td>
                                <td class="px-6 py-4">{{ $wedding->guests_count }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs rounded {{ $wedding->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                        {{ $wedding->is_active ? 'Activa' : 'Inactiva' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('weddings.show', $wedding) }}" class="text-sm text-blue-600">Ver</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-6 text-center text-gray-500">Todavia no hay bodas cargadas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
