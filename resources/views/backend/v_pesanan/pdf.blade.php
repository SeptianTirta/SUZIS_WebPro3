<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Pesanan - Suzuki Integaretd System</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #333;
        }

        h2 {
            text-align: center;
            color: #001437;
            margin-bottom: 5px;
        }

        p.subtitle {
            text-align: center;
            color: #666;
            margin-top: 0;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <h2>LAPORAN PESANAN (BOOKING)</h2>
    <p class="subtitle">Sistem Informasi Suzuki Integrated System</p>

    <table>
        <thead>
            <tr>
                <th class="text-center">No</th>
                <th>Kode Booking</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Unit Mobil</th>
                <th class="text-right">Booking Fee</th>
                <th class="text-center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pesanan as $key => $row)
                <tr>
                    <td class="text-center">{{ $key + 1 }}</td>
                    <td>{{ $row->kode_booking }}</td>
                    <td>{{ $row->created_at->format('d M Y') }}</td>
                    <td>{{ $row->user->nama ?? '-' }}</td>
                    <td>{{ $row->mobil->nama_mobil ?? '-' }}</td>
                    <td class="text-right">Rp {{ number_format($row->booking_fee, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $row->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
