<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi extends Admin_Controller {

	public function index()
	{
		$this->data['title'] = 'Trx Management';

		$this->db->select('trx_produk.id, trx_produk.customer_no, trx_produk.created_on, trx_produk.status, trx_produk.ref, user.email, produk.name, produk.price');
		$this->db->from('trx_produk');
		$this->db->join('user', 'trx_produk.user_id = user.id');
		$this->db->join('produk', 'trx_produk.produk_id = produk.id');
		$this->db->order_by('id', 'desc');

        $this->data['trx'] = $this->db->get()->result_array();
        foreach ($this->data['trx'] as $key => $value) {
        	$this->data['trx'][$key]['status'] = $this->_htmlstatus($value['status']);
        }
 		
        $this->template->admin_render('admin/trx/index', $this->data);
	}

	private function _htmlstatus($respon) {
		switch ($respon) {
			case 'Sukses':
				return '<span class="badge badge-success">Sukses</span>';
				break;
			case 'Gagal':
				return '<span class="badge badge-danger">Gagal</span>';
				break;
			case 'Pending':
				return '<span class="badge badge-warning">Pending</span>';
				break;
			
			default:
				return 'unknown status';
				break;
		}
	}

	public function reset() {
		$this->db->empty_table('trx_produk');

		redirect($_SERVER['HTTP_REFERER']);
	}

}

/* End of file Transaksi.php */
/* Location: ./application/controllers/admin/Transaksi.php */