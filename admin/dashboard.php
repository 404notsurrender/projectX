<?php
session_start();
include_once("../config/config.php");
include_once("../config/functions.php");
redirectIfNotAdmin();
$userId = $_SESSION['user_id'];
$saldo = getBalance($userId, $conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generate_code"])) {
    // Menghasilkan kode undangan unik
    $invitationCode = generateInvitationCode();

    // Menyimpan kode undangan ke database dan mengurangkan saldo admin
    $adminId = $_SESSION['user_id'];
    $updateQuery = "UPDATE users SET invitation_code = '$invitationCode', saldo = saldo - 10 WHERE id = '$adminId'";
    $conn->query($updateQuery);
}
?>

<!-- HTML untuk tampilan halaman admin dan formulir pembuatan kode undangan -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Dashboard</title>
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
                    <h1 class="h3 mb-4 text-gray-800">Admin Dashboard</h1>
                <div class="row">
                    <div class="col-md-12">
                        <?php if (isset($_SESSION['success_message'])) : ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['success_message']; ?>
                                <?php unset($_SESSION['success_message']); ?>
                            </div>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['error_message'])) : ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $_SESSION['error_message']; ?>
                                <?php unset($_SESSION['error_message']); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Saldo</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">$<?php echo $saldo; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Generate Invitation Code</h6>
                                    </div>
                <div class="card-body">

                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <button type="submit" name="generate_code" class="btn btn-primary">Generate Code</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include_once("../templates/footer.php"); ?>
</div>
</div>

<!-- Bootstrap JS and dependencies -->
    <!-- Bootstrap core JavaScript-->
    <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../assets/js/sb-admin-2.min.js"></script>

</body>
</html>