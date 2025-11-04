<!DOCTYPE html>
<html>

<head>
    <title>Invoice - {{ $rental->transaction_number }}</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 14px;
        }

        .container {
            width: 95%;
            margin: auto;
        }

        .header {
            text-align: center;
            margin-bottom: 25px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 5px 0;
        }

        .details {
            margin-bottom: 20px;
        }

        .details strong {
            display: inline-block;
            width: 140px;
        }

        .status-lunas {
            color: #28a745;
            /* Hijau */
            font-size: 24px;
            font-weight: bold;
            text-align: center;
            border: 2px solid #28a745;
            padding: 10px;
            margin: 20px 0;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f9f9f9;
        }

        .total-section {
            text-align: right;
            margin-top: 20px;
        }

        .total-section p {
            margin: 5px 0;
        }

        .total-section h3 {
            margin: 10px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h2>INVOICE PEMBAYARAN</h2>
            <p>Koloni Billiard (Sistem Anda)</p>
            <p><strong>Nomor Transaksi:</strong> {{ $rental->transaction_number }}</p>
        </div>

        <div class="details">
            <p><strong>Nama Pelanggan:</strong> {{ $rental->customer_name }}</p>
            <p><strong>Nomor WhatsApp:</strong> {{ $rental->customer_whatsapp }}</p>
            <p><strong>Tanggal Pesan:</strong> {{ $rental->created_at->format('d M Y, H:i') }}</p>
        </div>

        <h2 class="status-lunas">LUNAS</h2>

        <table>
            <thead>
                <tr>
                    <th>Deskripsi</th>
                    <th>Waktu Mulai</th>
                    <th>Durasi</th>
                    <th>Harga per Jam</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        Sewa Meja {{ $rental->billiardTable->table_number ?? 'N/A' }}
                        ({{ $rental->billiardTable->category ?? 'VIP' }}) </td>
                    <td>{{ \Carbon\Carbon::parse($rental->rental_start)->format('d M Y, H:i') }}</td>
                    <td>{{ $rental->duration_hours }} jam</td>
                    <td>Rp {{ number_format($rental->price_per_hour, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total-section">
            <h3>Total Bayar: Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</h3>
        </div>

        <div style="margin-top: 30px; text-align: center; font-size: 12px; color: #888;">
            <p>Terima kasih atas pembayaran Anda.</p>
            <p>Invoice ini sah dan dibuat oleh sistem.</p>
        </div>
    </div>
</body>

</html>