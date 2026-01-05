<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Produksi</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 18px;
            margin: 0;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 12px;
        }

        .production-box {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }

        .section-title {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 6px;
            border-bottom: 1px solid #000;
            padding-bottom: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: top;
        }

        table th {
            background-color: #f2f2f2;
            text-align: left;
        }

        .no-border td {
            border: none;
            padding: 3px 0;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .status {
            font-weight: bold;
            text-transform: uppercase;
        }

        .footer {
            position: fixed;
            bottom: 15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 9px;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    {{-- ================= HEADER ================= --}}
    <div class="header">
        <h1>LAPORAN PRODUKSI</h1>
        <p>Dicetak pada {{ now()->format('d-m-Y H:i') }}</p>
    </div>

    {{-- ================= DATA PRODUKSI ================= --}}
    @foreach ($productions as $production)
        <div class="production-box">

            {{-- INFORMASI UTAMA --}}
            <div class="section-title">{{ $loop->iteration }} Informasi Produksi</div>
            <table class="no-border">
                <tr>
                    <td width="30%">Kode Produksi</td>
                    <td width="5%">:</td>
                    <td>{{ $production->production_code }}</td>
                </tr>
                <tr>
                    <td> Nama Produk</td>
                    <td>:</td>
                    <td>{{ $production->product_name }}</td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td>:</td>
                    <td>{{ $production->description ?? '-' }}</td>
                </tr>
                <tr>
                    <td>Jumlah Produksi</td>
                    <td>:</td>
                    <td>{{ $production->quantity_product }}</td>
                </tr>
                <tr>
                    <td>Tanggal Mulai</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($production->start_date)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>Estimasi Selesai</td>
                    <td>:</td>
                    <td>{{ \Carbon\Carbon::parse($production->estimated_end_date)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>:</td>
                    <td class="status">{{ $production->status }}</td>
                </tr>
            </table>

            {{-- CUSTOMER --}}
            @if ($production->customer)
                <div class="section-title">Data Customer</div>
                <table class="no-border">
                    <tr>
                        <td width="30%">Nama Customer</td>
                        <td width="5%">:</td>
                        <td>{{ $production->customer->name }}</td>
                    </tr>
                    <tr>
                        <td>Kontak</td>
                        <td>:</td>
                        <td>{{ $production->customer->phone ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>:</td>
                        <td>{{ $production->customer->address ?? '-' }}</td>
                    </tr>
                </table>
            @endif

            {{-- MATERIAL --}}
            <div class="section-title">Daftar Material</div>
            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Material</th>
                        <th width="20%">Jumlah</th>
                        <th width="20%">Satuan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($production->materials as $material)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $material->material_name }}</td>
                            <td class="text-right">{{ $material->quantity }}</td>
                            <td>{{ $material->unit }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data material</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- TAHAP PRODUKSI --}}
            @if ($production->stages && $production->stages->count())
                <div class="section-title">Tahapan Produksi</div>
                <table>
                    <thead>
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama Tahap</th>
                            <th width="20%">Status</th>
                            <th width="30%">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($production->stages as $stage)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $stage->stage_name }}</td>
                                <td>{{ ucfirst($stage->status) }}</td>
                                <td>{{ $stage->description ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        </div>

        {{-- PAGE BREAK ANTAR PRODUKSI --}}
        @if (!$loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach

    {{-- ================= FOOTER ================= --}}
    <div class="footer">
        Laporan Produksi • {{ config('app.name') }}
    </div>

</body>

</html>
