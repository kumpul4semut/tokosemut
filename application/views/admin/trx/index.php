<div class="content">
    <div class="row">
        <div class="col-md-12">
          <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>
            <a href="<?php echo base_url('admin/transaksi/reset'); ?>" class="btn btn-danger">Reset</a>
            <div class="table-responsive">
              <table class="table tablesorter " id="">
                <thead class=" text-primary">
                  <tr>
                    <th>Email</th>
                    <th>Customer Nomor</th>
                    <th>produk</th>
                    <th>price</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Ref</th>
                  </tr>
                </thead>
                    <?php foreach ($trx as $t) : ?>
                    <tr>
                        <td><?= $t['email']; ?></td>
                        <td><?= $t['customer_no']; ?></td>
                        <td><?= $t['name']; ?></td>
                        <td><?= $t['price'] ?></td>
                        <td><?= date('y-M-d H:I:s', $t['created_on']) ?></td>
                        <td><?= $t['status']; ?></td>
                        <td><?= $t['ref']; ?></td>
                       
                    </tr>
  
                    <?php endforeach; ?>
                </tbody>
              </table>
            </div> <!-- end table-responsive-->
        </div><!-- end col -->
        <div class="col mt-5 d-flex justify-content-end">
          <nav>
           
          </nav>
        </div>
    </div>
</div>
       