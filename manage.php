<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: page.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = ""; // Database password
$dbname = "registration_db";
$user_id = $_SESSION['user_id'];

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch current user data
$sql = "SELECT name, email, country FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="form.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        label {
            display: block;
            margin: 10px 0 5px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        .btn {
            display: inline-block;
            width: 100%;
            background: #4CAF50;
            color: white;
            padding: 10px;
            text-align: center;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Profile</h1>
        <form id="updateProfileForm" action="update_profile.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter new password" required>

            <label for="country">Country:</label>
            <select id="country" name="country" required>
                <option value="India" <?php if($user['country'] == 'India') echo 'selected'; ?>>India</option>
                <option value="China" <?php if($user['country'] == 'China') echo 'selected'; ?>>China</option>
                <option value="Nepal" <?php if($user['country'] == 'Nepal') echo 'selected'; ?>>Nepal</option>
                <option value="Bhutan" <?php if($user['country'] == 'Bhutan') echo 'selected'; ?>>Bhutan</option>
                <option value="South Korea" <?php if($user['country'] == 'South Korea') echo 'selected'; ?>>South Korea</option>
                <!-- Add more country options as needed -->
            </select>

            <button type="submit" name="updateProfile" class="btn">Update Profile</button>
        </form>
    </div>
</body>
</html>