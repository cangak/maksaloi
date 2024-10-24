<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-_8r6i9rust4_g3tP"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    
</head>
<body>
    <form id="payment-form" method="post" action="<?=site_url()?>/bill/finish">
        <input type="hidden" name="result_type" id="result-type" value="">
        <input type="hidden" name="result_data" id="result-data" value="">
    </form>

    <?php if ($customer->num_rows() > 0) { ?>
        <?php if ($bill->num_rows() > 0) { ?>
            <div class="customer-info">
                <h4>Informasi Pelanggan</h4>
                <p>ID Pelanggan: <?= $customer->row()->no_services ?></p>
                <p>Nama Pelanggan: <?= $customer->row()->name ?></p>
                <p>Alamat: <?= $customer->row()->address ?></p>
            </div>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        
                        <th>Bulan</th>
                        <th>Jumlah Tagihan</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bill->result() as $data) { 
                        $subtotal = (int) $data->total; 
                        $query = "SELECT * FROM `customer` WHERE `customer`.`no_services` = $data->no_services"; 
                        $querying = $this->db->query($query); 
                        foreach ($querying->result() as $dataa) { ?>
                        <tr>
                            
                            <td><?= indo_month($data->month) ?> <?= date('Y') ?></td> <!-- Added month -->
                            <td><?= indo_currency($subtotal) ?></td>
                            <td>
                                <?php if ($data->status == 'BELUM BAYAR') { ?>
                                    <span class="badge bg-danger">Belum Bayar</span>
                                <?php } else { ?>
                                    <span class="badge bg-success">Sudah Bayar</span>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($data->status == 'BELUM BAYAR') { ?>
                                    <button class="btn btn-success pay-button" data-tagihan="<?= $data->no_services ?>" data-nama="<?= $dataa->name ?>" data-bulan="<?= indo_month($data->month)?> <?= date('Y') ?>"data-jumlah="<?= $subtotal ?>">Bayar Sekarang</button>
                                <?php } else { ?>
                                    <span>Tidak Ada Aksi</span>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div class="text-center mb-3">
                <div class="container">
                    <div class="card border-danger">
                        <div class="card-body">
                            <h4 class="card-title text-danger">Data Tagihan belum Tersedia</h4>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } else { ?>
        <div class="text-center mb-3">
            <div class="container">
                <div class="card border-danger">
                    <div class="card-body">
                        <h4 class="card-title text-warning">ID Pelanggan tidak terdaftar, silahkan cek kembali ID anda</h4>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>

    <script type="text/javascript">
        $(document).on('click', '.pay-button', function (event) {
            event.preventDefault();
            const idPelanggan = $(this).data('tagihan');
            const namaPelanggan = $(this).data('nama');
            const bulantagihan = $(this).data('bulan');
            const jumlahTagihan = $(this).data('jumlah');

            const data = {
                id_pelanggan: idPelanggan,
                nama_pelanggan: namaPelanggan,
                bulan_tagihan: bulantagihan,
                jumlah_tagihan: jumlahTagihan
            };

            $.ajax({
                type: 'POST',
                url: '<?=site_url()?>/snap/token',
                cache: false,
                data: data,
                success: function(response) {
                    snap.pay(response, {
                        onSuccess: function(result) {
                            $("#result-type").val('success');
                            $("#result-data").val(JSON.stringify(result));
                            $("#payment-form").submit();
                        },
                        onPending: function(result) {
                            $("#result-type").val('pending');
                            $("#result-data").val(JSON.stringify(result));
                            $("#payment-form").submit();
                        },
                        onError: function(result) {
                            $("#result-type").val('error');
                            $("#result-data").val(JSON.stringify(result));
                            $("#payment-form").submit();
                        }
                    });
                },
                error: function() {
                    alert('Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
                }
            });
        });
    </script>
</body>
</html>
