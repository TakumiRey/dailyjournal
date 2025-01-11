<?php
session_start();
// Include database connection file
include('db_connection.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $password = $_POST['password'];
    $profilePhoto = $_FILES['profile-photo'];
    $userId = $_SESSION['user_id']; // Assume user ID is stored in session

    // Update password if provided
    if (!empty($password)) {
        $encryptedPassword = md5($password);
        $query = "UPDATE users SET password='$encryptedPassword' WHERE id='$userId'";
        mysqli_query($conn, $query);
    }

    // Update profile photo if provided
    if ($profilePhoto['size'] > 0) {
        $targetDir = "img/";
        $targetFile = $targetDir . basename($profilePhoto['name']);
        move_uploaded_file($profilePhoto['tmp_name'], $targetFile);
        $query = "UPDATE users SET profile_photo='$targetFile' WHERE id='$userId'";
        mysqli_query($conn, $query);
    }

    header('Location: profile.php'); // Redirect to avoid resubmission
    exit;
}

// Fetch current user data
$userId = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id='$userId'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Daily Journal - Profil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fce4ec;
        }

        .header {
            background-color: #f8bbd0;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header a {
            text-decoration: none;
            color: black;
            margin: 0 10px;
        }

        .header .dropdown {
            position: relative;
        }

        .header .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 150px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .header .dropdown:hover .dropdown-content {
            display: block;
        }

        .container {
            padding: 20px;
        }

        h1 {
            color: #880e4f;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="password"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .current-photo {
            margin: 20px 0;
        }

        .current-photo img {
            max-width: 100px;
            border-radius: 10px;
        }

        .btn-save {
            background-color: #1976d2;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .footer {
            background-color: #f8bbd0;
            text-align: center;
            padding: 10px 0;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .footer a {
            text-decoration: none;
            color: black;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>My Daily Journal</div>
        <div>
            <a href="#">Dashboard</a>
            <a href="#">Article</a>
            <a href="#">Gallery</a>
            <a href="#">Homepage</a>
            <div class="dropdown">
                <a href="#">april &#9662;</a>
                <div class="dropdown-content">
                    <a href="#">Profile april</a>
                    <a href="#">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <h1>Profil</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="password">Ganti Password</label>
                <input type="password" id="password" name="password" placeholder="Tuliskan Password Baru Jika Ingin Mengganti Password Saja">
            </div>

            <div class="form-group">
                <label for="profile-photo">Ganti Foto Profil</label>
                <input type="file" id="profile-photo" name="profile-photo">
            </div>

            <div class="current-photo">
                <label>Foto Profil Saat Ini</label>
                <img src="<?php echo $user['profile_photo']; ?>" alt="Current Profile Photo">
            </div>

            <button type="submit" class="btn-save">Simpan</button>
        </form>
    </div>

    <div class="footer">
        <a href="#"><img src="img/instagram-icon.png" alt="Instagram"></a>
        <a href="#"><img src="img/twitter-icon.png" alt="Twitter"></a>
        <a href="#"><img src="img/whatsapp-icon.png" alt="WhatsApp"></a>
        <p>&copy; Apriliyani Nur Sefitri &#xA9; 2023</p>
    </div>
</body>
</html>
