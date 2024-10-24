<?php $no = 1;
foreach ($bill as $r => $data) { ?>
    Plg Yth, Tagihan Internet dengan ID Pelanggan <?= $data->no_services ?> a/n <?= $data->name ?>
<?php } ?>