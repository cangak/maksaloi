<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>BUMDESnet</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <a href="#" class="logo d-flex align-items-center">
        <h1 class="sitename">BUMDESnet</h1>
      </a>
      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="#tagihan" class="active">Bayar Tagihan</a></li>
          <li><a href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Registrasi Pelanggan</a></li>
          <li><a href="auth" class="active">Masuk Akun</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <main class="main">
    <!-- Modal Registrasi -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="registerModalLabel">Registrasi Pelanggan Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="registrationForm">
              <div class="mb-3">
              <label for="name" class="required">Nama Pelanggan</label>
                    <input type="hidden" name="no_services" value="<?= Date('ymdHis') ?>">
                    <input type="text" id="name" name="name" class="form-control" value="<?= set_value('name') ?>" required>
                    <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
              </div>
              <div class="mb-3">
              <label for="no_ktp" class="required">NIK Kartu Tanda Penduduk</label>
                    <input type="text" id="no_ktp" name="no_ktp" class="form-control" pattern="\d{16}" maxlength="16" minlength="16" value="<?= set_value('no_ktp') ?>" required>
                    <?= form_error('no_ktp', '<small class="text-danger pl-3 ">', '</small>') ?>
              </div>
              <div class="mb-3">
                <label for="no_wa" class="required">No WhatsApp</label>
                    <input type="text" id="no_wa" name="no_wa" class="form-control" pattern="08\d{11}" maxlength="13" minlength="13" required>
                    <small id="no_wa_error" class="text-danger pl-3"></small>
                    <?= form_error('no_wa', '<small class="text-danger pl-3 ">', '</small>') ?>
              </div>
              <div class="mb-3">
              <label for="address" class="required">Alamat</label>
              <textarea id="address" name="address" class="form-control" required></textarea>
                </div>
              <button type="submit" class="btn btn-primary">Daftar</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">
      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-3 order-lg-last hero-img" data-aos="zoom-out">
            <img src="assets/img/phone_1.png" alt="Phone 1" class="phone-1">
            <img src="assets/img/phone_2.png" alt="Phone 2" class="phone-2">
          </div>
          <div class="col-lg-8 d-flex flex-column justify-content-center align-items text-center text-md-start" data-aos="fade-up">
            <!-- <h2>Kini Telah Hadir</h2>
            <p>Untuk Area Desa Sungai Raya Dalam Internet Murah dan Ekonomis</p>
            <div class="d-flex mt-4 justify-content-center justify-content-md-start">
              <a href="#" data-bs-toggle="modal" class="download-btn" data-bs-target="#registerModal"><span>Berlanggan Sekarang</span></a>
            </div> -->
         <!-- Billing Section -->
    

           <h4 class="card-title">Informasi Tagihan</h>
          <br> <?= $company['company_name'] ?>
           <div class="row align-items-center mt-3">
             <div class="col-md-5 mt-2">
               <input class="form-control" id="no_services" name="no_services" type="text" placeholder="Masukkan ID Pelanggan" required>
             </div>
             <div class="col-md-3 mt-2">
               <button class="btn btn-warning" type="button" onclick="cek_bill()">Proses</button>
             </div>
  
         
              <div class="loading mt-3"></div>
              <div class="view_data mt-3"></div>
            </div>
          </div>
        </div>
      </div>
    </section><!-- /Billing Section -->
     
     
          </div>
        </div>
      </div>
    </section><!-- /Hero Section -->

    

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
      <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

    <script>
      function cek_bill() {
        var no = $('#no_services').val();
        if (no === '') {
          $('#no_services').focus();
        } else {
          $.ajax({
            type: 'POST',
            data: { cek_bill: 1, no_services: no },
            url: '<?= site_url('front/view_bill') ?>',
            cache: false,
            beforeSend: function() {
              $('#no_services').attr('disabled', true);
              $('.loading').html(`<div class="text-center">
                  <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                      <span class="sr-only">Loading...</span>
                  </div>
              </div>`);
            },
            success: function(data) {
              $('#no_services').attr('disabled', false);
              $('.loading').html('');
              $('.view_data').html(data);
            },
            error: function(jqXHR, textStatus, errorThrown) {
              $('#no_services').attr('disabled', false);
              $('.loading').html('Error retrieving data. Please try again.');
            }
          });
        }
        return false;
      }

      $(document).ready(function() {
        $('#registrationForm').on('submit', function(event) {
          event.preventDefault(); // Mencegah pengiriman form secara default
          const formData = $(this).serialize(); // Mengambil data dari form

          $.ajax({
            type: 'POST',
            url: '<?= site_url('customer/add') ?>', // Ganti dengan URL yang sesuai
            data: formData,
            success: function(response) {
              alert('Registrasi berhasil!');
              $('#registerModal').modal('hide'); // Tutup modal setelah sukses
              $('#registrationForm')[0].reset(); // Reset form
            },
            error: function(jqXHR, textStatus, errorThrown) {
              alert('Terjadi kesalahan. Silakan coba lagi.');
            }
          });
        });
      });
    </script>

</body>

</html>
