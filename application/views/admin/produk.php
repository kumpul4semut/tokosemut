 <div class="content">
    <div class="row">
      	<div class="col-lg-4">
			<form action="<?php echo base_url('admin/produk/add'); ?>" method="post">
				<div class="form-group">
					<select class="form-control" name="kimnoon">
						<?php foreach($kimnoon as $k): ?>
							<option value="<?php echo($k['id']."|".$k['harga']); ?>"><?php echo($k['nominal']); ?></option>
								
						<?php endforeach; ?>
					</select>
				</div>
				<button type="submit" class="btn btn-primary btn-sm">Add</button>
			</form>
		</div>
	</div>
</div>
