<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Refund extends Admin_Controller {

	public function index()
	{
		$this->data['title'] = 'Refund Management';

		$this->db->select('refund.id, user.email, produk.name, produk.price');
		$this->db->from('refund');
		$this->db->join('user', 'refund.user_id = user.id');
		$this->db->join('trx_produk', 'refund.trxid = trx_produk.id');
		$this->db->join('produk', 'trx_produk.produk_id = produk.id');
		$this->db->where('refund.status_read', 0);
        $this->data['refund'] = $this->db->get()->result_array();
 
        $this->template->admin_render('admin/refund/index', $this->data);
	}

	public function acc($id) {

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
			
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">This refund accept</div>');
            redirect('admin/refund');
		}

	}

	public function dany($id) {
		$this->db->set('status_read', 1);
		$this->db->where('id', $id);
		$this->db->update('refund');
		$this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This refund dannyed</div>');
        redirect('admin/refund');
	}

}

/* End of file Refund.php */
/* Location: ./application/controllers/admin/Refund.php */