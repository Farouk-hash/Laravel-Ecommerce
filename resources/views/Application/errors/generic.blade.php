<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Page Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            background: rgba(255,255,255,0.1);
            padding: 40px;
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>404</h1>
        <h2>CUSTOM - Not Found</h2>
        <p>{{ $message }}</p>
        <p>Status: {{ $status }}</p>
        <a href="{{ url('/') }}">Go Home</a>
    </div>
</body>
</html>