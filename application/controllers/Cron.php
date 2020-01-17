 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {

	private $token;


	function __construct(){
		parent::__construct();
		$this->token = 'rahasiasmt123';
		$get = $_GET['token'];
		if ($get !== $this->token) {
			show_404();
		}else{
			$this->load->library('Digiflazz');
			$this->load->library('ovo/Ovoload', '', 'ovo');
			$this->load->library('Newxl','','xl');
			$this->load->library('Xlcurl','','oxl');
			$this->load->model(array('Tbl_trx_produk', 'Tbl_invoice'));
		}
	}

	protected function setting()
	{
		return $this->db->get_where('general_setting', array('id' => 1, ))->row_array();
	}

	private function _accInvocie($id_invoice){
		#update done read and success deposit int tbl invoice
		#tambah saldo user sesuai nominal
		$user_id = (int)$this->Tbl_invoice->getById($id_invoice)->row()->user_id;
		$nominal = $this->Tbl_invoice->getById($id_invoice)->row()->nominal;
		$method_name = $this->Tbl_invoice->getById($id_invoice)->row()->method_name;
		$status = $this->Tbl_invoice->getById($id_invoice)->row()->status;
		$this->Tbl_invoice->updateAccept($id_invoice);
		# code...
		if ($method_name == 'Pulsa') {
			$nominal = (0.92 * $nominal);
		}
		$saldo_user = $this->Tbl_invoice->getById($id_invoice)->row()->saldo;
		$count =  (int)$nominal + (int)$saldo_user;
		$addSaldo = $this->addSaldoUser($user_id, $count);
		
	}

	private function addSaldoUser($user_id, $count)
	{
		$this->db->where('id', $user_id);
		$this->db->set('saldo', $count);
		return $this->db->update('user');
	}

	public function updateStatusTrx() {
		
		$this->data['statustrx'] = $this->db->select('trx_produk.*, group_produk.main_group_produk_id')
											->from('trx_produk')
											->join('produk', 'trx_produk.produk_id = produk.id')
											->join('group_produk', 'produk.group_produk_id = group_produk.id')
											// ->where_not_in('group_produk.main_group_produk_id', 2)
											->where('trx_produk.status', 'Pending')
											->get()->result();

		//looping trx_produk
		foreach ($this->data['statustrx'] as $d) {
			if ($d->main_group_produk_id == 1) {
				$trxid = $d->ref;
				$status = $d->status; 
				$nomor = $d->customer_no;
				//cek nomor tersebut sudah trx hari ini
				$count = $this->Tbl_trx_produk->checkCustomerNo($d->customer_no,$d->produk_id);
				if ($count !== 1){
					$nomor = ($count.'.'.$nomor);
				} 
				$rq = $this->digiflazz->getStatus($trxid, $nomor, $d->trx_code);
				$rqjson = json_decode($rq, true);
				$statusSRV = '';
				$ref_id = '';
				$sn = '';
				if (is_array($rqjson)) {
					# looping respon from the server
					foreach ($rqjson as $json) {
						$statusSRV = $json['status'];
						$ref_id = $json['ref_id'];
						$sn = $json['sn'];
					}
				}

				// awalnya pending akhirnya gagal maka save to refund
				if ($status == "Pending" AND $statusSRV == "Gagal") {

					$x = explode('-', $ref_id);
					$ref = $x[1];
					$dataRefund = [
						'user_id'	=> $d->user_id,
						'trxid'		=> $ref,
						'status_read' => 0
					];
					$this->db->select("*");
				    $this->db->from("refund");
				    $this->db->where($dataRefund); // will check row by column name in database
				    $result = $this->db->get();

				    if($result->num_rows() > 0){
				       // you data exist
				       return false;
				    } else {
				       // data not exist insert you information
						$this->db->insert('refund', $dataRefund);
				    }

				}elseif($status == "Pending" AND $statusSRV == "Sukses"){
					// update status to Sukses
					$dataSukses = [
						'sn'		=>$sn,
						'status' => $statusSRV
					];

					$this->db->where('id', $d->id);
					$this->db->update('trx_produk', $dataSukses);
				}
			}else{
				#pasca bayar
				$trxid = $d->ref;
				$status = $d->status; 
				$nomor = $d->customer_no;
				//cek nomor tersebut sudah trx hari ini
				$count = $this->Tbl_trx_produk->checkCustomerNo($d->customer_no,$d->produk_id);
				if ($count !== 1){
					$nomor = ($count.'.'.$nomor);
				} 
				$rq = $this->digiflazz->getStatus2($trxid, $nomor, $d->trx_code);
				$rqjson = json_decode($rq, true);
				$statusSRV = '';
				$ref_id = '';
				$sn = '';
				if (is_array($rqjson)) {
					# looping respon from the server
					foreach ($rqjson as $json) {
						$statusSRV = $json['status'];
						$ref_id = $json['ref_id'];
						$sn = $json['sn'];
					}
				}

				// awalnya pending akhirnya gagal maka save to refund
				if ($status == "Pending" AND $statusSRV == "Gagal") {

					$x = explode('-', $ref_id);
					$ref = $x[1];
					$dataRefund = [
						'user_id'	=> $d->user_id,
						'trxid'		=> $ref,
						'status_read' => 0
					];
					$this->db->select("*");
				    $this->db->from("refund");
				    $this->db->where($dataRefund); // will check row by column name in database
				    $result = $this->db->get();

				    if($result->num_rows() > 0){
				       // you data exist
				       return false;
				    } else {
				       // data not exist insert you information
						$this->db->insert('refund', $dataRefund);
				    }

				}elseif($status == "Pending" AND $statusSRV == "Sukses"){
					// update status to Sukses
					$dataSukses = [
						'sn'		=>$sn,
						'status' => $statusSRV
					];

					$this->db->where('id', $d->id);
					$this->db->update('trx_produk', $dataSukses);
				}
				
			}
		}
	}

	public function timeoutDepo(){
		$invoice = $this->db->get_where('invoice', ['status_read' => 0])->result();
		foreach ($invoice as $i) {
			$create = date('Y-m-d H:i:s', $i->created_on);
			$expired = date('Y-m-d H:i:s', strtotime('+12 hours', strtotime($create)));

			$date = new DateTime($expired);
			$now = new DateTime();

			//get yang masih aktif watu deponya
			$status = ($date <= $now);

			//ini udah lewat
			if ($status) {
			 	//update done read invoice
			 	$this->db->where('id', $i->id);
			 	$this->db->set('status_read', 1);
			 	$this->db->set('expired_on', '');
			 	$this->db->set('status_server', 0);
			 	$this->db->update('invoice');
			 }
		}

	}


	public function refreshPrice() {
		$this->load->library('Digiflazz');

		$listSRV = json_decode($this->digiflazz->getListHarga('prepaid'), true)['data'];
		// looping list from SRV
		foreach ($listSRV as $list) {
			$this->_updateProduk($list['buyer_sku_code'], $list['price']);
		}
	}

	private function _updateProduk($buyer_sku_code, $new_price){		
		$price = ($new_price + $this->setting()['laba']);
		
		$this->db->set('price', $price);
		$this->db->where('trx_code', $buyer_sku_code);
		return $this->db->update('produk');
	}

	public function invoice(){
		$invoicePending = $this->db->select('invoice.*, deposit.deposit_method_id, deposit.name')
									->from('invoice')
									->join('deposit', 'invoice.deposit_id = deposit.id')
									->where('status_server', 1)
									->get();

		foreach ($invoicePending->result() as $inv) {
			if ($inv->name == 'BRI'){

				$this->_accBri($inv->nominal, $inv->id);

			}elseif($inv->name == 'OVO'){

				$this->_accOvo($inv->nominal, $inv->id);

			}elseif($inv->name == 'XL'){

				$cek = $this->_accOXl($inv->nominal, $inv->from_sended, $inv->id);

			}
		}
	}

	private function _accBri($nominal, $id){

		$exec = json_decode( file_get_contents('https://mutasi.kumpul4semut.com/mutasi-bri/hasil_mutasi.json'), true);
		if (empty($exec)) {
			return false;
		}else{
			# bri cek
			foreach ($exec as $datMutasi) {
				# cek ini nominal sama gak dg yang masuk
				if ($nominal == $datMutasi['masuk']) {
					$this->_accInvocie($id);
				}else{
					print_r($datMutasi);
				}
			}
		}		
	} 

	private function _accOvo($nominal, $id){

		$exec = $this->ovo->getWalletTransaction(1);

		if (empty($exec)) {
			return false;
		}else{
			# ovo cek
			foreach ($exec as $datMutasi) {
				#cek ini nominal sama gak dg yang masuk
				if ($nominal == $datMutasi['emoney_topup']) {
					$this->_accInvocie($id);
				}else{
					print_r($datMutasi);
				}
			}
		}
	} 
	
	private function _accXl($nominal, $sended, $id){

		$exec = $this->xl->mutasi();
		if (empty($exec)) {
			return false;
		}else{
			# XL cek
			foreach ($exec as $datMutasi) {
				#cek ini nominal dan pengirim sama gak dg yang masuk
				if ($nominal == $datMutasi['amount'] && $sended == $datMutasi['destMsisdn']) {
					$this->_accInvocie($id);
				}else{
					print_r($datMutasi);
				}
			}
		}
	}

	private function _accOXl($nominal, $sended, $id){
		$exec = $this->oxl->mutasi();
		if (empty($exec)) {
			return false;
		}else{
			# OXL cek
			foreach ($exec as $datMutasi) {
				#cek ini nominal dan pengirim sama gak dg yang masuk
				if ($nominal == $datMutasi['amount'] && $sended == $datMutasi['from']) {
					$this->_accInvocie($id);
				}else{
					print_r($datMutasi);
				}
			}
		}
		
	}

	public function refund(){
		#looping
		foreach ($this->_getIsRefund()->result() as $refund) {
			$this->_accRefund($refund->id);
		}
		
	}

	private function _getIsRefund(){
		return $this->db->where('status_read', 0)
					 ->get('refund');
	}

	private function _accRefund($id){
		$this->db->select('refund.id,refund.user_id, user.email, produk.name, produk.price');
		$this->db->from('refund');
		$this->db->join('user', 'refund.user_id = user.id');
		$this->db->join('trx_produk', 'refund.trxid = trx_produk.id');
		$this->db->join('produk', 'trx_produk.produk_id = produk.id');
		$this->db->where('refund.id', $id);
        
        $getRefund = $this->db->get()->row();

		$price = $getRefund->price;
		$useId = $getRefund->user_id;

		$exec = $this->plusUserSaldo($useId, $price);
		if ($exec) {
			// update refund to done read
			$this->db->set('status_read', 1);
			$this->db->where('id', $id);
			$this->db->update('refund');

			//update trx_produk to gagal
			$idtrx = $this->db->get_where('refund', ['id' => $id])->row()->trxid;
			$this->db->set('status', 'Gagal');
			$this->db->where('trx_produk.id', $idtrx);
			$this->db->update('trx_produk');

		}
	}

	protected function plusUserSaldo($user_id, $berapa) {
		$nowUserSaldo = $this->db->get_where('user', ['id' => $user_id])->row()->saldo;
		$count = ($nowUserSaldo + $berapa);

		return $this->addSaldoUser($user_id, $count);
	}

	public function addproduk(){
		print_r(json_decode($this->digiflazz->getListHarga('prepaid'), true)['data']);
	}

	public function cek(){
	  print_r($this->oxl->mutasi());
	}




}

/* End of file Cron.php */
/* Location: ./application/controllers/Cron.php */