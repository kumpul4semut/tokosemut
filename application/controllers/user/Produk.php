<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Produk user controller
 */
class Produk extends User_Controller
{
	
	function __construct(){
		parent::__construct();
		$this->load->library(array('portal', 'Digiflazz'));
	}
	
	public function index(){
		$this->data['title'] = 'Produk';
		$this->data['main_produk'] = $this->Tbl_main_produk->getAll();
		$this->template->user_render('user/produk/main','user/_templates/footer', $this->data);
	}

	public function select($type = "Pulsa"){
		if (empty($type)) {
			show_404();
		}
		$cek = $this->db->get_where('group_produk', ['group_name' => urldecode($type)]);
		$main_group_produk = $cek->row()->main_group_produk_id;
		if ($cek->num_rows() > 0) {
			$this->data['title'] = $type;
			$this->data['group_produk'] = $this->Tbl_produk->getGroup($main_group_produk)->result();
			if ($cek->row()->group_name == 'Pulsa' || $cek->row()->group_name == 'Paket Data') 
			{
				$this->data['info_place'] = ['Masukan Nomor', '08xx'];
			}else{
				$this->data['info_place'] = ['Nomor '.$cek->row()->group_name, ''];
			}
			$this->template->user_render('user/produk/index','user/_templates/footer-produk', $this->data);
		}else{
			show_404();
		}
	}

	public function getProduk()
	{
		$id_group=$this->input->post('group_id');
		$produk = $this->Tbl_produk->getProduk($id_group)->result_array();
		echo json_encode($produk);

	}


	public function valid()
	{
		$nomor = $this->input->post('nomor');
		$idGroup = $this->input->post('idGroup');
		$mainGroup = $this->db->get_where('group_produk', ['id' => $idGroup])->row()->main_group_produk_id;
		if ($mainGroup == 2) {
			# ini pasca bayar cek dulu harganya baru psuh beli
			$this->form_validation->set_rules('nomor', 'Nomor', 'trim|required|numeric');
			if ($this->form_validation->run() == FALSE) {
				$data=[0 => ['code' => 0,'brand'=>validation_errors()] ];
				
				echo json_encode($data);
			} else {
				$data = $this->Tbl_produk->getBYBrand(null, $idGroup)->result_array();
				if ($data) {
					echo json_encode($data);
				}else{
					$data=[0 => ['code' => 0,'brand'=>'Unknow Group Produk'] ];
					echo json_encode($data);
				}
			}
		}else{
			if ($idGroup == 2 || $idGroup == 3) {
				# Ini pulsa dan paket data atau prabayar
				$valid_nomor = substr($nomor, 0,2);

				//validasi awalan use 08
				if ($valid_nomor == "08") {
					$valid_nomor2 = substr($nomor, 0,4);

					//db sub_pulsa
					// $data = $this->db->get('sub_pulsa')->result();

					if ($valid_nomor2 == "0817" OR 
						$valid_nomor2 == "0818" OR 
						$valid_nomor2 == "0819" OR 
						$valid_nomor2 == "0859" OR 
						$valid_nomor2 == "0877" OR 
						$valid_nomor2 == "0878") {
						//validasi is nomor xl
						$param = 'XL';
						$data = $this->Tbl_produk->getBYBrand($param, $idGroup)->result_array();
						echo json_encode($data);
					}elseif ($valid_nomor2 == "0838" OR
							 $valid_nomor2 == "0831" OR
							 $valid_nomor2 == "0832" OR
							 $valid_nomor2 == "0833" ) {
						//validasi is nomor Axis
						$param = 'AXIS';
						$data = $this->Tbl_produk->getBYBrand($param, $idGroup)->result_array();
						echo json_encode($data);
					}elseif ($valid_nomor2 == "0811" OR
							 $valid_nomor2 == "0812" OR
							 $valid_nomor2 == "0813" OR
							 $valid_nomor2 == "0821" OR
							 $valid_nomor2 == "0822" OR
							 $valid_nomor2 == "0823" OR
							 $valid_nomor2 == "0852" OR
							 $valid_nomor2 == "0851" OR
							 $valid_nomor2 == "0853") {
						//validasi is nomor telkomsel
						$param = 'TELKOMSEL';
						$data = $this->Tbl_produk->getBYBrand($param, $idGroup)->result_array();
						echo json_encode($data);
					}elseif ($valid_nomor2 == "0855" OR
							 $valid_nomor2 == "0856" OR
							 $valid_nomor2 == "0857" OR
							 $valid_nomor2 == "0858" OR
							 $valid_nomor2 == "0814" OR
							 $valid_nomor2 == "0815" OR
							 $valid_nomor2 == "0816" ) {
						//validasi is nomor Indosat
						$param = 'INDOSAT';
						$data = $this->Tbl_produk->getBYBrand($param, $idGroup)->result_array();
						echo json_encode($data);
					}elseif ($valid_nomor2 == "0881" OR
							 $valid_nomor2 == "0882" OR
							 $valid_nomor2 == "0883" OR
							 $valid_nomor2 == "0884" OR
							 $valid_nomor2 == "0887" OR
							 $valid_nomor2 == "0888" OR
							 $valid_nomor2 == "0889" ) {
						//validasi is nomor smartfren
						$param = 'SMARTFREN';
						$data = $this->Tbl_produk->getBYBrand($param, $idGroup)->result_array();
						echo json_encode($data);
					}elseif ($valid_nomor2 == "0896" OR
							 $valid_nomor2 == "0897" OR
							 $valid_nomor2 == "0898" OR
							 $valid_nomor2 == "0899" ) {
						//validasi is nomor tri
						$param = 'TRI';
						$data = $this->Tbl_produk->getBYBrand($param, $idGroup)->result_array();
						echo json_encode($data);
					}else{
						$data=[0 => ['code' => 0,'brand'=>'Undifine Nomor'] ];
						echo json_encode($data);
					}
				}else{
						$data=[0 => ['code' => 0,'brand'=>'Please Input Valid Nomor'] ];
						echo json_encode($data);
				}
			}else{
				// get by group
				$this->form_validation->set_rules('nomor', 'Nomor', 'trim|required|numeric');
				if ($this->form_validation->run() == FALSE) {
					$data=[0 => ['code' => 0,'brand'=>validation_errors()] ];
					
					echo json_encode($data);
				} else {
					$data = $this->Tbl_produk->getBYBrand(null, $idGroup)->result_array();
					if ($data) {
						echo json_encode($data);
					}else{
						$data=[0 => ['code' => 0,'brand'=>'Unknow Group Produk'] ];
						echo json_encode($data);
					}
				}

			}
		}
	}

	private function _valid($idGroup, $nomor)
	{
		$trueIdGroup = $this->db->get_where('group_produk', ['id' => $idGroup])->num_rows();

		if ($idGroup == 2 || $idGroup == 3) {
			$valid_nomor = substr($nomor, 0,2);

			//validasi awalan use 08
			if ($valid_nomor == "08") {
				$valid_nomor2 = substr($nomor, 0,4);

				//db sub_pulsa
				// $data = $this->db->get('sub_pulsa')->result();

				if ($valid_nomor2 == "0817" OR 
					$valid_nomor2 == "0818" OR 
					$valid_nomor2 == "0819" OR 
					$valid_nomor2 == "0859" OR 
					$valid_nomor2 == "0877" OR 
					$valid_nomor2 == "0878") {
					//validasi is nomor xl
					return true;
				}elseif ($valid_nomor2 == "0838" OR
						 $valid_nomor2 == "0831" OR
						 $valid_nomor2 == "0832" OR
						 $valid_nomor2 == "0833" ) {
					//validasi is nomor Axis
					
					return true;
				}elseif ($valid_nomor2 == "0811" OR
						 $valid_nomor2 == "0812" OR
						 $valid_nomor2 == "0813" OR
						 $valid_nomor2 == "0821" OR
						 $valid_nomor2 == "0822" OR
						 $valid_nomor2 == "0823" OR
						 $valid_nomor2 == "0852" OR
						 $valid_nomor2 == "0851" OR
						 $valid_nomor2 == "0853") {
					//validasi is nomor telkomsel
					
					return true;
				}elseif ($valid_nomor2 == "0855" OR
						 $valid_nomor2 == "0856" OR
						 $valid_nomor2 == "0857" OR
						 $valid_nomor2 == "0858" OR
						 $valid_nomor2 == "0814" OR
						 $valid_nomor2 == "0815" OR
						 $valid_nomor2 == "0816" ) {
					//validasi is nomor Indosat
					
					return true;
				}elseif ($valid_nomor2 == "0881" OR
						 $valid_nomor2 == "0882" OR
						 $valid_nomor2 == "0883" OR
						 $valid_nomor2 == "0884" OR
						 $valid_nomor2 == "0887" OR
						 $valid_nomor2 == "0888" OR
						 $valid_nomor2 == "0889" ) {
					//validasi is nomor smartfren
					
					return true;
				}elseif ($valid_nomor2 == "0896" OR
						 $valid_nomor2 == "0897" OR
						 $valid_nomor2 == "0898" OR
						 $valid_nomor2 == "0899" ) {
					//validasi is nomor tri
					
					return true;
				}else{
					return false;
				}
			}else{
					return false;
			}
		}elseif($trueIdGroup > 0 ){
			return true;
		}else{
			return false;
		}
	}

	public function getTypePulsa()
	{
		$type = $this->input->post('title');
		$query = $this->db->get_where('portal_pulsa', ['provider' => $type])->result_array();
		echo json_encode($query);
    	
	}

	public function purchase()
	{
		$idGroup = $this->input->post('idGroup'); 
		$inputs = $this->input->post('datas', true);
		$nomor  = $this->input->post('nomor');
		$mainGroup = $this->db->get_where('group_produk', ['id' => $idGroup])->row()->main_group_produk_id;

		if ($mainGroup == 2) {
			# pasca bayar mode
			$this->_purchasePasca($inputs, $nomor);
		}else{
			$cek = $this->_valid($idGroup, $nomor);
			if ($inputs == '') {
				$data=[
					'message'=>'Nomor Kosong',
					'code'=>0
				];
				echo json_encode($data);
			}else{

				//validasi input nomor
				if ($cek == false) {
					$data=[
						'message'=>'Not Valid',
						'code'=>0
					];
					echo json_encode($data);
				}else{
					//ambil produk
					$query = $this->db->get_where('produk', ['id' => $inputs])->row();

					$trx_code = $query->trx_code;
					$price = $query->price;
									
					$saldoUser = $this->email_login->saldo;

					if ($saldoUser <= 0) {
						# saldo kosong
						$data=[
							'message'=>"Silahkan Depostit",
							'code'=>0
						];
						echo json_encode($data);
					}else{

						#saldo user tidak mencukupi
						if($saldoUser < $price){
							$data=[
								'message'=>"saldo tidak cukup",
								'code'=>0
							];
							echo json_encode($data);
						}else{

							//save to trx produk
													
							$data = [
								'produk_id'		=> $query->id,
								'user_id'		=> $this->email_login->id,
								'customer_no'	=> $nomor,
								'trx_code'		=> $trx_code,
								'created_on'	=> time(),
								'status'		=> 0
							];

							$saveTrx = $this->db->insert('trx_produk', $data);

							$trxid =  $this->db->insert_id(); //ambil id trx barusan

							//cek nomor tersebut sudah trx hari ini
							$count = $this->Tbl_trx_produk->checkCustomerNo($nomor, $query->id);
							if ($count > 1){
								$nomor = ($count.'.'.$nomor);
							}
							//lalu jaidkan id tersebut trx id to server
							$trxid = date('Ymdhis', time() ).'-'.$trxid;
							$rq = $this->digiflazz->getTopUp($trxid, $nomor, $trx_code);

							$jsonRQ = json_decode($rq, true);
							$status = $jsonRQ['data']['status'];

							//status gagal
							if ($status == "Gagal") {
								
								$idtrx = explode('-', $trxid)[1];
	                    		$this->db->where('id', $idtrx);
								$this->db->delete('trx_produk');
								
								$data=[
										'message'=>$jsonRQ['data']['message'],
										'code'=>0
								];
								echo json_encode($data);
							}else{
								$query = $this->db->get_where('produk', ['id' => $inputs])->row();
								$price = $query->price;
								$saldoUser = $this->email_login->saldo;
								//potong saldo
								$count =  ($saldoUser - $price);
								$this->updateSaldoUser($this->email_login->id, $count);

								//update status after purchase to server
								$trxidX = explode('-', $trxid);
								$trxidY = $trxidX[1];
								$dataU = [
									'sn'		=> $jsonRQ['data']['sn'],
									'status'	=> $jsonRQ['data']['status'],
									'ref'		=> $trxid
								];
								$this->db->where('trx_produk.id', $trxidY);
								$this->db->update('trx_produk', $dataU);


								
								$data=[
									'message'=> "Pembelian sedang diproses",
									'code'=>1
								];
								echo json_encode($data);

							}
							
						}
						

					}
				}
			}
		}


	}

	private function _purchasePasca($inputs, $nomor){
		# ambil produk
		$query = $this->db->get_where('produk', ['id' => $inputs])->row();

		$trx_code = $query->trx_code;
		#get trxid
		//save to trx produk
												
		$data = [
			'produk_id'		=> $query->id,
			'user_id'		=> $this->email_login->id,
			'customer_no'	=> $nomor,
			'trx_code'		=> $trx_code,
			'created_on'	=> time(),
			'status'		=> 'Pending'
		];

		$saveTrx = $this->db->insert('trx_produk', $data);

		$trxid =  $this->db->insert_id(); //ambil id trx barusan

		//lalu jaidkan id tersebut trx id to server
		$trxid = date('Ymdhis', time() ).'-'.$trxid;
		
		# Rq check to server
		$rqCheck = $this->digiflazz->getTopUpPasca($trxid, $nomor, $trx_code, 'inq-pasca');

		$jsonRQ = json_decode($rqCheck, true);
		$status = $jsonRQ['data']['status'];

		//status gagal
		if ($status == "Gagal") {
			
			$idtrx = explode('-', $trxid)[1];
    		$this->db->where('id', $idtrx);
			$this->db->delete('trx_produk');
			
			$data=[
					'message'=>$jsonRQ['data']['message'],
					'code'=>0
			];
			echo json_encode($data);
		}else{
			# Update trx_produk == trx_price use respon rq server check price
			$trxidX = explode('-', $trxid);
			$trxidY = $trxidX[1];
			$dataU = [
				'trx_price'	=> ($jsonRQ['data']['price'] + 1000),
				'customer_name'	=> $jsonRQ['data']['customer_name'],
				'ref'		=> $trxid
			];
			$this->db->where('trx_produk.id', $trxidY);
			$this->db->update('trx_produk', $dataU);
			$data=[
				'message'=> "Pembelian sedang diproses",
				'code'=>1
			];
			echo json_encode($data);

		}
	}

	public function payPasca(){
		
		#get data from post ajax to tbl trx_produk
		$id_trx_produk = $this->input->post('id_trx_produk');
		$dataTrx = $this->db->get_where('trx_produk', ['id' => $id_trx_produk])->row();

		#data from tbl trx_produk
		$trxid 		= $dataTrx->ref;
		$nomor 		= $dataTrx->customer_no;
		$trx_code 	= $dataTrx->trx_code;
		$price 		= $dataTrx->trx_price;

		#jika saldo kurang
		if($this->email_login->saldo < $price){

			$data=[
				'message'=>"saldo tidak cukup",
				'code'=>0
			];
			echo json_encode($data);

		}else{

			# Rq pay pasca to server
			$rqPay = $this->digiflazz->getTopUpPasca($trxid, $nomor, $trx_code, 'pay-pasca');

			$jsonRQ = json_decode($rqPay, true);
			$status = $jsonRQ['data']['status'];

			//status gagal
			if ($status == "Gagal") {

				$data=[
						'message'=>"Pembayaran Gagal",
						'code'=>0
				];
				echo json_encode($data);

			}else{

				//potong saldo
				$count = ($this->email_login->saldo - $price);
				$this->updateSaldoUser($this->email_login->id, $count);

				//update status after purchase to server
				$trxidX = explode('-', $trxid);
				$trxidY = $trxidX[1];
				$dataU = [
					'sn'		=> $jsonRQ['data']['sn'],
					'status'	=> $jsonRQ['data']['status']
				];
				$this->db->where('trx_produk.id', $trxidY);
				$this->db->update('trx_produk', $dataU);
				
				$data=[
					'message'=> "Pembelian sedang diproses",
					'code'=>1
				];
				echo json_encode($data);

			}

		}

	}

	private function _htmlstatus($respon) {
		switch ($respon) {
			case 'Sukses':
				return '<td class="badge badge-success mt-3"><h6 class="text-white text-center mt-4">Sukses</h6></td>';
				break;
			case 'Gagal':
				return '<td class="badge badge-danger mt-3"><h6 class="text-white text-center mt-4">Gagal</h6></td>';
				break;
			case 'Pending':
				return '<td class="badge badge-warning mt-3"><h6 class="text-white text-center mt-4">Pending</h6></td>';
				break;
			
			default:
				return 'unknown status';
				break;
		}
	}

	public function getStatusTrx() {
		$this->_getStatusTrx();
		// model get trx_produk by user
		$id_user = $this->email_login->id;
		$this->result= $this->Tbl_trx_produk->getByUser($id_user)->result();
		foreach ($this->result as $key => $value) {
			if ($value->price == 0) {
				$this->result[$key]->price = $value->trx_price;
				if ($value->status == "Pending") {
					$this->result[$key]->pasca = true;
				}else{
					$this->result[$key]->pasca = false;
				}
			}else{
				$this->result[$key]->pasca = false;
			}
			$this->result[$key]->status = $this->_htmlstatus($value->status);
			$this->result[$key]->created_on = date('Y-m-d H:i:s',$value->created_on);
		}
		if (empty($this->result)) {
			$array = ['code' => 0, 'message' => 'No Data Transaksi'];
			echo json_encode($array);
		}else{
			echo json_encode($this->result);
		}

		
		
	}

	private function _getStatusTrx() {
		
		// model get trx_produk by user
		$id = $this->email_login->id;
		$this->data['statustrx'] = $this->db->select('trx_produk.*')
											->from('trx_produk')
											->join('produk', 'trx_produk.produk_id = produk.id')
											->join('group_produk', 'produk.group_produk_id = group_produk.id')
											->where_not_in('group_produk.main_group_produk_id', 2)
											->where('trx_produk.user_id', $id)
											->get()->result();
		//looping trx_produk
		foreach ($this->data['statustrx'] as $d) {
			$trxid = $d->ref;
			$status = $d->status;
			$nomor = $d->customer_no;
			//cek nomor tersebut sudah trx hari ini
			$count = $this->Tbl_trx_produk->checkCustomerNo($d->customer_no, $d->produk_id);
			if ($count > 1){
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
					'user_id'	=> $this->email_login->id,
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