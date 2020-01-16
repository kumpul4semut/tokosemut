<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
              <table class="table tablesorter " id="">
                <thead class=" text-primary">
                  <tr>
                    <th>
                      Type
                    </th>
                    <th>
                      Created On
                    </th>
                    <th>
                      Detail
                    </th>
                    <th>
                      Status
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($transaksi as $trk): ?>
                  <tr>
                    <td>
                      <?php echo($trk->type_transaksi); ?>
                    </td>
                    <td>
                      <?php echo($trk->created_on); ?>
                    </td>
                    <td>
                      <a href="<?php echo($trk->link); ?>" class="badge badge-primary">
                        Go
                      </a>
                    </td>
                    <td>
                      <?php echo($trk->status); ?>
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
       