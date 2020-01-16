<div class="content">
    <div class="row">
        <div class="col-md-12">
            <?= $this->session->flashdata('message'); ?>
              <div class="card card-user">
                    <?php foreach($invoice as $i): ?>
                <div class="card-header">
                  Invoice
                  <strong>#<?php echo($i->invoice_code) ?></strong> 
                    <span class="float-right"> <strong>Status:</strong> <?php echo($i->status) ?> </span>
                </div>
                <div class="card-body">
                  <div class="table-responsive-lg">
                    <?php if($i->status == '<span class="badge badge-warning">Pending</span>'): ?>
                      <h3 id="exp" data-expired="<?php echo($i->expired_on) ?>">Silahkan Lakukan Pembayaran Sesuai Nominal Jangan dibulatkan!!<h1 id="cek" class="text-center bg-warning text-white"></h1></h3>
                      <h5>3 kode unik terakhir akan masuk saldo juga</h5>
                      <h5>Jika Menggunakan pulsa sistem otomatis kami hanya menerima pulsa dari <strong>BAGI PULSA</strong></h5>
                    <?php else: ?>
                    <?php endif; ?>
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <td class="left strong">Jumlah</td>
                          <td class="left"><?php echo($i->nominal); ?></td>
                        </tr>
                        <tr>
                          <td class="left strong"><?php echo($i->method_name); ?></td>
                          <td class="left"><?php echo($i->name_transfer_to); ?></td>
                        </tr>
                        <tr>
                          <td class="left strong">Nomor</td>
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
                <div class="row">
                <?php endforeach; ?>
                </div>
                <div class="card-footer">
                  <div class="button-container">
                    <h5>Ada Masalah?? Contact kami</h5>
                    <a href="https://api.whatsapp.com/send?phone=6287719850938" class="btn btn-icon btn-round btn-facebook pt-2">
                      <i class="fab fa-whatsapp"></i>
                    </a>
                    <a href="https://facebook.com/kumpul4semut" class="btn btn-icon btn-round pt-2 btn-twitter">
                      <i class="fab fa-facebook"></i>
                    </a>
                  </div>
                </div>
              </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="noSendedPulsa" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Add New Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/deposit/index'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control text-dark" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control text-dark" name="nomor" placeholder="Nomor">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control text-dark" name="pemilik" placeholder="Pemilik">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>