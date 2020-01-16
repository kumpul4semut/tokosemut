<div class="container">
	<div class="row">
		<div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2 d-flex justify-content-center">
            <div class="section-heading text-center">
                <h2>Daftar Produk</h2>
                <ul class="nav nav-pills text-center"">
                <?php foreach($group as $g): ?>
				  <li class="nav-item px-4">
				    <a href="<?php echo base_url('produk/'.$g['id']); ?>" class="nav-link badge badge-primary text-white"><?php echo $g['group_name']; ?></a>
				  </li>
				<?php endforeach; ?>				  
				</ul>
				</div>
            </div>
        </div>
        <div class="col-lg-6 offset-lg-3 col-md-8 offset-md-2">
           <div class="table-responsive">
           	<table class="table table-hover">
           		<tr>
           			<th>#</th>
           			<th>Name</th>
           			<th>Price</th>
           			<th>Status</th>
           		</tr>
           			<?php $i=1; ?>
           			<?php foreach($produk as $p): ?>
	           		<tr>
	           			<td><?php echo $i; ?></td>
	           			<td><?php echo $p->name; ?></td>
	           			<td><?php echo $p->price; ?></td>
	           			<td><?php if ($p->status == 'true') {
	           				echo '<span class="badge badge-success">True</span>';
	           			}else{echo '<span class="badge badge-danger">False</span>';} ?></td>
						<?php $i++; ?>
	           		</tr>
					<?php endforeach; ?>           		
           	</table>
           </div>
        </div>
	</div>