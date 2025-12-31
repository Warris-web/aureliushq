<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Your KYC to Activate Your Aurelius Account</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;background:#f6f9fc;margin:0;padding:0;color:#333}
        .container{max-width:620px;margin:20px auto;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 6px 24px rgba(0,0,0,0.08)}
        .header{background:linear-gradient(135deg,#ff8c00,#ff6a00);color:#fff;padding:24px;text-align:center}
        .content{padding:28px;line-height:1.6}
        .btn{display:inline-block;background:#ff8c00;color:#fff!important;text-decoration:none;padding:12px 18px;border-radius:10px;margin-top:14px}
        .warning{background:#fff3cd;padding:12px;border-radius:6px;color:#856404;font-size:12px;margin:16px 0}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Complete Your KYC to Activate Your Aurelius Account</h2>
        </div>
        <div class="content">
            <p>Hello {{ ucfirst($user->first_name) }},</p>

            <p>Thank you for signing up on Aurelius.</p>

            <p>To activate your account and gain full access to the platform, please complete your KYC verification. This step is required to ensure account security and prevent duplicate registrations.</p>

            <p>Kindly log in to your dashboard and complete your KYC to proceed.</p>

            <a class="btn" href="{{ url('/dashboard') }}">Complete KYC Now</a>

            <p style="margin-top:24px;">If you need assistance, contact us at <a href="mailto:info@aureliushq.co">info@aureliushq.co</a> or visit <a href="http://www.aureliushq.co">www.aureliushq.co</a>.</p>

            <p>Thank you for choosing Aurelius.</p>

            <div class="warning">
                ⚠️ Please do not reply to this email. This mailbox is not monitored.
            </div>
        </div>
    </div>
</body>
</html>
