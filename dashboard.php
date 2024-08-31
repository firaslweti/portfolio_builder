<?php
include('db.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_GET['delete'])) {
    $portfolio_id = $_GET['delete'];
    $sql = "DELETE FROM portfolios WHERE id='$portfolio_id' AND user_id='$user_id'";
    if (mysqli_query($conn, $sql)) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

$sql = "SELECT * FROM portfolios WHERE user_id='$user_id'";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Portfolios</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2DhKN6n7wh3nR2sZC6k0PfF5DHSnq6ksH/FtP1LLcT9SxNxH1uJST1lX8xD0hKp8Q==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #121212;
            color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #1f1f1f;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #bb86fc;
        }
        header h1 {
            margin: 0;
            color: #bb86fc;
            font-size: 1.8em;
        }
        nav a {
            color: #f5f5f5;
            text-decoration: none;
            margin-left: 15px;
            font-weight: bold;
        }
        nav a:hover {
            color: #bb86fc;
        }
        .hero {
            background: url('hero-background.jpg') no-repeat center center/cover;
            padding: 60px 20px;
            text-align: center;
            color: #f5f5f5;
        }
        .hero h2 {
            font-size: 2.5em;
            margin-bottom: 20px;
        }
        .hero p {
            font-size: 1.2em;
            max-width: 600px;
            margin: 0 auto;
        }
        .container {
            flex: 1;
            padding: 40px 20px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            grid-gap: 30px;
        }
        .portfolio-card {
            background: #1e1e1e;
            border: 1px solid #333;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.5);
            transition: transform 0.2s ease-in-out;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            text-align: center;
        }
        .portfolio-card:hover {
            transform: translateY(-5px);
            border-color: #bb86fc;
        }
        .portfolio-card h3 {
            color: #bb86fc;
            margin: 0 0 10px;
            font-size: 1.5em;
        }
        .portfolio-card p {
            color: #cfcfcf;
            margin: 0 0 20px;
        }
        .portfolio-card a {
            text-decoration: none;
            color: #bb86fc;
            font-weight: bold;
            align-self: center;
            padding: 10px 15px;
            background-color: #1f1f1f;
            border-radius: 5px;
        }
        .portfolio-card a:hover {
            background-color: #333;
        }
        .delete-button {
            background-color: #ff6b6b;
            color: #121212;
            border: none;
            border-radius: 5px;
            padding: 8px;
            cursor: pointer;
            font-weight: bold;
            text-align: center;
            display: block;
            margin: 10px auto;
            text-decoration: none;
        }
        .delete-button:hover {
            background-color: #e63946;
        }
        .no-portfolios {
            text-align: center;
            color: #cfcfcf;
        }
        .no-portfolios img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        footer {
            background-color: #1f1f1f;
            padding: 20px;
            text-align: center;
            border-top: 2px solid #bb86fc;
            color: #cfcfcf;
        }
        .create-new {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #bb86fc;
            color: #121212;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
        .create-new:hover {
            background-color: #7a52d0;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }
            h2 {
                font-size: 2em;
            }
        }
    </style>
</head>
<body>

<header>
    <h1>My Portfolio</h1>
    <nav>
        <a href='index.php'>Home</a>
        <a href='create_portfolio.php'>Create Portfolio</a>
        <a href='logout.php'>Logout</a>
    </nav>
</header>

<section class='hero'>
    <h2>Welcome to Your Portfolio Collection</h2>
    <p>Showcase your projects and achievements. Create, view, and manage all your portfolios in one place.</p>
</section>

<div class='container'>
    <?php
    $hasPortfolios = mysqli_num_rows($result) > 0;

    if ($hasPortfolios) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='portfolio-card'>";
            echo "<h3>" . $row['title'] . "</h3>";
            echo "<p>" . $row['description'] . "</p>";
            echo "<a href='view_portfolio.php?id=" . $row['id'] . "'>View Portfolio</a>";
            echo "<a href='dashboard.php?delete=" . $row['id'] . "' class='delete-button'>Delete</a>";
            echo "</div>";
        }
    } else {
        echo "<div class='no-portfolios'>";
        echo "<p>You have no portfolios yet. Create one to get started!</p>";
        echo "</div>";
    }
    ?>
</div>

<footer>
    <a href='create_portfolio.php' class='create-new'>Create New Portfolio</a>
    <p>&copy; <?php echo date('Y'); ?> My Portfolio. All rights reserved.</p>
</footer>

</body>
</html>
