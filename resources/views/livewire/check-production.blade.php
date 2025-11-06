<div class=" max-w-5xl mx-auto bg-white shadow p-6 rounded-2xl">
    <h2 class="text-lg font-semibold mb-4 text-center">Cek Produksi</h2>
    <section class="mb-4 max-w-2xl mx-auto">
        <form wire:submit.prevent="checkProduction" class="flex  gap-2">
            <input wire:model="customer_code" type="text" placeholder="Masukkan Kode Customer..."
                class="grow border     mx-auto border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500 focus:outline-none">

            <div class="relative inline-flex  ">
                <!-- Tombol utama -->
                <button type="submit"
                    class="bg-blue-600 w-full hover:cursor-pointer text-white px-4 py-2 rounded hover:bg-blue-700 transition disabled:opacity-50 flex items-center gap-2"
                    wire:loading.attr="disabled">
                    <!-- Ikon loading -->
                    <svg wire:loading wire:target="checkProduction" class="animate-spin h-5 w-5 text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>

                    <!-- Teks tombol -->
                    <span wire:loading.remove wire:target="checkProduction">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>

                    </span>
                    <span wire:loading wire:target="checkProduction">Memeriksa...</span>
                </button>
            </div>

        </form>
        <div class="flex flex-col space-y-3">
            <div>
                @error('customer_code')
                    <small class="text-red-600">{{ $message }}</small>
                @enderror
            </div>

            <div wire:loading wire:target="checkProduction" class="text-center mt-4 text-gray-500 font-semibold">
                Mencari...
            </div>
        </div>
    </section>

    @if ($message)
        <div class="text-red-500">
            Produksi Tidak Ditemukan
        </div>
    @endif


    {{-- tampilkan produksi disini --}}

    @if ($productions)
        <div class=" flex justify-between items-center">
            <div class=" font-semibold">
                Daftar Produksi {{ $customer->name }} :
            </div>
            <a href="{{ route('production.print', $customer->customer_code) }}" target="_blank"
                class="inline-flex items-center gap-2 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                </svg>

                Cetak PDF
            </a>
        </div>

        <livewire:production-table :customer="$customer" :productions="$productions" />
    @endif

</div>
