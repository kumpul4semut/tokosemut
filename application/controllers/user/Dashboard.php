<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard user
 * kumpul4semut
 * 27 juli 2019
 */
class Dashboard extends User_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('Manage_menu');
	}

	public function index()
	{
		$this->data['title'] = 'Dashboard';
		$this->data['main_produk'] = $this->Tbl_main_produk->getAll();
		$this->template->user_render('user/dashboard','user/_templates/footer', $this->data);
	}

	public function getSaldoUser() 
	{
		echo "Saldo Rp ".number_format($this->email_login->saldo,2,',','.');
	}
}