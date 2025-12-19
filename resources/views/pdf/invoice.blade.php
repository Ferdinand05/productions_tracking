<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Invoice</title>

    <style>
        @page {
            size: A4;
            margin: 24mm;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
            color: #333;
            background: #fff;
        }

        .container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        /* ===== KOP SURAT ===== */
        .header {
            border-bottom: 2px solid #333;
            padding-bottom: 12px;
            margin-bottom: 20px;
            display: table;
            width: 100%;
        }

        .company {
            display: table-cell;
            vertical-align: top;
        }

        .company h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .company p {
            margin: 4px 0 0;
            font-size: 11px;
            line-height: 1.4;
        }

        .invoice-title {
            display: table-cell;
            vertical-align: top;
            text-align: right;
        }

        .invoice-title h2 {
            margin: 0;
            font-size: 22px;
            letter-spacing: 2px;
        }

        .invoice-title p {
            margin-top: 4px;
            font-size: 11px;
        }

        /* ===== INFO ===== */
        .info {
            margin-bottom: 20px;
            width: 100%;
        }

        .info-left,
        .info-right {
            width: 50%;
            vertical-align: top;
        }

        .info table {
            width: 100%;
            border-collapse: collapse;
        }

        .info td {
            padding: 3px 0;
        }

        .label {
            color: #666;
            width: 120px;
        }

        /* ===== TABLE ITEMS ===== */
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table.items th,
        table.items td {
            border: 1px solid #999;
            padding: 6px 8px;
        }

        table.items th {
            background: #f0f0f0;
            text-align: left;
        }

        table.items td.right,
        table.items th.right {
            text-align: right;
        }

        table.items tfoot td {
            font-weight: bold;
        }

        /* ===== NOTES ===== */
        .notes {
            margin-top: 20px;
            font-style: italic;
        }

        /* ===== FOOTER ===== */
        .signature {
            margin-top: 60px;
            text-align: right;
        }

        .signature p {
            margin: 0;
        }
    </style>
</head>

<body>

    <div class="container">

        <!-- KOP SURAT -->
        <div class="header">
            <div class="company">
                <h1>PT NILOSA RAMA BUANA</h1>
                <p>
                    Jl. Rawa Bunga 13<br>
                    Pd. Kacang Bar., Kec. Pd. Aren, Kota Tangerang Selatan, Banten 15226<br>
                    Telp: 085895106510<br>
                    Email: nilosaramabuana22@gmail.com
                </p>
            </div>

            <div class="invoice-title">
                <h2>INVOICE</h2>
                <p>{{ $invoice->invoice_number }}</p>
            </div>
        </div>

        <!-- INFO -->
        <table class="info">
            <tr>
                <td class="info-left">
                    <table>
                        <tr>
                            <td class="label">Ditujukan ke</td>
                            <td>: {{ ucfirst($invoice->customer?->name ?? '-') }}</td>
                        </tr>
                    </table>
                </td>

                <td class="info-right">
                    <table>
                        <tr>
                            <td class="label">Tanggal</td>
                            <td>: {{ $invoice->invoice_date }}</td>
                        </tr>

                        @if ($invoice->due_date)
                            <tr>
                                <td class="label">Jatuh Tempo</td>
                                <td>: {{ $invoice->due_date }}</td>
                            </tr>
                        @endif

                        <tr>
                            <td class="label">Status</td>
                            <td>: {{ strtoupper($invoice->status) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <!-- ITEMS -->
        <table class="items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="right">Qty</th>
                    <th class="right">Harga</th>
                    <th class="right">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($invoice->items as $item)
                    <tr>
                        <td>{{ $item->product_name }}</td>
                        <td class="right">{{ $item->quantity }}</td>
                        <td class="right">Rp {{ number_format($item->price) }}</td>
                        <td class="right">Rp {{ number_format($item->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="3" class="right">TOTAL</td>
                    <td class="right">Rp {{ number_format($invoice->grand_total) }}</td>
                </tr>
            </tfoot>
        </table>

        <!-- NOTES -->
        @if ($invoice->notes)
            <div class="notes">
                Catatan: {{ $invoice->notes }}
            </div>
        @endif

        <!-- SIGNATURE -->
        <div class="signature">
            <p>Hormat Kami,</p>
            <br><br><br>
            <p><strong>PT Nilosa Rama Buana</strong></p>
        </div>

    </div>

</body>

</html>
