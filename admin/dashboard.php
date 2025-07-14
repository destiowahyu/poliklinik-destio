<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit();
}

$current_page = basename($_SERVER['PHP_SELF']);

include '../includes/db.php';

// Fetch data from the database
$dokterCount = $conn->query("SELECT COUNT(*) AS total FROM dokter")->fetch_assoc()['total'];
$pasienCount = $conn->query("SELECT COUNT(*) AS total FROM pasien")->fetch_assoc()['total'];
$poliCount = $conn->query("SELECT COUNT(*) AS total FROM poli")->fetch_assoc()['total'];
$obatCount = $conn->query("SELECT COUNT(*) AS total FROM obat")->fetch_assoc()['total'];
$adminCount = $conn->query("SELECT COUNT(*) AS total FROM admin")->fetch_assoc()['total'];

$adminName = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin/styles.css">
    <link rel="icon" type="image/png" href="../assets/images/admin.png">

</head>
<body>
    <!-- Sidebar -->
    <?php include 'sidebar_admin.php'; ?>

    <!-- Main Content -->
    <div class="content" id="content">
        <div class="header">
            <h1>Dashboard</h1>
        </div>
        <div class="welcome mt-4">
            Selamat Datang, <span><?= htmlspecialchars($adminName) ?></span>!
        </div>
        <div class="row d-flex justify-content-center align-items-center">
            <div class="col-md-3 mb-4">
                <a style="text-decoration:none;" href="kelola_dokter.php">
                    <div class="card p-3">
                        <i class="fas fa-user-md mb-2"></i>
                        <h5>Total Dokter</h5>
                        <p><?= $dokterCount ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-4">
                <a style="text-decoration:none;" href="kelola_pasien.php">
                    <div class="card p-3">
                        <i class="fas fa-users mb-2"></i>
                        <h5>Total Pasien</h5>
                        <p><?= $pasienCount ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-4">
                <a style="text-decoration:none;" href="kelola_poli.php">
                    <div class="card p-3">
                        <i class="fas fa-hospital mb-2"></i>
                        <h5>Total Poli</h5>
                        <p><?= $poliCount ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-4">
                <a style="text-decoration:none;" href="kelola_obat.php">
                    <div class="card p-3">
                        <i class="fas fa-pills mb-2"></i>
                        <h5>Total Obat</h5>
                        <p><?= $obatCount ?></p>
                    </div>
                </a>
            </div>
            <div class="col-md-3 mb-4">
                <a style="text-decoration:none;" href="kelola_admin.php">
                    <div class="card p-3">
                        <i class="fas fa-user-shield mb-2"></i>
                        <h5>Total Admin</h5>
                        <p><?= $adminCount ?></p>
                    </div>
                </a>
            </div>
        </div>
        
    </div>

</body>
</html>
