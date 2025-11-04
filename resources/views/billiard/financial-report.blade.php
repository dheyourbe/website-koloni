<!DOCTYPE html>
<html>

<head>
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            margin: 0;
        }

        .filters {
            margin-bottom: 15px;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }

        .total-row td {
            text-align: right;
        }

        .grand-total {
            font-size: 1.1em;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Laporan Keuangan</h1>
        <p>Koloni Billiard (Sistem Anda)</p>
        <p>Periode: {{ $startDate }} s/d {{ $endDate }}</p>
    </div>

    <!-- (Opsional) Tampilkan filter aktif jika Anda mau -->

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>No. Transaksi</th>
                <th>Pelanggan</th>
                <th>Tanggal Lunas</th>
                <th>Meja</th>
                <th>Durasi</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rentals as $rental)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $rental->transaction_number }}</td>
                <td>{{ $rental->customer_name }}</td>
                <td>{{ $rental->updated_at->format('d M Y, H:i') }}</td>
                <td>{{ $rental->billiardTable->table_number ?? 'N/A' }}</td>
                <td>{{ $rental->duration_hours }} jam</td>
                <td>Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align: center;">Tidak ada data untuk periode ini.</td>
            </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="6">GRAND TOTAL</td>
                <td class="grand-total">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>

</html>