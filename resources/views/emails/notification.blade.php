<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 90%;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .header {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }
        .content {
            font-size: 16px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            text-align: center;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            {{ $title }}
        </div>
        <div class="content">
            <p>{{ $message }}</p>
        </div>
        <div class="footer">
            <p>This is an automated notification from {{ config('app.name') }}.</p>
        </div>
    </div>
</body>
</html>
