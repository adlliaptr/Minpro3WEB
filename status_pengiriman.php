<?php
session_start();

include 'config.php'; // File koneksi ke database

// Cek apakah admin sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Query untuk mengambil data pemesanan dengan join tabel pelanggan
$query = "SELECT pemesanan.*, pelanggan.nama_depan, pelanggan.nama_belakang 
          FROM pemesanan 
          JOIN pelanggan ON pemesanan.id_pelanggan = pelanggan.id_pelanggan";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Status Pengiriman</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

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
                    <h1 class="h3 mb-2 text-gray-800">Status Pengiriman</h1>
                    
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                       
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID Pemesanan</th>
                                            <th>Nama Pelanggan</th>
                                            <th>Berat (Gram)</th>
                                            <th>Detail</th>
                                            <th>Courier</th>
                                            <th>Service</th>
                                            <th>Biaya</th>
                                            <th>Status</th>
                                            <th>Action</th> 
                                        </tr>
                                    </thead>
                                    
                                    <tbody>
                                        <?php
                                        while ($row = mysqli_fetch_assoc($result)) {
                                        ?>
                                            <tr>
                                                <td><?php echo $row['id_pemesanan']; ?></td>
                                                <td><?php echo $row['nama_depan'] . ' ' . $row['nama_belakang']; ?></td>
                                                <td><?php echo $row['berat']; ?></td>
                                                <td><?php echo $row['detail']; ?></td>
                                                <td class="text-uppercase"><?php echo $row['courier']; ?></td>
                                                <td><?php echo $row['service']; ?></td>
                                                <td><?php echo $row['biaya']; ?></td>
                                                <td>
                                                    <?php
                                                        $status = $row['status'];
                                                        $badge_class = '';
                                                        
                                                        switch ($status) {
                                                            case 'Batal':
                                                                $badge_class = 'bg-danger';
                                                                break;
                                                            case 'Selesai':
                                                                $badge_class = 'bg-success';
                                                                break;
                                                            default:
                                                                $badge_class = 'bg-primary';
                                                                break;
                                                        }
                                                    ?>
                                                    <span class="badge rounded-pill <?php echo $badge_class; ?> text-white fw-bold"><?php echo $status; ?></span>
                                                </td>

                                                <td>
                                                    <button class="btn btn-primary btn-sm editBtn" data-id="<?php echo $row['id_pemesanan']; ?>" data-status="<?php echo $row['status']; ?>"><i class="fas fa-edit"></i></button>
                                                    <a href="hapus_pemesanan.php?id_pemesanan=<?php echo $row['id_pemesanan']; ?>" class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                                
                            </div>
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

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <!-- Modal Edit -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Status Pengiriman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="edit_status.php" method="post">
                        <input type="hidden" name="id_pemesanan" id="editId">
                        <div class="form-group">
                            <label for="editStatus">Status:</label>
                            <select class="form-control" name="status" id="editStatus">
                                <option value="Menunggu Pembayaran">Menunggu Pembayaran</option>
                                <option value="Diproses">Diproses</option>
                                <option value="Dikirim">Dikirim</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Selesai">Selesai</option>
                                <option value="Batal">Batal</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('.editBtn').on('click', function() {
            const id = $(this).data('id');
            const status = $(this).data('status');
            $('#editId').val(id);
            $('#editStatus').val(status);
            $('#editModal').modal('show');
        });
    </script>

</body>

</html>
