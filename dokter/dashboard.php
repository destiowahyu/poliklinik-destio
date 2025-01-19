<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'dokter') {
    header("Location: ../index.php");
    exit();
}

include '../includes/db.php';

$current_page = basename($_SERVER['PHP_SELF']);

// Ambil ID dokter dan username dari session
$dokterId = $_SESSION['id'];
$dokterUsername = $_SESSION['username'];

// Ambil data nama dokter dari database
$dokterData = $conn->query("SELECT nama FROM dokter WHERE id = '$dokterId'")->fetch_assoc();
$namaDokter = $dokterData['nama']; // Nama asli dokter dari database

// Ambil data nama poli dokter dari database
$poliData = $conn->query("SELECT p.nama_poli FROM poli p 
                          JOIN dokter d ON d.id_poli = p.id 
                          WHERE d.id = '$dokterId'")->fetch_assoc();
$poliDokter = $poliData['nama_poli'];

// Fetch jadwal aktif untuk dashboard
$jadwalAktif = $conn->query("
    SELECT hari, jam_mulai, jam_selesai 
    FROM jadwal_periksa 
    WHERE id_dokter = '$dokterId' AND status = 'Aktif'
    LIMIT 1
")->fetch_assoc();

// Fetch jumlah pasien yang mendaftar ke dokter ini hari ini
$pasienHariIni = $conn->query("
    SELECT COUNT(*) AS total 
    FROM daftar_poli dp
    JOIN jadwal_periksa jp ON dp.id_jadwal = jp.id
    WHERE jp.id_dokter = '$dokterId' 
    AND DATE(dp.created_at) = CURDATE()
")->fetch_assoc()['total'];

// Fetch jumlah pasien hari ini yang belum diperiksa
$pasienBelumDiperiksa = $conn->query("
    SELECT COUNT(*) AS total 
    FROM daftar_poli dp
    JOIN jadwal_periksa jp ON dp.id_jadwal = jp.id
    WHERE jp.id_dokter = '$dokterId' 
    AND DATE(dp.created_at) = CURDATE()
    AND dp.status = 'Belum Diperiksa'
")->fetch_assoc()['total'];

// Fetch jumlah konsultasi pasien belum terjawab
$konsultasiBelumTerjawab = $conn->query("
    SELECT COUNT(*) AS total 
    FROM konsultasi 
    WHERE id_dokter = '$dokterId' AND jawaban IS NULL
")->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Dokter</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin/styles.css">
    <link rel="icon" type="image/png" href="../assets/images/avatar-doctor.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>
<body>
    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    <?php include 'sidebar_dokter.php'; ?>

    <!-- Main Content -->
    <div class="content" id="content">
        <div class="header">
            <h1>Dashboard</h1>
        </div>
        <div class="welcome mt-4">
            Selamat Datang, <span><strong style="color: #42c3cf;"><?= htmlspecialchars($namaDokter) ?>!</strong></span><br>
        </div>
        <div class="welcome mt-2">
        Anda adalah Dokter di <strong>Poli</strong> : <strong style="color: #42c3cf;"><?= htmlspecialchars($poliDokter) ?></strong>
        </div>
        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <i class="fas fa-calendar-check"></i>
                        <h5>Jadwal Aktif</h5>
                        <p>
                            <?= $jadwalAktif ? $jadwalAktif['hari'] . " (" . $jadwalAktif['jam_mulai'] . " - " . $jadwalAktif['jam_selesai'] . ")" : "Tidak ada jadwal aktif" ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <i class="fas fa-user-plus"></i>
                        <h5>Pasien Hari Ini</h5>
                        <p><?= $pasienHariIni ?></p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <i class="fas fa-user-clock"></i>
                        <h5>Pasien Belum Diperiksa</h5>
                        <p><?= $pasienBelumDiperiksa ?></p>
                    </div>
                </div>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <i class="fas fa-comments"></i>
                        <h5>Konsultasi Belum Terjawab</h5>
                        <p><?= $konsultasiBelumTerjawab ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>
