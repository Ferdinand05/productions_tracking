

<section class="p-4 space-y-4">
    <h2 class="text-lg font-semibold text-gray-800">
        Daftar Tahap Produksi
    </h2>

    <table class="w-full text-sm border-collapse">
        <thead>
            <tr class="bg-gray-100 text-gray-700 text-left">
                <th class="p-3 border">Tahap</th>
                <th class="p-3 border">Deskripsi</th>
                <th class="p-3 border">Status</th>
                <th class="p-3 border">Tanggal Mulai</th>
                <th class="p-3 border">Tanggal Selesai</th>
                <th class="p-3 border text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($record->stages as $stage)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-3 border font-medium text-gray-800">{{ $stage->stage_name }}</td>
                    <td class="p-3 border text-gray-600">{{ $stage->description }}</td>
                    <td class="p-3 border">
                        @php
                            $color = match ($stage->status) {
                                'pending' => 'bg-gray-300 text-gray-800',
                                'in_progress' => 'bg-yellow-200 text-yellow-800',
                                'done' => 'bg-green-200 text-green-800',
                                default => 'bg-gray-200 text-gray-700',
                            };
                        @endphp
                        <span class="px-2 py-1 rounded text-xs font-semibold {{ $color }}">
                            {{ ucfirst(str_replace('_', ' ', $stage->status)) }}
                        </span>
                    </td>
                    <td class="p-3 border text-gray-700">
                        {{ $stage->start_date ? \Carbon\Carbon::parse($stage->start_date)->format('d M Y') : '-' }}
                    </td>
                    <td class="p-3 border text-gray-700">
                        {{ $stage->end_date ? \Carbon\Carbon::parse($stage->end_date)->format('d M Y') : '-' }}
                    </td>
                    <td class="p-3 border text-center space-x-1">
                        {{-- Tombol Aksi Berdasarkan Status --}}
                        @if ($stage->status === 'pending')
                            <button
                                wire:click.prevent="startStage({{ $stage->id }})"
                                class="px-2 py-1 text-xs bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                                Mulai
                            </button>
                        @elseif ($stage->status === 'in_progress')
                            <button
                                wire:click.prevent="completeStage({{ $stage->id }})"
                                class="px-2 py-1 text-xs bg-green-500 text-white rounded hover:bg-green-600 transition">
                                Selesai
                            </button>
                        @endif

                        
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($record->stages->isEmpty())
        <div class="text-center py-6 text-gray-500">
            Belum ada tahap produksi.
        </div>
    @endif
</section>

