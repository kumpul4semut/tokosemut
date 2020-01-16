<div class="content">
    <div class="row">
        <div class="col-md-12">
          <?= $this->session->flashdata('message'); ?>
          <div class="row">
            <div class="col">
              <a href="<?php echo base_url('admin/user/delpending') ?>" class="btn btn-warning mb-3" >Delete Pending</a>
            </div>
            <div class="col">
                  <form action="<?php echo base_url('admin/user/search') ?>" method="POST" class="float-right">
                    <div class="form-group">
                      <input class="form-control" type="text" name="search" placeholder="Search">
                    </div>
                    <button class="btn btn-primary btn-sm">Search</button>
                  </form>
                </div>
          </div>
            <div class="table-responsive">
              <table class="table tablesorter " id="">
                <thead class=" text-primary">
                  <tr>
                    <th>
                      Name
                    </th>
                    <th>
                      Email
                    </th>
                    <th>
                      Slado
                    </th>
                    <th>
                      Active
                    </th>
                    <th>
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($list_user as $lu): ?>
                  <tr>
                    <td>
                    <?php echo($lu->name); ?>
                    </td>
                    <td>
                    <?php echo($lu->email); ?>
                    </td>
                    <td>
                    <?php echo($lu->saldo); ?>
                    </td>
                    <td>
                    <?php 
                    $data_status = [
                      '<span class="bagde badge-warning">Pending</span>',
                      '<span class="bagde badge-success">Done</span>',
                    ];
                    
                    echo ($data_status[$lu->is_active]);
                    ?>
                    </td>
                    <td>
                      <a href="<?php echo base_url('admin/user/edit/'.$lu->id) ?>" class="badge badge-success">edit</a>
                      <a href="<?php echo base_url('admin/user/deleteUser/'.$lu->id) ?>" class="badge badge-danger">delete</a>
                      <a href="<?php echo base_url('admin/user/lock/'.$lu->id) ?>" class="badge badge-warning">lock</a>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div> <!-- end table-responsive-->
        </div><!-- end col -->
        <div class="col mt-5 d-flex justify-content-end">
          <nav>
            <?php 
            echo $this->pagination->create_links();
            ?>
          </nav>
        </div>
    </div>
</div>
       