<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Dashboard admin
 * @author kumpul4semut
 * 23 julin 2019
 */
class Dashboard extends Admin_Controller
{
	
	public function index()
	{
		$this->data['title'] = 'Dashboard';
		$this->data['totalUser'] = $this->db->get('user')->num_rows() - 1;
		$this->template->admin_render('admin/dashboard', $this->data);
	}
}