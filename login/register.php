<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /dotudu/");
    exit();
}
include "../db.php";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('../assets/login.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
        }
        .login-box {
            background-color:rgb(187, 187, 187);
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="login-box">
        <h3 class="text-center mb-3">Register</h3>

        <?php
        $notif = "";

        if (isset($_POST['register'])) {
            $user = trim($_POST['username']);
            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $cek = $koneksi->prepare("SELECT id FROM users WHERE username = ?");
            $cek->bind_param("s", $user);
            $cek->execute();
            $cek->store_result();

            if ($cek->num_rows > 0) {
                $notif = "<div class='alert alert-warning text-center'>Username sudah terdaftar.</div>";
            } else {
                $stmt = $koneksi->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
                $stmt->bind_param("ss", $user, $pass);

                if ($stmt->execute()) {
                    $notif = "<div class='alert alert-success text-center'>Berhasil daftar!</div>";
                } else {
                    $notif = "<div class='alert alert-danger text-center'>Terjadi kesalahan saat mendaftar.</div>";
                }
            }
        }

        echo $notif;
        ?>

        <form method="POST">
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button class="btn btn-primary w-100" name="register">Register</button>
            <div class="text-center mt-2">
                <a href="index.php" class="btn btn-link">Sudah punya akun? Login</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>
