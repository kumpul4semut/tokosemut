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
                      Name
                    </th>
                    <th>
                      To
                    </th>
                    <th>
                      Pengirim
                    </th>
                    <th>
                      Nominal
                    </th>
                    <th>
                      Status
                    </th>
                    <th>
                      Action
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach($list_invoice as $li): ?>
                  <tr>
                    <td>
                      <?php echo($li->invoice_type); ?>
                    </td>
                    <td>
                    <?php echo($li->user_name); ?>
                    </td>
                    <td>
                    <?php echo($li->deposit_name.' On '.$li->nomor); ?>
                    </td>
                    <td>
                    <?php echo($li->from_sended); ?>
                    </td>
                    <td>
                    <?php echo($li->nominal); ?>
                    </td>
                    <td>
                    <?php 
                    $data_status = [
                      '<span class="bagde badge-danger">Gagal</span>',
                      '<span class="bagde badge-warning">Pending</span>',
                      '<span class="bagde badge-info">Check</span>',
                      '<span class="bagde badge-success">Done</span>'
                    ];
                    
                    echo ($data_status[$li->status_user]);
                    ?>
                    </td>
                    <td>
                      <a href="<?php echo base_url('admin/invoice/detail/'.$li->id); ?>" class="badge badge-primary">check</a>
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
       