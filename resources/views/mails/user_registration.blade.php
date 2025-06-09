<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to {{ config('app.name') }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 0;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }

        .content {
            padding: 40px 30px;
        }

        .welcome-message {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c3e50;
        }

        .info-box {
            background-color: #f8f9fa;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }

        .info-box h3 {
            margin-top: 0;
            color: #2c3e50;
            font-size: 16px;
        }

        .user-details {
            background-color: #e8f4fd;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .user-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .user-details td {
            padding: 8px 0;
            border-bottom: 1px solid #ddd;
        }

        .user-details td:first-child {
            font-weight: bold;
            width: 30%;
            color: #555;
        }

        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 25px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
            transition: transform 0.2s;
        }

        .login-button:hover {
            transform: translateY(-2px);
            text-decoration: none;
            color: white;
        }

        .footer {
            background-color: #2c3e50;
            color: #ecf0f1;
            padding: 30px;
            text-align: center;
            font-size: 14px;
        }

        .footer a {
            color: #3498db;
            text-decoration: none;
        }

        .divider {
            height: 2px;
            background: linear-gradient(to right, #667eea, #764ba2);
            margin: 30px 0;
        }

        @media only screen and (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 5px;
            }

            .content {
                padding: 20px 15px;
            }

            .header {
                padding: 20px 15px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>🎉 Welcome to {{ config('app.name') }}!</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="welcome-message">
                Hello <strong>{{ $user->name }}</strong>,
            </div>

            <p>Congratulations! Your account has been successfully created. We're excited to have you join our
                community.</p>

            <!-- User Details -->
            <div class="user-details">
                <h3 style="margin-top: 0; color: #2c3e50;">📋 Your Account Details</h3>
                <table>
                    <tr>
                        <td>Name:</td>
                        <td>{{ $user->full_name }}</td>
                    </tr>
                    <tr>
                        <td>Username:</td>
                        <td>{{ $user->username ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td>Email:</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    @if ($user->phone)
                        <tr>
                            <td>Phone:</td>
                            <td>{{ $user->phone }}</td>
                        </tr>
                    @endif
                    @if ($user->whatsapp)
                        <tr>
                            <td>WhatsApp:</td>
                            <td>{{ $user->whatsapp }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td>Registration Date:</td>
                        <td>{{ $user->created_at_formatted }}</td>
                    </tr>
                </table>
            </div>

            @if ($password)
                <div class="info-box">
                    <h3>🔐 Login Credentials</h3>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Password:</strong> {{ $password }}</p>
                    <p style="color: #e74c3c; font-size: 14px; margin-top: 15px;">
                        <strong>⚠️ Important:</strong> Please change your password after your first login for security
                        purposes.
                    </p>
                </div>
            @endif

            <div class="divider"></div>

            <!-- Call to Action -->
            <div style="text-align: center;">
                <p>Ready to get started? Click the button below to access your account:</p>
                <a href="{{ route('login') }}" class="login-button">
                    🚀 Login to Your Account
                </a>
            </div>

            <div class="info-box">
                <h3>🛡️ What's Next?</h3>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Complete your profile information</li>
                    <li>Explore our features and services</li>
                    <li>Browse and place your first order</li>
                    <li>Contact support if you need any assistance</li>
                </ul>
            </div>

            <p style="margin-top: 30px;">
                If you have any questions or need assistance, please don't hesitate to reach out to our support team.
                We're here to help!
            </p>

            <p style="margin-top: 20px;">
                Best regards,<br>
                <strong>The {{ config('app.name') }} Team</strong>
            </p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
            <p>
                <a href="{{ config('app.url') }}">Visit our website</a> |
                <a href="{{ route('frontend.contact') }}/contact">Contact Support</a>
            </p>
            <p style="font-size: 12px; color: #95a5a6; margin-top: 15px;">
                This email was sent to {{ $user->email }} because you registered for an account on
                {{ config('app.name') }}.
            </p>
        </div>
    </div>
</body>

</html>
