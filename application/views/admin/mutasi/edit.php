<div class="content">
	<div class="row">
		<div class="col">
			<h1 class="border-bottom"><?php echo $title; ?></h1>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<form action="<?php echo base_url('admin/mutasi/update/'.$edit->id) ?>" method="post">
				<?php if ($title == 'xl'): ?>
				<div class="form-group">
					<label>access token</label>
					<input type="text" class="form-control" name="token" value="<?php echo $edit->token; ?>">
				</div>
				<div class="form-group">
					<label>number_enc</label>
					<input type="text" class="form-control" name="number_enc" value="<?php echo $edit->number_enc; ?>">
				</div>
				<div class="form-group">
					<label>refresh_token</label>
					<input type="text" class="form-control" name="refresh_token" value="<?php echo $edit->refresh_token; ?>">
				</div>
				<?php else: ?>
				<div class="form-group">
					<input type="text" class="form-control" name="token" value="<?php echo $edit->token; ?>">
				</div>
				<?php endif; ?>
				<button type="submit" class="btn btn-primary">Update</button>
				<a href="<?php echo base_url('admin/mutasi/'.$title.'/gettoken') ?>" class="btn btn-warning">GetToken</a>
			</form>
		</div>
	</div>
</div>