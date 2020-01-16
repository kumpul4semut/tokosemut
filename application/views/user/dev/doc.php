<div class="content">
	<div class="row">
		<div class="col"> 
		    <div class="">
		      <p class="text-size-14">API (Application Programming Interface) adalah sekumpulan perintah, fungsi, dan protokol yang dapat digunakan oleh programmer saat membangun software, sehingga tercipta interkoneksi yang stabil dan cepat antar sistem.</p>
		      <br>
		<h2 class="text-size-25">Syarat dan ketentuan menggunakan API pulsa</h2>
		<ol class="text-size-14">
		<li>men-generate  <i style="color:#00C03F;font-style:italic;">token</i> Sebagai parameter utama saat transaksi untuk pengamanan tambahan transaksi.<br></li>
		<li>Response yang muncul dan yang dikirim berupa <i style="color:#00C03F;font-style:italic;">DATA JSON</i>. Sehingga sistem Anda harus sudah mendukung <i style="color:#00C03F;font-style:italic;">JSON</i>.<br></li>
		</ol>

		<br><br>
		<h3 class="text-size-25">Contoh Script API Untuk Pemrograman PHP dan Response yang Muncul</h3>
		<div id="accordion">
		    <div class="card-header" id="headingOne">
		      <h5 class="mb-0">
		        <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
		          #1 API request cek saldo
		        </button>
		      </h5>
		    </div>

		    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
		      <div class="card-body">
		        <pre>
				<code>
	$url = "https://api.tokosemut.com/api/connect";
	
	$header = [
		'Accept:application/json,'
	];
	
	$payload = [
		'token'		=> 'tokenanda', //
		'inquiry'	=> 'saldo',
	];

	$data = http_build_query($payload);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
	$exec = curl_exec ($ch);
	curl_close ($ch);
	echo $exec;
				</code>
			</pre>
		  </div>
		</div>
		<div id="accordion">
		    <div class="card-header" id="headingtwo">
		      <h5 class="mb-0">
		        <button class="btn btn-link" data-toggle="collapse" data-target="#collapsetwo" aria-expanded="true" aria-controls="collapsetwo">
		          #2 API request check list produk
		        </button>
		      </h5>
		    </div>

		    <div id="collapsetwo" class="collapse" aria-labelledby="headingtwo" data-parent="#accordion">
		      <div class="card-body">
		        <pre>
				<code>
	$url = "https://api.tokosemut.com/api/connect";
	
	$header = [
		'Accept:application/json,'
	];
	
	$payload = [
		'token'		=> 'tokenanda', //
		'inquiry'	=> 'produk',
	];

	$data = http_build_query($payload);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
	$exec = curl_exec ($ch);
	curl_close ($ch);
	echo $exec;
				</code>
			</pre>
		  </div>
		</div>
		<div id="accordion">
		    <div class="card-header" id="headingthree">
		      <h5 class="mb-0">
		        <button class="btn btn-link" data-toggle="collapse" data-target="#collapsethree" aria-expanded="true" aria-controls="collapsethree">
		          #3 API request beli produk
		        </button>
		      </h5>
		    </div>

		    <div id="collapsethree" class="collapse" aria-labelledby="headingthree" data-parent="#accordion">
		      <div class="card-body">
		        <pre>
				<code>
	$url = "https://api.tokosemut.com/api/connect";
	
	$header = [
		'Accept:application/json,'
	];
	
	$payload = [
		'token'			=> 'tokenanda', //
		'inquiry'		=> 'beli',
		'customer_no'		=> 087232422424, //nomor costumer / pembeli
		'produk_id'		=> 7  //id produk check di api produk list
	];

	$data = http_build_query($payload);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
	$exec = curl_exec ($ch);
	curl_close ($ch);
	echo $exec;

	//contoh respon jika request benar
	{
	    "status": true,
	    "message": "Pending", // respon => Sukses | Pending | Gagal
	    "trx_id":10 // id untuk cek status terupdate dari pembelian
	}
				</code>
			</pre>
		  </div>
		</div>
		<div id="accordion">
		    <div class="card-header" id="headingfour">
		      <h5 class="mb-0">
		        <button class="btn btn-link" data-toggle="collapse" data-target="#collapsefour" aria-expanded="true" aria-controls="collapsefour">
		          #4 API request cek transaksi
		        </button>
		      </h5>
		    </div>

		    <div id="collapsefour" class="collapse" aria-labelledby="headingfour" data-parent="#accordion">
		      <div class="card-body">
		        <pre>
				<code>
	$url = "https://api.tokosemut.com/api/connect";
	
	$header = [
		'Accept:application/json,'
	];
	
	$payload = [
		'token'			=> 'tokenanda', //
		'inquiry'		=> 'cektrx',
		'trx_id'		=> 7  //id trx check dari respon beli 
	];

	$data = http_build_query($payload);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
	$exec = curl_exec ($ch);
	curl_close ($ch);
	echo $exec;
				</code>
			</pre>
		  </div>
		</div>
	</div>
</div>