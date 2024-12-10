<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BTAM Inventory App-User</title>

    <!-- Custom fonts for this template -->
    <link href="<?= base_url('sb2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?= base_url('sb2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <!-- Custom styles for this page -->
    <link href="<?= base_url('sb2/vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/index.css') ?>">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-text mx-3">Inventory BTAM</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="/dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Nav Item -->
            <li class="nav-item">
                <a class="nav-link" href="/dashboard/user">
                    <i class="fas fa-fw fa-user"></i>
                    <span>User</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/dashboard/barang">
                    <i class="fas fa-fw fa-boxes"></i>
                    <span>Item</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/dashboard/laporan">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Pemeliharaan</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="/dashboard/barang_keluar">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Barang Keluar</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <?php if ($userRole === 'Super Admin' || $userRole === 'Admin'): ?>
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard/data_master">
                        <i class="fas fa-fw fa-table"></i>
                        <span>Data Master</span></a>
                </li>
            <?php endif; ?>
            <li class="nav-item">
                <a class="nav-link" href="/dashboard/cetak_laporan">
                    <i class="fas fa-fw fa-print"></i>
                    <span>Cetak Laporan</span></a>
            </li>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">
                                    <?= session()->get('username'); ?>
                                </span>
                                <img class="img-profile rounded-circle"
                                    src="<?= base_url('sb2/img/undraw_profile.svg') ?>">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= base_url('auth/logout') ?>" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Barang Keluar</h1>

                    <!-- Flash message -->
                    <?php if ($userRole === 'Super Admin'): ?>
                        <!-- Success Message -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('success'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                        <!-- Error Message -->
                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= session()->getFlashdata('error'); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!-- Form input barang keluar -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Form Barang Keluar</h6>
                        </div>
                        <div class="card-body">
                            <form action="barang_keluar/save" method="post">
                                <?= csrf_field(); ?>
                                <div class="form-group">
                                    <label for="id_barang">Barang</label>
                                    <select class="form-control" name="id_barang" id="id_barang" onchange="getStokBarang()">
                                        <option value="">-- Pilih Barang --</option>
                                        <?php foreach ($barang as $b): ?>
                                            <option value="<?= $b['id_barang']; ?>"><?= $b['nama_barang']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="stok">Stok Barang</label>
                                    <input type="number" class="form-control" id="stok" name="stok" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="jumlah">Jumlah</label>
                                    <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                                </div>

                                <div class="form-group">
                                    <label for="tanggal_keluar">Tanggal Keluar</label>
                                    <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar" required>
                                </div>

                                <div class="form-group">
                                    <label for="nama_penanggung_jawab">Nama Penanggung Jawab</label>
                                    <input type="text" class="form-control" id="nama_penanggung_jawab" name="nama_penanggung_jawab" value="<?= session('nama_user'); ?>" readonly>
                                </div>

                                <div class="form-group">
                                    <label for="lama_peminjaman">Lama Peminjaman</label>
                                    <input type="text" class="form-control" id="lama_peminjaman" name="lama_peminjaman" required>
                                </div>

                                <div class="form-group">
                                    <label for="alasan">Alasan</label>
                                    <textarea class="form-control" id="alasan" name="alasan" rows="3" required></textarea>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>
                    </div>

                    <!-- Form Filter Tanggal -->
                    <div class="mb-3">
                        <form action="<?= base_url('dashboard/barang_keluar/filter') ?>" method="get">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= isset($_GET['tanggal_mulai']) ? $_GET['tanggal_mulai'] : '' ?>">
                                </div>
                                <div class="col-md-4">
                                    <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                                    <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="<?= isset($_GET['tanggal_akhir']) ? $_GET['tanggal_akhir'] : '' ?>">
                                </div>
                                <div class="col-md-4">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- DataTables Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Barang Keluar</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah</th>
                                            <th>Kondisi</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Nama Penanggung Jawab</th>
                                            <th>Lama Peminjaman</th>
                                            <th>Estimasi Pengembalian</th>
                                            <th>Alasan</th>
                                            <th>Status Pengembalian</th>
                                            <th>Tanggal Pengembalian</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($barangKeluar)): ?>
                                            <?php foreach ($barangKeluar as $bk): ?>
                                                <tr>
                                                    <td><?= $bk['id_barang_keluar']; ?></td>
                                                    <td><?= $bk['nama_barang']; ?></td>
                                                    <td><?= $bk['jumlah']; ?></td>
                                                    <td><?= $bk['kondisi']; ?></td>
                                                    <td><?= $bk['tanggal_keluar']; ?></td>
                                                    <td><?= $bk['nama_penanggung_jawab']; ?></td>
                                                    <td><?= $bk['lama_peminjaman']; ?> Hari</td>
                                                    <td><?= $bk['estimasi_pengembalian']; ?></td>
                                                    <td><?= $bk['alasan']; ?></td>
                                                    <td><?= $bk['status_pengembalian']; ?></td>
                                                    <td><?= $bk['tanggal_kembali']; ?></td>
                                                    <td>
                                                        <?php if ($bk['status_pengembalian'] === 'Sudah Dikembalikan'): ?>
                                                            <button class="btn btn-secondary" disabled>Sudah Dikembalikan</button>
                                                        <?php else: ?>
                                                            <button class="btn btn-warning" onclick="returnItem(<?= $bk['id_barang_keluar']; ?>)">Kembalikan</button>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="9">Tidak ada data barang keluar.</td>
                                            </tr>
                                        <?php endif; ?>
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
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Balai Teknologi Air Minum 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Pengembalian -->
    <div class="modal fade" id="confirmReturnModal" tabindex="-1" role="dialog" aria-labelledby="confirmReturnModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmReturnModalLabel">Konfirmasi Pengembalian Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="returnForm">
                        <div class="form-group">
                            <label for="kondisi_barang">Pilih Kondisi Barang</label>
                            <select class="form-control" id="kondisi_barang" name="id_kondisi">
                                <option value="">-- Pilih Kondisi --</option>
                                <?php foreach ($kondisi as $k): ?>
                                    <option value="<?= $k['id_kondisi']; ?>"><?= $k['kondisi_item']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="confirmReturnButton">Kembalikan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('sb2/vendor/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('sb2/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('sb2/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('sb2/js/sb-admin-2.min.js') ?>"></script>

    <!-- Page level plugins -->
    <script src="<?= base_url('sb2/vendor/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('sb2vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('sb2/js/demo/datatables-demo.js') ?>"></script>

    <script>
        function getStokBarang() {
            var id_barang = document.getElementById('id_barang').value;

            if (id_barang) {
                // Lakukan request ke server menggunakan AJAX
                fetch('<?= base_url('dashboard/barang/getStok'); ?>/' + id_barang)
                    .then(response => response.json())
                    .then(data => {
                        console.log(data); // Log respons server untuk memeriksa apakah data berhasil diterima
                        if (data.success) {
                            document.getElementById('stok').value = data.stok;
                        } else {
                            document.getElementById('stok').value = 0;
                            alert('Barang tidak ditemukan atau stok kosong.');
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching stock:', error);
                    });
            } else {
                // Reset stok jika tidak ada barang yang dipilih
                document.getElementById('stok').value = '';
            }
        }

        let itemId;

        function returnItem(id) {
            itemId = id;
            $('#confirmReturnModal').modal('show');
        }

        document.getElementById('confirmReturnButton').addEventListener('click', function() {
            const id_kondisi = document.getElementById('kondisi_barang').value;

            if (!id_kondisi) {
                alert('Silakan pilih kondisi barang sebelum mengembalikan.');
                return;
            }

            const url = '<?= base_url("dashboard/barang_keluar/returnItem/") ?>' + itemId + '?id_kondisi=' + id_kondisi;

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest' // Tambahkan header ini jika diperlukan
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan saat mengembalikan barang.');
                });
        });

        $(document).ready(function() {
            // Cek apakah ada pesan sukses dari session
            <?php if (session()->getFlashdata('success')) : ?>
                $('#notifMessage').text('<?= session()->getFlashdata('success') ?>');
                $('#notifModal').modal('show');
            <?php endif; ?>

            // Cek apakah ada pesan error dari session
            <?php if (session()->getFlashdata('error')) : ?>
                $('#notifMessage').text('<?= session()->getFlashdata('error') ?>');
                $('#notifModal').modal('show');
            <?php endif; ?>

            // Bisa juga menampilkan pesan validasi error
            <?php if (session()->getFlashdata('errors')) : ?>
                var errors = <?= json_encode(session()->getFlashdata('errors')) ?>;
                var errorMessage = '';
                for (var key in errors) {
                    if (errors.hasOwnProperty(key)) {
                        errorMessage += errors[key] + '\n';
                    }
                }
                $('#notifMessage').text(errorMessage);
                $('#notifModal').modal('show');
            <?php endif; ?>
        });

        // Auto-close alert after 3 seconds
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function() {
                $(this).remove();
            });
        }, 3000);
    </script>
</body>

</html>