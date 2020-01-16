<div class="content">
    <div class="row">
        <div class="col-md-12">
          <?php if (validation_errors()) : ?>
            <div class="alert alert-danger" role="alert">
                <?= validation_errors(); ?>
            </div>
            <?php endif; ?>

            <?= $this->session->flashdata('message'); ?>

            <a href="" class="btn btn-primary mb-3" data-toggle="modal" data-target="#newSubMenuModal">Add New Deposit</a>
            <div class="table-responsive">
              <table class="table tablesorter " id="">
                <thead class=" text-primary">
                  <tr>
                    <th>Method Name</th>
                    <th>Name</th>
                    <th>Nomor</th>
                    <th>Pemilik</th>
                    <th>Action</th>
                  </tr>
                </thead>
                    <?php foreach ($deposit as $d) : ?>
                    <tr>
                        <td><?= $d['method_name']; ?></td>
                        <td><?= $d['name']; ?></td>
                        <td><?= $d['nomor']; ?></td>
                        <td><?= $d['pemilik']; ?></td>
                        <td>
                            <a href="<?php echo base_url('admin/deposit/edit/'.$d['id']) ?>" class="badge badge-success">edit</a>
                            <a href="<?php echo base_url('admin/deposit/delete/'.$d['id']) ?>" class="badge badge-danger">delete</a>
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
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
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
                        <select name="depo_method" id="menu_id" class="form-control text-dark">
                            <option value="">Select Deposit Method</option>
                            <?php foreach ($depo_method as $dm) : ?>
                            <option value="<?= $dm['id']; ?>"><?= $dm['method_name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
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