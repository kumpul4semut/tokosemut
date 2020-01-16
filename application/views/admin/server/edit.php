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
			<form action="<?php echo base_url('admin/server/update') ?>" method="post">
				<div class="form-group">
					<label>Title</label>
					<input type="text" name="id" value="<?php echo $server['id']; ?>" hidden="">
					<input type="text" name="title" value="<?php echo $server['title']; ?>" class="form-control">
				</div>
				<div class="form-group">
					<label>Secret</label>
					<input type="text" name="secret" value="<?php echo $server['secret']; ?>" class="form-control">
				</div>
				<div class="form-group">
					<label>Key</label>
					<input type="text" name="key" value="<?php echo $server['key']; ?>" class="form-control">
				</div>
				<button type="submit" class="btn btn-primary">Update</button>
			</form>
		</div>
	</div>
</div>