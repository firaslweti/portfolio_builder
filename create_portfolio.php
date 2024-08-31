<?php
// Include database connection file
include('db.php');

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $template = $_POST['template'];
    $photos = implode(',', $_FILES['photos']['name']);
    $job_title = $_POST['job_title'];
    $cv_file = $_FILES['cv_file']['name'];
    $about_image = $_FILES['about_image']['name'];
    $services = $_POST['services'];
    $projects = $_POST['projects'];
    $contact_info = $_POST['contact_info'];

    foreach ($_FILES['photos']['tmp_name'] as $key => $tmp_name) {
        $file_name = $_FILES['photos']['name'][$key];
        $file_tmp = $_FILES['photos']['tmp_name'][$key];
        move_uploaded_file($file_tmp, "uploads/" . $file_name);
    }
    
    if ($cv_file) {
        move_uploaded_file($_FILES['cv_file']['tmp_name'], "uploads/" . $cv_file);
    }

    if ($about_image) {
        move_uploaded_file($_FILES['about_image']['tmp_name'], "uploads/" . $about_image);
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO portfolios (user_id, title, description, template, photos, job_title, cv_file, about_image, services, projects, contact_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssssss", $user_id, $title, $description, $template, $photos, $job_title, $cv_file, $about_image, $services, $projects, $contact_info);

    // Execute the statement
    if ($stmt->execute()) {
        header('Location: dashboard.php');
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Portfolio</title>
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
            overflow: auto;
        }
        .container {
            background-color: #1e1e1e;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 800px;
            box-sizing: border-box;
            margin-bottom:150px;
            margin:  auto;
        }
        h2 {
            color: #bb86fc;
            margin-bottom: 20px;
            text-align: center;
            font-size: 2em;
        }
        form {
            display: flex;
            flex-direction: column;
            
        }
        label {
            color: #cfcfcf;
            margin-bottom: 8px;
            font-weight: bold;
            text-align: left;
        }
        input[type="text"],
        input[type="file"],
        textarea,
        select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #333;
            border-radius: 5px;
            background-color: #2a2a2a;
            color: #f5f5f5;
            box-sizing: border-box;
            width: 100%;
        }
        textarea {
            resize: vertical;
            min-height: 100px;
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
            transition: background-color 0.3s ease;
            width: 100%;
        }
        input[type="submit"]:hover {
            background-color: #7a52d0;
        }
        .error-message {
            color: #ff6b6b;
            margin-bottom: 15px;
            font-size: 0.9em;
            text-align: center;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
                margin: 10px;
            }
            h2 {
                font-size: 1.5em;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 10px;
                margin: 5px;
            }
            h2 {
                font-size: 1.2em;
            }
            input[type="text"],
            input[type="file"],
            textarea,
            select {
                padding: 8px;
                margin-bottom: 10px;
            }
            input[type="submit"] {
                padding: 8px;
                font-size: 0.9em;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Create Portfolio</h2>

    <form method="post" action="" enctype="multipart/form-data">
        <?php if (isset($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <label for="title">Title:</label>
        <input type="text" name="title" id="title" placeholder="Like :I'm Firas Lweti Full stack Developer" required>

        <label for="description">Description:</label>
        <textarea name="description" id="description" placeholder="introduction ✔" required></textarea>

        <label for="template">Template:</label>
        <select name="template" id="template">
            <option value="template1">Template 1</option>
            <option value="template2">Template 2</option>
        </select>

        <label for="photos">Photos:</label>
        <input type="file" name="photos[]" id="photos" multiple required>

        <label for="job_title">Job Title:</label>
        <input type="text" name="job_title" id="job_title">

        <label for="cv_file">CV File:</label>
        <input type="file" name="cv_file" id="cv_file">

        <label for="about_image">About Image:</label>
        <input type="file" name="about_image" id="about_image">

        <label for="services">Services:</label>
        <textarea name="services" id="services"></textarea>

        <label for="projects">Projects (links and images):</label>
        <textarea name="projects" id="projects"></textarea>

        <label for="contact_info">Contact Info:</label>
        <textarea name="contact_info" id="contact_info"></textarea>

        <input type="submit" value="Create Portfolio">
    </form>
</div>


</body>
</html>