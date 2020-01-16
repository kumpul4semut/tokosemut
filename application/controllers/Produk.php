<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	public function index($group = 2)
	{
		
        $this->data['title'] = 'Daftar Produk - ' .ucwords($_SERVER['HTTP_HOST']);
        $this->data['keywords'] = 'Belajar programing, javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';
        $this->data['description'] = 'Belajar programing, tembak xl, pemrograman javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';

        $this->data['group'] = $this->db->get('group_produk')->result_array();

        $this->db->select('produk.name, produk.price, produk.status');
	    $this->db->from('produk');
	    $this->db->join('group_produk', 'produk.group_produk_id = group_produk.id');
	    $this->db->where('group_produk.id', $group);

        $this->data['produk'] = $this->db->get()->result();

		$this->template->public_render('public/list_produk', 'public/_templates/footer', $this->data);
		
	}

}

/* End of file Produk.php */
/* Location: ./application/controllers/Produk.php */