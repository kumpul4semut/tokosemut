<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Group_produk extends Admin_Controller {

	public function index()
	{
		$this->data['title'] = 'group produk';
		$this->data['totalUser'] = $this->db->get('user')->num_rows() - 1;
		$this->data['saldo_user']= $this->email_login->saldo;
		$this->template->admin_render('admin/group_produk', $this->data);
	}

}

/* End of file Group_produk.php */
/* Location: ./application/controllers/admin/Group_produk.php */