<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tbl_refund extends CI_Model {
	public function cekDoneSave($user_id, $trxapi) {
		$this->db->where('status_read', 0);
		$this->db->where('user_id', $user_id);
		$this->db->where('trxid_api', $trxapi);
		return $this->db->get('refund')->num_rows();
	}
	

}

/* End of file Tbl_refund.php */
/* Location: ./application/models/Tbl_refund.php */