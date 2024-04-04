<?php
session_start();

include 'config.php'; // File koneksi ke database
include 'config_API.php'; // File koneksi ke API

// Cek apakah admin sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = $_POST['id_pelanggan'];
    
    // Mendapatkan nama provinsi pengirim dan kota pengirim
    $nama_provinsi_pengirim = getNamaProvinsi($_POST['provinsi_pengirim']);
    $nama_kota_pengirim = getNamaKota($_POST['kota_pengirim']);
    
    // Mendapatkan nama provinsi tujuan dan kota tujuan
    $nama_provinsi_tujuan = getNamaProvinsi($_POST['provinsi_tujuan']);
    $nama_kota_tujuan = getNamaKota($_POST['kota_tujuan']);
    
    $kode_pos_pengirim = $_POST['kode_pos_pengirim'];
    $alamat_pengirim = $_POST['alamat_pengirim'];
    $kode_pos_tujuan = $_POST['kode_pos_tujuan'];
    $alamat_tujuan = $_POST['alamat_tujuan'];
    $berat = $_POST['berat'];
    $detail = $_POST['detail'];
    $courier = $_POST['courier'];
    $service = $_POST['service'];
    $biaya = $_POST['biaya'];

    $sql = "INSERT INTO pemesanan (id_pelanggan, provinsi_pengirim, kota_pengirim, kode_pos_pengirim, alamat_pengirim, provinsi_tujuan, kota_tujuan, kode_pos_tujuan, alamat_tujuan, berat, detail, courier, service, biaya) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issssssssisssd", $id_pelanggan, $nama_provinsi_pengirim, $nama_kota_pengirim, $kode_pos_pengirim, $alamat_pengirim, $nama_provinsi_tujuan, $nama_kota_tujuan, $kode_pos_tujuan, $alamat_tujuan, $berat, $detail, $courier, $service, $biaya);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: data_pemesanan.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
