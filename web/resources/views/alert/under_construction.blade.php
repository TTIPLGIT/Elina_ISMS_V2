<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Coming Soon</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .coming-soon-container {
            background-color: #fff;
            border-radius: 15px;
            padding: 50px;
            width: 80%;
            max-width: 600px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            font-size: 36px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #666;
            margin-bottom: 30px;
        }

        .content p {
            color: #888;
            font-size: 16px;
        }

        /* Button Style */
        .btn {
            display: inline-block;
            padding: 12px 25px;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #2980b9;
        }

        .btn:focus {
            outline: none;
        }
    </style>
</head>
<body>
    <div class="coming-soon-container">
        <div class="content">
            <h1>We're Bringing It To You Soon!</h1>
            <p>Thank you for your patience. We are working hard to bring this feature to you.</p>
            <p>Stay tuned for updates!</p>
            <a href="{{ route('home') }}" class="btn">Home</a>
        </div>
    </div>
</body>
</html>