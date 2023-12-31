<?php
// Fungsi-fungsi umum

function isSuperAdmin() {
    return $_SESSION['level'] === 'superadmin';
}

function isAdmin() {
    return $_SESSION['level'] === 'admin';
}

function isReseller() {
    return $_SESSION['level'] === 'reseller';
}

function isMember() {
    return $_SESSION['level'] === 'member';
}

function redirectIfNotLoggedIn() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../auth/login.php");
        exit();
    }
}

function redirectIfNotSuperAdmin() {
    redirectIfNotLoggedIn();
    if (!isSuperAdmin()) {
        header("Location: unauthorized.php");
        exit();
    }
}

function redirectIfNotAdmin() {
    redirectIfNotLoggedIn();
    if (!isAdmin()) {
        header("Location: unauthorized.php");
        exit();
    }
}
function redirectIfNotResellerOrMember() {
    redirectIfNotLoggedIn();
    if (!isReseller() && !isMember()) {
        header("Location: unauthorized.php");
        exit();
    }
}
// Fungsi lainnya
function cleanInput($data) {
    global $conn;
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return mysqli_real_escape_string($conn, $data);
}
function generateInvitationCode() {
    // Menghasilkan kode undangan unik (gunakan metode sesuai kebutuhan Anda)
    return uniqid("INV_", true);
}
function generateRandomString($length = 10) {
    // Menghasilkan string acak (gunakan metode sesuai kebutuhan Anda)
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i=0; $i < $length ; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
// Fungsi untuk mengambil data saldo dari database
function getBalance($userId, $conn) {
    $query = "SELECT saldo FROM users WHERE id = $userId";
    $result = $conn->query($query);

    if ($result && $result->num_rows == 1) {
        $user = $result->fetch_assoc();
        return $user['saldo'];
    } else {
        return 0; // Default value or handle accordingly
    }
}
function updateBalance($userId, $amountToAdd, $conn) {
    // Get the current balance
    $currentBalance = getBalance($userId, $conn);

    // Calculate new balance
    $newBalance = $currentBalance + $amountToAdd;

    // Update the user's balance in the database
    $query = "UPDATE users SET saldo = $newBalance WHERE id = $userId";
    $conn->query($query);
}
function saveFileInfoToDatabase($userId, $fileName, $filePath, $conn) {
    $query = "INSERT INTO file_info (user_id, file_name, file_path) VALUES ('$userId', '$fileName', '$filePath')";
    $result = $conn->query($query);
    // Handle the result or add error handling as needed
}
// functions.php

function getFilesByUserId($userId, $conn) {
    $query = "SELECT * FROM files WHERE user_id = $userId";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $files = [];
        while ($row = $result->fetch_assoc()) {
            $files[] = $row;
        }
        return $files;
    } else {
        return []; // Return an empty array if no files found or handle accordingly
    }
}
function getUsersFromDatabase($conn) {
    $users = array(); // Array untuk menyimpan data pengguna

    $query = "SELECT id, username, saldo FROM users";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }

    return $users;
}
function getUserById($userId, $conn) {
    // Escape parameter untuk mencegah SQL injection
    $userId = mysqli_real_escape_string($conn, $userId);

    // Query SQL untuk mendapatkan data pengguna berdasarkan ID
    $query = "SELECT * FROM users WHERE id = $userId";
    $result = $conn->query($query);

    if ($result && $result->num_rows == 1) {
        // Ambil data pengguna sebagai asosiatif array
        $user = $result->fetch_assoc();
        return $user;
    } else {
        // Pengguna tidak ditemukan
        return false;
    }
}
?>
