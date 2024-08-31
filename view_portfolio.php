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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #121212;
            color: #e0e0e0;
            overflow-x: hidden;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #1e1e1e;
            padding: 20px 40px;
            color: #bb86fc;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.5);
        }

        .header h1 {
            font-size: 2rem;
            margin: 0;
        }

        nav a {
            text-decoration: none;
            color: #bb86fc;
            font-weight: bold;
            margin-left: 30px;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        nav a:hover {
            color: #ffffff;
        }

        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(to bottom, #1e1e1e, black);
            text-align: center;
            padding: 40px;
        }

        .hero img {
            border-radius: 50%;
            border: solid 4px #bb86fc;
            width: 200px;
            height: 200px;
            margin-bottom: 20px;
        }

        .hero h2 {
            color: white;
            font-size: 2.5rem;
            margin: 20px 0;
        }

        .button {
            text-decoration: none;
            border: solid 2px #bb86fc;
            padding: 10px 20px;
            color: white;
            font-size: 1.1rem;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .button:hover {
            background-color: #bb86fc;
            color: #1e1e1e;
        }

        .section {
            padding: 60px 40px;
            background-color: #181818;
            text-align: center;
        }

        .section h2 {
            color: #bb86fc;
            margin-bottom: 30px;
            font-size: 2.2rem;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .card {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 6px 16px rgba(0, 0, 0, 0.5);
            margin-bottom: 30px;
        }

        .card p {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #e0e0e0;
        }

        .projects .card,
        .services .card {
            flex: 1 1 calc(33% - 20px);
            margin: 20px 10px;
        }

        .gallery img {
            width: 100%;
            border-radius: 10px;
            margin: 10px 0;
            transition: transform 0.3s ease;
        }

        .gallery img:hover {
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .hero img {
                width: 150px;
                height: 150px;
            }

            .hero h2 {
                font-size: 2rem;
            }

            .hero .button {
                font-size: 1rem;
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
    <img src='uploads/<?php echo htmlspecialchars($portfolio['about_image']); ?>' alt='About Image'>
    <h2><?php echo htmlspecialchars($portfolio['title']); ?></h2>
    <a href='uploads/<?php echo htmlspecialchars($portfolio['cv_file']); ?>' class="button" download>Download CV</a>
</section>

<section id="about" class="section">
    <h2>About</h2>
    <div class="card">
        <p><?php echo htmlspecialchars($portfolio['description']); ?></p>
    </div>
</section>

<section id="services" class="section">
    <h2>Services</h2>
    <div class="services-container" style="display: flex; flex-wrap: wrap; justify-content: center;">
        <?php foreach (explode(',', $portfolio['services']) as $service): ?>
            <div class="card">
                <p><?php echo htmlspecialchars(trim($service)); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="projects" class="section">
    <h2>Projects</h2>
    <div class="projects" style="display: flex; flex-wrap: wrap; justify-content: center;">
        <?php foreach ($projects as $project): ?>
            <div class="card">
                <p><a href="<?php echo htmlspecialchars($project); ?>" target="_blank"><?php echo htmlspecialchars($project); ?></a></p>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="contact" class="section">
    <h2>Contact Info</h2>
    <div class="card">
        <p><?php echo htmlspecialchars($portfolio['contact_info']); ?></p>
    </div>
    <div class="card">
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
