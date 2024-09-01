<?php
// Include database connection file
include('db.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$portfolio_id = $_GET['id'];
$sql = "SELECT * FROM portfolios WHERE id='$portfolio_id'";
$result = mysqli_query($conn, $sql);
$portfolio = mysqli_fetch_assoc($result);

$photos = explode(',', $portfolio['photos']);
$projects = explode(',', $portfolio['projects']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($portfolio['title']); ?> - Portfolio</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            color: #333333;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .header {
            background-color: #000000;
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 2.5rem;
            font-weight: normal;
        }

        nav {
            margin-top: 20px;
        }

        nav a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 15px;
            font-size: 1rem;
            transition: color 0.3s;
        }

        nav a:hover {
            color: #bb86fc;
        }

        .hero {
            background-color: #f0f0f0;
            padding: 60px 0;
            text-align: center;
        }

        .hero img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            margin-bottom: 20px;
        }

        .hero h2 {
            font-size: 2rem;
            margin: 20px 0;
            color: #000000;
        }

        .hero .button {
            background-color: #000000;
            color: #ffffff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            transition: background-color 0.3s;
        }

        .hero .button:hover {
            background-color: #bb86fc;
        }

        .section {
            padding: 60px 0;
            text-align: center;
        }

        .section h2 {
            font-size: 2rem;
            margin-bottom: 40px;
            color: #333333;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .section .content {
            max-width: 800px;
            margin: 0 auto;
        }

        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: left;
        }

        .card p {
            font-size: 1rem;
            margin: 0;
            color: #666666;
        }

        .flex-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .flex-container .card {
            flex: 1 1 calc(33% - 40px);
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
        }

        .gallery img {
            width: calc(33% - 20px);
            border-radius: 10px;
            transition: transform 0.3s ease;
        }

        .gallery img:hover {
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .flex-container .card, .gallery img {
                flex: 1 1 calc(100% - 20px);
                width: 100%;
            }

            .hero img {
                width: 100px;
                height: 100px;
            }

            .hero h2 {
                font-size: 1.5rem;
            }

            .hero .button {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <h1><?php echo htmlspecialchars($portfolio['job_title']); ?></h1>
    <nav>
        <a href="#home">Home</a>
        <a href="#about">About</a>
        <a href="#services">Services</a>
        <a href="#projects">Projects</a>
        <a href="#contact">Contact</a>
    </nav>
</div>

<section id="home" class="hero">
    <div class="container">
        <img src='uploads/<?php echo htmlspecialchars($portfolio['about_image']); ?>' alt='About Image'>
        <h2><?php echo htmlspecialchars($portfolio['title']); ?></h2>
        <a href='uploads/<?php echo htmlspecialchars($portfolio['cv_file']); ?>' class="button" download>Download CV</a>
    </div>
</section>

<section id="about" class="section">
    <div class="container content">
        <h2>About</h2>
        <div class="card">
            <p><?php echo htmlspecialchars($portfolio['description']); ?></p>
        </div>
    </div>
</section>

<section id="services" class="section">
    <div class="container">
        <h2>Services</h2>
        <div class="flex-container">
            <?php foreach (explode(',', $portfolio['services']) as $service): ?>
                <div class="card">
                    <p><?php echo htmlspecialchars(trim($service)); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="projects" class="section">
    <div class="container">
        <h2>Projects</h2>
        <div class="flex-container">
            <?php foreach ($projects as $project): ?>
                <div class="card">
                    <p><a href="<?php echo htmlspecialchars($project); ?>" target="_blank"><?php echo htmlspecialchars($project); ?></a></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="contact" class="section">
    <div class="container content">
        <h2>Contact Info</h2>
        <div class="card">
            <p><?php echo htmlspecialchars($portfolio['contact_info']); ?></p>
        </div>
        <h2>Gallery</h2>
        <div class="gallery">
            <?php foreach ($photos as $photo): ?>
                <img src='uploads/<?php echo htmlspecialchars($photo); ?>' alt='Portfolio Photo'>
            <?php endforeach; ?>
        </div>
    </div>
</section>

</body>
</html>
