<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    {{ __("You're logged in as") }} {{ Auth::user()->role }} 
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">
    <div class="p-6 bg-blue-100 border border-blue-200 rounded-lg shadow">
        <h5 class="text-gray-500">Total Aset</h5>
        <p class="text-3xl font-bold">{{ $totalAssets }}</p>
    </div>

    <div class="p-6 bg-yellow-100 border border-yellow-200 rounded-lg shadow">
        <h5 class="text-gray-500">Aset Dipinjam</h5>
        <p class="text-3xl font-bold">{{ $borrowedAssets }}</p>
    </div>

    <div class="p-6 bg-orange-100 border border-orange-200 rounded-lg shadow">
        <h5 class="text-gray-500">Dalam Perbaikan</h5>
        <p class="text-3xl font-bold">{{ $inRepairAssets }}</p>
    </div>

    <div class="p-6 bg-red-100 border border-red-200 rounded-lg shadow">
        <h5 class="text-gray-500">Aset Rusak (Butuh Perbaikan)</h5>
        <p class="text-3xl font-bold">{{ $brokenAssets }}</p>
    </div>
</div>
</x-app-layout>
