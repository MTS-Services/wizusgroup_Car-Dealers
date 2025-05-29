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

        <p><span class="label">User:</span> {{ $reservation->user->first_name }} {{ $reservation->user->last_name }}</p>
        <p><span class="label">Contact Email:</span> {{ $reservation->email }}</p>
        <p><span class="label">WhatsApp:</span> {{ $reservation->whatsapp }}</p>

        <hr>

        <p><span class="label">Container:</span> {{ $reservation->container?->title }}</p>
        <p><span class="label">Product:</span> {{ $reservation->product?->name }}</p>
        <p><span class="label">Price:</span>
            {{ $reservation->quantity . ' x ' . $reservation->price / $reservation->quantity }} =
            {{ $reservation->price }}</p>
        <p><span class="label">Reserve Price:</span>
            {{ $reservation->quantity . ' x ' . $reservation->reserve_price / $reservation->quantity }} =
            {{ $reservation->reserve_price }}</p>
        <p><span class="label">Quantity:</span> {{ $reservation->quantity }}</p>
        <p><span class="label">Shipping Date:</span> {{ dateFormat($reservation->container?->deadline) }}</p>

        <hr>
        <p><span class="label">Submitted At:</span> {{ timeFormat($reservation->created_at) }}</p>
    </div>
</body>

</html>
