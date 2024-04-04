<?php
session_start();

include 'config.php'; // File koneksi ke database

// Cek apakah admin sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id_pemesanan'])) {
    $id_pemesanan = $_GET['id_pemesanan'];

    $sql = "DELETE FROM pemesanan WHERE id_pemesanan = ?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_pemesanan);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: data_pemesanan.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    header("Location: data_pemesanan.php");
    exit();
}
?>
