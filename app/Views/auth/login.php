<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Inventory BTAM - Login</title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('sb2/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('sb2/css/sb-admin-2.min.css') ?>" rel="stylesheet">

    <style>
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50vh;
            /* Mengatur minimum tinggi container */
        }

        .bg-login-image {
            display: flex;
            justify-content: center;
            align-items: center;
            flex: 7;
            /* Gambar tetap mengambil proporsi 7 dari total */
            height: 100%;
            /* Pastikan elemen ini memiliki tinggi penuh dari container */
        }

        .col-lg-6 img {
            width: 100%;
            /* Gambar mengisi lebar container */
            height: 100%;
            /* Gambar mengisi tinggi container */
            object-fit: cover;
            /* Memastikan gambar tidak terdistorsi dan memenuhi area */
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                padding: 20px;
                min-height: auto;
                /* Tinggi disesuaikan untuk layar kecil */
            }

            .col-lg-6,
            .col-lg-6 {
                flex: none;
                width: 100%;
                height: auto;
                /* Pada layar kecil, tinggi otomatis */
            }

            .bg-login-image {
                height: auto;
            }
        }
    </style>

</head>

<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="container h-100">
                            <div class="row justify-content-center align-items-center h-100">
                                <div class="col-lg-6 d-flex justify-content-center align-items-center bg-login-image p-0">
                                    <img src="<?= base_url('assets/img/btam.jpg') ?>" alt="BTAM Image" class="img-fluid">
                                </div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        </div>
                                        <!-- Menampilkan pesan error -->
                                        <?php if (session()->getFlashdata('error')): ?>
                                            <div class="alert alert-danger">
                                                <?= session()->getFlashdata('error') ?>
                                            </div>
                                            <script>
                                                console.error("<?= session()->getFlashdata('error') ?>");
                                            </script>
                                        <?php endif; ?>
                                        <form class="user" method="POST" action="<?= base_url('auth/login') ?>">
                                            <?= csrf_field() ?>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="exampleInputUsername" name="username" placeholder="Enter Username..." required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" id="exampleInputPassword" name="password" placeholder="Password" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
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

</body>

</html>