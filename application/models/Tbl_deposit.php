<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Tbl_deposit model
 */
class Tbl_deposit extends CI_Model
{
	/**
	*-----------------
	* Method get BY Id
	*-----------------
	* @param From Ajax Checkbox deposit
	*/
	public function getById($id)
	{
		$this->db->where('id', $id);
        return $this->db->get('deposit');
	}

	/**
	*-----------------
	* Method get BY Id and join method deposit
	*-----------------
	* @param id From Ajax Checkbox deposit
	* 
	*/
	public function getByIdJoin($id)
	{
		$this->db->select('deposit.*,deposit_method.method_name');
		$this->db->from('deposit');
		$this->db->join('deposit_method','deposit.deposit_method_id=deposit_method.id');
        $this->db->order_by('deposit.id','desc');
		$this->db->where('deposit.id', $id);
        return $this->db->get();

	}
}