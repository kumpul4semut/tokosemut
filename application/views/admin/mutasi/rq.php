<div class="content">
	<div class="row">
		<div class="col">
			<h1 class="border-bottom"><?php echo $title; ?></h1>
		</div>
	</div>
	<div class="row">
		<div class="col">
			<form action="<?php echo base_url($url) ?>" method="post">
				<div class="form-group">
					<input type="text" class="form-control" name="<?php echo $rqR ?>" placeholder="<?php echo $rqP ?>">
				</div>
				<button type="submit" class="btn btn-primary"><?php echo $rqName; ?></button>
			</form>
		</div>
	</div>
</div>