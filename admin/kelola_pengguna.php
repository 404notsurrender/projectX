<?php
session_start();
include_once("../config/config.php");
include_once("../config/functions.php");
redirectIfNotAdmin();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kelola Pengguna</title>
    <!-- Include CSS dan JS dari template SB Admin 2 -->
    <!-- Gantilah dengan path yang sesuai di proyek Anda -->
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<?php if ($_SESSION['level'] === 'superadmin') : ?>
<?php elseif ($_SESSION['level'] === 'admin') : ?>
<?php endif; ?>
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

        <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Kelola Pengguna</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Pengguna</h6>
            </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID Pengguna</th>
                            <th>Username</th>
                            <th>Saldo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <!-- Tambahkan perulangan untuk setiap pengguna di sini -->
                    <?php
                    // Gantilah bagian ini dengan logika untuk mengambil data pengguna dari database
                    $users = getUsersFromDatabase($conn); // Anda perlu membuat fungsi ini
                    foreach ($users as $user) {
                        echo "<tr>";
                        echo "<td>{$user['id']}</td>";
                        echo "<td>{$user['username']}</td>";
                        echo "<td>{$user['saldo']}</td>";
                        echo "<td><a href='edit_pengguna.php?id={$user['id']}'>Edit</a> | <a href='delete_user.php?id={$user['id']}'>Hapus</a></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>
<!-- End of Page Content -->

                <!-- End of Page Content -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include_once("../templates/footer.php"); ?>
            <!-- End of Footer -->
        </div>
        <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- Include JS dari template SB Admin 2 -->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="../assets/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../assets/js/demo/chart-area-demo.js"></script>
    <script src="../assets/js/demo/chart-pie-demo.js"></script>
</body>
</html>
