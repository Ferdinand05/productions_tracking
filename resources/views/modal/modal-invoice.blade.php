<html>

<head>
    {{-- Vite + Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
    <section>
        <!-- Modal -->
        <div class="bg-white w-full max-w-4xl  overflow-hidden">

            <!-- Header -->
            <div class="px-6 py-4 border-b flex flex-wrap items-center gap-3 justify-between">
                <h2 class="text-lg font-semibold text-gray-800 truncate">
                    Invoice/Nota
                </h2>

                <span
                    class="shrink-0 px-3 py-1 text-xs font-semibold rounded-full whitespace-nowrap
                @class([
                    'bg-green-100 text-green-700' => $invoice->status === 'paid',
                    'bg-yellow-100 text-yellow-700' => $invoice->status === 'draft',
                    'bg-red-100 text-red-700' => $invoice->status === 'dp',
                ])">
                    {{ strtoupper($invoice->status) }}
                </span>
            </div>


            <!-- Content -->
            <div class="p-6 space-y-6 text-sm text-gray-700">

                <!-- Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-500">Nomor Invoice</p>
                        <p class="font-medium">{{ $invoice->invoice_number }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500">Customer</p>
                        <p class="font-medium">{{ $invoice->customer?->name ?? '-' }}</p>
                    </div>


                    <div>
                        <p class="text-gray-500">Tanggal</p>
                        <p class="font-medium">{{ $invoice->invoice_date }}</p>
                    </div>


                    <div>
                        <p class="text-gray-500">Jatuh Tempo</p>
                        <p class="font-medium">{{ $invoice->due_date ?? '-' }}</p>
                    </div>
                </div>

                <!-- Items -->
                <div>
                    <p class="font-semibold text-gray-800 mb-3">Invoice Items</p>

                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[600px] border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 text-gray-600">
                                <tr>
                                    <th class="px-4 py-2 text-left">Item</th>
                                    <th class="px-4 py-2 text-right">Qty</th>
                                    <th class="px-4 py-2 text-right">harga</th>
                                    <th class="px-4 py-2 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($invoice->items as $item)
                                    <tr class="border-t hover:bg-gray-50">
                                        <td class="px-4 py-2">
                                            {{ $item->product_name }}
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            {{ $item->quantity }}
                                        </td>
                                        <td class="px-4 py-2 text-right">
                                            Rp {{ number_format($item->price) }}
                                        </td>
                                        <td class="px-4 py-2 text-right font-medium">
                                            Rp {{ number_format($item->subtotal) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="font-semibold text-lg" colspan="1">Total</td>
                                    <td></td>
                                    <td></td>
                                    <td class="font-semibold text-lg text-right">
                                        Rp {{ number_format($invoice->grand_total) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>


                <!-- Notes -->
                @if ($invoice->notes)
                    <div class="border rounded-lg bg-gray-50 p-4">
                        <p class="text-gray-500 mb-1">Catatan</p>
                        <p class="italic text-gray-700">
                            {{ $invoice->notes }}
                        </p>
                    </div>
                @endif



            </div>



        </div>

    </section>
</body>

</html>
