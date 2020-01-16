<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tbl_trx_produk extends CI_Model {

	public function getByUser($id_user) {
		$this->db->select('
			trx_produk.id,
			trx_produk.sn,
			trx_produk.customer_no as nomor,
			trx_produk.created_on,
			trx_produk.status,
			trx_produk.trx_price,
			trx_produk.customer_name,
			produk.name,
			produk.price,
			group_produk.group_name');
		$this->db->from('trx_produk');
		$this->db->join('produk', 'trx_produk.produk_id = produk.id');
		$this->db->join('group_produk', 'produk.group_produk_id = group_produk.id');
		$this->db->where('trx_produk.user_id', $id_user);
		$this->db->order_by('trx_produk.id', 'desc');
		return $this->db->get();
	}

	public function checkCustomerNo($nomor, $id_produk) {
		$now = date('Y-m-d', time());
		
		$nomors = $this->db->get_where('trx_produk', ['customer_no' => $nomor, 'produk_id' => $id_produk])->result();

		$count = 0;
		foreach ($nomors as $nomor) {
			$thisTimeNo = date('Y-m-d', $nomor->created_on);
			if ($thisTimeNo == $now) {
				$count += 1;
			}
		}
		return $count;
	}

}

/* End of file Tbl_trx_produk.php */
/* Location: ./application/models/Tbl_trx_produk.php */