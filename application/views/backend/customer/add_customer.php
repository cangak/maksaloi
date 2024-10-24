<head>
    <style>
        .required::after {
            content: "*";
            color: red;
            margin-left: 0.2em;
        }
    </style>
</head>
<div class="col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Pelanggan Baru</h6>
        </div>
        <div class="card-body">
            <?php echo form_open_multipart('customer/add') ?>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="name" class="required">Nama Pelanggan</label>
                    <input type="hidden" name="no_services" value="<?= Date('ymdHis') ?>">
                    <input type="text" id="name" name="name" class="form-control" value="<?= set_value('name') ?>" required>
                    <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
                </div>
                <div class="form-group col-md-4">
                    <label for="no_ktp" class="required">NIK Kartu Tanda Penduduk</label>
                    <input type="text" id="no_ktp" name="no_ktp" class="form-control" pattern="\d{16}" maxlength="16" minlength="16" value="<?= set_value('no_ktp') ?>" required>
                    <?= form_error('no_ktp', '<small class="text-danger pl-3 ">', '</small>') ?>
                </div>
                <div class="form-group col-md-4">
                    <label for="no_wa" class="required">No WhatsApp</label>
                    <input type="text" id="no_wa" name="no_wa" class="form-control" pattern="08\d{11}" maxlength="13" minlength="13" required>
                    <small id="no_wa_error" class="text-danger pl-3"></small>
                    <?= form_error('no_wa', '<small class="text-danger pl-3 ">', '</small>') ?>
                </div>
                  <div class="form-group col-md-12">
                    <label for="address" class="required">Alamat</label>
                    <textarea id="address" name="address" class="form-control" required></textarea>
                </div>

                <div class="modal-footer">
                    <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>

<script>
    document.getElementById('no_wa').addEventListener('input', function () {
        var input = this;
        var errorElement = document.getElementById('no_wa_error');

        // Clear any previous error message
        errorElement.textContent = '';
        errorElement.style.display = 'none';
        
        // Validate input
        if (!input.validity.valid) {
            if (input.value === '' || !/^08\d{11}$/.test(input.value)) {
                errorElement.textContent = 'Dimulai dengan 08';
                errorElement.style.display = 'block';
            }
        }
    });
</script>
