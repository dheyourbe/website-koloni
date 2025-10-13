<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billiard Receipt - {{ $rental->transaction_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .receipt {
            background: white;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #3b82f6;
            padding-bottom: 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #3b82f6;
            margin-bottom: 5px;
        }
        .subtitle {
            color: #6b7280;
            font-size: 16px;
        }
        .transaction-info {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .transaction-number {
            font-size: 20px;
            font-weight: bold;
            color: #1f2937;
            text-align: center;
        }
        .details {
            margin: 20px 0;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 500;
            color: #4b5563;
        }
        .detail-value {
            font-weight: 600;
            color: #1f2937;
        }
        .pricing {
            margin-top: 30px;
            border: 2px solid #e5e7eb;
            border-radius: 6px;
            padding: 20px;
        }
        .pricing-title {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 15px;
            text-align: center;
        }
        .price-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
        }
        .price-row.total {
            border-top: 2px solid #3b82f6;
            margin-top: 10px;
            padding-top: 10px;
            font-size: 18px;
            font-weight: bold;
        }
        .total .price-value {
            color: #3b82f6;
        }
        .discount {
            color: #10b981;
        }
        .status {
            text-align: center;
            margin: 30px 0;
        }
        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
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
            color: #3b82f6;
            font-weight: 600;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header -->
        <div class="header">
            <div class="logo">🎱 COFFEE SHOP BILLIARD</div>
            <div class="subtitle">Official Receipt</div>
        </div>

        <!-- Transaction Number -->
        <div class="transaction-info">
            <div class="transaction-number">{{ $rental->transaction_number }}</div>
        </div>

        <!-- Customer & Booking Details -->
        <div class="details">
            <div class="detail-row">
                <span class="detail-label">Customer Name:</span>
                <span class="detail-value">{{ $rental->customer_name }}</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Table Number:</span>
                <span class="detail-value">{{ $rental->billiardTable->table_number }}</span>
            </div>
            @if($rental->billiardTable->name)
            <div class="detail-row">
                <span class="detail-label">Table Name:</span>
                <span class="detail-value">{{ $rental->billiardTable->name }}</span>
            </div>
            @endif
            <div class="detail-row">
                <span class="detail-label">Duration:</span>
                <span class="detail-value">{{ $rental->duration_hours }} hours</span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Booking Date:</span>
                <span class="detail-value">{{ $rental->created_at->format('d F Y, H:i') }} WIB</span>
            </div>
            @if($rental->rental_start)
            <div class="detail-row">
                <span class="detail-label">Rental Period:</span>
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
            <div class="pricing-title">Payment Details</div>
            
            <div class="price-row">
                <span>Price per Hour:</span>
                <span>Rp {{ number_format($rental->price_per_hour, 0, ',', '.') }}</span>
            </div>
            
            <div class="price-row">
                <span>Subtotal ({{ $rental->duration_hours }} hours):</span>
                <span>Rp {{ number_format($rental->subtotal, 0, ',', '.') }}</span>
            </div>
            
            @if($rental->discount_amount > 0)
            <div class="price-row discount">
                <span>Member Discount (10%):</span>
                <span>- Rp {{ number_format($rental->discount_amount, 0, ',', '.') }}</span>
            </div>
            @endif
            
            <div class="price-row total">
                <span>Total Amount:</span>
                <span class="price-value">Rp {{ number_format($rental->total_amount, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Status -->
        <div class="status">
            <span class="status-badge status-{{ $rental->status }}">
                @if($rental->status === 'paid')
                    ✓ PAID
                @elseif($rental->status === 'rejected')
                    ✗ REJECTED
                @else
                    ⏳ PAYMENT PENDING
                @endif
            </span>
        </div>

        <!-- Footer -->
        <div class="footer">
            <div class="thank-you">Thank you for choosing Coffee Shop Billiard!</div>
            <p>For any inquiries, please contact our staff or visit our location.</p>
            <p>This is a computer-generated receipt and does not require a signature.</p>
            <p>Generated on: {{ now()->format('d F Y, H:i') }} WIB</p>
        </div>
    </div>
</body>
</html>
