<div class="content"> <!-- Content -->
	<div class="row">
    <div class="col">
      <p class="text-size-14">Setelah anda dapat token jika bingung bisa membaca documentasinya  <a href="<?php echo base_url('user/development/doc'); ?>">DISINI</a></p> 
    </div>
  </div>
  <div class="row"> 
		<div class="col-lg">
			<h1><?php echo $title; ?></h1>
      <?php if($this->session->flashdata('message') ): ?>
        <?php
          $alert = '<div class="alert alert-success">'.$this->session->flashdata('message').'</div>'; 
          echo $alert;
         ?>
      <?php endif; ?>
      <div class="row">
        <div class="col-sm">
    			<div class="form-group">
            <label>Token</label>
            <input class="form-control" type="text" value="<?php echo $token; ?>" id="myInput" readonly>
          </div>
        </div>
        <div class="col-sm">
          <div class="form-group">
             <button onclick="myFunction()" class="btn btn-outline-dark btn-sm">Copy</button>
          </div>
        </div>
      </div>
      <div class="form-group">
      <a href="<?php echo base_url('user/development/generate') ?>" class="btn btn-primary">Generate</a>
      <div id="load-depo" class="mt-2 " style="display: none;"><img src="<?= base_url('assets/load/load4.gif'); ?>"></div>
      </div>
    </div>
  </div>
</div> <!-- End Content -->



