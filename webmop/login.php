<?php
//login.php
session_start();
require 'config.php';
// Menginisialisasi variabel pesan error
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

 //Query untuk mencari user berdasarkan username
    $query = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Verifikasi password dengan perbandingan langsung (tanpa hashing)
        if ($password == $user['password']) {
            $_SESSION['user'] = $user;
            header('Location: index.php');
            exit; // Menghentikan eksekusi setelah redirect
    } else {
        $error = "Password salah!";
    }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
 <style>
    .login-container {
        max-width: 400px; /* Lebar maksimal form login */
        margin: auto;
        margin-top: 80px;
        padding: 20px;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        background-color: #f8f9fa;
    }

    .login-container h2 {
        margin-bottom: 20px;
    }
 </style>
</head>
<body>
<div class="container">
    <div class="login-container">
        <h2 class="text-center">Login</h2>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <br>

            <a href="register.php">Register</a>
        </form>
    </div>
</div>
</body>
</html>