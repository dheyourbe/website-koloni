<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Billiard - {{ $rental->transaction_number }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .receipt {
            background: white;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #1B2B28;
            padding-bottom: 20px;
        }

        .logo {
            font-size: 24px;
            font-weight: 700;
            color: #1B2B28;
            margin-bottom: 5px;
            letter-spacing: 0.05em;
        }

        .subtitle {
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
        }

        .transaction-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
            border: 1px solid #e5e7eb;
        }

        .transaction-number {
            font-size: 18px;
            font-weight: 700;
            color: #1B2B28;
            text-align: center;
            letter-spacing: 0.05em;
        }

        .details {
            margin: 20px 0;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 500;
            color: #4b5563;
            font-size: 14px;
        }

        .detail-value {
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
        }

        .pricing {
            margin-top: 30px;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            padding: 20px;
        }

        .pricing-title {
            font-size: 16px;
            font-weight: 700;
            color: #1B2B28;
            margin-bottom: 15px;
            text-align: center;
            letter-spacing: 0.05em;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 14px;
        }

        .price-row.total {
            border-top: 2px solid #1B2B28;
            margin-top: 15px;
            padding-top: 15px;
            font-size: 18px;
            font-weight: 700;
        }

        .total .price-value {
            color: #1B2B28;
        }

        .discount {
            color: #059669;
            font-weight: 500;
        }

        .status {
            text-align: center;
            margin: 30px 0;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 13px;
            letter-spacing: 0.05em;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-paid {
            background: #d1fae5;
            color: #065f46;
        }

        .status-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 12px;
        }

        .thank-you {
            font-size: 16px;
            color: #1B2B28;
            font-weight: 600;
            margin-bottom: 10px;
            letter-spacing: 0.05em;
        }

        .contact-info {
            margin-top: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
        }

        .contact-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 5px;
            font-size: 13px;
            color: #4b5563;
        }

        .contact-row:last-child {
            margin-bottom: 0;
        }

        .icon {
            display: inline-block;
            width: 16px;
            height: 16px;
            color: #1B2B28;
        }

        /* Icon SVGs embedded directly */
        .icon-map-pin::before {
            content: "📍";
        }

        .icon-phone::before {
            content: "📞";
        }

        .icon-time::before {
            content: "🕐";
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <div class="logo">KOLONI COFFEE</div>
            <div class="subtitle">Billiard Receipt</div>
        </div>

        <!-- Transaction Number -->
        <div class="transaction-info">
            <div class="transaction-number">{{ $rental->transaction_number }}</div>
        </div>

        <!-- Customer & Booking Details -->
        <div class="details">
            <div class="detail-row">
                <span class="detail-label">Nama Pelanggan:</span>
                <span class="detail-value">{{ $rental->customer_name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Nomor Meja:</span>
                <span class="detail-value">Meja {{ $rental->billiardTable->table_number }}</span>
            </div>
            @if($rental->billiardTable->name)
            <div class="detail-row">
                <span class="detail-label">Nama Meja:</span>
                <span class="detail-value">{{ $rental->billiardTable->name }}</span>
            </div>
            @endif
            <div class="detail-row">
                <span class="detail-label">Durasi:</span>
                <span class="detail-value">{{ $rental->duration_hours }} jam</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Tanggal Pemesanan:</span>
                <span class="detail-value">{{ $rental->created_at->format('d F Y, H:i') }} WIB</span>
            </div>
            @if($rental->rental_start)
            <div class="detail-row">
                <span class="detail-label">Periode Sewa:</span>
                <span class="detail-value">
                    {{ $rental->rental_start->format('d/m/Y H:i') }} - {{ $rental->rental_end->format('d/m/Y H:i') }}
                </span>
            </div>
            @endif
            @if($rental->customer_whatsapp)
            <div class="detail-row">
                <span class="detail-label">WhatsApp:</span>
                <span class="detail-value">{{ $rental->customer_whatsapp }}</span>
            </div>
            @endif
        </div>

        <!-- Pricing Breakdown -->
        <div class="pricing">
            <div class="pricing-title">Rincian Pembayaran</div>

            <div class="price-row">
                <span>Harga per Jam:</span>
                <span>Rp {{ number_format($rental->price_per_hour, 0, ',', '.') }}</span>
            </div>

            <div class="price-row">
                <span>Subtotal ({{ $rental->duration_hours }} jam):</span>
                <span>Rp {{ number_format($rental->subtotal, 0, ',', '.') }}</span>
            </div>

            @if($rental->discount_amount > 0)
            <div class="price-row discount">
                <span>Diskon Member (10%):</span>
                <span>- Rp {{ number_format($rental->discount_amount, 0, ',', '.') }}</span>
            </div>
            @endif

            <div class="price-row total">
                <span>Total Pembayaran:</span>
                <span class="price-value">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Status -->
        <div class="status">
            <span class="status-badge status-{{ $rental->status }}">
                @if($rental->status === 'paid')
                    ✓ LUNAS
                @elseif($rental->status === 'rejected')
                    ✗ DITOLAK
                @else
                    ⏳ MENUNGGU PEMBAYARAN
                @endif
            </span>
        </div>

        <!-- Contact Information -->
        <div class="contact-info">
            <div class="contact-row">
                <span class="icon icon-map-pin"></span>
                <span>123 Coffee Street, Jakarta</span>
            </div>
            <div class="contact-row">
                <span class="icon icon-phone"></span>
                <span>+62 812 3456 7890</span>
            </div>
            <div class="contact-row">
                <span class="icon icon-time"></span>
                <span>Setiap hari: 10:00 - 22:00 WIB</span>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">Terima kasih telah memilih KOLONI Coffee!</div>
            <p>Untuk pertanyaan, silakan hubungi staff kami atau kunjungi lokasi kami.</p>
            <p>Ini adalah struk yang dihasilkan komputer dan tidak memerlukan tanda tangan.</p>
            <p>Dibuat pada: {{ now()->format('d F Y, H:i') }} WIB</p>
        </div>
    </div>
</body>
</html>
