<html>
    <head>

    {{-- Vite + Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    
    <body>
        <section>
                <table class="w-full text-sm border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2 border text-left">Nama Bahan</th>
                        <th class="px-4 py-2 border text-center">Jumlah</th>
                        <th class="px-4 py-2 border text-center">Satuan</th>
                        <th class="px-4 py-2 border text-left">Supplier</th>
                        <th class="px-4 py-2 border text-left">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($record->materials as $material)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 border font-medium text-gray-800">
                                {{ $material->material_name }}
                            </td>
                            <td class="px-4 py-2 border text-center text-gray-700">
                                {{ number_format($material->quantity, 2) }}
                            </td>
                            <td class="px-4 py-2 border text-center text-gray-700">
                                {{ $material->unit }}
                            </td>
                            <td class="px-4 py-2 border text-gray-600 italic">
                                {{ $material->supplier ?? '-' }}
                            </td>
                            <td class="px-4 py-2 border text-gray-600 italic">
                                {{ $material->note ?? '-' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 italic py-3">
                                Belum ada data bahan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </section>
    </body>
</html>
