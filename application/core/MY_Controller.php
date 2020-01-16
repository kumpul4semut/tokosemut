<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Store core controller
 * @author kumpul4semut
 * @date 18 juli 2019
 */
Class Core_Controller extends CI_Controller
{

	protected $email_login; //property data user logined

	function __construct()
	{
		parent::__construct();
		// auto cek user login or not and cek akses menu user
	    if (!$this->session->userdata('email')) {
	        redirect('auth');
	    } else {
	    	// email done login
	    	$this->email_login = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row();

	        $role_id = $this->session->userdata('role_id');

	        $menu = $this->uri->segment(1);

	        $queryMenu = $this->db->get_where('user_menu', ['menu' => $menu])->row_array();
	        $menu_id = $queryMenu['id'];

	        $userAccess = $this->db->get_where('user_access_menu', [
	            'role_id' => $role_id,
	            'menu_id' => $menu_id
	        ]);

	        if ($userAccess->num_rows() < 1) {
	            show_404();
	        }
	        if ($this->email_login->is_active == 0) {
	        	$this->session->unset_userdata('email');
		        $this->session->unset_userdata('role_id');

		        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">Your Account Lock By admin!</div>');
		        redirect('auth');
	        }
	    }

	    // loaded model for all access
	    $this->load->model( array('Manage_menu', 
	    						  'Tbl_produk',
	    						  'General_setting',
	    						  'Tbl_deposit',
	    						  'Tbl_transaksi',
	    						  'Tbl_user',
	    						  'Tbl_invoice',
	    						  'Tbl_refund',
	    						  'Tbl_trx_produk',
	    						  'Tbl_main_produk'
	    						) );

	    //loaded data for view all access
	    $menus = $this->Manage_menu->getMenu($this->email_login->role_id)->result();
	    $this->data['user'] = $this->email_login;

	    //create submenu on menu
	    foreach ($menus as $m => $menu) {
	    	$menus[$m]->submenu = $this->Manage_menu->getSubMenu($menu->id)->result();
	    }
	    $this->data['count_invoice'] = $this->Tbl_invoice->getNotRead()->num_rows();
	    $this->data['count_refund'] = $this->_sumrefund();
	    $this->data['menu'] = $menus;
	    $this->data['produk_err'] = $this->_sumprodukerr();
	    $this->data['saldo_user'] = $this->_sumsaldo()->row();
	    $this->data['profit'] = $this->_sumprofit();
	}

	private function _sumrefund()
	{
		return $this->db->get_where('refund', ['status_read' =>0])->num_rows();
	}

	private function _sumprodukerr()
	{
		return $this->db->get_where('produk', ['status' =>'false'])->num_rows();
	}

	private function _sumsaldo()
	{
		$this->db->select_sum('saldo');
		$this->db->where_not_in('role_id', 1);
		return $this->db->get('user');
	}

	private function _sumprofit()
	{
		return ( $this->db->get_where('trx_produk', ['status' =>'Sukses'])->num_rows()*150 );
	}

}


class User_Controller extends Core_Controller
{
	public function __construct() {
		parent::__construct();
		$on = false;
		if ($on) {
			echo '<!doctype html>
					<title>Site Maintenance</title>
					<style>
					  body { text-align: center; padding: 150px; }
					  h1 { font-size: 50px; }
					  body { font: 20px Helvetica, sans-serif; color: #333; }
					  article { display: block; text-align: left; width: 650px; margin: 0 auto; }
					  a { color: #dc8100; text-decoration: none; }
					  a:hover { color: #333; text-decoration: none; }
					</style>

					<article>
					    <h1>We&rsquo;ll be back soon!</h1>
					    <div>
					        <p>Sorry for the inconvenience but we&rsquo;re performing some maintenance at the moment. If you need to you can always <a href="mailto:#">contact us</a>, otherwise we&rsquo;ll be back online shortly!</p>
					        <p>&mdash; The Team</p>
					    </div>
					</article>';
			die;
		}else{
			$this->data['saldo'] = "Saldo Rp ".number_format($this->email_login->saldo,2,',','.');
		}

	}

	protected function updateSaldoUser($user_id, $count)
	{
		$this->db->where('id', $user_id);
		$this->db->set('saldo', $count);
		return $this->db->update('user');
	}

}

Class Admin_Controller extends Core_Controller
{
	protected $MY_Model;

	function __construct()
	{
		parent::__construct();
		$this->MY_Model = new MY_Model;
	}

	protected function addSaldoUser($user_id, $count)
	{
		$this->db->where('id', $user_id);
		$this->db->set('saldo', $count);
		return $this->db->update('user');
	}

	protected function plusUserSaldo($user_id, $berapa) {
		$nowUserSaldo = $this->db->get_where('user', ['id' => $user_id])->row()->saldo;
		$count = ($nowUserSaldo + $berapa);

		return $this->addSaldoUser($user_id, $count);
	}

	protected function setting()
	{
		return $this->db->get_where('general_setting', array('id' => 1, ))->row_array();
	}
}
