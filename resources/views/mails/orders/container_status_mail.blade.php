<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Container Status Update - {{ $container->name }}</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f9fafb; padding: 20px; color: #111827;">
    <table width="100%"
        style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; padding: 30px;">
        <tr>
            <td>
                <h2 style="color: #2563eb; margin-bottom: 20px;">
                    🚢 Container Status Update
                </h2>

                <p style="font-size: 16px; margin-bottom: 20px;">
                    Hello {{ $isAdmin ? 'Admin' : $user_name }},
                </p>

                <p style="font-size: 14px; color: #6b7280; margin-bottom: 25px;">
                    {{ $isAdmin ? 'We have an update regarding a container.' : 'We have an update regarding your container. Here are the latest details:' }}
                </p>

                <!-- Container Info Card -->
                <div
                    style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 20px; margin-bottom: 25px;">
                    <h3 style="margin-top: 0; margin-bottom: 15px; color: #1e293b;">
                        📦 {{ $container->name ?? 'Container Information' }}
                    </h3>

                    <table width="100%" style="font-size: 14px;">
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;"><strong>Route:</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #e2e8f0;">
                                {{ $container->shippingPort?->name ?? 'N/A' }} →
                                {{ $container->destinationPort?->name ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0;"><strong>Departure Date:</strong></td>
                            <td style="padding: 8px 0;">
                                {{ $container->departure_date }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0;"><strong>Estimated Delivery Time From Dispature Date:</strong>
                            </td>
                            <td style="padding: 8px 0;">
                                {{ $container->estimated_delivery_days }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0;"><strong>Updated:</strong></td>
                            <td style="padding: 8px 0;">
                                {{ $container->updated_at_formatted }}
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Status Update -->
                <div
                    style="background-color: #f0f9ff; border-left: 4px solid #3b82f6; padding: 20px; margin-bottom: 25px;">
                    <h3 style="margin-top: 0; margin-bottom: 10px; color: #1e40af;">
                        📋 Current Status
                    </h3>
                    <p style="font-size: 18px; font-weight: bold; color: #1e40af; margin-bottom: 10px;">
                        {{ $container->status_label }}
                    </p>
                    @if (!$isAdmin)
                        <p style="font-size: 14px; color: #374151; margin-bottom: 0; line-height: 1.5;">
                            {{ "Your container status has been $container->status_label. Please check the details for more information about your shipment progress." }}
                        </p>
                    @endif
                </div>

                <!-- Action Button -->
                @if (!$isAdmin)
                    <div style="text-align: center; margin: 30px 0;">
                        <a href="{{ route('user.container.details', $container->slug) }}"
                            style="background-color: #2563eb; color: #ffffff; padding: 12px 30px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
                            📋 View Full Details
                        </a>
                    </div>
                    <!-- Footer -->
                    <div style="border-top: 1px solid #e5e7eb; padding-top: 20px; margin-top: 30px;">
                        <p style="font-size: 12px; color: #6b7280; margin-bottom: 10px;">
                            {{ $isAdmin ?:
                                "If you have any questions about your container status, please don't hesitate to contact our
                                                                                    support team." }}
                        </p>
                        <p style="margin-top: 20px; font-size: 14px;">
                            Best regards,<br>
                            <strong>{{ config('app.name') }}</strong>
                        </p>
                    </div>
                @endif


            </td>
        </tr>
    </table>
</body>

</html>
