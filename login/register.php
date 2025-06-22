<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /dotudu/");
    exit();
}
include "../db.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register - DoTuDu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('../assets/login.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
    }
    .login-box {
      background-color: rgba(255, 255, 255, 0.9); /* semi-transparan seperti login */
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-4 login-box">
      <h2 class="mb-4 text-center">Register</h2>

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
        <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
        <div class="d-grid">
          <button class="btn btn-primary" name="register">Register</button>
        </div>
        <div class="text-center mt-3">
          <a href="index.php" class="btn btn-link">Sudah punya akun? Login</a>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
