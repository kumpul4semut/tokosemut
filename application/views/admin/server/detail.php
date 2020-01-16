<div class="content">
	<div class="row">
		<div class="col-lg">
			<h2 class="badge badge-primary text-white">Saldo Rp<?php echo $saldo; ?></h2>
			<h3 class="mt-3 mb-2">Daftar Harga</h3>
            <a href="<?php echo base_url('admin/server/refresh/'.$title) ?>" class="btn-sm btn btn-warning float-right">Refresh price</a>	
			<?= $this->session->flashdata('message'); ?>	
			<div class="table-responsive">
				<table class="table table-hover" id="add-produk">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">category</th>
							<th scope="col">product_name</th>
							<th scope="col">price</th>
							<th scope="col">status</th>
							<th scope="col">action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=1; ?>
						<?php foreach($daftar_harga as $dh): ?>
						<tr>
					      <th><?php echo $i; ?></th>
					      <td><?php echo $dh['category']; ?></td>
					      <td><?php echo $dh['product_name']; ?></td>
					      <td><?php if(empty($dh['price'])){echo 0;}else{echo $dh['price'];}; ?></td>
					      <td>
					      	<?php 
					      		$st = $dh['buyer_product_status'];
					      		if ($st) {
					      		 	echo "<span class='badge badge-success'>Active<span>";
					      		 }else{
					      		 	echo "<span class='badge badge-danger'>Offline<span>";
					      		 } 
					      	?>
					      </td>
					      <td>
					      	<span class="badge badge-primary" data-toggle="modal" data-target="#addProduk" data-all='<?php echo json_encode($dh); ?>' >Add</span>
					      </td>
					    </tr>
					    <?php $i++; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<!-- Modal -->
<div class="modal fade" id="addProduk" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add New Produk</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('admin/server/addToProduk'); ?>" method="post">
                <div class="modal-body">
                	<div class="form-group">
                		<label>Category</label>
                		<select class="form-control text-dark" name="group_produk_id">
                			<?php foreach($group_produk as $gp): ?>
                			<option value="<?php echo $gp['id'] ?>"><?php echo $gp['group_name'] ?></option>
                			<?php endforeach; ?>
                		</select>
                	</div>
                	<div class="form-group">
                		<label>Server</label>
                		<select class="form-control text-dark" name="server_id">
                			<?php foreach($server as $s): ?>
                			<option value="<?php echo $s['id'] ?>"><?php echo $s['title'] ?></option>
                			<?php endforeach; ?>
                		</select>
                	</div>
                    <div class="form-group">
                    	<label>Name</label>
                        <input type="text" class="form-control text-dark" name="name" placeholder="Title">
                    </div>
                    <div class="form-group">
                    	<label>Brand</label>
                        <input type="text" class="form-control text-dark" name="brand" placeholder="Title">
                    </div>
                    <div class="form-group">
                    	<label>Trx_code</label>
                        <input type="text" class="form-control text-dark" name="trx_code" placeholder="Title">
                    </div>
                    <div class="form-group">
                    	<label>Price</label>
                        <input type="text" class="form-control text-dark" name="price" placeholder="Title">
                    </div>
                    <div class="form-group">
                    	<label>Status</label>
                        <input type="text" class="form-control text-dark" name="status" placeholder="Title">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div> 