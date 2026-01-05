<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Produksi</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #000;
        }

        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitle {
            text-align: center;
            font-size: 12px;
            margin-bottom: 20px;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 8px;
            border-bottom: 1px solid #000;
            padding-bottom: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
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
            padding: 4px 0;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 10px;
        }
    </style>
</head>

<body>

    {{-- ================= JUDUL ================= --}}
    <div class="title">LAPORAN DETAIL PRODUKSI</div>
    <div class="subtitle">
        Kode Produksi: <strong>{{ $production->production_code }}</strong>
    </div>

    {{-- ================= INFORMASI UMUM ================= --}}
    <div class="section">
        <div class="section-title">Informasi Produksi</div>

        <table class="no-border">
            <tr>
                <td width="30%">Nama Produk</td>
                <td width="5%">:</td>
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
                <td>{{ ucfirst($production->status) }}</td>
            </tr>
        </table>
    </div>

    {{-- ================= DATA CUSTOMER ================= --}}
    @if ($production->customer)
        <div class="section">
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
        </div>
    @endif

    {{-- ================= MATERIAL ================= --}}
    <div class="section">
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
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $material->material_name }}</td>
                        <td class="text-right">{{ $material->quantity }}</td>
                        <td>{{ $material->unit }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">
                            Tidak ada data material
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================= TAHAP PRODUKSI ================= --}}
    @if ($production->stages && $production->stages->count())
        <div class="section">
            <div class="section-title">Tahapan Produksi</div>

            <table>
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th>Nama Tahap</th>
                        <th width="25%">Status</th>
                        <th width="25%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($production->stages as $stage)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $stage->stage_name }}</td>
                            <td>{{ ucfirst($stage->status) }}</td>
                            <td>{{ $stage->description ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- ================= FOOTER ================= --}}
    <div class="footer">
        Dicetak pada {{ now()->format('d-m-Y H:i') }}
    </div>

</body>

</html>
