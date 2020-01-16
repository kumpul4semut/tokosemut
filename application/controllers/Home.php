<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{
        $data['title'] = 'Store Pulsa Paket Data Produk Web Script - ' .ucwords($_SERVER['HTTP_HOST']);
        $data['keywords'] = 'Belajar programing, javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';
        $data['description'] = 'Belajar programing, tembak xl, pemrograman javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';

		$this->template->public_render('public/home_view', 'public/_templates/footer', $data);
		
	}
}
