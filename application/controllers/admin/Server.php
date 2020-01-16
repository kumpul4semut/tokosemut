<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Server extends Admin_Controller {


	function __construct(){
		parent::__construct();
	}

	public function index()
	{
		$this->data['title'] = "Admin Server";
		$this->data['server'] = $this->db->get('server')->result_array();
		$this->template->admin_render('admin/server/index', $this->data);
	}

	public function add() {

		$data = [
			'title' =>  $this->input->post('title')
		];


		$q = $this->db->insert('server', $data);
		if ($q) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New server added!</div>');
			redirect('admin/server','refresh');
		}
	}

	public function edit($id) {
		$this->data['title'] = "Admin Server Edit";
		$this->data['server'] = $this->db->get_where('server',['id' => $id])->row_array();
		$this->template->admin_render('admin/server/edit', $this->data);
	}

	public function update() {
		$data = [
			'title' => $this->input->post('title'),
			'secret' => $this->input->post('secret'),
			'key' => $this->input->post('key')
		];
		$this->db->where('id', $this->input->post('id'));
		$q = $this->db->update('server', $data);
		if ($q) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Updated!</div>');
			redirect('admin/server','refresh');
		}
	}

	public function delete($id) {

		$this->db->where('id', $id);
		$q = $this->db->delete('server');
		if ($q) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Deleted!</div>');
			redirect('admin/server','refresh');
		}
	}

	public function detail($base_server, $type) {
		$this->load->library($base_server);

		$this->data['title'] = $base_server;
		$this->data['saldo'] = json_decode($this->digiflazz->getSaldo(), true)['data']['deposit'];
		$this->data['daftar_harga'] = json_decode($this->digiflazz->getListHarga($type), true)['data'];
		$this->data['group_produk'] = $this->db->get('group_produk')->result_array();
		$this->data['server'] = $this->db->get('server')->result_array();
		$this->template->admin_render('admin/server/detail', $this->data);
	}

	public function addToProduk() {
		if ($this->input->post('price') == 0) {
			$price = 0;
		}else{
			$price = ($this->input->post('price') + $this->setting()['laba']);
		}
		$data = [
			'group_produk_id' 	=> $this->input->post('group_produk_id'),
			'server_id'		=> $this->input->post('server_id'),
			'name'			=> $this->input->post('name'),
			'brand'			=> $this->input->post('brand'),
			'trx_code'		=> $this->input->post('trx_code'),
			'price'			=> $price,
			'status'		=> $this->input->post('status')
		];

		$q = $this->db->insert('produk', $data);
		if ($q) {
			$server_id = $this->input->post('server_id');
			$server = $this->db->get_where('server', ['id' => $server_id])->row_array();	
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New produk added!</div>');
            redirect($_SERVER['HTTP_REFERER']);
		}
	}

	public function refresh($base_server) {
		$this->load->library($base_server);

		
		$listSRV = json_decode($this->digiflazz->getListHarga(), true)['data'];
		// looping list from SRV
		foreach ($listSRV as $list) {
			echo "<br>";
			echo $list['buyer_sku_code'];
			echo "<br>";
			echo $list['price'];
			echo "<br>";
			echo "<hr>";
			echo $this->_updateProduk($list['buyer_sku_code'], $list['price']);
			echo "<hr>";
			echo "<br>";
		}
	}

	private function _updateProduk($buyer_sku_code, $new_price){
		$price = ($new_price + $this->setting()['laba']);
		
		$this->db->set('price', $price);
		$this->db->where('trx_code', $buyer_sku_code);
		return $this->db->update('produk');
	}

}

/* End of file Server.php */
/* Location: ./application/controllers/admin/Server.php */