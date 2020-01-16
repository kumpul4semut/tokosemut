<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * pengaturan dasar store
 * atur limit pagination
 * atur minimum deposit
 * atur maximum deposit
 * atur keuntungan
 */

class Setting extends Admin_Controller {

	public function index()
	{
		$this->data['title'] = "Setting";
		$this->data['setting'] = $this->General_setting->getAll()->row_array();

		$this->form_validation->set_rules('laba', 'Laba', 'trim|required');
		$this->form_validation->set_rules('md', 'Minimum Deposit', 'trim|required');
		$this->form_validation->set_rules('xd', 'Maximum Deposit', 'trim|required');
		$this->form_validation->set_rules('pp', 'Pagination', 'trim|required');
		if ($this->form_validation->run() == False) {
			$this->template->admin_render('admin/setting/index', $this->data);
		} else {
			$data = [
				'laba' 				=> $this->input->post('laba'),
				'minimum_deposit' 	=> $this->input->post('md'),
				'maximum_deposit' 	=> $this->input->post('xd'),
				'total_pagination' 	=> $this->input->post('pp')
			];

			if ( $this->db->update('general_setting', $data) ) {
				$this->session->set_flashdata('msg' , 'update oke');
				redirect('admin/setting','refresh');
			}
		}
	}

}

/* End of file Setting.php */
/* Location: ./application/controllers/admin/Setting.php */