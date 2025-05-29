<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Container Reservation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        h2 {
            color: #333;
        }

        p {
            margin: 5px 0;
        }

        .label {
            font-weight: bold;
            color: #555;
        }
    </style>
</head>

<body>
    <div class="card">
        <h2>New Container Reservation Request</h2>

        <p><span class="label">User:</span> {{ $reservation->user->name }} ({{ $reservation->user->email }})</p>
        <p><span class="label">WhatsApp:</span> {{ $reservation->whatsapp }}</p>

        <hr>

        <p><span class="label">Container:</span> {{ optional($reservation->container)->name }}</p>
        <p><span class="label">Product:</span> {{ optional($reservation->product)->name }}</p>
        <p><span class="label">Quantity:</span> {{ $reservation->quantity ?? 'N/A' }}</p>
        <p><span class="label">Preferred Shipping Date:</span> {{ $reservation->preferred_shipping_date ?? 'N/A' }}</p>

        <hr>

        <p><span class="label">Submitted At:</span> {{ $reservation->created_at->format('Y-m-d H:i A') }}</p>
    </div>
</body>

</html>
