<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Portfolio Builder</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2DhKN6n7wh3nR2sZC6k0PfF5DHSnq6ksH/FtP1LLcT9SxNxH1uJST1lX8xD0hKp8Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212;
            color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden;
        }
        .container {
            background-color: #1e1e1e;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        h1 {
            color: #bb86fc;
            margin-bottom: 20px;
            font-size: 2em;
        }
        p {
            color: #cfcfcf;
            margin-bottom: 30px;
            font-size: 1.1em;
        }
        .login-btn {
            background-color: #bb86fc;
            color: #121212;
            border: none;
            border-radius: 5px;
            padding: 15px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        .login-btn:hover {
            background-color: #7a52d0;
        }
        .login-btn i {
            margin-right: 10px;
        }
        .footer {
            margin-top: 20px;
            color: #7a7a7a;
            font-size: 0.9em;
        }
        .footer a {
            color: #bb86fc;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Welcome to Your Portfolio Builder</h1>
    <p>Create and manage your personal portfolios effortlessly.</p>
    <button class="login-btn" onclick="window.location.href='login.php'">
        <i class="fas fa-sign-in-alt"></i> Login to Get Started
    </button>
    <div class="footer">
        <p>Don't have an account? <a href="register.php">Sign Up</a></p>
    </div>
</div>

</body>
</html>
