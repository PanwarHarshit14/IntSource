<html>
<head>
    <style>
        .container {
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
        }
        .button {
            background-color: #3490dc;
            color: white;
            padding: 12px 20px;
            border-radius: 4px;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Hi {{ $adminName }},</h2>
        <p>We received a request to reset your password. Use the following OTP to proceed:</p>
        <h3>{{ $otp }}</h3>
        <p>If you did not request a password reset, please ignore this email.</p>
        <p>Thank you, {{ $contact->name }}</p>
    </div>
</body>
</html>