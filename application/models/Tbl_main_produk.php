<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tbl_main_produk extends CI_Model {

	public function getAll()
	{
		$main_group_produk = $this->db->get('main_group_produk')->result_array();
		foreach ($main_group_produk as $k => $v) {
			$main_group_produk[$k]['group_produk'] = $this->db->get_where('group_produk', ['main_group_produk_id' => $v['id']])->result_array();
		}
		return $main_group_produk;
	}	

}

/* End of file Tbl_main_produk.php */
/* Location: ./application/models/Tbl_main_produk.php */