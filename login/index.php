<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: /dotudu/");
    exit();

    


}
// Cegah caching halaman login
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include "../db.php";
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>DoTuDu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('../assets/login.jpg') no-repeat center center fixed;
      background-size: cover;
      min-height: 100vh;
    }
    .login-box {
      background-color: rgba(255, 255, 255, 0.9); /* semi-transparan */
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 15px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="col-md-4 login-box">
      <h2 class="mb-4 text-center">Do Tu Du</h2>
      <form method="POST">
        <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
        <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
        <div class="d-grid">
          <button class="btn btn-secondary" name="login">Login</button>
        </div>
        <div class="text-center mt-3">
          <a href="register.php" class="btn btn-link">Register</a>
        </div>
      </form>

      <?php
      if (isset($_POST['login'])) {
          $user = $_POST['username'];
          $pass = $_POST['password'];

          $stmt = $koneksi->prepare("SELECT * FROM users WHERE username = ?");
          $stmt->bind_param("s", $user);
          $stmt->execute();
          $result = $stmt->get_result();
          $res = $result->fetch_assoc();

          if ($res && password_verify($pass, $res['password'])) {
              $_SESSION['user_id'] = $res['id'];
              header("Location: /dotudu/");
              exit();
          } else {
              echo "<div class='alert alert-danger mt-2'>Username atau password salah!</div>";
          }
      }
      ?>
    </div>
  </div>

</body>
</html>
