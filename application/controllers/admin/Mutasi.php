<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi extends Admin_Controller {

	function __construct(){
		parent::__construct();
		$this->load->library('ovo/Ovoload', '', 'ovo');
		$this->load->library('Newxl','','xl');
		$this->load->library('Xlcurl','','oxl');
	}

	public function index()
	{
		$this->data['title'] = 'Mutasi Manajemen';
		$this->template->admin_render('admin/mutasi/index', $this->data);
	}

	public function ovo($param = null)
	{
		switch ($param) {
			case '':
				$this->data['title'] = 'ovo';
				$this->data['edit'] = $this->db->get_where('mutasi', ['id' => 1])->row();
				$this->template->admin_render('admin/mutasi/edit', $this->data);
				break;
			case 'gettoken':
				$this->_rqOvo();
				break;
			default:
				show_404();
				break;
		}
	}

	public function xl($param = null)
	{
		switch ($param) {
			case '':
				$this->data['title'] = 'xl';
				$this->data['edit'] = $this->db->get_where('mutasi', ['id' => 2])->row();
				$this->template->admin_render('admin/mutasi/edit', $this->data);
				break;
			case 'gettoken':
				$this->_rqXl();
				break;
			default:
				show_404();
				break;
		}
	}

	public function oxl($param = null)
	{
		switch ($param) {
			case '':
				$this->data['title'] = 'oxl';
				$this->data['edit'] = $this->db->get_where('mutasi', ['id' => 3])->row();
				$this->template->admin_render('admin/mutasi/edit', $this->data);
				break;
			case 'gettoken':
				$this->_rqOXl();
				break;
			default:
				show_404();
				break;
		}
	}

	
	
	////////////////////////
	// Rq ovo get token //
	////////////////////////

	private function _rqOvo(){
		$this->data['title'] = 'rq ovo';
		$this->data['url'] = 'admin/mutasi/rqOtpOvo';
		$this->data['rqR'] = 'nomor';
		$this->data['rqP'] = '08xx';
		$this->data['rqName'] = 'OtpOvo';
		$this->template->admin_render('admin/mutasi/rq', $this->data);
	}



	public function rqOtpOvo(){
		$rq = json_decode( $this->ovo->reqOtp($this->input->post('nomor')), true) ;
		$array = array(
			'nomor' => $this->input->post('nomor'),
			'refId'	=> $rq['refId']
		);
		
		$this->session->set_userdata( $array );

		$this->data['title'] = 'login ovo';
		$this->data['url'] = 'admin/mutasi/rqLoginOvo';
		$this->data['rqR'] = 'otp';
		$this->data['rqP'] = '1122';
		$this->data['rqName'] = 'LoginOvo';
		$this->template->admin_render('admin/mutasi/rq', $this->data);
	}

	public function rqLoginOvo(){
		$rq = json_decode( $this->ovo->login($this->input->post('otp')), true);
		$array = array(
			'updateAccessToken'	=> $rq['updateAccessToken']
		);
		
		$this->session->set_userdata( $array );

		$this->data['title'] = 'login security ovo';
		$this->data['url'] = 'admin/mutasi/rqLoginSecureOvo';
		$this->data['rqR'] = 'pin';
		$this->data['rqP'] = '6 digits';
		$this->data['rqName'] = 'LoginSecureOvo';
		$this->template->admin_render('admin/mutasi/rq', $this->data);
	}

	public function rqLoginSecureOvo(){
		$rq = json_decode( $this->ovo->loginSecurity($this->input->post('pin')), true);
		$this->db->where('id', 1);
		$this->db->update('mutasi', ['token' => $rq['token']]);
		redirect('admin/mutasi/ovo', 'refresh');		
	}

	////////////////////////
	// Rq xl get token //
	////////////////////////
	

	private function _rqXl(){
		$this->data['title'] = 'rq ovo';
		$this->data['url'] = 'admin/mutasi/rqOtpXl';
		$this->data['rqR'] = 'nomor';
		$this->data['rqP'] = '062xx';
		$this->data['rqName'] = 'OtpXl';
		$this->template->admin_render('admin/mutasi/rq', $this->data);
	}

	public function rqOtpXl(){
		$this->xl->getPass($this->input->post('nomor'));
		$array = array(
			'msisdn' => $this->input->post('nomor'),
		);
		
		$this->session->set_userdata( $array );

		$this->data['title'] = 'login Xl';
		$this->data['url'] = 'admin/mutasi/rqLoginXl';
		$this->data['rqR'] = 'otp';
		$this->data['rqP'] = '1122';
		$this->data['rqName'] = 'LoginXl';
		$this->template->admin_render('admin/mutasi/rq', $this->data);
	}

	public function rqLoginXl(){
		$rq = json_decode( $this->xl->login($this->session->userdata('msisdn'), $this->input->post('otp')), true);

		$this->db->where('id', 2);
		$this->db->update('mutasi', [
			'token' => $rq['result']['accessToken'],
			'number_enc' => $rq['result']['user']['msisdn_enc'],
			'refresh_token' => $rq['result']['refreshToken']
		]);
		redirect('admin/mutasi/xl', 'refresh');	
	}

	////////////////////////
	// Rq Oxl get token //
	////////////////////////
	

	private function _rqOXl(){
		$this->data['title'] = 'rq ovo';
		$this->data['url'] = 'admin/mutasi/rqOtpOXl';
		$this->data['rqR'] = 'nomor';
		$this->data['rqP'] = '062xx';
		$this->data['rqName'] = 'OtpXl';
		$this->template->admin_render('admin/mutasi/rq', $this->data);
	}

	public function rqOtpOXl(){
		$this->oxl->getPass($this->input->post('nomor'));
		$array = array(
			'msisdn' => $this->input->post('nomor'),
		);
		
		$this->session->set_userdata( $array );

		$this->data['title'] = 'login Xl';
		$this->data['url'] = 'admin/mutasi/rqLoginOXl';
		$this->data['rqR'] = 'otp';
		$this->data['rqP'] = '1122';
		$this->data['rqName'] = 'LoginXl';
		$this->template->admin_render('admin/mutasi/rq', $this->data);
	}

	public function rqLoginOXl(){
		$rq = $this->oxl->login($this->session->userdata('msisdn'), $this->input->post('otp'));

		$this->db->where('id', 3);
		$this->db->update('mutasi', [
			'token' => $rq->sessionId
		]);
		redirect('admin/mutasi/oxl', 'refresh');	
	}

	////////////////////
	// update method  //
	////////////////////

	public function update($id){
		$this->db->where('id', $id);
		$this->db->update('mutasi', ['token' => $this->input->post('token'), 'number_enc' => $this->input->post('number_enc'), 'refresh_token' => $this->input->post('refresh_token')]);
		redirect($_SERVER['HTTP_REFERER']);
	}

}

/* End of file Mutasi.php */
/* Location: ./application/controllers/admin/Mutasi.php */