<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Produksi {{ $customer->name }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        h1,
        h2,
        h3 {
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .section {
            margin-bottom: 25px;
        }

        .stage-table,
        .material-table {
            margin-top: 5px;
        }

        .small {
            font-size: 11px;
            color: #555;
        }
    </style>
</head>

<body>
    <h2>Laporan Produksi - {{ $customer->name }}</h2>
    <p><strong>Kode Customer:</strong> {{ $customer->customer_code }}</p>
    <hr>

    @foreach ($productions as $index => $production)
        <div class="section">
            <h3>{{ $index + 1 }}. Produksi: {{ $production->production_code }}</h3>
            <p><strong>Produk:</strong> {{ $production->product_name }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ $production->start_date }} |
                <strong>Estimasi Selesai:</strong> {{ $production->estimated_end_date }}
            </p>
            <p class="capitalize"><strong>Status:</strong> <span
                    style="padding: 2px 4px;border:1px solid black;border-radius:15px">{{ $production->status }}</span>
            </p>

            <h4>Tahapan Produksi</h4>
            <table class="stage-table">
                <thead>
                    <tr>
                        <th>Bagian</th>
                        <th>Deskripsi</th>
                        <th>Tgl. Mulai</th>
                        <th>Tgl. Selesai</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($production->stages as $stage)
                        <tr>
                            <td>{{ $stage->stage_name }}</td>
                            <td>{{ $stage->description }}</td>
                            <td>{{ $stage->start_date }}</td>
                            <td>{{ $stage->end_date }}</td>
                            <td>{{ ucfirst($stage->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h4>Material / Bahan</h4>
            <table class="material-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Supplier</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($production->materials as $mat)
                        <tr>
                            <td>{{ $mat->material_name }}</td>
                            <td>{{ $mat->quantity }}</td>
                            <td>{{ $mat->unit }}</td>
                            <td>{{ $mat->supplier }}</td>
                            <td>{{ $mat->note }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <hr>
    @endforeach

    <p class="small">Dicetak pada {{ now()->format('d M Y H:i') }}</p>
</body>

</html>
