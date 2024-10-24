<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <a href="<?= site_url('customer/add') ?>" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Input Pelanggan Baru
    </a>
</div>
<?php $this->view('messages') ?>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold">Data Pelanggan</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr style="text-align: center">
                        <th style="text-align: center; width:10px">No</th>
                        <th>ID Pelanggan</th>
                        <th>Nama</th>
                        <th>No WhatsApp</th>
                        <th>Alamat</th>
                        <th>Tagihan / Bulan</th>
                        <th>Status</th>
                        <th style="text-align: center; width: 50px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; foreach ($customer as $data) { ?>
                        <tr>
                            <td style="text-align: center"><?= $no++ ?>.</td>
                            <td><?= $data->no_services ?> <br>
                                <a href="<?= site_url('services/detail/') ?><?= $data->no_services ?>" class="btn btn-success" style="font-size: smaller">Rincian Paket</a>
                            </td>
                            <td><?= $data->name ?></td>
                            <td><?= $data->no_wa ?></td>
                            <td><?= $data->address ?></td>
                            <td style="text-align:right; font-weight:bold">
                                <?php
                                $query = "SELECT * FROM `services` WHERE `services`.`no_services` = $data->no_services";
                                $subtotal = array_sum(array_column($this->db->query($query)->result(), 'total'));
                                ?>
                                <?= indo_currency($subtotal) ?>
                            </td>
                            <td style="text-align: center">
                                <select class="form-control status-select" data-id="<?= $data->customer_id ?>" data-status="<?= $data->status_p ?>" <?= $subtotal === 0 ? 'disabled' : '' ?>>
                                    <?php if ($subtotal === 0) { ?>
                                        <option value="pending" selected>Pending</option>
                                    <?php } else { ?>
                                        <option value="aktif" <?= $data->status_p == 'aktif' ? 'selected' : '' ?>>Aktif</option>
                                        <option value="nonaktif" <?= $data->status_p == 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
                                    <?php } ?>
                                </select>
                            </td>

                            <td style="text-align: center">
                                <a href="<?= site_url('customer/edit/') ?><?= $data->customer_id ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a> 
                                <a href="" data-toggle="modal" data-target="#DeleteModal<?= $data->customer_id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Hapus -->
<?php foreach ($customer as $data) { ?>
    <div class="modal fade" id="DeleteModal<?= $data->customer_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus Pelanggan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo form_open_multipart('customer/delete') ?>
                    <input type="hidden" name="customer_id" value="<?= $data->customer_id ?>" class="form-control">
                    <input type="hidden" name="no_services" value="<?= $data->no_services ?>" class="form-control">
                    Apakah yakin akan hapus No Layanan <?= $data->no_services ?> A/N <?= $data->name ?> ?
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

<!-- SweetAlert2 CSS dan JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelects = document.querySelectorAll('.status-select');

    statusSelects.forEach(select => {
        const customerId = select.getAttribute('data-id');
        const currentStatus = select.getAttribute('data-status');

        // Ambil subtotal dari server saat memuat halaman (dapat diimplementasikan dengan cara lain sesuai kebutuhan)
        fetch(`<?= site_url('customer/get_subtotal/${customerId}') ?>`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const subtotal = data.subtotal;

                    // Atur status default berdasarkan subtotal
                    if (subtotal === 0) {
                        select.value = 'pending'; // Set to pending if subtotal is 0
                        select.setAttribute('data-status', 'pending');
                    } else {
                        select.value = 'aktif'; // Set to aktif if subtotal > 0
                        select.setAttribute('data-status', 'aktif');
                    }

                    // Nonaktifkan pilihan 'nonaktif' jika status saat ini 'pending'
                    if (currentStatus === 'pending') {
                        select.querySelector('option[value="nonaktif"]').disabled = true;
                    }
                }
            })
            .catch(error => console.error('Error fetching subtotal:', error));

        select.addEventListener('change', function() {
            const newStatus = this.value;

            console.log('Customer ID:', customerId, 'New Status:', newStatus);

            Swal.fire({
                title: 'Konfirmasi Perubahan Status',
                text: `Apakah Anda yakin ingin mengubah status dari "${currentStatus}" menjadi "${newStatus}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, ubah!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('<?= site_url('customer/update_status') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ customer_id: customerId, status_p: newStatus })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log(data); // Log data dari server
                        if (data.success) {
                            Swal.fire('Berhasil!', 'Status berhasil diubah.', 'success');
                            this.setAttribute('data-status', newStatus);
                            // Update status tampilan di dropdown
                            select.value = newStatus;
                        } else {
                            Swal.fire('Gagal!', data.message || 'Gagal mengubah status.', 'error');
                        }
                    })
                    .catch(error => {
                        Swal.fire('Gagal!', 'Terjadi kesalahan: ' + error.message, 'error');
                    });
                } else {
                    this.value = currentStatus; // Kembalikan pilihan ke status sebelumnya
                }
            });
        });
    });
});
</script>

