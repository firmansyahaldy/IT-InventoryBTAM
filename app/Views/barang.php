<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Balai Teknologi Air Minum - Items</title>

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
            <li class="nav-item active">
                <a class="nav-link" href="/dashboard/barang">
                    <i class="fas fa-fw fa-boxes"></i>
                    <span>Item</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/dashboard/laporan">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Maintenance</span></a>
            </li>
            <li class="nav-item">
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Barang</h1>

                        <?php if ($userRole === 'Super Admin' || $userRole === 'Admin'): ?>
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
                    </div>

                    <!-- Tabel Barang -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Data Tables Barang</h6>
                            <?php if ($userRole === 'Super Admin' || $userRole === 'Admin'): ?>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addBarangModal">
                                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambah Barang
                                </button>
                            <?php endif; ?>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Kategori</th>
                                            <th>Nama Barang</th>
                                            <th>Merk</th>
                                            <th>Spesifikasi</th>
                                            <th>Tipe</th>
                                            <th>Tgl Pembelian</th>
                                            <th>Harga Pembelian</th>
                                            <th>Status Barang</th>
                                            <th>Kuantitas</th>
                                            <th>Kondisi Barang</th>
                                            <th>masa_garansi</th>
                                            <th>serial_number</th>
                                            <th>Lokasi Barang</th>
                                            <th>Maintenance Selanjutnya</th>
                                            <?php if ($userRole === 'Super Admin'): ?>
                                                <th>Aksi</th>
                                            <?php endif; ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($barangs as $barang) : ?>
                                            <tr>
                                                <td><?= esc($barang['kode_barang']) ?></td>
                                                <td><?= esc($barang['kategori_item']) ?></td>
                                                <td><?= esc($barang['nama_barang']) ?></td>
                                                <td><?= esc($barang['merk']) ?></td>
                                                <td><?= esc($barang['spesifikasi']) ?></td>
                                                <td><?= esc($barang['tipe']) ?></td>
                                                <td><?= esc($barang['tgl_pembelian']) ?></td>
                                                <td><?= esc($barang['harga_pembelian']) ?></td>
                                                <td><?= esc($barang['status_barang']) ?></td>
                                                <td><?= esc($barang['kuantitas']) ?></td>
                                                <td><?= esc($barang['kondisi_item']) ?></td>
                                                <td><?= esc($barang['masa_garansi']) ?></td>
                                                <td><?= esc($barang['serial_number']) ?></td>
                                                <td><?= esc($barang['lokasi_barang']) ?></td>
                                                <td><?= esc($barang['maintenance_selanjutnya']) ?></td>

                                                <?php if ($userRole === 'Super Admin'): ?>
                                                    <td>
                                                        <button type="button" class="btn btn-warning btn-sm editBarangBtn" data-id="<?= $barang['id_barang'] ?>" data-toggle="modal" data-target="#editBarangModal">Edit</button>
                                                        <button type="button" class="btn btn-danger btn-sm deleteBarangBtn" data-id="<?= $barang['id_barang'] ?>" data-toggle="modal" data-target="#deleteBarangModal">Hapus</button>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php endforeach; ?>
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

    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="addBarangModal" tabindex="-1" role="dialog" aria-labelledby="addBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBarangModalLabel">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="addBarangForm" method="POST" action="<?= base_url('dashboard/barang/create') ?>">
                        <?= csrf_field() ?>
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang</label>
                            <input type="text" id="kode_barang" name="kode_barang" class="form-control" required>
                        </div>

                        <!-- Dropdown Kategori Barang -->
                        <div class="form-group">
                            <label for="edit_kategori">kategori Barang</label>
                            <select id="edit_kategori" name="kategori" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                <?php foreach ($kategoris as $kategori): ?>
                                    <option value="<?= $kategori['id_kategori']; ?>"><?= $kategori['kategori_item']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Nama Barang</label>
                            <input type="text" id="nama_barang" name="nama_barang" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="merk">Merk</label>
                            <input type="text" id="merk" name="merk" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="spesifikasi">spesifikasi</label>
                            <input type="text" id="spesifikasi" name="spesifikasi" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tipe">Tipe</label>
                            <input type="text" id="tipe" name="tipe" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="tgl_pembelian">Tanggal Pembelian</label>
                            <input type="date" id="tgl_pembelian" name="tgl_pembelian" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="harga_pembelian">Harga Pembelian</label>
                            <input type="number" id="harga_pembelian" name="harga_pembelian" class="form-control" required>
                        </div>
                        <!-- Dropdown Status Barang -->
                        <div class="form-group">
                            <label for="status_barang">Status Barang</label>
                            <select id="status_barang" name="status_barang" class="form-control" required>
                                <option value="">-- Pilih Status Barang --</option>
                                <?php foreach ($statusBarangs as $statusBarang): ?>
                                    <option value="<?= $statusBarang['id_status_barang']; ?>"><?= $statusBarang['status_barang']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kuantitas">Kuantitas</label>
                            <input type="number" id="kuantitas" name="kuantitas" class="form-control" required>
                        </div>
                        <!-- Dropdown Kondisi Barang -->
                        <div class="form-group">
                            <label for="kondisi_barang">Kondisi Barang</label>
                            <select id="kondisi_barang" name="kondisi_barang" class="form-control" required>
                                <option value="">-- Pilih Kondisi Barang --</option>
                                <?php foreach ($kondisiBarangs as $kondisiBarang): ?>
                                    <option value="<?= $kondisiBarang['id_kondisi']; ?>"><?= $kondisiBarang['kondisi_item']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="masa_garansi">Masa Garansi</label>
                            <input type="date" id="masa_garansi" name="masa_garansi" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="serial_number">Serial Number</label>
                            <input type="text" id="serial_number" name="serial_number" class="form-control">
                        </div>
                        <!-- Dropdown lokasi Barang -->
                        <div class="form-group">
                            <label for="lokasi_barang">Lokasi Barang</label>
                            <select id="lokasi_barang" name="lokasi_barang" class="form-control" required>
                                <option value="">-- Pilih Lokasi Barang --</option>
                                <?php foreach ($lokasiBarangs as $lokasiBarang): ?>
                                    <option value="<?= $lokasiBarang['id_lokasi_barang']; ?>"><?= $lokasiBarang['lokasi_barang']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="maintenance_selanjutnya">Maintenance Selanjutnya</label>
                            <input type="date" id="maintenance_selanjutnya" name="maintenance_selanjutnya" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Barang -->
    <div class="modal fade" id="editBarangModal" tabindex="-1" role="dialog" aria-labelledby="editBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBarangModalLabel">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editBarangForm" method="POST" action="<?= base_url('dashboard/barang/update') ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" id="edit_barang_id" name="id_barang">
                        <!-- Dropdown Kategori Barang -->
                        <div class="form-group">
                            <label for="edit_kategori">kategori Barang</label>
                            <select id="edit_kategori" name="kategori" class="form-control" required>
                                <?php foreach ($kategoris as $kategori): ?>
                                    <option value="<?= $kategori['id_kategori']; ?>"><?= $kategori['kategori_item']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_kondisi_barang">Kondisi Barang</label>
                            <select id="edit_kondisi_barang" name="kondisi_barang" class="form-control" required>
                                <?php foreach ($kondisiBarangs as $kondisiBarang): ?>
                                    <option value="<?= $kondisiBarang['id_kondisi']; ?>"><?= $kondisiBarang['kondisi_item']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="edit_deskripsi_kerusakan_field" class="form-group" style="display: none;">
                            <label for="edit_deskripsi_kerusakan">Deskripsi Kerusakan</label>
                            <textarea id="edit_deskripsi_kerusakan" name="deskripsi_kerusakan" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="edit_lokasi_barang">Lokasi Barang</label>
                            <select id="edit_lokasi_barang" name="lokasi_barang" class="form-control" required>
                                <?php foreach ($lokasiBarangs as $lokasiBarang): ?>
                                    <option value="<?= $lokasiBarang['id_lokasi_barang']; ?>"><?= $lokasiBarang['lokasi_barang']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_maintenance_selanjutnya">Maintenance Selanjutnya</label>
                            <input type="date" id="edit_maintenance_selanjutnya" name="maintenance_selanjutnya" class="form-control" required>
                        </div> 
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteBarangModal" tabindex="-1" role="dialog" aria-labelledby="deleteBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteBarangModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus barang ini?</p>
                    <form id="deleteBarangForm" method="POST" action="<?= base_url('dashboard/barang/delete/' . $barang['id_barang']) ?>">
                        <?= csrf_field() ?>
                        <input type="hidden" id="delete_barang_id" name="id_barang">
                        <button type="submit" class="btn btn-danger">Hapus</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    </form>
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
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });

        $(document).ready(function() {
            // Fungsi untuk menampilkan/menyembunyikan field deskripsi kerusakan berdasarkan kondisi
            function toggleDeskripsiKerusakan(condition) {
                if (condition == 2) {
                    $('#edit_deskripsi_kerusakan_field').show(); // Tampilkan field deskripsi kerusakan
                } else {
                    $('#edit_deskripsi_kerusakan_field').hide(); // Sembunyikan field deskripsi kerusakan
                }
            }

            // Saat tombol edit diklik, ambil data barang berdasarkan ID, dan isi form
            $(document).on('click', '.editBarangBtn', function() {
                var barangId = $(this).data('id');
                $.ajax({
                    url: "<?= base_url('dashboard/barang/getBarang') ?>/" + barangId,
                    method: "GET",
                    success: function(response) {
                        // Isi form dengan data yang diterima dari server 
                        $('#edit_barang_id').val(response.kode_barang);
                        $('#edit_kategori').val(response.id_kategori); // Trigger untuk menampilkan field tambahan
                        $('#edit_maintenance_selanjutnya').val(response.maintenance_selanjutnya);
                        // Isi dan cek kondisi barang untuk menampilkan/menyembunyikan deskripsi kerusakan
                        $('#edit_kondisi_barang').val(response.id_kondisi).trigger('change');
                        toggleDeskripsiKerusakan(response.kondisi_barang);
                    }
                });
            });

            // Ketika dropdown kondisi barang berubah, tampilkan/ sembunyikan field deskripsi kerusakan
            $('#edit_kondisi_barang').on('change', function() {
                var condition = $(this).val();
                toggleDeskripsiKerusakan(condition);
            });

        });


        // Delete Barang
        $(document).on('click', '.deleteBarangBtn', function() {
            var barangId = $(this).data('id');
            $('#delete_barang_id').val(barangId);
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