<div class="col-lg-6">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold">Edit Pelanggan</h6>
        </div>
        <div class="card-body">
            <?php echo form_open_multipart('') ?>
            <div class="form-group">
                <label for="name">Nama Pelanggan</label>
                <input type="hidden" name="customer_id" value="<?= $customer->customer_id ?>" readonly>
                <input type="text" id="name" name="name" class="form-control" value="<?= $customer->name ?>">
                <?= form_error('name', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>
            <!-- <div class="form-group">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" class="form-control" value="<?= $customer->email ?>">
                <?= form_error('email', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div> -->
            <div class="form-group">
                <label for="no_ktp">No KTP</label>
                <input type="number" id="no_ktp" name="no_ktp" class="form-control" value="<?= $customer->no_ktp ?>">
                <?= form_error('no_ktp', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>
            <div class="form-group">
                <label for="no_wa">No Telp.</label>
                <input type="number" id="no_wa" name="no_wa" class="form-control" value="<?= $customer->no_wa ?>">
                <?= form_error('no_wa', '<small class="text-danger pl-3 ">', '</small>') ?>
            </div>
            <div class="form-group">
                <label for="address">Alamat</label>
                <textarea id="address" name="address" class="form-control"> <?= $customer->address ?></textarea>
            </div>

            <div class="modal-footer">
                <button type="reset" class="btn btn-secondary" data-dismiss="modal">Reset</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            <?php echo form_close() ?>
        </div>
    </div>
</div>