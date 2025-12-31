<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Aurelius Account is Now Activated!</title>
    <style>
        body{font-family:Arial,Helvetica,sans-serif;background:#f6f9fc;margin:0;padding:0;color:#333}
        .container{max-width:620px;margin:20px auto;background:#fff;border-radius:14px;overflow:hidden;box-shadow:0 6px 24px rgba(0,0,0,0.08)}
        .header{background:linear-gradient(135deg,#ff8c00,#ff6a00);color:#fff;padding:24px;text-align:center}
        .content{padding:28px;line-height:1.6}
        .section{margin:20px 0}
        .section-title{font-weight:bold;color:#ff8c00;margin-top:16px}
        .bullet{margin-left:20px}
        .footer{background:#f8f9fa;padding:20px;border-top:1px solid #eee;text-align:center;font-size:13px}
        .contact{margin:16px 0;font-size:13px;color:#666}
        .warning{background:#fff3cd;padding:12px;border-radius:6px;color:#856404;font-size:12px;margin:16px 0}
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Your Aurelius Account is Now Activated!</h2>
        </div>
        <div class="content">
            <p>Hello {{ ucfirst($user->first_name) }},</p>

            <p>Congratulations! Your Aurelius account has been successfully activated. You now have full access to our platform and can start shopping for essential foodstuffs conveniently.</p>

            <p class="section-title">Here's what you can do now:</p>
            <div class="bullet">
                <p><strong>Browse and Shop:</strong> Access a wide range of food items available for outright or instalment purchases.</p>
                <p><strong>Add to Cart & Track Orders:</strong> Place orders easily and track them in real-time.</p>
                <p><strong>Wallet:</strong> Manage payments directly on the platform.</p>
                <p><strong>Referral Program:</strong> Earn rewards by referring friends to Aurelius.</p>
                <p><strong>Notifications:</strong> Receiving updates, notifications, and delivery timelines.</p>
                <p><strong>Terms & Conditions:</strong> Review our policies directly on the platform.</p>
            </div>

            <p class="section-title">Important Next Step:</p>
            <p>Please go to your Dashboard Menu, click Profile and set your house address to ensure smooth deliveries.</p>

            <p>Your account is now fully ready to make purchases, manage your wallet, track your payment and enjoy all Aurelius features.</p>

            <p>For support or inquiries, contact us at <a href="mailto:info@aureliushq.co">info@aureliushq.co</a> or visit <a href="http://www.aureliushq.co">www.aureliushq.co</a>.</p>

            <p>Thank you for choosing Aurelius, <em>Simplifying Food Access for Every Nigerian</em>.</p>

            <hr style="border:none;border-top:1px solid #eee;margin:24px 0;">

            <p style="font-size:12px;color:#666;margin:0;">
                <strong>Aurelius Nigeria (HQ)</strong><br>
                Kenuj, O2 Mall, Kaura, Abuja<br>
                020 1330 6342 | info@aureliushq.co<br>
                Website: www.aureliushq.co
            </p>

            <div class="warning">
                ⚠️ Please do not reply to this email. This mailbox is not monitored.
            </div>
        </div>
    </div>
</body>
</html>
