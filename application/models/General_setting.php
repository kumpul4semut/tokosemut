<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * General setting model
 */
class General_setting extends CI_Model
{
	public function getAll() {
		return $this->db->get('general_setting');
	}

	public function get() {
		$this->db->where('id', 1);
        return $this->db->get('general_setting');
	}
}