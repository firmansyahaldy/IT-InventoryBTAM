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
            <li class="nav-item active">
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

                    <div class="container">
                        <h2>Laporan</h2>
                        <form id="laporanForm" action="">
                            <div class="form-group">
                                <label for="table">Pilih Tabel:</label>
                                <select id="table" class="form-control">
                                    <?php foreach ($tables as $table): ?>
                                        <option value="<?= $table ?>"><?= ucfirst($table) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <!-- Filter tanggal akan tampil hanya untuk barang-keluar -->
                            <div id="dateFilter" style="display:none;">
                                <div class="form-group">
                                    <label for="startDate">Tanggal Mulai:</label>
                                    <input type="date" id="startDate" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="endDate">Tanggal Akhir:</label>
                                    <input type="date" id="endDate" class="form-control">
                                </div>
                            </div>

                            <button type="button" id="loadData" class="btn btn-primary">Tampilkan Data</button>
                        </form>

                        <table id="laporanTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <!-- Kolom akan otomatis terisi setelah load data -->
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Baris akan diisi secara dinamis -->
                            </tbody>
                        </table>

                        <button id="exportPDF" class="btn btn-danger">Export to PDF</button>
                        <button id="exportExcel" class="btn btn-success">Export to Excel</button>
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

    <!-- Modal untuk input data surat jalan -->
    <div class="modal fade" id="suratJalanModal" tabindex="-1" role="dialog" aria-labelledby="suratJalanLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="suratJalanLabel">Input Data Surat Jalan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="suratJalanForm">
                        <div class="form-group">
                            <label for="alamatTujuan">Alamat Tujuan</label>
                            <input type="text" class="form-control" id="alamatTujuan" placeholder="Masukkan alamat tujuan">
                        </div>
                        <div class="form-group">
                            <label for="penanggungJawab">Penanggung Jawab</label>
                            <input type="text" class="form-control" id="penanggungJawab" placeholder="Nama penanggung jawab">
                        </div>
                        <button type="button" class="btn btn-primary" id="submitSuratJalan">Cetak PDF</button>
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
    <script src="<?= base_url('sb2/vendor/datatables/dataTables.bootstrap4.min.js') ?>"></script>

    <!-- Page level custom scripts -->
    <script src="<?= base_url('sb2/js/demo/datatables-demo.js') ?>"></script>

    <script>
        // Tampilkan filter tanggal hanya untuk tabel barang-keluar
        $('#table').change(function() {
            var table = $('#table').val();
            if (table === 'barang-keluar') {
                $('#dateFilter').show(); // Tampilkan filter tanggal
            } else {
                $('#dateFilter').hide(); // Sembunyikan filter tanggal
            }
        });

        // Mengirim data melalui AJAX
        $('#loadData').click(function() {
            var table = $('#table').val();
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            var data = {
                table: table
            };

            if (table === 'barang-keluar') {
                data.startDate = startDate;
                data.endDate = endDate;
            }

            $.ajax({
                url: '<?= base_url('dashboard/laporancontroller/getData/') ?>' + table,
                method: 'GET',
                data: data,
                success: function(response) {
                    console.log('Response dari server:', response); // Debug response dari server

                    // Cek apakah response berisi data
                    if (response.length > 0) {
                        // Bersihkan tabel sebelum diisi ulang
                        $('#laporanTable thead').empty();
                        $('#laporanTable tbody').empty();

                        // Buat header tabel dinamis dari kunci data
                        var headerHtml = '<tr>';
                        for (var key in response[0]) {
                            headerHtml += '<th>' + key.replace(/_/g, ' ').toUpperCase() + '</th>';
                        }
                        headerHtml += '</tr>';
                        $('#laporanTable thead').html(headerHtml);

                        // Buat baris data
                        var rowsHtml = '';
                        response.forEach(function(row) {
                            rowsHtml += '<tr>';
                            for (var key in row) {
                                rowsHtml += '<td>' + row[key] + '</td>';
                            }
                            rowsHtml += '</tr>';
                        });
                        $('#laporanTable tbody').html(rowsHtml);
                    } else {
                        $('#laporanTable tbody').html('<tr><td colspan="5">Tidak ada data ditemukan.</td></tr>');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching data:', textStatus, errorThrown);
                }
            });
        });

        // Tampilkan modal form surat jalan sebelum cetak PDF untuk tabel barang-keluar
        $('#exportPDF').click(function() {
            var table = $('#table').val();
            if (table === 'barang-keluar') {
                // Tampilkan modal surat jalan
                $('#suratJalanModal').modal('show');
            } else {
                cetakPDF(table);
            }
        });

        $('#submitSuratJalan').click(function() {
            var alamatTujuan = $('#alamatTujuan').val();
            var penerima = $('#penanggungJawab').val();

            console.log('Alamat Tujuan:', alamatTujuan); // Debug untuk cek nilai alamat tujuan
            console.log('Penerima:', penerima); // Debug untuk cek nilai penerima

            if (alamatTujuan && penerima) {
                // Kirim ke server untuk mencetak surat jalan
                cetakPDF('barang-keluar', alamatTujuan, penerima);
                $('#suratJalanModal').modal('hide');
            } else {
                alert('Harap isi semua field!');
            }
        });

        function cetakPDF(table, alamatTujuan = '', penerima = '') {
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();
        
            console.log('URL yang dibentuk:', '<?= base_url('dashboard/laporancontroller/export/') ?>' + table + '/pdf?startDate=' + startDate + '&endDate=' + endDate + '&alamatTujuan=' + alamatTujuan + '&penerima=' + penerima); // Debug URL

            var url = '<?= base_url('dashboard/laporancontroller/export/') ?>' + table + '/pdf?startDate=' + startDate + '&endDate=' + endDate + '&alamatTujuan=' + alamatTujuan + '&penerima=' + penerima;
            window.location.href = url;
        }

        $('#exportExcel').click(function() {
            var table = $('#table').val();
            var startDate = $('#startDate').val();
            var endDate = $('#endDate').val();

            // Sertakan filter tanggal jika tabel adalah barang-keluar
            if (table === 'barang-keluar') {
                window.location.href = '<?= base_url('dashboard/laporancontroller/export/') ?>' + table + '/excel?startDate=' + startDate + '&endDate=' + endDate;
            } else {
                window.location.href = '<?= base_url('dashboard/laporancontroller/export/') ?>' + table + '/excel';
            }
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