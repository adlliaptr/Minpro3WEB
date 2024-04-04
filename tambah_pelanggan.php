<?php
session_start();

include 'config.php'; // File koneksi ke database

// Cek apakah admin sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $email = $_POST['email'];
    $nomor_telepon = $_POST['nomor_telepon'];
    $alamat = $_POST['alamat'];
    $province_id = $_POST['provinsi'];
    $city_id = $_POST['kota'];
    $kode_pos = $_POST['kode_pos'];

    // Ambil nama provinsi dan kota berdasarkan ID
    include 'config_API.php';
    $nama_provinsi = getNamaProvinsi($province_id);
    $nama_kota = getNamaKota($city_id);

    // Query untuk insert data pelanggan
    $sql = "INSERT INTO pelanggan (nama_depan, nama_belakang, email, nomor_telepon, alamat, provinsi, kota, kode_pos) VALUES ('$nama_depan', '$nama_belakang', '$email', '$nomor_telepon', '$alamat', '$nama_provinsi', '$nama_kota', '$kode_pos')";

    if (mysqli_query($conn, $sql)) {
        header("Location: data_pelanggan.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Tambah Pelanggan</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'partials/sidebar.php'; ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

            <?php include 'partials/topbar.php'; ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Tambah Pelanggan</h1>
                    
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <!-- Form Input Data Pelanggan -->
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label for="nama_depan">Nama Depan:</label>
                                    <input type="text" class="form-control" id="nama_depan" name="nama_depan" required>
                                </div>
                                <div class="form-group">
                                    <label for="nama_belakang">Nama Belakang:</label>
                                    <input type="text" class="form-control" id="nama_belakang" name="nama_belakang" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_telepon">Nomor Telepon:</label>
                                    <input type="number" class="form-control" id="nomor_telepon" name="nomor_telepon" required>
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat:</label>
                                    <textarea class="form-control" id="alamat" name="alamat" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="provinsi">Provinsi:</label>
                                    <select class="form-control" id="provinsi" name="provinsi" required>
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kota">Kota:</label>
                                    <select class="form-control" id="kota" name="kota" required>
                                        <option value="">Pilih Kota</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="kode_pos">Kode Pos:</label>
                                    <input type="text" class="form-control" id="kode_pos" name="kode_pos">
                                </div>
                                <button type="submit" class="btn btn-success">Tambah</button>
                            </form>
                        </div>
                    </div>
                    

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include 'partials/footer.php'; ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Mengambil data provinsi dari API RajaOngkir
            $.ajax({
                url: 'config_API.php',
                type: 'POST',
                data: {
                    action: 'getProvinsi'
                },
                success: function(response) {
                    var data = JSON.parse(response);
                    var options = "<option value=''>Pilih Provinsi</option>";
                    data.forEach(function(item) {
                        options += "<option value='" + item.province_id + "'>" + item.province + "</option>";
                    });
                    $("#provinsi").html(options);
                }
            });

            // Mengisi dropdown Kota berdasarkan Provinsi yang dipilih
            $("#provinsi").change(function() {
                var province_id = $(this).val();
                $.ajax({
                    url: 'config_API.php',
                    type: 'POST',
                    data: {
                        action: 'getKota',
                        province_id: province_id
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        var options = "<option value=''>Pilih Kota</option>";
                        data.forEach(function(item) {
                            options += "<option value='" + item.city_id + "'>" + item.city_name + "</option>";
                        });
                        $("#kota").html(options);
                    }
                });
            });

        });
    </script>
    
</body>

</html>
