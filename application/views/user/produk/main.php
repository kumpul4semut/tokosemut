<div class="content">
  <?php foreach($main_produk as $MP): ?>
  <div class="container">
    <div class="row">
      <div class="col">
        <h2><?php echo $MP['main_group_produk_name']; ?></h2>
      </div>
    </div>
    <div class="row d-flex justify-content-center">
    <?php foreach($MP['group_produk'] as $GP): ?>
      <div class="col-4 mt-3">
        <a href="<?php echo base_url('user/produk/select/'.$GP['group_name']); ?>" style="font-decoration:none; color: #fff;">
          <div class="bg-primary color-white pt-3 pr-10 pb-3" style="border-radius: 5px; text-align:center; padding:3px;" data="green">
            <i class="<?php echo $GP['icon']; ?> text-center" style="font-size: 2em; display:block;"></i>
            <span style="font-size: 10px;"><?php echo $GP['group_name']; ?></span>
          </div>   
        </a>
      </div>
    <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
  </div>
</div>