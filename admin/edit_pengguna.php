<?php
// edit_user.php

session_start();
include_once("../config/config.php");
include_once("../config/functions.php");
redirectIfNotLoggedIn();


// Periksa apakah parameter ID pengguna disediakan di URL
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Dapatkan informasi pengguna dari database
    $user = getUserById($userId, $conn);

    if (!$user) {
        // Handle jika pengguna tidak ditemukan
        echo "User not found.";
        exit();
    }

    // Proses formulir pengeditan pengguna
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Proses update pengguna
        // ...

        // Redirect ke halaman kelola pengguna setelah update
        header("Location: kelola_pengguna.php");
        exit();
    }

    // Tampilkan formulir pengeditan pengguna
    ?>
<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include_once("../templates/sidebar.php"); ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Include Navbar -->
                <?php include_once("../templates/topbar.php"); ?>
                <!-- End of Navbar -->
                <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- ... -->
            </div>
    </div>
    <?php
    include("../templates/footer.php");
} else {
    // Handle jika parameter ID tidak disediakan
    echo "User ID not provided.";
}
?>
