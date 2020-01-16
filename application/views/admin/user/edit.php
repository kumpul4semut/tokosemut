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
			<form action="<?php echo base_url('admin/user/update') ?>" method="post">
				<div class="form-group">
					<label>Email</label>
					<input type="text" name="id" value="<?php echo $user->id; ?>" hidden="">
					<input type="text" name="email" value="<?php echo $user->email; ?>" class="form-control">
				</div>
				<div class="form-group">
					<label>Saldo</label>
					<input type="text" name="saldo" value="<?php echo $user->saldo; ?>" class="form-control">
				</div>
				<button type="submit" class="btn btn-primary">Update</button>
			</form>
		</div>
	</div>
</div>