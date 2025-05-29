<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Contact Form,</title>
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
        <h2>Contact Form</h2>

        <p><span class="label">Name:</span> {{ $contact?->name }}</p>
        <p><span class="label">Email:</span> {{ $contact?->email }}</p>
        <p><span class="label">Message:</span> {{ $contact?->message }}</p>
    </div>
</body>

</html>
