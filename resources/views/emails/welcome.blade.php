<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Aurelius</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;background:#f6f9fc;margin:0;padding:0;color:#333}
        .container{max-width:620px;margin:20px auto;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 6px 24px rgba(0,0,0,0.08)}
        .header{background:linear-gradient(135deg,#ff8c00,#ff6a00);color:#fff;padding:24px;text-align:center}
        .content{padding:28px}
        .btn{display:inline-block;background:#ff8c00;color:#fff;text-decoration:none;padding:12px 18px;border-radius:10px;margin-top:14px}
        .muted{color:#666;font-size:12px}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Welcome to Aurelius, {{ ucfirst($user->first_name) }}!</h2>
        </div>
        <div class="content">
            <p>We're thrilled to have you on board.</p>
            <p>
                Thank you for signing up on Aurelius. You can explore food items, manage your profile, and complete KYC to unlock full access.
            </p>

            <p>
                Need help? Our team is here for you at
                <a href="mailto:info@aureliushq.co">info@aureliushq.co</a>.
            </p>

            <a class="btn" href="{{ url('/dashboard') }}">Go to Dashboard</a>

            <p class="muted" style="margin-top:22px;">If you didn't create this account, please ignore this email.</p>
        </div>
    </div>
</body>
</html>
