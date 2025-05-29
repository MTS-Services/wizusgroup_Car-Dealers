<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Auction Bid</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            padding: 40px;
            display: flex;
            justify-content: center;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
        }

        h2 {
            color: #222;
            font-size: 24px;
            margin-bottom: 25px;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }

        .info-row {
            margin-bottom: 15px;
        }

        .label {
            font-weight: 600;
            color: #666;
            display: block;
            margin-bottom: 5px;
        }

        .value {
            font-size: 18px;
            color: #111;
        }

        .hidden-info {
            font-size: 16px;
            color: #0a0000;
            margin-top: 20px;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>Auction Bid Details</h2>

        <div class="hidden-info">
            <p><strong>Auction ID:</strong> {{ $auctionBid?->id }}</p>
            <p><strong>User Name:</strong> {{ auth()->user()?->first_name }}</p>
        </div>
        <div class="info-row">
            <span class="label">Bid Amount (USD):</span>
            <span class="value">${{ number_format($auctionBid?->bid_amount) }}</span>
        </div>

        <div class="info-row">
            <span class="label">WhatsApp Number:</span>
            <span class="value">{{ $auctionBid?->whatsapp_number }}</span>
        </div>

    </div>
</body>

</html>

