<?php
session_start();
include_once("../config/config.php");
include_once("../config/functions.php");

// Pastikan hanya reseller atau member yang dapat mengakses halaman ini
redirectIfNotResellerOrMember();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["generate_code"])) {
    // Menghasilkan kode undangan unik
    $invitationCode = generateInvitationCode();

    // Menyimpan kode undangan ke database dan mengurangkan saldo reseller/member
    $userId = $_SESSION['user_id'];
    $level = $_SESSION['level'];
    $updateQuery = "UPDATE users SET invitation_code = '$invitationCode', saldo = saldo - 5 WHERE id = '$userId' AND level = '$level'";
    $conn->query($updateQuery);
}
?>

<!-- HTML untuk tampilan halaman reseller/member dan formulir pembuatan kode undangan -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Reseller Dashboard</title>
    <!-- Bootstrap CSS (Dark Theme) -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    <style>
        body {
            background-color: #343a40;
            color: #fff;
        }
        .container {
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reseller Dashboard</div>
                <div class="card-body">
                    <h5 class="card-title">Generate Invitation Code</h5>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <button type="submit" name="generate_code" class="btn btn-primary">Generate Code</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"
        integrity="sha384-cm8Vmqu5U04tLOcx5eB8WTj2EHjgb6KkqW6Y91r4PxbEXG+ivW2hXDIJNtIq8iE3"
        crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8sh+Wyao3ETcb2HQpNV46vEsucb5qSEa5BsgJH"
        crossorigin="anonymous"></script>

</body>
</html>