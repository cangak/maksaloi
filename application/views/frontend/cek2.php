<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            margin-bottom: 20px;
        }
        .form-control-lg {
            font-size: 14px;
        }
        .badge {
            font-size: 14px;
        }
        .input-group-text {
            background-color: #e9ecef;
            border: none;
        }
        .input-group input {
            border: none;
            outline: none;
            background-color: #e9ecef;
        }
        .input-group input:readonly {
            background-color: #e9ecef;
        }
        .total {
            font-size: 35pt;
            color: #007bff; /* Warna untuk total pembayaran */
        }
    </style>
</head>
<body>
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <?php if ($customer->num_rows() == 0) { ?>
                    <div class="alert alert-warning" role="alert">
                        ID Pelanggan Tidak Ditemukan. Silahkan Cek dan Masukan Kembali Dengan Benar!
                    </div>
                <?php } else { ?>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body" style="<?= $bill->num_rows() > 4 ? 'max-height: 300px; overflow-y: auto;' : ''; ?>">
                                    <?php if ($bill->num_rows() > 0) { 
                                        $total = 0; // Initialize total
                                    ?>
                                        <table class="table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th><input type="checkbox" id="select-all"> </th>
                                                    <th>Bulan</th>
                                                    <th>Jumlah Tagihan</th>
                                                    <th>Status</th>
                                                    <th>Detail</th>
                                                </tr>
                                            </thead>
                                            <tbody>
    <?php foreach ($bill->result() as $data) {
        $subtotal = (int) $data->total;
        $total += $subtotal; // Sum up total
        $isPaid = ($data->status == 'SUDAH BAYAR'); // Cek apakah status sudah dibayar
    ?>
    <tr>
        <td>
            <input type="checkbox" class="bill-checkbox" 
                   data-amount="<?= $subtotal ?>" 
                   <?= $isPaid ? 'disabled' : 'checked' ?> 
                   <?= $isPaid ? 'readonly' : '' ?> />
        </td>
        <td><?= indo_month($data->month) ?> <?= date('Y') ?></td>
        <td><?= indo_currency($subtotal) ?></td>
        <td>
            <?php if ($data->status == 'BELUM BAYAR') { ?>
                <span class="badge badge-danger">Belum Bayar</span>
            <?php } else { ?>
                <span class="badge badge-success">Sudah Bayar</span>
            <?php } ?>
        </td>
        <td class="text-center">
            <a href="#" data-toggle="modal" data-target="#detailModal" title="Lihat Detail">
                <i class="fa fa-eye" style="font-size:20px; color:brown"></i>
            </a>
        </td>
    </tr>
    <?php } ?>
</tbody>

                                        </table>
                                        <input type="hidden" id="totaldisplay" value="<?= $total ?>">
                                    <?php } else { ?>
                                        <div class="alert alert-danger text-center" role="alert">
                                            Data Tagihan belum tersedia
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="name">Nama Pelanggan</label>
                                                <input type="text" class="form-control" name="name" id="name"
                                                       value="<?= $customer->row()->name ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="address">Alamat Pelanggan</label>
                                                <input type="text" class="form-control" name="address" id="address"
                                                       value="<?= $customer->row()->address ?>" readonly>
                                            </div>
                                        </div>
                                     
                                        <div class="col-md-6">
    <div class="form-group">
        <label for="invoice">No. Transaksi</label>
        <?php $invoice = $this->input->post('invoice'); // Mengambil nomor invoice dari input POST ?>
        <input type="text" class="form-control" name="invoice" id="invoice" value="<?= htmlspecialchars($invoice, ENT_QUOTES, 'UTF-8'); ?>" readonly>
    </div>
</div>                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="tanggal">Tanggal Transaksi</label>
                                                <input type="date" class="form-control" name="tanggal" id="tanggal" readonly
                                                       value="<?= date('Y-m-d'); ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="cashier">Kasir</label>
                                                <input type="text" class="form-control" name="cashier" id="cashier" 
                                                       value="<?= isset($user['name']) ? htmlspecialchars($user['name']) : 'Kasir Tidak Ditemukan'; ?>" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jumlah_item" style="color: green; font-weight: bold;">Tagihan yang dipilih:</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1" style="border: none; background: none;">
                                            <i class="fas fa-info-circle" style="color: green;"></i> <!-- Ikon hijau -->
                                        </span>
                                    </div>

                                    <input type="text" name="jumlah_item" id="jumlah_item"
                                           style="text-align: left; color: green; font-weight: bold; font-size: 14pt; background: none; border: none;" 
                                           value="0" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 text-right">
                            <label style="color: green; font-weight: bold;">Total Tagihan:</label>
                            <div class="total" id="totalbayar"><?= indo_currency($total) ?></div>
                        </div>
                    </div>

                    <!-- Tombol Simpan Transaksi dan History -->
                    <div class="row mt-3">
                        <div class="col-md-12 text-right">
                            <button id="btnSimpanTransaksi" class="btn btn-success">Payment</button>
                         


                            <!-- <button id="btnHistoryTransaksi" class="btn btn-info">History Simpan Transaksi</button> -->
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script type="text/javascript">
    
$(document).ready(function() {
    // Fungsi untuk menghitung total tagihan yang dipilih
    function calculateTotal() {
        let total = 0;
        let count = 0;
        $('.bill-checkbox:checked').each(function() {
            total += parseInt($(this).data('amount'));
            count++;
        });
        $('#totalbayar').text(indo_currency(total));
        $('#jumlah_item').val(count);
    }

    // Event handler untuk checkbox yang dipilih
    $(document).on('change', '.bill-checkbox', function () {
        calculateTotal();
    });

    // Event handler untuk checkbox "Select All"
    $('#select-all').on('change', function() {
    $('.bill-checkbox').not(':disabled').prop('checked', this.checked);
    calculateTotal();
});
    // Fungsi untuk mengkonversi angka ke format mata uang Indonesia
    function indo_currency(number) {
        return 'Rp. ' + number.toLocaleString('id-ID');
    }

  // Event handler untuk tombol Simpan Transaksi
$('#btnSimpanTransaksi').on('click', function(e) {
    e.preventDefault(); // Mencegah form di-submit secara langsung

    // Mengambil data yang diperlukan dari form dan tabel
    let checkedItems = [];
    $('.bill-checkbox:checked').each(function() {
        checkedItems.push($(this).data('amount'));
    });

    if (checkedItems.length === 0) {
        alert('Pilih setidaknya satu tagihan untuk dibayar.');
        return;
    }

    // Mengambil nilai-nilai form
    let formData = {
        invoice: $('#invoice').val(),           // Nomor Transaksi
        total: $('#totaldisplay').val(),            // Total yang ditampilkan
        selectedBills: checkedItems,                // Tagihan yang dipilih
        name: $('#name').val(),                      // Nama pelanggan
        address: $('#address').val(),                // Alamat pelanggan
        no_services: $('#no_services').val(),        // ID pelanggan
        tanggal: $('#tanggal').val(),                // Tanggal transaksi
        cashier: $('#cashier').val()  
                       // Kasir
    };

    // Konfirmasi sebelum melakukan penyimpanan
    if (confirm('Apakah Anda yakin ingin menyimpan transaksi ini?')) {
        // Mengirim data menggunakan AJAX
        $.ajax({
            url: "<?= site_url('kasir/payment') ?>", // Endpoint untuk memproses pembayaran
            method: "POST",
            data: formData,
            dataType: 'json', // Menentukan bahwa respon akan dalam format JSON
            
            success: function(response) {
                console.log(response); // Lihat apakah respons adalah JSON
                // Pastikan response diparsing sebagai JSON
                if (response && response.status === 'success') {
                    alert('Transaksi berhasil disimpan!');
                    // Redirect ke halaman lain jika perlu
                    window.location.href = '<?= site_url('kasir') ?>'; // Contoh redirect ke halaman lain
                } else {
                    console.log('Error:', response.message);
                    alert('Terjadi kesalahan saat menyimpan transaksi: ' + (response.message || 'Silakan coba lagi.'));
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('AJAX error:', textStatus, errorThrown);
                console.log('Response Text:', jqXHR.responseText); // Log respons untuk melihat isi
                alert('Terjadi kesalahan saat menghubungi server. Silakan coba lagi.'); // Tambahkan pesan kesalahan untuk pengguna
            }
        });
    }
});


    // Event handler untuk tombol History Simpan Transaksi
    $('#btnHistoryTransaksi').on('click', function() {
        // Lakukan aksi untuk menampilkan history simpan transaksi di sini
        alert('Menampilkan history simpan transaksi!'); // Ganti dengan logika untuk menampilkan history
    });

    // Hitung total awal
    calculateTotal();
});
</script>

</body>
</html>
