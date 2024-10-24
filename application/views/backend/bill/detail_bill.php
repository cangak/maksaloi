<?php
$subtotal = 0;
foreach ($services->result() as $data) {
    $subtotal += (int) $data->total;
}
?>
<div class="table-responsive">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr style="text-align: center;">
                <th style="text-align: center; width:20px">No</th>
                <th>Name</th>
                <th style="text-align: center; width:50px;">Qty</th>
                <th>Price</th>
                <th>Disc</th>
                <th>Remark</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; ?>
            <?php if ($services->num_rows() > 0): ?>
                <?php foreach ($services->result() as $data): ?>
                    <tr>
                        <td style="text-align: center;"><?= $no++ ?>.</td>
                        <td><?= htmlspecialchars($data->item_name) ?></td>
                        <td style="text-align: center;"><?= (int) $data->qty ?></td>
                        <td style="text-align: right;"><?= indo_currency($data->services_price) ?></td>
                        <td style="text-align: right;">
                            <?= ($data->disc > 0) ? indo_currency($data->disc) : '-' ?>
                        </td>
                        <td><?= htmlspecialchars($data->remark) ?></td>
                        <td style="text-align: right;"><?= indo_currency($data->total) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">Belum ada layanan yang aktif</td>
                </tr>
            <?php endif; ?>
        </tbody>
        <tfoot>
            <tr style="text-align: right;">
                <th colspan="6">Grand Total</th>
                <th><?= indo_currency($subtotal) ?>
                    <input type="hidden" name="grand_total" value="<?= $subtotal ?>">
                </th>
            </tr>
        </tfoot>
    </table>
</div>
