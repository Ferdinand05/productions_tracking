<div class="max-w-lg mx-auto bg-white shadow p-6 rounded-2xl">
    <h2 class="text-lg font-semibold mb-4 text-center">Cek Status Produksi</h2>
    <form wire:submit.prevent="checkProduction" class="flex gap-2">
        <input wire:model="customer_code" type="text" placeholder="Masukkan Kode Customer..."
            class="grow border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">
        <button type="submit"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700 transition">
            Cek
        </button>
    </form>

    @if ($production)
    <div class="mt-6 border-t pt-4">
        <p><strong>Kode Produksi:</strong> {{ $production->code }}</p>
        <p><strong>Status:</strong> {{ $production->status }}</p>
        <p><strong>Estimasi Selesai:</strong> {{ $production->estimated_finish }}</p>
    </div>
    @endif
</div>