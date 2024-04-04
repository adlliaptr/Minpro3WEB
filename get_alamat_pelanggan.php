<?php
include 'config.php';

if (isset($_POST['id_pelanggan'])) {
    $id_pelanggan = $_POST['id_pelanggan'];

    $query = "SELECT nama_depan, nama_belakang, alamat, kota, provinsi, kode_pos FROM pelanggan WHERE id_pelanggan = '$id_pelanggan'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode($row);
    } else {
        echo json_encode(['error' => 'Pelanggan tidak ditemukan']);
    }
} else {
    echo json_encode(['error' => 'ID Pelanggan tidak ditemukan']);
}

mysqli_close($conn);
?>
