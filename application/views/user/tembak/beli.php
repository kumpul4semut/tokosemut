<div class="content">
	<div class="row">
		<div class="col-lg-4">
			<h1 class="h3 mb-4 text-gray-800 text-center"><?= $title; ?></h1>
			<h2>Limit</h2>
			<div class="progress mb-4">
			  <div class="progress-bar" role="progressbar" style="width: <?php echo $persen; ?>;"> <?php echo $persen; ?></div>
			</div>
			<?= $this->session->flashdata('msg'); ?>
			<form action="<?php echo base_url(); ?>user/tembak/action_beli" method="POST">
				<div class="form-group">
					<select class="form-control text-dark" name="reg">
						<!-- <option value="1">6GB 27K</option> -->
						<!-- <option value="2">10GB 41K</option> -->
						<!-- <option value="3">20GB 62K</option> -->
						<!-- <option value="4">30GB 90K</option> -->
						<option value="5">Free 500mb Freefire</option>
						<!-- <option value="6">10GB Rp53.000</option> -->
						<option value="7">Rp.0, WhatsApp, Twitter, Line 50MB</option>
						<option value="8">Rp.0, iflix 500MBB</option>
						<option value="9">Rp.0, Joox 500MB</option>
						<option value="10">Rp.0, AOV 500MB</option>
						<option value="11">Rp.0, Smule 500MB</option>
						<option value="12">Rp.0, Tokopedia 50MB</option>
						<option value="13">Rp.0, Google Duo 50MB</option>
						<option value="14">Rp.0, Facebook 500MB</option>
						<option value="15">Rp.11900 Xtra Kuota 30GB</option>
					</select>
				</div>
				<button type="submit" class="btn btn-success" name="beli">Beli</button>
				<a href="<?php echo base_url('user/tembak/logout'); ?>" class="btn btn-danger">Logout</a>
			</form>
		</div>
	</div>
</div>