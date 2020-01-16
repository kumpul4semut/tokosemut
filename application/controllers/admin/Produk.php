<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Manage User for admin
 * @author kumpul4semut
 * 28 juli 2019
 */
class Produk extends Admin_Controller
{
	function __construct(){
		parent::__construct();
		$this->load->library( array('curl', 'portal', 'digiflazz') );
	}
	
	public function index() {
		$this->data['title'] = "admin produk";
		$this->data['produk'] = $this->Tbl_produk->getBYJoin()->result_array();
		$this->data['group_produk'] = $this->db->get('group_produk')->result_array();
		$this->data['main_group'] = $this->db->get('main_group_produk')->result_array();
		$this->template->admin_render('admin/produk/index', $this->data);
	}

	public function filter() {
		$data = $this->Tbl_produk->getBYJoin($this->input->post('group_id'))->result_array();
		echo json_encode($data);
	}

	public function edit($id) {
		$this->data['title'] = "Admin Produk Edit";
		$this->data['edit'] = $this->db->get_where('produk', ['id' =>$id])->row_array();
		foreach ($this->data['edit'] as $key => $value) {
			$this->data['edit']['group_produk_id'] = $this->db->get('group_produk')->result_array();
			$this->data['edit']['server_id'] = $this->db->get('server')->result_array();
		}
		$this->template->admin_render('admin/edit', $this->data);
	}

	public function update() {
		$tbl = $this->db->get('produk')->row();

		//create dinamis data for update from db
		foreach ($tbl as $k => $v) {
			$array[]= $k;
		}

		foreach ($tbl as $k => $v) {
			$array2[]= $this->input->post($k);
		}
		$data = array_combine($array,$array2);

		$this->db->where('id',$this->input->post('id'));
		$q = $this->db->update('produk', $data);
		if ($q) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Updated!</div>');
			redirect('admin/produk','refresh');
		}
	}

	public function delete($id) {

		// $this->db->where('id', $id);
		$q = $this->MY_Model->delete('produk', $id);
		if ($q) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Deleted!</div>');
			redirect('admin/produk','refresh');
		}
	}

	public function addGroup() {
		$dataAdd = [
			'main_group_produk_id' => $this->input->post('main-group'),
			'group_name' => $this->input->post('group_name'),
			'icon' => $this->input->post('icon'),
		];
		$q = $this->db->insert('group_produk', $dataAdd);
		if ($q) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Category added!</div>');
			redirect('admin/produk','refresh');
		}
	}

	// public function index()
	// {
	// 	$url = "https://kimnoon.com/api/main/get-vouchers";
	// 	$parameters = array(
	// 		"auth_username" => "semutoke123",
	// 		"auth_token" => "6052:AJEpfzxdlbecZTkj190Vg7ODs5Y2a3Sw",
	// 		);
	// 	$data = $this->curl->kimnoon($url,$parameters);
	// 	$json = json_decode($data ,true);
		
	// 	$this->data['title'] = "Produk";
	// 	$this->data['kimnoon'] = $json['results'];
	// 	$this->template->admin_render('admin/produk', $this->data);

	// }

	public function add()
	{
		$data = $this->input->post('kimnoon');
		$split = explode("|", $data);
		$id_produk = $split[0];

		$parameters = array(
			"auth_username" => "semutoke123",
			"auth_token" => "6052:AJEpfzxdlbecZTkj190Vg7ODs5Y2a3Sw",
			"voucher_id" => "71",
			"phone" => "087822618221",
			"id_plgn" => "",
			"payment" => "balance",
			);
		$url = "https://kimnoon.com/api/main/order";
		$data = $this->curl->kimnoon($url,$parameters);
		print_r($data);
		// echo("id:".$split[0]);
		// echo "<br>";
		// echo("harga:".$split[1]);
	}

	public function getPortal()
	{
		
		$exec = $this->portal->getPulsa();

		$json = json_decode($exec, true);

		$data_server = $json['message'];

		$laba = $this->General_setting->get()->row()->laba;

		foreach ($data_server as $ds) {
			# looping portal_pulsa save
			$provider	=	$ds['provider'];
			$type 		=	$ds['provider_sub'];
			$code		=	$ds['code'];
			$price		=	($ds['price'] + $laba);
			$description=	$ds['description'];
			$status     =	$ds['status'];

			$data = [
				'provider'		=> $provider,
				'type'			=> $type,
				'code'			=> $code,
				'price'			=> $price,
				'description'	=> $description,
				'status'		=> $status
			];

			$this->db->where('code', $code);
			$exec = $this->db->update('portal_pulsa', $data);
			// $exec = $this->db->insert('portal_pulsa', $data);
			print_r($exec);

		} //endforeach

	}

	public function digiflazz() {
		// print_r ($this->digiflazz->getSaldo());
		print_r ($this->digiflazz->getListHarga());
		// print_r ($this->digiflazz->getTopUp());
		// print_r ($this->digiflazz->getStatus());
	}





}
