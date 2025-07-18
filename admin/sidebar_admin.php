<?php
// Ambil data admin dari sesi
$adminName = $_SESSION['username'];
$adminData = $conn->query("SELECT * FROM admin WHERE username = '$adminName'")->fetch_assoc();

// Ambil ID admin dan username dari session
$adminId = $_SESSION['id'];
$adminUsername = $_SESSION['username'];
?>

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

<!-- Tombol Sidebar Mobile-->
<button class="toggle-btn-mobile" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>


<!-- Sidebar -->
<div class="sidebar" id="sidebar">
<button class="toggle-btn" onclick="toggleSidebar()">
    <i class="fas fa-bars"></i>
</button>
    <div class="avatar-container">
        <h4 id="admin-panel">Admin Panel</h4>
        <img src="../assets/images/admin.png" class="admin-avatar" alt="Admin">
        <h6 id="admin-name"><?= htmlspecialchars($adminName) ?></h6>
    </div>
    <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
        <i class="fas fa-chart-pie"></i> <span>Dashboard</span>
    </a>
    <a href="kelola_pasien.php" class="<?php echo ($current_page == 'kelola_pasien.php') ? 'active' : ''; ?>">
        <i class="fas fa-users"></i> <span>Kelola Pasien</span>
    </a>
    <a href="kelola_dokter.php" class="<?php echo ($current_page == 'kelola_dokter.php') ? 'active' : ''; ?>">
        <i class="fas fa-user-md"></i> <span>Kelola Dokter</span>
    </a>
    <a href="kelola_poli.php" class="<?php echo ($current_page == 'kelola_poli.php') ? 'active' : ''; ?>">
        <i class="fas fa-hospital"></i> <span>Kelola Poli</span>
    </a>
    <a href="kelola_obat.php" class="<?php echo ($current_page == 'kelola_obat.php') ? 'active' : ''; ?>">
        <i class="fas fa-pills"></i> <span>Kelola Obat</span>
    </a>
    <a href="kelola_admin.php" class="<?php echo ($current_page == 'kelola_admin.php') ? 'active' : ''; ?>">
        <i class="fas fa-user-shield"></i> <span>Kelola Admin</span>
    </a>
    <a href="../logout.php" class="<?php echo ($current_page == 'logout.php') ? 'active' : ''; ?>">
        <i class="fas fa-sign-out-alt"></i> <span>Logout</span>
    </a>
</div>


<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const overlay = document.getElementById('overlay');
        const toggleBtnMobile = document.querySelector('.toggle-btn-mobile');

        if (window.innerWidth > 768) {
            // Toggle for desktop
            sidebar.classList.toggle('collapsed');
            content.classList.toggle('collapsed');

            // Save state to localStorage
            const isCollapsed = sidebar.classList.contains('collapsed');
            localStorage.setItem('sidebarState', isCollapsed ? 'collapsed' : 'expanded');
        } else {
            // Toggle for mobile
            sidebar.classList.toggle('open');
            overlay.classList.toggle('show');

            // Sembunyikan tombol toggle ketika sidebar terbuka
            if (sidebar.classList.contains('open')) {
                toggleBtnMobile.style.display = 'none'; // Sembunyikan tombol toggle
            } else {
                toggleBtnMobile.style.display = 'block'; // Tampilkan tombol toggle
            }
        }
    }

    // Restore sidebar state on page load
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.getElementById('sidebar');
        const content = document.getElementById('content');
        const overlay = document.getElementById('overlay');
        const toggleBtnMobile = document.querySelector('.toggle-btn-mobile');
        const sidebarState = localStorage.getItem('sidebarState');

        if (sidebarState === 'collapsed' && window.innerWidth > 768) {
            sidebar.classList.add('collapsed');
            content.classList.add('collapsed');
        } else {
            sidebar.classList.remove('collapsed');
            content.classList.remove('collapsed');
        }

        // Ensure overlay is hidden on load
        if (window.innerWidth <= 768) {
            sidebar.classList.add('hidden');
            overlay.classList.remove('show');

            // Periksa status sidebar dan sembunyikan tombol toggle jika sidebar terbuka
            if (sidebar.classList.contains('open')) {
                toggleBtnMobile.style.display = 'none';
            } else {
                toggleBtnMobile.style.display = 'block';
            }
        }
    });
</script>
