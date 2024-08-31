<?php
// Include database connection file
include('db.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];  // Store user ID in session
        $_SESSION['username'] = $user['username'];  // Store username in session
        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Personal Portfolio Builder</title>
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
        .login-container {
            background-color: #1e1e1e;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.5);
            text-align: center;
            width: 100%;
            max-width: 400px;
        }
        h2 {
            color: #bb86fc;
            margin-bottom: 20px;
            font-size: 2em;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            text-align: left;
            color: #cfcfcf;
            margin-bottom: 10px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #333;
            border-radius: 5px;
            background-color: #2a2a2a;
            color: #f5f5f5;
            font-size: 1em;
            width: 100%;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #bb86fc;
            color: #121212;
            border: none;
            border-radius: 5px;
            padding: 10px;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #7a52d0;
        }
        .error-message {
            color: #ff6b6b;
            margin-bottom: 15px;
            font-size: 0.9em;
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

<div class="login-container">
    <h2>Login</h2>
    
    <?php if (isset($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <input type="submit" value="Login">
    </form>
    
    <div class="footer">
        <p>Don't have an account? <a href="register.php">Sign Up</a></p>
    </div>
</div>

</body>
</html>
