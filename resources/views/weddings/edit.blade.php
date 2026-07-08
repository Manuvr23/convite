<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar boda</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('weddings.update', $wedding) }}">
                    @csrf
                    @method('PUT')
                    @include('weddings.form-fields', ['wedding' => $wedding])

                    <div class="mt-6 flex justify-end">
                        <x-primary-button>Guardar cambios</x-primary-button>
                    </div>
                </form>

                <form method="POST" action="{{ route('weddings.destroy', $wedding) }}" onsubmit="return confirm('¿Eliminar esta boda y todos sus invitados?');" class="mt-4 pt-4 border-t">
                    @csrf
                    @method('DELETE')
                    <x-danger-button type="submit">Eliminar boda</x-danger-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
