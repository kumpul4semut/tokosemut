<div class="content">
    <div class="row">
        <div class="col-md-8">
            <?= $this->session->flashdata('message'); ?>
              <div class="card card-user">
                <?php foreach ($invoice as $i): ?>
                <div class="card-header">
                  Invoice
                  <strong>#<?php echo($i->id) ?></strong> 
                    <span class="float-right"> <strong>Status:</strong> 
                      <?php $data_status = [
                            '<span class="badge badge-danger">Failed</span>',

                            '<span class="badge badge-warning">Pending</span>',

                            '<span class="badge badge-info">Check</span>',

                            '<span class="badge badge-success">Success</span>'
                          ]; 
                          echo($data_status[$i->status]) 
                      ?>
                    </span>
                </div>
                <div class="card-body">
                  <div class="table-responsive-sm">
                    <h3>Pembayaran!!</h3>
                    <span class="badge badge-sm badge-primary mb-2"><?php echo($i->created_on); ?></span>
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <td class="left strong">Jumlah</td>
                          <td class="left"><?php echo($i->nominal); ?></td>
                        </tr>
                        <tr>
                          <td class="left strong">Dari</td>
                          <td class="left"><?php echo($i->name); ?></td>
                        </tr>
                        <tr>
                          <td class="left strong">Saldo User</td>
                          <td class="left"><?php echo($i->saldo); ?></td>
                        </tr>
                        <tr>
                          <td class="left strong">Bank</td>
                          <td class="left"><?php echo($i->name_transfer_to); ?></td>
                        </tr>
                        <tr>
                          <td class="left strong">Nomor Rekening</td>
                          <td class="left"><?php echo($i->rek_transfer_to); ?></td>
                        </tr>
                        <tr>
                          <td class="left strong">Atas Nama</td>
                          <td class="left"><?php echo($i->atas_nama); ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              <?php endforeach; ?>
                <div class="row">
                  <div class="col-lg d-flex justify-content-center">
                    <a href="<?php echo base_url('admin/invoice/goAccept/'.$i->id); ?>" class="btn btn-sm btn-success">Accept</a>
                  </div>
                  <div class="col-lg d-flex justify-content-center">
                    <a href="<?php echo base_url('admin/goaccpt/'.$i->id); ?>" class="btn btn-sm btn-warning">Send Message</a>
                  </div>
                  <div class="col-lg d-flex justify-content-center">
                    <a href="<?php echo base_url('admin/invoice/goDeny/'.$i->id); ?>" class="btn btn-sm btn-danger">Deny</a>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>