<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9fafb;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        .text-muted {
            font-size: 14px;
            color: #555;
            margin-bottom: 20px;
        }

        label {
            font-weight: 600;
            display: block;
            margin-bottom: 8px;
            color: #444;
        }

        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        input[type="email"]:focus {
            border-color: #007bff;
        }

        .error {
            color: #e3342f;
            font-size: 13px;
            margin-top: 6px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #1e40af;
        }

        .status-message {
            background: #d1fae5;
            color: #065f46;
            padding: 10px;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="container">
<div style="text-align:center;" class="brand-logo">
                <a href="#">
                    <img style="width:120px; text-align:center;" src="{{ asset('logo.png') }}" alt="Logo">
                </a>
            </div>

    <h2>Forgot Password</h2>

    <p class="text-muted">
        Forgot your password? No problem. Just let us know your email address and we’ll email you a password reset link that will allow you to choose a new one.
    </p>

    <!-- Session Status -->
    @if (session('status'))
        <div class="status-message">
            {{ session('status') }}
        </div>
    @endif

    <!-- Forgot Password Form -->
    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div style="margin-top: 20px;">
            <button style="background:darkorange;" type="submit" class="btn">Email Password Reset Link</button>
        </div>
    </form>
</div>

</body>
</html>
