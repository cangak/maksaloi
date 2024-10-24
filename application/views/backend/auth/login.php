<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?= $title ?> | <?= $company['company_name'] ?></title>

    <!-- Custom fonts for this template-->
    <link href="<?= base_url('assets/backend/') ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?= base_url('assets/backend/') ?>css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body class="bg-gradient-primary">
<div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-lg-5">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                          
                            <div class="col-lg">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img class="mb-3" style=" display: block;margin-left: auto;margin-right: auto;width: 100%;" src="<?= base_url('assets/images/') ?><?= $company['logo'] ?>" alt="">
                                        <?php $this->view('messages') ?>
                                    </div>
                                    <form action="" method="post" class="user">
                                        <div class="form-group">
                                            <input type="text" name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="ID Pelanggan">
                                            <?= form_error('email', '<small class="text-danger pl-3 ">', '</small>') ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Sandi">
                                            <?= form_error('password', '<small class="text-danger pl-3 ">', '</small>') ?>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Masuk
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <!-- <a class="small" href="<?= site_url('auth/forgotpassword') ?>" style="text-decoration: none">Lupa Password ?</a> -->
                                    </div>

                                    <!-- <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4 mt-2" style="font-weight:bold">Powered By</h1>
                                        <div class="logo-pertamina">
                                            <img style="width: 200px" src="<?= base_url('assets/images/1112-project.jpg') ?>" alt="">
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url('assets/backend/') ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url('assets/backend/') ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url('assets/backend/') ?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url('assets/backend/') ?>js/sb-admin-2.min.js"></script>

</body>

</html>