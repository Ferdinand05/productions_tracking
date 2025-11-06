<div class="mt-3">

    <div class="overflow-x-auto border rounded-lg shadow-sm bg-white dark:bg-gray-800">
        <table class="min-w-full border-collapse">
            <thead>
                <tr
                    class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-100 text-sm uppercase tracking-wide">
                    <th class="px-4 py-3 text-left border-b">Kode Produksi</th>
                    <th class="px-4 py-3 text-left border-b">Produk</th>
                    <th class="px-4 py-3 text-center border-b">Jumlah</th>
                    <th class="px-4 py-3 text-left border-b">Deskripsi</th>
                    <th class="px-4 py-3 text-center border-b">Tgl. Mulai</th>
                    <th class="px-4 py-3 text-center border-b">Estimasi Selesai</th>
                    <th class="px-4 py-3 text-center border-b">Status</th>
                    <th class="px-4 py-3 text-center border-b">Aksi</th>
                </tr>
            </thead>

            <tbody class="text-sm text-gray-700 dark:text-gray-200">
                @foreach ($productions as $index => $item)
                    <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">
                            {{ $item->production_code }}</td>
                        <td class="px-4 py-3">{{ $item->product_name }}</td>
                        <td class="px-4 py-3 text-center">{{ $item->quantity_product }}</td>
                        <td class="px-4 py-3">{{ $item?->description ?? '-' }}</td>
                        <td class="px-4 py-3 text-center">
                            {{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-center">
                            {{ \Carbon\Carbon::parse($item->estimated_end_date)->format('d M Y') }}</td>

                        {{-- Status badge --}}
                        <td class="px-4 py-3 text-center">
                            @php
                                $statusColor = match ($item->status) {
                                    'draft' => 'bg-green-100 text-green-700 border-green-300',
                                    'in_progress' => 'bg-blue-100 text-blue-700 border-blue-300',
                                    'completed' => 'bg-yellow-100 text-yellow-700 border-yellow-300',
                                    default => 'bg-gray-100 text-gray-700 border-gray-300',
                                };
                            @endphp
                            <span
                                class="px-2 py-1 text-xs font-semibold border rounded-full uppercase {{ $statusColor }}">
                                {{ $item->status }}
                            </span>
                        </td>

                        {{-- Tombol Aksi --}}
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <button wire:click="modalStage('{{ $item->production_code }}')"
                                    wire:loading.attr="disabled"
                                    class="px-2 py-1 hover:cursor-pointer disabled:bg-blue-200 bg-indigo-600 hover:bg-indigo-700 text-white rounded-md transition">
                                    <div class="flex items-center gap-1">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6 6.878V6a2.25 2.25 0 0 1 2.25-2.25h7.5A2.25 2.25 0 0 1 18 6v.878m-12 0c.235-.083.487-.128.75-.128h10.5c.263 0 .515.045.75.128m-12 0A2.25 2.25 0 0 0 4.5 9v.878m13.5-3A2.25 2.25 0 0 1 19.5 9v.878m0 0a2.246 2.246 0 0 0-.75-.128H5.25c-.263 0-.515.045-.75.128m15 0A2.25 2.25 0 0 1 21 12v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6c0-.98.626-1.813 1.5-2.122" />
                                            </svg>

                                        </span>
                                        <span>
                                            Tahap
                                        </span>

                                    </div>
                                </button>
                                <button wire:click="modalMaterial('{{ $item->production_code }}')"
                                    wire:loading.attr="disabled"
                                    class="px-2 py-1  hover:cursor-pointer bg-emerald-600 disabled:bg-emerald-200 hover:bg-emerald-700 text-white rounded-md transition">
                                    <div class="flex items-center gap-1">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m21 7.5-9-5.25L3 7.5m18 0-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                                            </svg>
                                        </span>
                                        <span>
                                            Bahan
                                        </span>

                                    </div>

                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- modal tahap --}}
    <div wire:show="showModalStage"
        class="fixed inset-0 bg-gray-900/45 z-50 flex items-center justify-center  transition duration-300">
        <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-2xl p-6 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Tahap Produksi</h3>
                <button x-on:click="$wire.showModalStage = false"
                    class="text-gray-500  px-1.5 border rounded-full font-medium hover:cursor-pointer hover:text-gray-700 absolute top-4 right-4">
                    X
                </button>
            </div>
            <div>
                {{-- Konten modal tahap produksi --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold border-b">No</th>
                                <th class="px-4 py-3 text-left font-semibold border-b">Bagian</th>
                                <th class="px-4 py-3 text-left font-semibold border-b">Deskripsi</th>
                                <th class="px-4 py-3 text-left font-semibold border-b">Tgl. Mulai</th>
                                <th class="px-4 py-3 text-left font-semibold border-b">Tgl. Selesai</th>
                                <th class="px-4 py-3 text-left font-semibold border-b">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 text-gray-700">
                            @forelse ($stages as $index =>  $stage)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 font-medium">{{ $stage->stage_name }}</td>
                                    <td class="px-4 py-2">{{ $stage->description ?? '-' }}</td>
                                    <td class="px-4 py-2">
                                        {{ $stage->start_date ? \Carbon\Carbon::parse($stage->start_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $stage->end_date ? \Carbon\Carbon::parse($stage->end_date)->format('d M Y') : '-' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        @php
                                            $statusColor = match ($stage->status) {
                                                'done' => 'bg-green-100 text-green-800',
                                                'in_progress' => 'bg-yellow-100 text-yellow-800',
                                                'pending' => 'bg-blue-100 text-blue-800',
                                                default => 'bg-gray-100 text-gray-700',
                                            };
                                        @endphp
                                        <span
                                            class="px-2 py-1 text-xs rounded-full uppercase font-semibold {{ $statusColor }}">
                                            {{ ucfirst($stage->status ?? '-') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-4 text-center text-gray-500 italic">
                                        Belum ada tahap produksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <button x-on:click="$wire.showModalStage = false"
                    class="mt-4 bg-gray-600 hover:bg-gray-700 hover:cursor-pointer text-white  px-3 py-1.5 rounded-md transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    {{-- modal bahan / material --}}
    <div wire:show="showModalMaterial"
        class="fixed inset-0 bg-gray-900/45 z-50 flex items-center justify-center  transition duration-300">
        <div class="bg-white rounded-lg shadow-lg w-11/12 max-w-2xl p-6 relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Bahan Produksi</h3>
                <button x-on:click="$wire.showModalMaterial = false"
                    class="text-gray-500  px-1.5 border rounded-full font-medium hover:cursor-pointer hover:text-gray-700 absolute top-4 right-4">
                    X
                </button>
            </div>
            <div>
                {{-- Konten modal Bahan Produksi --}}
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden text-sm">
                        <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                            <tr>
                                <th class="px-4 py-3 text-left font-semibold border-b">No</th>
                                <th class="px-4 py-3 text-left font-semibold border-b">Material</th>
                                <th class="px-4 py-3 text-left font-semibold border-b">Jumlah</th>
                                <th class="px-4 py-3 text-left font-semibold border-b">Satuan</th>
                                <th class="px-4 py-3 text-left font-semibold border-b">Supplier</th>
                                <th class="px-4 py-3 text-left font-semibold border-b">Catatan</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200 text-gray-700">
                            @forelse ($materials as $index =>  $material)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 font-medium">{{ $material->material_name }}</td>
                                    <td class="px-4 py-2 ">{{ $material->quantity }}</td>
                                    <td class="px-4 py-2 ">{{ $material->unit ?? '-' }}</td>
                                    <td class="px-4 py-2 ">{{ $material->supplier ?? '-' }}</td>
                                    <td class="px-4 py-2 ">{{ $material->note ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-4 text-center text-gray-500 italic">
                                        Belum ada bahan produksi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="mt-6 flex justify-end">
                <button x-on:click="$wire.showModalMaterial = false"
                    class="mt-4 bg-gray-600 hover:bg-gray-700 hover:cursor-pointer text-white  px-3 py-1.5 rounded-md transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>


</div>
