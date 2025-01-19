<?php
session_start();
require 'includes/db.php'; // Koneksi ke database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek Admin
    $query = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        // Cek apakah password disimpan menggunakan password_hash()
        if (password_verify($password, $admin['password'])) {
            $_SESSION['role'] = 'admin';
            $_SESSION['username'] = $admin['username'];
            $_SESSION['id'] = $admin['id']; // Menyimpan ID admin
            header("Location: splash.php");
            exit;
        }
    }

        // Cek Dokter
        $query = "SELECT * FROM dokter WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $dokter = $result->fetch_assoc();
            
            // Verifikasi password menggunakan password_verify()
            if (password_verify($password, $dokter['password'])) {
                $_SESSION['role'] = 'dokter';
                $_SESSION['username'] = $dokter['username'];
                $_SESSION['id'] = $dokter['id']; // Menyimpan ID dokter
                header("Location: splash.php");
                exit;
            } else {
                $error = "Username atau password salah!";
            }
        } else {
            $error = "Username atau password salah!";
        }



    // Jika username dan password salah
    $error = "Username atau password salah!";
}
?>





<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="assets/images/doctor-login.png">

    <link rel="stylesheet" href="assets/login/fonts/icomoon/style.css">
    <link rel="stylesheet" href="assets/login/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/login/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="assets/login/css/style.css">

    <title>Login Dokter</title>
    <style>
      .login-pasien-link {
        color: #42c3cf;
        font-size: 14px;
        font-weight: bold;
        display: block;
        text-align: center;
        margin-top: 15px;
        transition: color 0.3s ease;
      }

      .login-pasien-link:hover {
        color: #35b5bf;
      }

      .doctor-image {
        min-width: 60%;
        max-width: 60%;
        margin: auto;
        display: block;
        text-align: center;
        align-items: center;
        justify-content: center;
      }
    </style>
  </head>
  <body>
    <div class="content">
      <div style="max-width: 70%;" class="container">
        <div class="row">
            <div class="col-md-5 d-flex flex-column justify-content-center align-items-center p-4">
                <img src="assets/login/images/doctor.svg" alt="Image" class="img-fluid doctor-image">
            </div>
          <div class="col-md-6 contents">

                <div class="mb-4">
                <h3><span><strong style="color: #42c3cf;">Login Dokter & Admin</strong></span></h3>
                  <p class="mb-4">Silahkan masukkan username & password dibawah :</p>
                </div>
                <?php if (isset($error)) { echo "<p class='error'>$error</p>"; } ?>
                <form method="POST" action="">

                  <div class="form-group first">
                    <label for="username"></label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                  </div>

                  <div class="form-group last mb-4">
                    <label for="password"></label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password" required class="form-control">
                  </div>

                  <input type="submit" value="Login" class="btn btn-login">
                </form>

                <!-- Teks Login Pasien -->
                <a href="login_pasien.php" class="login-pasien-link">Bukan Dokter? Login sebagai Pasien</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>

