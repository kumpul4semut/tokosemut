<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *|----------------------|
 *| Base Model           |
 *| @author kumpul4semut |
 *| On 7 Agustus 2019    |
 *|----------------------|
 */

class MY_Model extends CI_Model
{
	
	function __construct() {
		parent::__construct(); $this->load->database();		
	} 

	/**
	*--------------
	* Method Delete
	*--------------
	* @param table_name
	* @param id
	*/

	public function delete($table_name, $id)
	{
		$this->db->where('id', $id);
        return $this->db->delete($table_name);
	}

	/**
	*--------------
	* Method getUpdate
	*--------------
	* @param table_name
	* @param id
	*/

	public function getUpdate($table_name, $id)
	{
		$this->db->where('id', $id);
        return $this->db->get($table_name);
	}

}