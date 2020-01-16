<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User model
 */
class Tbl_user extends CI_Model
{

	/**
	*-----------------
	* get all
	*-----------------
	*/
	public function getAll($limit, $offset)
	{
        $this->db->limit($limit, $offset);
		$this->db->order_by('user.id','desc');
        return $this->db->get('user');
	}

	/**
	*-----------------
	* Change Name
	*-----------------
	*/
	public function changeName($email, $name)
	{
		
		$this->db->where('email', $email);
		$this->db->set('name',$name);
        return $this->db->update('user');
	}

	/**
	*-----------------
	* Change password
	*-----------------
	*/
	public function changePassword($email, $new_password)
	{
		
		$this->db->where('email', $email);
		$this->db->set('password',$new_password);
        return $this->db->update('user');
	}

	/**
	*-----------------
	* get search
	*-----------------
	*/
	public function getSearch($limit, $offset, $keyword)
	{
		$this->db->like('saldo', $keyword);
		$this->db->or_like('name', $keyword);
		$this->db->or_like('email', $keyword);
        $this->db->limit($limit, $offset);
		$this->db->order_by('user.id','desc');
        return $this->db->get('user');
	}
}