<?php
session_start();

include 'config.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pemesanan = $_POST['id_pemesanan'];
    $status = $_POST['status'];

    $update_query = "UPDATE pemesanan SET status = ? WHERE id_pemesanan = ?";
    $stmt = mysqli_prepare($conn, $update_query);
    mysqli_stmt_bind_param($stmt, "si", $status, $id_pemesanan);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: status_pengiriman.php");
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}
?>
