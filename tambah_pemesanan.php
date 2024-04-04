<?php
session_start();

include 'config.php'; // File koneksi ke database

// Cek apakah admin sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$query = "SELECT * FROM pelanggan";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Data Pemesanan</title>
    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    

</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php include 'partials/sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <?php include 'partials/topbar.php'; ?>
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <h1 class="h3 mb-2 text-gray-800">Data Pemesanan</h1>
                    <form class="mb-5" action="proses_tambah_pemesanan.php" method="POST">
                        <div class="row">
                            <!-- Pencarian Data Pelanggan -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pelanggan">Cari Pelanggan:</label>
                                    <select class="form-control select2" style="height: calc(1.5em + 0.75rem + 2px);" id="pelanggan" name="id_pelanggan">
                                        <option value="">Pilih Pelanggan</option>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='" . $row['id_pelanggan'] . "'>" . $row['nama_depan'] . " " . $row['nama_belakang'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                               
                            </div>
                            

                        
                        </div>

                        <hr>
                        <div class="row">
    <!-- Form Alamat Pengirim -->
    <div class="col-md-6">
        <h5 class="mb-2 text-gray-800 fw-bolder">Alamat Pengirim</h5>
        <div class="form-group">
            <label for="provinsi_pengirim">Provinsi:</label>
            <select class="form-control" id="provinsi_pengirim" name="provinsi_pengirim" required>
                <option value="">Pilih Provinsi</option>
            </select>
        </div>
        <div class="form-group"> 
            <label for="kota_pengirim">Kota:</label>
            <select class="form-control" id="kota_pengirim" name="kota_pengirim" required>
                <option value="">Pilih Kota</option>
            </select>
        </div>
        <div class="form-group">
            <label for="kode_pos_pengirim">Kode Pos:</label>
            <input type="text" class="form-control" id="kode_pos_pengirim" name="kode_pos_pengirim" required>
        </div>
        <div class="form-group">
            <label for="alamat_pengirim">Alamat:</label>
            <textarea class="form-control" id="alamat_pengirim" name="alamat_pengirim" rows="3" required></textarea>
        </div>
    </div>

    <!-- Form Alamat Tujuan -->
    <div class="col-md-6">
        <h5 class="mb-2 text-gray-800 fw-bolder">Alamat Tujuan</h5>
        <div class="form-group">
            <label for="provinsi_tujuan">Provinsi:</label>
            <select class="form-control" id="provinsi_tujuan" name="provinsi_tujuan" required>
                <option value="">Pilih Provinsi</option>
            </select>
        </div>
        <div class="form-group">
            <label for="kota_tujuan">Kota:</label>
            <select class="form-control" id="kota_tujuan" name="kota_tujuan" required>
                <option value="">Pilih Kota</option>
            </select>
        </div>
        <div class="form-group">
            <label for="kode_pos_tujuan">Kode Pos:</label>
            <input type="text" class="form-control" id="kode_pos_tujuan" name="kode_pos_tujuan" required>
        </div>
        <div class="form-group">
            <label for="alamat_tujuan">Alamat:</label>
            <textarea class="form-control" id="alamat_tujuan" name="alamat_tujuan" rows="3" required></textarea>
        </div>
    </div>
</div>


                        <hr>

                        <div class="row">
                            <!-- Form Detail Barang -->
                            <div class="col-md-6">
                                <h5 class="mb-2 text-gray-800 fw-bolder">Detail Barang</h5>
                                <div class="form-group">
                                    <label for="berat">Berat (gram):</label>
                                    <input type="number" class="form-control" id="berat" name="berat" required>
                                </div>
                                <div class="form-group">
                                    <label for="detail">Detail:</label>
                                    <textarea class="form-control" id="detail" name="detail" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="courier">Kurir:</label>
                                    <select class="form-control" id="courier" name="courier">
                                        <option value="jne">JNE</option>
                                        <option value="POS">POS Indonesia</option>
                                        <option value="tiki">TIKI</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary" id="cekOngkir">Cek Ongkos Kirim</button>
                                                            
                            </div>

                            <div class="col-md-6">
                            <h5 class="mb-2 text-gray-800 fw-bolder">Ongkos Kirim</h5>
                                <div id="result"></div>
                            </div>

                        </div>
                        <hr>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </form>
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
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <!-- Script untuk cek alamat -->
        <script>
           $(document).ready(function() {
    // Inisialisasi Select2
    $('.select2').select2({
        placeholder: 'Pilih Pelanggan',
        ajax: {
            url: 'get_pelanggan.php',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    keyword: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            id: item.id_pelanggan,
                            text: item.nama_depan + ' ' + item.nama_belakang
                        };
                    })
                };
            },
            cache: true
        }
    });

    // Mengisi dropdown Provinsi
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
            $("#provinsi_pengirim, #provinsi_tujuan").html(options);
        }
    });

    // Event untuk mengisi dropdown Kota berdasarkan Provinsi Pengirim
    $('#provinsi_pengirim').change(function() {
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
                $("#kota_pengirim").html(options);
            }
        });
    });

    // Event untuk mengisi dropdown Kota berdasarkan Provinsi Tujuan
    $('#provinsi_tujuan').change(function() {
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
                $("#kota_tujuan").html(options);
            }
        });
    });

   // Event untuk tombol cek ongkos kirim
$('#cekOngkir').click(function() {
    var origin = $('#kota_pengirim').val();
    var destination = $('#kota_tujuan').val();
    var weight = $('#berat').val();
    var detail = $('#detail').val();
    var courier = $('#courier').val();

    var provinsiPengirim = $('#provinsi_pengirim').val();
    var kotaPengirim = $('#kota_pengirim').val();
    var provinsiTujuan = $('#provinsi_tujuan').val();
    var kotaTujuan = $('#kota_tujuan').val();

    // Validasi input
    if (provinsiPengirim == '' || kotaPengirim == '' || provinsiTujuan == '' || kotaTujuan == '') {
        alert('Mohon lengkapi data provinsi dan kota terlebih dahulu');
        return;
    }

    $.ajax({
        url: 'cek_ongkir.php',
        type: 'POST',
        data: {
            origin: origin,
            destination: destination,
            weight: weight,
            detail: detail,
            courier: courier
        },
        success: function(data) {
            var resultData = JSON.parse(data);
            var radioButtons = "";

            resultData.forEach(function(item) {
                radioButtons += `
                
                    <div class="form-check mb-5">
                        <input class="form-check-input text-gray-800" type="radio" name="service" id="${item.service}" value="${item.service}" data-description="${item.description}" data-biaya="${item.biaya}" required>
                        <label class="form-check-label" for="${item.service}">
                            Service     : ${item.service}<br>
                            Description : ${item.description}<br>
                            Biaya       : ${item.biaya}
                        </label>
                    </div>

                `;
            });

            $('#result').html(radioButtons);
        },
        error: function(error) {
            $('#result').html("<p>Error: " + error.responseJSON.message + "</p>");
        }
    });
});

// Event untuk form submit
$('form').submit(function(e) {
    e.preventDefault();

    var selectedService = $("input[name='service']:checked");
    var description = selectedService.data('description');
    var biaya = selectedService.data('biaya');

    $('<input>').attr({
        type: 'hidden',
        name: 'description',
        value: description
    }).appendTo('form');

    $('<input>').attr({
        type: 'hidden',
        name: 'biaya',
        value: biaya
    }).appendTo('form');

    this.submit();
});



    
   
});

        </script>
    </div>
</body>

</html>
