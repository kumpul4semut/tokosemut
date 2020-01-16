<div class="content">
    <div class="row mb-5">
        <div class="col-lg-4">
            <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addGroup">AddGroup</button>    
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <?= form_error('menu', '<div class="alert alert-danger" role="alert">', '</div>'); ?>

            <?= $this->session->flashdata('message'); ?>
            <div class="row mb-4">
                <div class="col">
                  <form class="float-left">
                    <div class="form-group">
                      <input class="form-control" type="text" name="search" placeholder="Search">
                    </div>
                    <button class="btn btn-primary btn-sm">Search</button>
                  </form>
                </div>
                <div class="col-3-lg">
                    <label>filter</label>
                    <div class="form-group">    
                        <select class="form-control text-dark" id="filter-produk">
                            <option selected>Select...</option>
                            <?php foreach($group_produk as $gp): ?>
                            <option value="<?php echo $gp['id']; ?>">
                                <?php echo $gp['group_name']; ?>
                            </option>
                            <?php endforeach;  ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
              <table class="table tablesorter " id="">
                <thead class=" text-primary">
                  <tr>
                    <th>
                        #
                    </th>
                    <th>
                        Server
                    </th>
                    <th>
                        Category
                    </th>
                    <th>
                      Name
                    </th>
                    <th>
                        Price
                    </th>
                    <th>
                        Status
                    </th>
                    <th>
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody id="tbody">
                  <?php $i=1 ?>
                  <?php foreach ($produk as $p) : ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?= $p['server']; ?></td>
                        <td><?= $p['category']; ?></td>
                        <td><?= $p['name']; ?></td>
                        <td><?= $p['price']; ?></td>
                        <td><?= $p['status']; ?></td>
                        <td>
                            <a href="<?php echo base_url('admin/produk/edit/').$p['id'] ?>" class="badge badge-success">edit</a>
                            <a href="<?php echo base_url('admin/produk/delete/').$p['id'] ?>" class="badge badge-danger">delete</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
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
       

<!-- Modal add group-->
<div class="modal fade" id="addGroup" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add New Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/produk/addGroup'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control text-dark" name="group_name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="main-group">
                            <?php foreach($main_group as $mg): ?>
                            <option value="<?php echo $mg['id'] ?>"><?php echo $mg['main_group_produk_name'] ?></option>
                        <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" name="icon" placeholder="tim-icons icon-support-17" class="form-control">
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