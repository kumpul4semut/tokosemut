<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Development extends User_Controller {

	public function index()
	{
		$this->data['title'] = 'Development';

		$id_user = $this->email_login->id;

		$keys = $this->db->get_where('keys', ['user_id' => $id_user])->row_array();

		if ($keys) {
			$this->data['token'] = $keys['key'];
		}else{
			$this->data['token'] = '';
		}
		$this->template->user_render('user/dev/index','user/_templates/footer', $this->data);
	}

	public function doc()
	{
		$this->data['title'] = 'Development Documentation';
		$this->template->user_render('user/dev/doc','user/_templates/footer', $this->data);
	}

	public function generate()
	{
		$token = base64_encode(random_bytes(32));
		$data = [
			'key'			=>	$token,
			'user_id'		=>	$this->email_login->id,
			'level'			=>	0,
			'ignore_limits'	=>	0,
			'date_created'	=>	time()
		];

		$keys = $this->db->get_where('keys', ['user_id' => $this->email_login->id])->num_rows();
		if ($keys > 0) {
			$this->db->where('user_id', $this->email_login->id);
			$this->db->update('keys', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success new generate!</div>');
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->db->insert('keys', $data);
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success new generate!</div>');
			redirect($_SERVER['HTTP_REFERER']);	
		}
		
	}

}

/* End of file Development.php */
/* Location: ./application/controllers/user/Development.php */