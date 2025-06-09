<?php include "../db.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            max-width: 400px;
            margin: 80px auto;
        }
    </style>
</head>
<body>

<div class="card shadow">
    <div class="card-body">
        <h3 class="card-title text-center mb-4">Register</h3>
        <form method="POST">
            <input type="text" name="username" class="form-control mb-3" placeholder="Username" required>
            <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
            <button class="btn btn-primary w-100" name="register">Register</button>
            <div class="text-center mt-2">
                <a href="index.php" class="btn btn-link">Sudah punya akun? Login</a>
            </div>
        </form>

        <?php
        if (isset($_POST['register'])) {
            $user = $_POST['username'];
            $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $stmt = $koneksi->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $user, $pass);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success mt-3'>Berhasil daftar!</div>";
            } else {
                echo "<div class='alert alert-danger mt-3'>Username sudah digunakan.</div>";
            }
        }
        ?>
    </div>
</div>

</body>
</html>
