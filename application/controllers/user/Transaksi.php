<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Transaksi controller user
 * @author kumpul4semut
 * 3 agustus 2019
 */
class Transaksi extends User_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->data['title'] = 'Transaksi';
	}

	/*
	*load view transaksi
	*/
	public function index()
	{
		$this->load->library('pagination');

		$limit = 2;
		$id_user = $this->email_login->id;

		//pagination transaksi
		$config['base_url'] = base_url().'user/transaksi/index';
		$config['total_rows'] = $this->db->get('transaksi')->num_rows();
		$config['per_page'] = $limit;

		$offset = $this->uri->segment(4);

		$this->pagination->initialize($config);
		$datas = $this->Tbl_transaksi->getByUser($id_user, $limit, $offset)->result();
		foreach ($datas as $key => $value) {
				$data_status = [
	                          '<span class="badge badge-danger">Failed</span>',

	                          '<span class="badge badge-warning">Pending</span>',

	                          '<span class="badge badge-info">Check</span>',

	                          '<span class="badge badge-success">Success</span>'
	                        ];
				$datas[$key]->created_on = date('d M Y H:i:s', $value->created_on);
				$datas[$key]->nominal = ("Rp".number_format($value->nominal,0,',','.') );
				$datas[$key]->status = $data_status[$value->status];
				$datas[$key]->link = base_url('user/transaksi/detail/'.$value->id);
			}
		$this->data['transaksi'] = $datas;

		$this->template->user_render('user/transaksi','user/_templates/footer', $this->data);
	}

	/*
	*Method detail
	*/
	public function detail($id_transaksi)
	{
		$id_user = $this->email_login->id;

		$check = $this->Tbl_transaksi->getById_User($id_transaksi, $id_user)->num_rows();
		if ($check) {
			$datas = $this->Tbl_transaksi->getById_User($id_transaksi, $id_user)->result();
			foreach ($datas as $key => $value) {
				$data_status = [
	                          '<span class="badge badge-danger">Failed</span>',

	                          '<span class="badge badge-warning">Pending</span>',

	                          '<span class="badge badge-info">Check</span>',

	                          '<span class="badge badge-success">Success</span>'
	                        ];
				$datas[$key]->created_on = date('d M Y H:i:s', $value->created_on);
				$datas[$key]->nominal = ("Rp".number_format($value->nominal,0,',','.') );
				$datas[$key]->invoice_code = ($id_transaksi);
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
	public function sudah_bayar($id_transaksi)
	{
		$id_user = $this->email_login->id;
		$check = $this->Tbl_transaksi->getById_Just_Pending($id_transaksi, $id_user)->num_rows();
		if ($check) {
			$update = $this->Tbl_transaksi->updateSudahBayarUser($id_transaksi);
			if ($update) {
				$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Thanks Please wait Admin Checking!</div>');
                    
				redirect('user/transaksi/detail/'.$id_transaksi);
			}else{
				show_404();				
			}
		}else{
			show_404();
		}
	}
}