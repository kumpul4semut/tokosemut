<div class="content"> <!-- Content -->
	<div class="row"> <!-- row For header --> 
		<div class="col">
			<h1><?php echo urldecode($title); ?></h1>
			<div class="btn-group btn-group-toggle float-right">

			<?php foreach($group_produk as $gp): ?>		
	          <a 
	          	href="<?php 
	          			echo base_url('user/produk/select/'.$gp->group_name); 
	          		?>" 

	          	class="btn btn-sm btn-primary btn-simple group_produk <?php if(urldecode($title) == $gp->group_name){echo "active";} ?>" data-id-group="<?php echo ($gp->id); ?>" id="group"
	          	>
	            <input type="radio" checked="">
	            <span class=""><?php echo $gp->group_name; ?></span>
	          </a>
	        <?php endforeach; ?>
	        </div>
		</div>
	</div><!-- End row For header -->
	<div class="row"><!-- Row for list produk -->
		<div class="col">
			<div class="card-body all-icons">
                <div class="row">
                	<div class="col-md-4 pr-md-1">
                        <div class="form-group">
                          <label><?php echo $info_place[0]; ?></label>
                          <input type="number" class="form-control nomor" placeholder="<?php echo $info_place[1]; ?>" name="nomor">
                          <small class="text-primary" id="info-nomor"></small>
                        </div>
                        <div class="form-group" id="show">
                         
                        </div>
                        <button type="button" class="btn btn-sm btn-primary" id="beli-pulsa">Beli <i class="fa"></i></button>
                    </div>
            </div>
		</div>
		<div class="col-lg-6 mt-5 ">
              <div class="card-header bg-primary">
                <div class="btn btn-sm btn-success float-right" id="invoice-refresh">Refresh</div>
                <h6 class="title text-white mt-2">Log Trx</h6>
                <span id="saldo"></span>
              </div>
              <div class="card-body ">
                <div class="table-full-width table-responsive">
                  <table class="table">
                    <tbody id="show-log-invoice">
                      <!-- ajax load -->
                    </tbody>
                  </table>
                </div>

            </div>
          </div>
	</div><!-- End Row for list produk -->
</div> <!-- End Content -->