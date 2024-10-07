<?php
//login.php
session_start();
require 'config.php';
// Menginisialisasi variabel pesan error
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $file = basename($_FILES["foto"]["name"]);
    $file1 = "img/" . basename($_FILES["foto"]["name"]);
    $imageFileType = strtolower(pathinfo($file,PATHINFO_EXTENSION));
    move_uploaded_file($_FILES["foto"]["tmp_name"], $file1);

    $stmt = $conn->prepare("INSERT INTO user (id_user, username, password,  foto_user) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss",$id, $username,$password, $file);

    if($stmt->execute()){
        $_SESSION['massage'] = ['type'=> 'success', 'text'=>'Data berhasil ditambah.'];
    }else{
        $_SESSION['massage'] = ['type'=> 'success', 'text'=>'Data gagal ditambah.'];
    }
    $stmt->close();
    header("Location: login.php");
    exit();
        
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
        <?php 
            $stmt = $conn->query("SELECT * FROM user ORDER BY id_user DESC LIMIT 1");
            $latestiddep = $stmt->fetch_row();
            $urut = 1;
            if ($latestiddep) {
                $latestNumber = $latestiddep[0];
                $urut = $latestNumber + 1;
            }
            $newid = $urut;
        ?>
        <form method="post" enctype="multipart/form-data">
        <div class="form-group">
                <label for="username">ID:</label>
                <input type="text" name="id" class="form-control" value="<?php echo $newid;?>" readonly>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="text" name="password" class="form-control" required>
            </div>
            <div class="mb-3">
                    <label for="foto" class="form-label">foto</label>
                    <input type="file" class="form-control" id="foto" name="foto" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block" value="Upload File">Sign In</button>
            <br>

        </form>
    </div>
</div>
</body>
</html>