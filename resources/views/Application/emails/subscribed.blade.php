<!DOCTYPE html>
<html>
<head>
    <title>Subscription Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .verify-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
            text-align: center;
        }
        .verify-button:hover {
            background-color: #0056b3;
            color: white;
            text-decoration: none;
        }
        .verification-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin: 20px 0;
            text-align: center;
        }
        hr {
            border: none;
            border-top: 1px solid #eee;
            margin: 30px 0;
        }
    </style>
</head>
<body>
    <h1>Welcome, {{ $user->name }}!</h1>
    
    <p>Thank you for subscribing to <strong>{{ $appName }}</strong>.</p>
    
    <p><strong>{{ $customMessage }}</strong></p>
    
    <div class="verification-section">
        <h3>📧 Please Verify Your Email</h3>
        <p>To complete your subscription and start receiving our newsletters, please verify your email address by clicking the button below:</p>
        
        <a href="{{route('user.email.verify' , [$user->id , hash('sha256',$user->email)])}}" class="verify-button">
            ✅ Verify Your Email
        </a>
        
        <p><small>If the button doesn't work, copy and paste this link into your browser:<br>
        {{route('user.email.verify' , [$user->id , hash('sha256',$user->email)])}}</small></p>
    </div>
    
    <p>We're glad to have you with us. If you have any questions, feel free to reach out anytime.</p>
    
    <hr>
    <small>&copy; {{ $year }} {{ $appName }}. All rights reserved.</small>
</body>
</html>