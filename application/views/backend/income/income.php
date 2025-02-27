  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="<?= base_url('assets/backend') ?>/bootstrap-datepicker/css/bootstrap-datepicker.min.css">

  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <a href="" data-toggle="modal" data-target="#add" class="d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
      <?php $subtotal = 0;
        foreach ($income as $c => $data) {
            $subtotal += $data->nominal;
        } ?>
  </div>
  <?php $this->view('messages') ?>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
      <div class="card-header py-3">
          <h6 class="m-0 font-weight-bold">Data Pemasukan</h6>

      </div>
      <div class="card-body">
          <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                      <tr style="text-align: center">
                          <th style="text-align: center; width:20px">No</th>
                          <th style="text-align: center; width:150px">Tanggal</th>
                          <th>Keterangan</th>
                          <th style="text-align: center; width:100px">Nominal</th>

                          <th style="text-align: center; width:50px">Aksi</th>
                      </tr>
                  </thead>
                  <tfoot>
                      <tr style="text-align: center">
                          <th style="text-align: right; font-weight:bold" colspan="3"><b>Total</b></th>

                         
                          <th style="text-align: right">
                              <?= indo_currency($subtotal) ?> </th>
                          
                      </tr>
                  </tfoot>
                  <tbody>
                      <?php $no = 1;
                        foreach ($income as $r => $data) { ?>
                          <tr>
                              <td style="text-align: center"><?= $no++ ?>.</td>
                              <td><?= ($data->date_payment)  ?> <br>
                              <td><?= $data->remark ?></td>
                              <td style="text-align: right"><?= indo_currency($data->nominal)  ?></td>
                              </td>
                              <td style="text-align: center"><a href="#" data-toggle="modal" data-target="#edit<?= $data->income_id ?>" title="Edit"><i class="fa fa-edit" style="font-size:25px"></i></a> 
                              <a href="" data-toggle="modal" data-target="#delete<?= $data->income_id ?>" title="Hapus"><i class="fa fa-trash" style="font-size:25px; color:red"></i></a></td>
                          </tr>
                      <?php } ?>
                  </tbody>
              </table>
          </div>
      </div>
  </div>

  <!-- Modal Add -->
  <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tambah Pemasukan</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  <form action="<?= site_url('income/add') ?>" method="POST">
                      <div class="form-group">
                          <label for="nominal">Nominal</label>
                          <input type="number" id="nominal" name="nominal" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label for="datepicker">Tanggal</label> <span style="font-size: 10px">Format : yyyy-mm-dd Contoh <?= date('Y-m-d') ?></span>
                          <input type="text" name="date_payment" id="datepicker" class="form-control" required>
                      </div>
                      <div class="form-group">
                          <label for="remark">Keterangan</label>
                          <textarea type="text" name="remark" id="remark" class="form-control"> </textarea>
                      </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                  <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
              </form>
          </div>
      </div>
  </div>


  <!-- Modal Edit -->
  <?php foreach ($income as $r => $data) { ?>
      <div class="modal fade" id="edit<?= $data->income_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Edit Pemasukan</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <form action="<?= site_url('income/edit') ?>" method="POST">
                          <div class="form-group">
                              <label for="nominal">Nominal</label>
                              <input type="number" id="nominal" name="nominal" value="<?= $data->nominal ?>" class="form-control" required>
                              <input type="hidden" id="income_id" name="income_id" value="<?= $data->income_id ?>" class="form-control" required>
                          </div>
                          <div class="form-group">
                              <label for="datepicker">Tanggal</label> <span style="font-size: 10px">Format : yyyy-mm-dd Contoh <?= date('Y-m-d') ?></span>
                              <input type="text" name="date_payment" id="datepicker" onclick="$(this).datepicker({format: 'yyyy-mm-dd',autoclose: true,todayHighlight: true,}).datepicker('show')" value="<?= $data->date_payment ?>" class="form-control" required>
                          </div>
                          <div class="form-group">
                              <label for="remark">Keterangan</label>
                              <textarea type="text" name="remark" id="remark" class="form-control"><?= $data->remark ?></textarea>
                          </div>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                  </form>
              </div>
          </div>
      </div>
  <?php } ?>
  <!-- Modal Edit -->
  <?php foreach ($income as $r => $data) { ?>
      <div class="modal fade" id="delete<?= $data->income_id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">Hapus Pemasukan</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <form action="<?= site_url('income/delete') ?>" method="POST">
                          <input type="hidden" name="income_id" value="<?= $data->income_id ?>">
                          <?php $d = substr($data->date_payment, 8, 2);
                            $m = substr($data->date_payment, 5, 2);
                            $y = substr($data->date_payment, 0, 4); ?>
                          Apakah yakin akan hapus data pendapatan pada tanggal <?= indo_date($data->date_payment) ?> senilai <?= indo_currency($data->nominal) ?> ?
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-danger">Hapus</button>
                  </div>
                  </form>
              </div>
          </div>
      </div>
  <?php } ?>
  <!-- bootstrap datepicker -->
  <script src="<?= base_url('assets/backend') ?>/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
  <script>
      //Date picker
      $('#datepicker').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          todayHighlight: true,
      })
  </script>