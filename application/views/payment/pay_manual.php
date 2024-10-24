<div class="row mt-4">
  <div class="col-lg-12 mb-2">
    <h4 class="card-title">Pembayaran Tagihan</h4>
    <div class="row mt-4 align-items-center">
      <div class="col-md-4">
        <!-- Input dengan event listener untuk Enter -->
        <input class="form-control mb-2" id="no_services" name="no_services" type="text" placeholder="Masukkan ID Pelanggan" required autofocus>
      </div>
      <div class="col-md-6 text-md-left">
        <!-- Tombol Proses untuk klik manual -->
      </div>
    </div>
    <div class="loading mt-3"></div>
    <div class="view_data mt-3"></div>
  </div>
</div>

<script>
  // Event listener untuk mendeteksi Enter pada input no_services
  document.getElementById('no_services').addEventListener('keydown', function(event) {
    // Cek apakah tombol yang ditekan adalah Enter
    if (event.key === "Enter") {
      event.preventDefault(); // Mencegah aksi default dari tombol Enter
      cek2(); // Panggil fungsi cek2
    }
  });

  // Fungsi cek2
  function cek2() {
    var no = $('#no_services').val(); // Ambil nilai input
    if (no === '') {
      $('#no_services').focus(); // Fokus kembali ke input jika kosong
    } else {
      // AJAX untuk memproses ID Pelanggan
      $.ajax({
        type: 'POST',
        data: { cek2: 1, no_services: no }, // Kirim data ke server
        url: '<?= site_url('kasir/view_bill') ?>',
        cache: false,
        beforeSend: function() {
          $('#no_services').attr('disabled', true); // Nonaktifkan input
          $('.loading').html(`<div class="text-center">
              <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                  <span class="sr-only">Loading...</span>
              </div>
          </div>`); // Tampilkan loading spinner
        },
        success: function(data) {
          $('#no_services').attr('disabled', false); // Aktifkan kembali input
          $('.loading').html(''); // Hilangkan loading spinner
          $('.view_data').html(data); // Tampilkan data yang diterima
        },
        error: function(jqXHR, textStatus, errorThrown) {
          $('#no_services').attr('disabled', false); // Aktifkan kembali input
          $('.loading').html('Error retrieving data. Please try again.'); // Tampilkan pesan error
        }
      });
    }
    return false; // Mencegah form submit jika ada
  }
</script>
