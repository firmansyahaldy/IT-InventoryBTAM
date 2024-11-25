<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>BTAM Inventory App</title>

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
	<style>
		#kategoriTable_filter {
			float: left;
			/* Mengapungkan elemen ke kiri */
			margin-right: 20px;
			/* Jarak antara elemen pencarian dan elemen lain (jika ada) */
		}
	</style>
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
						<h1 class="h3 mb-0 text-gray-800">Data Master</h1>
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
					</div>

					<!-- data master -->
					<div class="container mt-5">
						<div class="row">

							<!-- Tabel Role -->
							<div class="col-md-6">
								<div class="card shadow mb-4">
									<div class="card-header py-3 d-flex justify-content-between align-items-center">
										<h6 class="m-0 font-weight-bold text-primary">Data Role</h6>
										<?php if ($userRole === 'Super Admin'): ?>
											<!-- Button trigger modal -->
											<button type="button" class="btn btn-primary addBtn" data-toggle="modal" data-target="#addRoleModal" data-table="role">
												<i class="fas fa-plus fa-sm text-white-50"></i> Tambah Role
											</button>
										<?php endif; ?>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered" id="roleTable" cellspacing="0">
												<thead>
													<tr>
														<th>ID</th>
														<th>User Role</th>
														<?php if ($userRole === 'Super Admin'): ?>
															<th>Aksi</th>
														<?php endif; ?>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($roles as $role): ?>
														<tr>
															<td><?= esc($role['id_role']) ?></td>
															<td><?= esc($role['user_role']) ?></td>
															<?php if ($userRole === 'Super Admin'): ?>
																<td>
																	<button type="button" class="btn btn-warning btn-sm editBtn" data-id="<?= $role['id_role'] ?>" data-toggle="modal" data-target="#editRoleModal">Edit</button>
																	<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="<?= $role['id_role'] ?>" data-toggle="modal" data-target="#deleteRoleModal">Hapus</button>
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

							<!-- Tabel Kategori -->
							<div class="col-md-6">
								<div class="card shadow mb-4">
									<div class="card-header py-3 d-flex justify-content-between align-items-center">
										<h6 class="m-0 font-weight-bold text-primary">Data Kategori</h6>
										<?php if ($userRole === 'Super Admin'): ?>
											<!-- Button trigger modal -->
											<button type="button" class="btn btn-primary addBtn" data-toggle="modal" data-target="#addKategoriModal" data-table="kategori">
												<i class="fas fa-plus fa-sm text-white-50"></i> Tambah Kategori
											</button>
										<?php endif; ?>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered" id="kategoriTable">
												<thead>
													<tr>
														<th>ID</th>
														<th>Nama Kategori</th>
														<?php if ($userRole === 'Super Admin'): ?>
															<th>Aksi</th>
														<?php endif; ?>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($kategoris as $kategori): ?>
														<tr>
															<td><?= esc($kategori['id_kategori']) ?></td>
															<td><?= esc($kategori['kategori_item']) ?></td>
															<?php if ($userRole === 'Super Admin'): ?>
																<td>
																	<button type="button" class="btn btn-warning btn-sm editBtn" data-id="<?= $kategori['id_kategori'] ?>" data-toggle="modal" data-target="#editKategoriModal">Edit</button>
																	<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="<?= $kategori['id_kategori'] ?>" data-toggle="modal" data-target="#deleteKategoriModal">Hapus</button>
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

							<!-- Tabel Kondisi -->
							<div class="col-md-6">
								<div class="card shadow mb-4">
									<div class="card-header py-3 d-flex justify-content-between align-items-center">
										<h6 class="m-0 font-weight-bold text-primary">Data Kondisi</h6>
										<?php if ($userRole === 'Super Admin'): ?>
											<!-- Button trigger modal -->
											<button type="button" class="btn btn-primary addBtn" data-toggle="modal" data-target="#addKondisiModal" data-table="kondisi">
												<i class="fas fa-plus fa-sm text-white-50"></i> Tambah Kondisi
											</button>
										<?php endif; ?>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered" id="kondisiTable">
												<thead>
													<tr>
														<th>ID</th>
														<th>Kondisi Item</th>
														<?php if ($userRole === 'Super Admin'): ?>
															<th>Aksi</th>
														<?php endif; ?>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($kondisis as $kondisi): ?>
														<tr>
															<td><?= esc($kondisi['id_kondisi']) ?></td>
															<td><?= esc($kondisi['kondisi_item']) ?></td>
															<?php if ($userRole === 'Super Admin'): ?>
																<td>
																	<button type="button" class="btn btn-warning btn-sm editBtn" data-id="<?= $kondisi['id_kondisi'] ?>" data-toggle="modal" data-target="#editKondisiModal">Edit</button>
																	<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="<?= $kondisi['id_kondisi'] ?>" data-toggle="modal" data-target="#deleteKondisiModal">Hapus</button>
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

							<!-- Tabel Lokasi -->
							<div class="col-md-6">
								<div class="card shadow mb-4">
									<div class="card-header py-3 d-flex justify-content-between align-items-center">
										<h6 class="m-0 font-weight-bold text-primary">Data Lokasi Item</h6>
										<?php if ($userRole === 'Super Admin'): ?>
											<!-- Button trigger modal -->
											<button type="button" class="btn btn-primary addBtn" data-toggle="modal" data-target="#addLokasiModal" data-table="lokasi">
												<i class="fas fa-plus fa-sm text-white-50"></i> Tambah Lokasi
											</button>
										<?php endif; ?>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered" id="LokasiTable">
												<thead>
													<tr>
														<th>ID</th>
														<th>Lokasi Barang</th>
														<?php if ($userRole === 'Super Admin'): ?>
															<th>Aksi</th>
														<?php endif; ?>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($lokasis as $lokasi): ?>
														<tr>
															<td><?= esc($lokasi['id_lokasi_barang']) ?></td>
															<td><?= esc($lokasi['lokasi_barang']) ?></td>
															<?php if ($userRole === 'Super Admin'): ?>
																<td>
																	<button type="button" class="btn btn-warning btn-sm editBtn" data-id="<?= $lokasi['id_lokasi_barang'] ?>" data-toggle="modal" data-target="#editLokasiModal">Edit</button>
																	<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="<?= $lokasi['id_lokasi_barang'] ?>" data-toggle="modal" data-target="#deleteLokasiModal">Hapus</button>
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

							<!-- Tabel Status Maintenance -->
							<div class="col-md-6">
								<div class="card shadow mb-4">
									<div class="card-header py-3 d-flex justify-content-between align-items-center">
										<h6 class="m-0 font-weight-bold text-primary">Data Status Maintenance</h6>
										<?php if ($userRole === 'Super Admin'): ?>
											<!-- Button trigger modal -->
											<button type="button" class="btn btn-primary addBtn" data-toggle="modal" data-target="#addStatusMaintenanceModal" data-table="statusMaintenance">
												<i class="fas fa-plus fa-sm text-white-50"></i> Tambah Status Maintenance
											</button>
										<?php endif; ?>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered" id="statusMaintenanceTable">
												<thead>
													<tr>
														<th>ID</th>
														<th>Status Maintenance</th>
														<?php if ($userRole === 'Super Admin'): ?>
															<th>Aksi</th>
														<?php endif; ?>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($statusmaintenances as $statusmaintenance): ?>
														<tr>
															<td><?= esc($statusmaintenance['id_status_maintenance']) ?></td>
															<td><?= esc($statusmaintenance['status_maintenance']) ?></td>
															<?php if ($userRole === 'Super Admin'): ?>
																<td>
																	<button type="button" class="btn btn-warning btn-sm editBtn" data-id="<?= $statusmaintenance['id_status_maintenance'] ?>" data-toggle="modal" data-target="#editStatusMaintenanceModal">Edit</button>
																	<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="<?= $statusmaintenance['id_status_maintenance'] ?>" data-toggle="modal" data-target="#deleteStatusMaintenanceModal">Hapus</button>
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

							<!-- Tabel Status Barang -->
							<div class="col-md-6">
								<div class="card shadow mb-4">
									<div class="card-header py-3 d-flex justify-content-between align-items-center">
										<h6 class="m-0 font-weight-bold text-primary">Data Status Barang</h6>
										<?php if ($userRole === 'Super Admin'): ?>
											<!-- Button trigger modal -->
											<button type="button" class="btn btn-primary addBtn" data-toggle="modal" data-target="#addStatusBarangModal" data-table="statusBarang">
												<i class="fas fa-plus fa-sm text-white-50"></i> Tambah Status Barang
											</button>
										<?php endif; ?>
									</div>
									<div class="card-body">
										<div class="table-responsive">
											<table class="table table-bordered" id="statusBarangTable">
												<thead>
													<tr>
														<th>ID</th>
														<th>Status Barang</th>
														<?php if ($userRole === 'Super Admin'): ?>
															<th>Aksi</th>
														<?php endif; ?>
													</tr>
												</thead>
												<tbody>
													<?php foreach ($statusbarangs as $statusbarang): ?>
														<tr>
															<td><?= esc($statusbarang['id_status_barang']) ?></td>
															<td><?= esc($statusbarang['status_barang']) ?></td>
															<?php if ($userRole === 'Super Admin'): ?>
																<td>
																	<button type="button" class="btn btn-warning btn-sm editBtn" data-id="<?= $statusbarang['id_status_barang'] ?>" data-toggle="modal" data-target="#editStatusBarangModal">Edit</button>
																	<button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="<?= $statusbarang['id_status_barang'] ?>" data-toggle="modal" data-target="#deleteStatusBarangModal">Hapus</button>
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

	<!-- Add Role Modal -->
	<div class="modal fade" id="addRoleModal" tabindex="-1" role="dialog" aria-labelledby="addRoleLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addRoleLabel">Tambah Role</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="addRoleForm" method="POST" action="<?= base_url('dashboard/data_master/role/create') ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<div class="form-group">
							<label for="roleName">Nama Role</label>
							<input type="text" class="form-control" id="user_role" name="user_role" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit Role Modal -->
	<div class="modal fade" id="editRoleModal" tabindex="-1" role="dialog" aria-labelledby="editRoleLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editRoleLabel">Edit Role</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="editRoleForm" method="POST" action="<?= base_url('dashboard/data_master/role/update/' . $role['id_role']) ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<input type="hidden" id="editRoleId" name="roleId">
						<div class="form-group">
							<label for="editRoleName">Nama Role</label>
							<input type="text" class="form-control" id="editRoleName" name="user_role" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Delete Role Modal -->
	<div class="modal fade" id="deleteRoleModal" tabindex="-1" role="dialog" aria-labelledby="deleteRoleLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteRoleLabel">Hapus Role</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="deleteRoleForm" method="POST" action="<?= base_url('dashboard/data_master/role/delete/' . $role['id_role']) ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<input type="hidden" id="deleteRoleId" name="roleId">
						<p>Apakah kamu yakin ingin menghapus role ini?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-danger">Hapus</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Add Kategori Modal -->
	<div class="modal fade" id="addKategoriModal" tabindex="-1" role="dialog" aria-labelledby="addKategoriLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addKategoriLabel">Tambah Kategori</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="addKategoriForm" method="POST" action="<?= base_url('dashboard/data_master/kategori/create') ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<div class="form-group">
							<label for="KategoriName">Nama Kategori</label>
							<input type="text" class="form-control" id="KategoriName" name="kategori_item" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit Kategori Modal -->
	<div class="modal fade" id="editKategoriModal" tabindex="-1" role="dialog" aria-labelledby="editKategoriLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editKategoriLabel">Edit Kategori</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="editKategoriForm" method="POST" action="<?= base_url('dashboard/data_master/kategori/update/' . $kategori['id_kategori']) ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<input type="hidden" id="editKategoriId" name="KategoriId">
						<div class="form-group">
							<label for="editKategoriName">Nama Kategori</label>
							<input type="text" class="form-control" id="editKategoriName" name="kategori_item" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Delete Kategori Modal -->
	<div class="modal fade" id="deleteKategoriModal" tabindex="-1" role="dialog" aria-labelledby="deleteKategoriLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteKategoriLabel">Hapus Kategori</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="deleteKategoriForm" method="POST" action="<?= base_url('dashboard/data_master/kategori/delete/' . $kategori['id_kategori']) ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<input type="hidden" id="deleteKategoriId" name="KategoriId">
						<p>Apakah kamu yakin ingin menghapus Kategori ini?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-danger">Hapus</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Add Kondisi Modal -->
	<div class="modal fade" id="addKondisiModal" tabindex="-1" role="dialog" aria-labelledby="addKondisiLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addKondisiLabel">Tambah Kondisi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="addKondisiForm" method="POST" action="<?= base_url('dashboard/data_master/kondisi/create') ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<div class="form-group">
							<label for="KondisiName">Nama Kondisi</label>
							<input type="text" class="form-control" id="KondisiName" name="kondisi_item" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit Kondisi Modal -->
	<div class="modal fade" id="editKondisiModal" tabindex="-1" role="dialog" aria-labelledby="editKondisiLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editKondisiLabel">Edit Kondisi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="editKondisiForm" method="POST" action="<?= base_url('dashboard/data_master/kondisi/update/' . $kondisi['id_kondisi']) ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<input type="hidden" id="editKondisiId" name="KondisiId">
						<div class="form-group">
							<label for="editKondisiName">Nama Kondisi</label>
							<input type="text" class="form-control" id="editKondisiName" name="kondisi_item" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Delete Kondisi Modal -->
	<div class="modal fade" id="deleteKondisiModal" tabindex="-1" role="dialog" aria-labelledby="deleteKondisiLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteKondisiLabel">Hapus Kondisi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="deleteKondisiForm" method="POST" action="<?= base_url('dashboard/data_master/kondisi/delete/' . $kondisi['id_kondisi']) ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<input type="hidden" id="deleteKondisiId" name="KondisiId">
						<p>Apakah kamu yakin ingin menghapus Kondisi ini?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-danger">Hapus</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Add Lokasi Modal -->
	<div class="modal fade" id="addLokasiModal" tabindex="-1" role="dialog" aria-labelledby="addLokasiLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addLokasiLabel">Tambah Lokasi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="addLokasiForm" method="POST" action="<?= base_url('dashboard/data_master/lokasi/create') ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<div class="form-group">
							<label for="LokasiName">Nama Lokasi</label>
							<input type="text" class="form-control" id="LokasiName" name="lokasi_barang" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit Lokasi Modal -->
	<div class="modal fade" id="editLokasiModal" tabindex="-1" role="dialog" aria-labelledby="editLokasiLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editLokasiLabel">Edit Lokasi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="editLokasiForm" method="POST" action="<?= base_url('dashboard/data_master/lokasi/update/' . $lokasi['id_lokasi_barang']) ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<input type="hidden" id="editLokasiId" name="LokasiId">
						<div class="form-group">
							<label for="editLokasiName">Nama Lokasi</label>
							<input type="text" class="form-control" id="editLokasiName" name="lokasi_barang" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Delete Lokasi Modal -->
	<div class="modal fade" id="deleteLokasiModal" tabindex="-1" role="dialog" aria-labelledby="deleteLokasiLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteLokasiLabel">Hapus Lokasi</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="deleteLokasiForm" method="POST" action="<?= base_url('dashboard/data_master/lokasi/delete/' . $lokasi['id_lokasi_barang']) ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<input type="hidden" id="deleteLokasiId" name="LokasiId">
						<p>Apakah kamu yakin ingin menghapus Lokasi ini?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-danger">Hapus</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Add StatusMaintenance Modal -->
	<div class="modal fade" id="addStatusMaintenanceModal" tabindex="-1" role="dialog" aria-labelledby="addStatusMaintenanceLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addStatusMaintenanceLabel">Tambah Status Maintenance</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="addStatusMaintenanceForm" method="POST" action="<?= base_url('dashboard/data_master/statusMaintenance/create') ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<div class="form-group">
							<label for="StatusMaintenanceName">Nama Status Maintenance</label>
							<input type="text" class="form-control" id="StatusMaintenanceName" name="status_maintenance" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit StatusMaintenance Modal -->
	<div class="modal fade" id="editStatusMaintenanceModal" tabindex="-1" role="dialog" aria-labelledby="editStatusMaintenanceLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editStatusMaintenanceLabel">Edit Status Maintenance</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="editStatusMaintenanceForm" method="POST" action="<?= base_url('dashboard/data_master/statusMaintenance/update/' . $statusmaintenance['id_status_maintenance']) ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<input type="hidden" id="editStatusMaintenanceId" name="StatusMaintenanceId">
						<div class="form-group">
							<label for="editStatusMaintenanceName">Nama Status Maintenance</label>
							<input type="text" class="form-control" id="editStatusMaintenanceName" name="status_maintenance" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Delete StatusMaintenance Modal -->
	<div class="modal fade" id="deleteStatusMaintenanceModal" tabindex="-1" role="dialog" aria-labelledby="deleteStatusMaintenanceLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteStatusMaintenanceLabel">Hapus Status Maintenance</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="deleteStatusMaintenanceForm" method="POST" action="<?= base_url('dashboard/data_master/statusMaintenance/delete/' . $statusmaintenance['id_status_maintenance']) ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<input type="hidden" id="deleteStatusMaintenanceId" name="StatusMaintenanceId">
						<p>Apakah kamu yakin ingin menghapus Status Maintenance ini?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-danger">Hapus</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Add StatusBarang Modal -->
	<div class="modal fade" id="addStatusBarangModal" tabindex="-1" role="dialog" aria-labelledby="addStatusBarangLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="addStatusBarangLabel">Tambah Status Barang</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="addStatusBarangForm" method="POST" action="<?= base_url('dashboard/data_master/statusBarang/create') ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<div class="form-group">
							<label for="StatusBarangName">Nama Status Barang</label>
							<input type="text" class="form-control" id="StatusBarangName" name="status_barang" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit StatusBarang Modal -->
	<div class="modal fade" id="editStatusBarangModal" tabindex="-1" role="dialog" aria-labelledby="editStatusBarangLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="editStatusBarangLabel">Edit Status Barang</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="editStatusBarangForm" method="POST" action="<?= base_url('dashboard/data_master/statusBarang/update/' . $statusbarang['id_status_barang']) ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<input type="hidden" id="editStatusBarangId" name="StatusBarangId">
						<div class="form-group">
							<label for="editStatusBarangName">Nama Status Barang</label>
							<input type="text" class="form-control" id="editStatusBarangName" name="status_barang" required>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Delete StatusBarang Modal -->
	<div class="modal fade" id="deleteStatusBarangModal" tabindex="-1" role="dialog" aria-labelledby="deleteStatusBarangLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="deleteStatusBarangLabel">Hapus Status Barang</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form id="deleteStatusBarangForm" method="POST" action="<?= base_url('dashboard/data_master/statusBarang/delete/' . $statusbarang['id_status_barang']) ?>">
					<?= csrf_field() ?>
					<div class="modal-body">
						<input type="hidden" id="deleteStatusBarangId" name="StatusBarangId">
						<p>Apakah kamu yakin ingin menghapus Status Barang ini?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-danger">Hapus</button>
					</div>
				</form>
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
			$('#kategoriTable').DataTable({
				pageLength: 10, // Menampilkan 10 data per halaman
				lengthChange: true // Menonaktifkan opsi untuk mengubah jumlah data yang ditampilkan
			});
		});

		// Auto-close alert after 3 seconds
		window.setTimeout(function() {
			$(".alert").fadeTo(500, 0).slideUp(500, function() {
				$(this).remove();
			});
		}, 3000);

		$(document).redy(function() {
			// Add
			$('addBtn').on('click', function() {
				let table = $(this).data('table');
				$('#add' + capitalizeFirstLetter(table) + 'Form').trigger('reset');
			});

			// EDIT
			$('.editBtn').on('click', function() {
				let id = $(this).data('id');
				let table = $(this).closest('table').attr('id').replace('Table', '');
				let url = `/dashboard/data_master/${table}/get/${id}`;

				$.get(url, function(data) {
					let form = $('#edit' + capitalizeFirstLetter(table) + 'Form');
					form.find('input[name="' + capitalizeFirstLetter(table) + 'Id"]').val(data.id);
					form.find('input[name="' + capitalizeFirstLetter(table) + 'Name"]').val(data.name);
				});
			});

			// DELETE
			$('.deleteBtn').on('click', function() {
				let id = $(this).data('id');
				let table = $(this).closest('table').attr('id').replace('Table', '');
				$('#delete' + capitalizeFirstLetter(table) + 'Form').find('input[name="' + capitalizeFirstLetter(table) + 'Id"]').val(id);
			});
		});

		function capitalizeFirstLetter(string) {
			return string.charAt(0).toUpperCase() + string.slice(1);
		}
	</script>
</body>

</html>