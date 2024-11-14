<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: page.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "registration_db";

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data for the logged-in user
$sql = "SELECT name, email, country, profile_image FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    $country = $row['country'];
    $profile_image = $row['profile_image'] ? $row['profile_image'] : 'uploads/default.jpg';
} else {
    $name = "N/A";
    $email = "N/A";
    $country = "N/A";
    $profile_image = "uploads/default.jpg";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form.css">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
        }
        .upload-btn-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
        }
        .btn {
            border: 2px solid gray;
            color: gray;
            background-color: white;
            padding: 8px 20px;
            border-radius: 8px;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }
        .upload-btn-wrapper input[type=file] {
            font-size: 100px;
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
        }
        .info {
            margin-top: 20px;
        }
        .update-profile-btn, .logout-btn {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
            background: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            text-decoration: none;
            border-radius: 5px;
        }
        .logout-btn {
            background: #f44336;
        }
        .user-details {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Welcome, <?php echo $name; ?></h1>
            <img src="<?php echo $profile_image; ?>" alt="Profile Picture" class="profile-pic" id="profilePic">
            <form id="uploadForm" action="upload_image.php" method="POST" enctype="multipart/form-data">
                <div class="upload-btn-wrapper">
                    <button class="btn">Upload a picture</button>
                    <input type="file" name="profilePic" id="fileInput">
                </div>
            </form>
        </div>
        <div class="info">
            <h2>Dashboard</h2>
            <p>Your account details and recent activities will appear here.</p>
            <div class="user-details">
                <p><strong>Name:</strong> <?php echo $name; ?></p>
                <p><strong>Country:</strong> <?php echo $country; ?></p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
            </div>
        </div>
        <a href="manage.php" class="update-profile-btn">Update Profile</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
    <script>
        document.getElementById('fileInput').addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const formData = new FormData(document.getElementById('uploadForm'));

                fetch('upload_image.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('profilePic').src = data;
                })
                .catch(error => console.error('Error uploading image:', error));
            }
        });
    </script>
</body>
</html>
