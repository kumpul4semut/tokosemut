<div class="content">
	<div class="row">
		<div class="col-lg-4">
			<h1><?php echo $title; ?></h1>
			<?php if(validation_errors() ): ?>
				<?php
					$alert = '<div class="alert alert-danger">'.validation_errors().'</div>'; 
					echo $alert;
				 ?>
			<?php endif; ?>
			<?php if($this->session->flashdata('msg') ): ?>
				<?php
					$alert = '<div class="alert alert-success">'.$this->session->flashdata('msg').'</div>'; 
					echo $alert;
				 ?>
			<?php endif; ?>
			<form action="<?php echo base_url('admin/setting/index') ?>" method="post">
				<div class="form-group">
					<label>Laba</label>
					<input type="text" name="laba" value="<?php echo $setting['laba']; ?>" class="form-control">
				</div>
				<div class="form-group">
					<label>Minimum Deposit</label>
					<input type="text" name="md" value="<?php echo $setting['minimum_deposit']; ?>" class="form-control">
				</div>
				<div class="form-group">
					<label>Maximum Deposit</label>
					<input type="text" name="xd" value="<?php echo $setting['maximum_deposit']; ?>" class="form-control">
				</div>
				<div class="form-group">
					<label>Pagination perpage</label>
					<input type="text" name="pp" value="<?php echo $setting['total_pagination']; ?>" class="form-control">
				</div>

				<button type="submit" class="btn btn-primary">Update</button>
			</form>
		</div>
	</div>
</div>