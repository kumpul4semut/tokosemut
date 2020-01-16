<div class="content"> <!-- Content -->
	<div class="row">
    <div class="col-lg">
      <div class="alert alert-info alert-with-icon" data-notify="container">
        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
          <i class="tim-icons icon-simple-remove"></i>
        </button>
        <span data-notify="icon" class="tim-icons icon-bell-55"></span>
        <span data-notify="message">
          <h2 class="text-white">Cara Deposit</h2>
          Segera Lakukan Pembanyaran Sesuai Nominal Tercantum. Deposit Otomatis Masuk Setelah Melakukan Pembanyaran. Waktu Maximal Pembayaran 12 Jam.
        </span>
      </div>
      <div class="alert alert-danger alert-with-icon" data-notify="container">
        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
          <i class="tim-icons icon-simple-remove"></i>
        </button>
        <span data-notify="icon" class="tim-icons icon-bell-55"></span>
        <span data-notify="message">
        <h2 class="text-white">Penting</h2>
        Deposit menggunkan pulsa kena rate 0.92 jika menggunkan pulsa.
        </span>
      </div>
    </div>
    </div> <!-- row For header --> 
		<div class="col-lg">
			<h1>Deposit</h1>
			<div class="form-group">
        <label>Nominal</label>
        <input type="text" class="form-control" placeholder="Masukan Nominal" name="nominal" id="nominal">
        <small class="text-primary" id="info-nominal"></small>
      </div>
      <div class="form-group">
        <label>Metode</label>
        <select class="form-control" id="method_deposit" name="method_deposit">
        <option selected="">Pilih..</option>
        <?php foreach($method_deposit as $md): ?>
        <option methodDepo-id="<?php echo $md->id; ?>" class="bg-success"><?php echo $md->method_name; ?></option>
        <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group" id="show-deposit">
        <!-- deposit load -->
      </div>
      <div class="form-group" id="show-go-deposit">
        <!-- load if pulsa -->
      </div>
      <div id="load-depo" class="mt-2 " style="display: none;"><img src="<?= base_url('assets/load/load4.gif'); ?>"></div>
    </div>

		<div class="col-lg mt-5">
        <div class="card-header bg-primary">
            <button type="button" class="title btn btn-info btn-sm float-right" data-toggle="modal" data-target="#info-deposit">
            Info
          </button>
          <h6 class="title text-white">Log Invoice</h6>
          <span class="badge badge-warning" id="cek"></span>
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


