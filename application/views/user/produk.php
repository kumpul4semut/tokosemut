<div class="content"> <!-- Content -->
	<div class="row"> <!-- row For header --> 
		<div class="col">
			<h1>Produk</h1>
			<div class="btn-group btn-group-toggle float-right" data-toggle="buttons">

			<?php foreach($group_produk as $gp): ?>		
	          <label class="btn btn-sm btn-primary btn-simple group_produk <?php if($title == $gp->group_name){echo "active";} ?>" data-id-group="<?php echo ($gp->id); ?>" >
	            <input type="radio" checked="">
	            <span class="" <?php if($title == $gp->group_name){echo "checked";} ?>><?php echo $gp->group_name; ?></span>
	          </label>
	        <?php endforeach; ?>
	        </div>
		</div>
	</div><!-- End row For header -->
	<div class="row"><!-- Row for list produk -->
		<div class="col">
			<div class="card-body all-icons">
                <div class="row" id="show_data">
                
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