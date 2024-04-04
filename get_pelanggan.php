<?php
include 'config.php';

$keyword = $_POST['keyword'] ?? '';

$query = "SELECT * FROM pelanggan WHERE nama_depan LIKE '%$keyword%' OR nama_belakang LIKE '%$keyword%'";
$result = mysqli_query($conn, $query);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = [
        'id_pelanggan' => $row['id_pelanggan'],
        'nama_depan' => $row['nama_depan'],
        'nama_belakang' => $row['nama_belakang']
    ];
}

echo json_encode($data);
?>
