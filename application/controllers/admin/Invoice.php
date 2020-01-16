<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Manage Invoice for admin
 * @author kumpul4semut
 * 28 juli 2019
 */
class Invoice extends Admin_Controller
{
	function __construct(){
		parent::__construct();
		$this->data['title'] = 'Invoice';
		$this->load->library('ovo/Ovoload', '', 'ovo');
	}
	
	public function index()
	{
		$this->load->library('pagination');

		$limit = $this->setting()['total_pagination'];

		//pagination transaksi
		$config['base_url'] = base_url().'admin/invoice/index';
		$config['total_rows'] = $this->db->get('invoice')->num_rows();
		$config['per_page'] = $limit;

		$offset = $this->uri->segment(4);

		$this->pagination->initialize($config);
		$this->data['list_invoice'] = $this->Tbl_invoice->getAll($limit, $offset)->result();
		$this->template->admin_render('admin/invoice/index', $this->data);
	}

	/*
	*Method detail
	*/
	public function detail($id_invoice)
	{

		$check = $this->Tbl_invoice->getById($id_invoice)->num_rows();
		if ($check) {
			$datas = $this->Tbl_invoice->getById($id_invoice)->result();
			foreach ($datas as $key => $value) {
				$datas[$key]->created_on = date('d M Y H:i:s', $value->created_on);
			    $datas[$key]->nominal = ("Rp".number_format($value->nominal,0,',','.') );
			    $datas[$key]->saldo = ("Rp".number_format($value->saldo,0,',','.') );
			}

			//update status read invoice done read atau 1
			$data_update_invoice = $this->Tbl_invoice->getById($id_invoice)->row();
			$id_update_invoice = $data_update_invoice->invoice_id;
			if ($data_update_invoice) {
				$this->data['invoice'] = $datas;
				$this->template->admin_render('admin/invoice/invoice', $this->data);
			}else{
				echo "error update read";
			}
		}else{
			show_404();
		}
	}

	/*
	*Method goAccept
	*/
	public function goAccept($id_invoice)
	{
		// print_r($this->Tbl_invoice->getById($id_invoice)->row());
		$user_id = (int)$this->Tbl_invoice->getById($id_invoice)->row()->user_id;
		$nominal = $this->Tbl_invoice->getById($id_invoice)->row()->nominal;
		$method_name = $this->Tbl_invoice->getById($id_invoice)->row()->method_name;
		$status = $this->Tbl_invoice->getById($id_invoice)->row()->status;

		// hanya yang pending dan check yanng dapat add saldo
		if ($status == 1 || $status == 2) {
			$this->Tbl_invoice->updateAccept($id_invoice);
			# code...
			if ($method_name == 'Pulsa') {
				$nominal = (0.92 * $nominal);
			}
			$saldo_user = $this->Tbl_invoice->getById($id_invoice)->row()->saldo;
			$count =  (int)$nominal + (int)$saldo_user;
			$addSaldo = $this->addSaldoUser($user_id, $count);
			if ($addSaldo) {
				redirect('admin/invoice/detail/'.$id_invoice);
			}
		}else{
			redirect('admin/invoice/detail/'.$id_invoice);
		}

	}

	/*
	*Method goDeny
	*/
	public function goDeny($id_invoice)
	{
		$id_invoice = $this->Tbl_invoice->getById($id_invoice)->row()->invoice_id;//update expired_on to 0
		$this->Tbl_invoice->updateDeny($id_invoice);
		redirect('admin/invoice/detail/'.$id_invoice);
	}

	public function forcedany($id_transaksi) 
	{
		$this->db->where('id', $id_transaksi);
		$this->db->set('status', 0);
		$this->db->update('transaksi');
		redirect('admin/invoice/detail/'.$id_transaksi);
	}

	public function cekovo() {
		// print_r($this->ovo->reqOtp('087822618221'));
		// print_r($this->ovo->login('087822618221'));
		// print_r($this->ovo->loginSecurity());
		// print_r($this->ovo->balanceModel());
		print_r($this->ovo->getWalletTransaction(1));
	}
}
