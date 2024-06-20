<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- format. --}}
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .header {
            /* text-align: center;
            padding: 20px 0; */
        }

        .header img {
            width: 100px;
        }

        .content {
            text-align: center;
            padding: 20px;
        }

        .content h1 {
            color: #333333;
        }

        .content p {
            color: #666666;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            color: #ffffff;
            background-color: #007BFF;
            border-radius: 5px;
            text-decoration: none;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #aaaaaa;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            {{-- <img src="https://example.com/logo.png" alt="Company Logo"> --}}
        </div>
        <div class="content">
            <h1>Welcome to Kredo Insta!</h1>
            <p>Hi {{ $name }},</p>
            <p>Thank you for registering on our website. We are thrilled to have you!</p>
            <p>You can start by visiting the website <a href="{{ $app_url }}">here</a>!</p>
        </div>
        <div class="footer">
            <p>If you have any questions, feel free to <a href="mailto:support@example.com">contact us</a>.</p>
            <p>&copy; 2024 Yasuhiro WATANABE. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
