<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Invoice user
 * kumpul4semut
 * 27 juli 2019
 */
class Invoice extends User_Controller
{
	
	public function index()
	{
		$this->data['title'] = 'Invoice';
		$this->template->user_render('user/invoice','user/_templates/footer', $this->data);
	}
}