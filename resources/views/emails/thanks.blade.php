<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You for Contacting Us</title>
</head>
<body style="margin: 0; padding: 24px; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #0A0D14; color: #E8ECF4;">
    <div style="max-width: 580px; margin: 0 auto; background-color: #11161F; border: 1px solid #232C3D; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
        <div style="background: linear-gradient(135deg, #171E2B 0%, #11161F 100%); padding: 24px; border-bottom: 1px solid #232C3D;">
            <h2 style="margin: 0; font-size: 20px; color: #0c2454; letter-spacing: -0.02em;">We Received Your Enquiry</h2>
            <p style="margin: 6px 0 0 0; font-size: 13px; color: #9AA5BA;">Thank you for getting in touch with us</p>
        </div>

        <div style="padding: 24px; font-size: 14px; line-height: 1.6; color: #CBD5E1;">
            <p style="margin-top: 0;">Hi <strong style="color: #ffffff;">{{ $name }}</strong>,</p>
            <p>Thank you for reaching out to us. We have successfully received your enquiry and our team is already reviewing your details.</p>
            <p>We typically review all incoming project requests and respond within <strong style="color: #0c2454;">24 business hours</strong> with next steps and a clear plan.</p>

            <div style="margin-top: 24px; padding-top: 18px; border-top: 1px solid #1c2433; color: #9AA5BA; font-size: 13px;">
                <p style="margin: 0;">Best regards,</p>
                <p style="margin: 4px 0 0 0; font-weight: 600; color: #0c2454; font-size: 14px;">{{ $contact?->name ?? config('app.name', 'IntSource') }} Team</p>
            </div>
        </div>

        <div style="padding: 14px 24px; background-color: #0A0D14; border-top: 1px solid #232C3D; font-size: 11px; color: #64748b; text-align: center;">
            &copy; {{ date('Y') }} {{ $contact?->name ?? config('app.name', 'IntSource') }}. All rights reserved.
        </div>
    </div>
</body>
</html>