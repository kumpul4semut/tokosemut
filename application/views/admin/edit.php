<div class="content">
  <div class="row">
    <div class="col">
    <!-- form start -->
    <form role="form" action="<?php echo base_url('admin/'.$this->uri->segment(2).'/update') ?>" method="POST">
      <div class="box-body">
        <!-- <input type="hidden" name="id" value="> -->
      <?php foreach ($edit as $key => $value): ?>
        <?php if($key == 'id'): ?>
          <div class="form-group">
            <input type="hidden" class="form-control" value="<?php echo $value; ?>" name="<?php echo $key; ?>">
          </div>
        <?php else: ?>
          <?php if(is_array($value)): ?>
            <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $key; ?></label>
            <select class="form-control" name="<?php echo $key; ?>">
              <?php foreach($value as $p => $r): ?>
                <option value="<?php echo $r['id']; ?>">
                  <?php
                  echo $r['id'];
                  ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <?php else: ?>
          <div class="form-group">
            <label for="exampleInputEmail1"><?php echo $key; ?></label>
            <input type="text" class="form-control" value="<?php echo $value; ?>" name="<?php echo $key; ?>">
          </div>
          <?php endif; ?>
        <?php endif; ?>
      <?php endforeach; ?>
      </div>
      <!-- /.box-body -->

      <div class="box-footer">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>
    </div>
  </div>