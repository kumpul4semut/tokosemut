<div class="content">
    <div class="row">
        <div class="col-md-12">
          <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>
          <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newMenuModal">Add New Server</a>
            <div class="table-responsive">
              <table class="table tablesorter " id="">
                <thead class=" text-primary">
                  <tr>
                    <th>
                      Title
                    </th>
                    <th>
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($server as $s) : ?>
                    <tr>
                        <td><?= $s['title']; ?></td>
                        <td>
                            <a href="<?php echo base_url('admin/server/edit/').$s['id'] ?>" class="badge badge-success">edit</a>
                            <a href="<?php echo base_url('admin/server/delete/').$s['id'] ?>" class="badge badge-danger">delete</a>
                            <a href="<?php echo base_url('admin/server/detail/'.$s['title'].'/prepaid'); ?>" class="badge badge-primary">Go Prabayar</a>
                            <a href="<?php echo base_url('admin/server/detail/'.$s['title'].'/pasca') ?>" class="badge badge-primary">Go Pasca Bayar</a>
                        </td>
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
       
<!-- Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/server/add'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control text-dark" id="menu" name="title" placeholder="Title">
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