<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Tbl_produk model
 */
class Tbl_produk extends CI_Model
{
	
	public function getProduk($group_id = null)
	{
	
      $query = "SELECT *
                FROM `group_produk` JOIN `produk_access_group`
                ON `group_produk`.`id`=`produk_access_group`.`group_produk_id`
                JOIN `produk`
                ON `produk_access_group`.`produk_id` = `produk`.`id`
                WHERE `produk_access_group`.`group_produk_id`= $group_id
                ORDER BY `produk_access_group`.`produk_id` ASC
                ";
      return $this->db->query($query);
	}

  public function getBYJoin($category = 2)
  {
    $this->db->select('server.title AS server, group_produk.group_name as category, produk.name, produk.price, produk.status, produk.id');
    $this->db->from('produk');
    $this->db->join('server', 'produk.server_id = server.id', 'left');
    $this->db->join('group_produk', 'produk.group_produk_id = group_produk.id', 'left');
    $this->db->where('produk.group_produk_id', $category);
    return $this->db->get();
  }

  public function getGroup($main_group_id)
  {
    $query = $this->db->get_where('group_produk', ['main_group_produk_id' => $main_group_id]);
    return $query;
  }

  public function getBYBrand($param, $idGroup)
  {
    if ($param == null) {
      // get produk token
      $this->db->where('produk.group_produk_id', $idGroup);
      return $this->db->get('produk');
    }else{
      $this->db->where('produk.brand', $param);
      $this->db->where('produk.group_produk_id', $idGroup);
      return $this->db->get('produk');
    }
  }



  
}