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
			<?php if($this->session->flashdata('message') ): ?>
				<?php
					$alert = '<div class="alert alert-success">'.$this->session->flashdata('message').'</div>'; 
					echo $alert;
				 ?>
			<?php endif; ?>
			<form action="<?php echo base_url('admin/deposit/update') ?>" method="post">
				<div class="form-group">
					<input name="id" hidden value="<?= $deposit['id']; ?>">
                        <select name="depo_method" id="depo_method" class="form-control bg-primary">
                            <?php foreach ($depo_method as $dm) : ?>
                            <option value="<?= $dm['id']; ?>"
								<?php if ($dm['id'] == $deposit['deposit_method_id']) {
									echo "selected";
								}?>
                            	>

                            	<?= $dm['method_name']; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <span class="btn btn-warning btn-sm" id="edit-method">Edit Method</span>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" placeholder="Name" value="<?php echo $deposit['name']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="nomor" placeholder="Nomor" value="<?php echo $deposit['nomor']; ?>">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="pemilik" placeholder="Pemilik" value="<?php echo $deposit['pemilik']; ?>">
                    </div>
				<button type="submit" class="btn btn-primary">Update</button>
			</form>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="Medit">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Edit Method Deposit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/deposit/editMethod'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                    	<input name="id" hidden>
                        <input type="text" class="form-control text-dark" name="method_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>