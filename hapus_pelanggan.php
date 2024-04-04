<?php
session_start();

include 'config.php'; // File koneksi ke database

// Cek apakah admin sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_pelanggan = $_GET['id_pelanggan'];

// Query untuk menghapus data pelanggan
$sql = "DELETE FROM pelanggan WHERE id_pelanggan = $id_pelanggan";

if (mysqli_query($conn, $sql)) {
    header("Location: data_pelanggan.php");
    exit();
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
