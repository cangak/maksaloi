<!-- Page Heading -->
<div class="dropdown mb-4">
    <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      </i> Buat Tagihan
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addAllModal">Buat Untuk Semua Pelanggan</a>
        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#addModal">Buat Untuk Per Pelanggan</a>
    </div>
</div>

<!-- Modal Tambah Tagihan ke Semua Pelanggan -->
<div class="modal fade" id="addAllModal" tabindex="-1" role="dialog" aria-labelledby="addAllModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAllModalLabel">Semua Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open('bill/addAllBills') ?>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="month">Bulan</label>
                            <select class="form-control" name="month" required>
                                <option value="">------Pilih Bulan------</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="year">Tahun</label>
                            <select class="form-control" name="year" required>
                                <option value="">------Pilih Tahun------</option>
                                <?php for ($i = date('Y'); $i >= 2023; $i -= 1) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Proses</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
        </div>
 

<!-- Modal Tambah Tagihan Per Pelanggan -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Tagihan Per Pelanggan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php echo form_open_multipart('bill/addBill') ?>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="month">Bulan</label>
                            <input type="hidden" name="invoice" value="<?= $invoice ?>">
                            <select class="form-control select2" style="width: 100%;" name="month" required>
                                <option value="">-Pilih-</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="year">Tahun</label>
                            <select class="form-control select2" style="width: 100%;" name="year" required>
                                <option value="">-Pilih-</option>
                                <?php for ($i = date('Y'); $i >= 2015; $i -= 1) { ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name">ID - Nama Pelanggan</label>
                    <select class="form-control select2" name="no_services" id="no_services" onchange="cek_data()" style="width: 100%;" required>
                        <option value="">-Pilih-</option>
                        <?php foreach ($customer as $r => $data) { ?>
                            <option value="<?= $data->no_services ?>"><?= $data->no_services ?> - <?= $data->name ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nominal">Rincian Tagihan</label>
                    <div class="loading"></div>
                    <div class="view_data"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Tagihan Pelanggan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:20px">No</th>
                        <th>ID Pelanggan</th>
                        <th>Nama Pelanggan</th>
                        <th>Periode</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th style="text-align: center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
    <?php $no = 1; foreach ($bill as $r => $data) { ?>
        <tr>
            <td style="text-align: center"><?= $no++ ?>.</td>
            <td style="text-align: center"><?= $data->no_services ?></td>
            <td><?= $data->name ?></td>
            <td>
                <?= indo_month($data->month) ?> <?= $data->year ?>
            </td>
            <td style="text-align: right;">
    <?php 
    // Inisialisasi Subtotal
    $subtotal = 0;

    // Ambil ID Faktur
    $invoiceId = isset($data->invoice) ? $data->invoice : null;

    // Query untuk mendapatkan total dari tabel invoice_detail berdasarkan invoice_id
    if ($invoiceId) {
        $this->db->select_sum('total'); // Mengambil total keseluruhan
        $this->db->where('invoice_id', $invoiceId);
        $invoice_detail = $this->db->get('invoice_detail')->row();

        // Jika ada hasil, tambahkan total dari invoice_detail ke subtotal
        if ($invoice_detail) {
            $subtotal += $invoice_detail->total;
        }
    }

    // Menampilkan subtotal dalam format mata uang Indonesia
    echo indo_currency($subtotal);
    ?>
</td>
            <td id="status-<?= $data->invoice_id ?>" class="status" style="text-align: center; font-weight:bold; color:<?= $data->status == 'SUDAH BAYAR' ? 'green' : 'red' ?>" data-date="<?= date('Y m d', strtotime($data->date_payment)) ?>">
                <?= $data->status ?>
            </td>
            <td style="text-align: center">
                <a href="<?= site_url('bill/detail/' . $data->invoice) ?>" title="Lihat"><i class="fa fa-eye" style="font-size:25px; color:gray"></i></a>
                <?php if ($data->status == 'BELUM BAYAR') { ?>
                    <a href="https://api.whatsapp.com/send?phone=<?= indo_tlp($data->no_wa) ?>&text=Plg Yth, Iuran Internet no <?= $data->no_services ?> a/n _<?= $data->name ?>_ bln <?= indo_month($data->month) ?> <?= $data->year ?> Sebesar *<?= indo_currency($subtotal) ?>*, Mohon untuk melakukan pembayaran iuran melalui ATM, Internet Banking atau langsung ke <?= $company['company_name'] ?>. Abaikan jika sudah melakukan pembayaran. Tks %0A%0A%0A <?= $company['company_name'] ?> %0A<?= $company['sub_name'] ?>" target="blank" title="Kirim Notifikasi"><i class="fab fa-whatsapp" style="font-size:25px; color:green"></i></a>
                <?php } ?>
                <a href="" data-toggle="modal" data-target="#DeleteModal<?= $data->invoice_id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
            </td>
        </tr>
    <?php } ?>
               
        </div>
 

</tbody>
            </table>
            </div>

   

<!-- Modal Hapus -->
<?php foreach ($bill as $r => $data) { ?>
    <div class="modal fade" id="DeleteModal<?= $data->invoice_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Tagihan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open_multipart('bill/delete') ?>
                    <input type="hidden" name="invoice_id" value="<?= $data->invoice_id ?>" class="form-control">
                    <input type="hidden" name="invoice" value="<?= $data->invoice ?>" class="form-control">
                    Apakah yakin akan hapus Tagihan <?= $data->no_services ?> A/N <?= $data->name ?> ?
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                    <?php echo form_close() ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<script>
    $(function() {
        // Initialize Select2 Elements
        $('.select2').select2();
    });

    function cek_data() {
        var no_services = $('[name="no_services"]');
        $.ajax({
            type: 'POST',
            data: "cek_data=" + 1 + "&no_services=" + no_services.val(),
            url: '<?= site_url('bill/view_data') ?>',
            cache: false,

            beforeSend: function() {
                no_services.attr('disabled', true);
                $('.loading').html(`<div class="container">
                    <div class="text-center">
                        <div class="spinner-border text-primary" style="width: 5rem; height: 5rem;" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>`);
            },
            success: function(data) {
                no_services.attr('disabled', false);
                $('.loading').html('');
                $('.view_data').html(data);
            }
        });
        return false;
    }

    $(document).ready(function() {
        $('.status').click(function() {
            var currentStatus = $(this).text().trim();
            var paymentDate = $(this).data('date');

            if (currentStatus === 'SUDAH BAYAR') {
                var dateObj = new Date(paymentDate);
                if (isNaN(dateObj.getTime())) {
                    console.error("Invalid Date:", paymentDate);
                    return;
                }

                var options = { year: 'numeric', month: 'long', day: 'numeric' };
                var formattedDate = dateObj.toLocaleDateString('id-ID', options);
                $(this).text(formattedDate);
            }
        });
    });
</script>

<style>
    .status {
        cursor: pointer; /* Mengubah bentuk kursor menjadi tangan saat hover */
    }
</style>
