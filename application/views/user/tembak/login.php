<div class="content">
	<div class="row">
		<div class="col-lg-4">
			<h1 class="h3 mb-4 text-gray-800 text-center"><?= $title; ?></h1>
			<h2>Limit</h2>
			<div class="progress mb-4">
			  <div class="progress-bar" role="progressbar" style="width: <?php echo $persen; ?>;"> <?php echo $persen; ?></div>
			</div>
			<?= $this->session->flashdata('msg'); ?>
			<form action="<?php echo base_url(); ?>user/tembak/action_login" method="POST">
				<div class="form-group">
					<input class="form-control" type="text" placeholder="Otp" name="otp" />
				</div>
				<button type="submit" class="btn btn-warning" name="login">Login</button>
			</form>
		</div>
	</div>
</div>