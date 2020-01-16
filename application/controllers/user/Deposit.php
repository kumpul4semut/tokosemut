<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Deposit controller user
 * @author kumpul4semut
 * 3 agustus 2019
 */
class Deposit extends User_Controller
{

	private $minimum_depo;

	private $maximum_depo;

	/**
	*---------
	*Construct
	*---------
	*/
	function __construct()
	{
		parent::__construct();

		//data setting general
		$data = $this->General_setting->get()->row_array();

		//inisial property
		$this->minimum_depo = $data['minimum_deposit'];
		$this->maximum_depo = $data['maximum_deposit'];
		$this->data['title'] = 'Deposit';
	}

	/**
	*------------------
	* load view deposit
	*------------------
	*/
	public function index()
	{
		$this->data['method_deposit'] = $this->db->get('deposit_method')->result();
		$this->template->user_render('user/deposit', 'user/_templates/footer-deposit', $this->data);
	}

	/*
	*------------------------
	* Get JSON Method Deposit
	*------------------------
	*/
	public function getDeposit()
	{
		$id_method = $this->input->post('id_method');
		$data = $this->db->get_where('deposit', ['deposit_method_id' => $id_method])->result_array();
		echo json_encode($data);
	}

	/*
	*--------------------
	* Get Invoice deposit
	*--------------------
	*/
	public function invoice()
	{
		$this->data['title'] = 'Deposit';
		$this->template->user_render('user/detail_invoice','user/_templates/footer-deposit', $this->data);
	}

	/*
	*------------------------
	* Validator keyup nominal
	*------------------------
	*/
	public function valid_nominal(){

		$this->form_validation->set_rules('nominal', 'Nominal', 'required|trim|numeric');
		if ($this->form_validation->run() == false) {
			$message = validation_errors();
			$data = [
				'response'=>[
					'code'=>0,
					'message'=>$message
				]
			];
			echo json_encode($data);
		}else{
			$nominal = $this->input->post('nominal');
			$minimum_depo = $this->minimum_depo;

			if ($nominal < $minimum_depo) {
				$message = "Minimun Deposit is ".$minimum_depo;
				$data = [
					'response'=>[
						'code'=>1,
						'message'=>$message
					]
				];
				echo json_encode($data);
			}else{

				$maximum_depo = $this->maximum_depo;
				if ($nominal > $maximum_depo ) {
					$message = "Maximum Deposit is ".$maximum_depo;
					$data = [
						'response'=>[
							'code'=>1,
							'message'=>$message
						]
					];
					echo json_encode($data);
				}else{
					$validNom = substr($nominal,-3);
					if ($validNom != 000) {
						$message = "Nominal Harus Kelipatan 1000";
						$data = [
							'response'=>[
								'code'=>1,
								'message'=>$message
							]
						];
						echo json_encode($data);
					}else{
					$message = "Benar";
					$data = [
						'response'=>[
							'code'=>2,
							'message'=>$message
						]
					];
					echo json_encode($data);
					}
				}		
				
			}	
		}
	}

	/**
	*-----------------------
	* Validator back nominal
	*-----------------------
	* @param nominal ajax goDeposit
	*/
	Private function _valid_nominal($nominal_func){

		$this->form_validation->set_rules('nominal', 'Nominal', 'required|trim|numeric');
		if ($this->form_validation->run() == false) {
			$message = validation_errors();
			$data = [
				'response'=>[
					'code'=>0,
					'message'=>$message
				]
			];
			return json_encode($data);
		}else{
			$nominal = $nominal_func;
			$minimum_depo = $this->minimum_depo;
			if ($nominal < $minimum_depo) {
				$message = "Minimun Deposit is ".$minimum_depo;
				$data = [
					'response'=>[
						'code'=>1,
						'message'=>$message
					]
				];
				return json_encode($data);
			}else{
				$maximum_depo = $this->maximum_depo;
				if ($nominal > $maximum_depo ) {
					$message = "Maximum Deposit is ".$maximum_depo;
					$data = [
						'response'=>[
							'code'=>1,
							'message'=>$message
						]
					];
					return json_encode($data);
				}else{
					$validNom = substr($nominal,-3);
					if ($validNom != 000) {
						$message = "Nominal Harus Kelipatan 1000";
						$data = [
							'response'=>[
								'code'=>1,
								'message'=>$message
							]
						];
						echo json_encode($data);
					}else{
					$message = "true";
					$data = [
						'response'=>[
							'code'=>2,
							'message'=>$message
						]
					];
					return (json_encode($data));
					}
				}		
			}
		}
	}

	/*
	*-------------------
	*goDeposit User Method
	*-------------------
	*/
	public function goDeposit()
	{
		$nominal_func = $this->input->post('nominal', true);
		$id_deposit = $this->input->post('id', true);
		$fromSend = $this->input->post('pulsaFrom');
		$valid = $this->_valid_nominal($nominal_func);
		$ok_valid = json_decode($valid);

		//cek is valid nominal
		if($ok_valid->response->code == 2){
			//cek id deposit
			$cekIdDepo = $this->Tbl_deposit->getById($id_deposit)->num_rows();
			if ($cekIdDepo) {
				//data deposit
				$dataDepo= $this->Tbl_deposit->getByIdJoin($id_deposit)->row();
				
				//data save to deposit_invoice
				$invoice_type_id = $dataDepo->invoice_type_id;
				$depoId	= $dataDepo->id;
				$userId = $this->email_login->id;
				$methodName = $dataDepo->method_name;
				$creatInvoice = time();
				$statusDefault = 0;


				//message deposit invoice saldo unik jika pakai bank
				if ($methodName == "Bank" || $methodName == "Ovo") {
					$rand = substr(str_shuffle("123456789"), 0, 3);
					$depo_saldo = ($nominal_func + $rand);
				 }else{
				 	$depo_saldo = $nominal_func;
				 }
				// cek user masih punya invoice deposit gak sebelumnya
				$data_check_user_have_pending = $this->Tbl_invoice->checkHavePending($userId)->num_rows();
				// cek user masih punya invoice deposit gak sebelumnya
				$data_check_user_have_check = $this->Tbl_invoice->checkHaveCheck($userId)->num_rows();
				if ($data_check_user_have_pending > 0 || $data_check_user_have_check > 0 ) {
				 	$message = "Anda Masih Punya Invoice Yang Belum Selesai";
					$data = [
						'response'=>[
							'code'=>0,
							'message'=>$message
						]
					];
					echo (json_encode($data));
				 }else{
				 	//cek nominal ini sudah belum kemarin dan sekarang
				 	$dataYestToday = $this->Tbl_invoice->getYestToday($depo_saldo, $fromSend);
				 	if ($dataYestToday > 0) {
				 		# nominal sudah pernah kemarin / sekarang
				 		$data = [
							'response'=>[
								'code'=> 0,
								'message'=> "Tolong Ubah Nominal"
							]
						];
						echo (json_encode($data));
				 	}else{

						//set expired deposit
						$date = (new DateTime('now'))->format('Y/m/d H:i:s');
						$expired = date('Y/m/d H:i:s', strtotime('+12 hours', strtotime($date)));
						// invoice deposit insert
						 $data_save_invoice = [
						 	'invoice_type_id'	=>	$invoice_type_id ,
						 	'deposit_id'		=>	$depoId,
						 	'user_id'			=>	$userId,
						 	'created_on'		=>	$creatInvoice,
						 	'expired_on'		=>	$expired,
						 	'nominal'			=>	$depo_saldo,
						 	'status_read'		=> 	$statusDefault,
						 	'status_server'		=>  1, //pending
						 	'from_sended'		=>  htmlentities($fromSend)
						 ];
						 $query = $this->Tbl_invoice->insertInvoiceUser($data_save_invoice);

						 if ($query) {
						 	$message = "Silahkan Lakukan Pembayaran Sebelum Waktu Habis";
							$data = [
								'response'=>[
									'code'=>1,
									'message'=>$message
								]
							];
							echo (json_encode($data));
						 }else{
						 	$message = "Unknow Error";
							$data = [
								'response'=>[
									'code'=>0,
									'message'=>$message
								]
							];
							echo (json_encode($data));
						 }
				 	}
				}

			}else{
				$message = "Not Pound Selected Metode";
				$data = [
					'response'=>[
						'code'=>0,
						'message'=>$message
					]
				];
				echo (json_encode($data));
				}

		}else{
			$message = "Please valid Input";
			$data = [
				'response'=>[
					'code'=>2,
					'message'=>$message
				]
			];
			echo (json_encode($data));
		}
	}

	/*
	*-------------------
	*getlogTransaksi User Method
	*-------------------
	*/

	public function getlogTransaksi()
	{
        $id_user = $this->email_login->id;
		$datas = $this->Tbl_invoice->getLog($id_user)->result();
		$data_status = [
	                          '<td class="badge badge-danger mt-3"><h6 class="text-white text-center mt-4">Failed</h6></td>',

	                          '<td class="badge badge-warning mt-3"><h6 class="text-white text-center mt-4">Pending</h6></td>',

	                          '<td class="badge badge-info mt-3"><h6 class="text-white text-center mt-4">Check</h6></td>',

	                          '<td class="badge badge-success mt-3"><h6 class="text-white text-center mt-4">Success</h6></td>'
                        ];
                        
		foreach ($datas as $key => $value) {
			//style number unik kode
			$nominal = ("Rp".number_format($value->nominal,0,',','.') );
			
			$dtF = substr($nominal, 0, -3);
			$dtL = substr($nominal,-3);
			$datas[$key]->created_on = date('d M Y H:i:s', $value->created_on);
			$datas[$key]->nominal = $dtF.'<span class="bg-danger text-white ml-1">'.$dtL.'</span>';
			$datas[$key]->link = base_url('user/deposit/detail/'.$value->id);
			$datas[$key]->status = $data_status[$value->status];
		}
		// print_r($datas);
		echo json_encode($datas);
	}

	/*
	*Method detail
	*/
	public function detail($id_invoice)
	{
		$id_user = $this->email_login->id;

		$check = $this->Tbl_invoice->getById_User($id_invoice, $id_user)->num_rows();
		if ($check) {
			$datas = $this->Tbl_invoice->getById_User($id_invoice, $id_user)->result();
			foreach ($datas as $key => $value) {
				//style number unik kode
				$nominal = ("Rp".number_format($value->nominal,0,',','.') );
				
				$dtF = substr($nominal, 0, -3);
				$dtL = substr($nominal,-3);

				$data_status = [
	                          '<span class="badge badge-danger">Failed</span>',

	                          '<span class="badge badge-warning">Pending</span>',

	                          '<span class="badge badge-info">Check</span>',

	                          '<span class="badge badge-success">Success</span>'
	                        ];
				$datas[$key]->created_on = date('d M Y H:i:s', $value->created_on);
				$datas[$key]->nominal = $dtF.'<span class="bg-danger text-white ml-1">'.$dtL.'</span>';
				$datas[$key]->invoice_code = ($id_invoice);
				$datas[$key]->status = $data_status[$value->status];
			}
			$this->data['invoice'] = $datas;
			$this->template->user_render('user/invoice','user/_templates/footer', $this->data);
		}else{
			show_404();
		}
	}

	/*
	*Method sudah_bayar
	*/
	// public function sudah_bayar($id_invoice)
	// {
	// 	$this->db->select('deposit.deposit_method_id');
	// 	$this->db->from('invoice');
	// 	$this->db->join('deposit', 'invoice.deposit_id = deposit.id', 'left');
	// 	$this->db->where('invoice.id', $id_invoice);
	// 	$id_type_deposit = $this->db->get()->row()->deposit_method_id;

	// 	if ($id_type_deposit == 2) {
	// 		$this->template->user_render('user/deposit/depo_pulsa', 'user/_templates/footer-deposit', $this->data);
	// 	}

	// }


}