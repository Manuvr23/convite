<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nueva boda</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('weddings.store') }}">
                    @csrf
                    @include('weddings.form-fields', ['wedding' => null])

                    <div class="mt-6 flex justify-end">
                        <x-primary-button>Crear boda</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
