<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Manage User for admin
 * @author kumpul4semut
 * 28 juli 2019
 */
class User extends Admin_Controller
{
	
	public function index()
	{
		$this->load->library('pagination');
		$this->data['title'] = 'User';
		$limit = $this->setting()['total_pagination'];

		//pagination transaksi
		$config['base_url'] = base_url().'admin/user/index';
		$config['total_rows'] = $this->db->get('user')->num_rows();
		$config['per_page'] = $limit;

		$offset = $this->uri->segment(4);

		$this->pagination->initialize($config);
		$this->data['list_user'] = $this->Tbl_user->getAll($limit, $offset)->result();
		$this->template->admin_render('admin/user/index', $this->data);
	}

	public function lock($id) {
		$q = $this->db->get_where('user', ['id' => $id])->row();
		$is_active = $q->is_active;

		$respon = '';

		if ($is_active == 1) {
			$this->db->where('id', $id);
			$this->db->set('is_active', 0);
			$this->db->update('user');

			$respon = 'locked';
		}else{
			$this->db->where('id', $id);
			$this->db->set('is_active', 1);
			$this->db->update('user');

			$respon = 'Unlocked';
		}


		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User '.$q->email.' '.$respon.'</div>');
		redirect('admin/user','refresh');

	}

	public function deleteUser($id) {
		$this->MY_Model->delete('user', $id);

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">User Deleted</div>');
		redirect('admin/user','refresh');
	}

	public function delpending() {
		$this->db->where('is_active', 0);
		$this->db->delete('user');

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Pending User Deleted</div>');
		redirect('admin/user','refresh');
	}

	public function edit($id) {
		if ($id == 22) {
			show_404();
		}
		$this->data['title'] = 'User Edit';

		$this->data['user'] = $this->db->get_where('user', ['id' => $id])->row();
		$this->template->admin_render('admin/user/edit', $this->data);
	}

	public function update() {
		$data = [
			'email' => $this->input->post('email'),
			'saldo' => $this->input->post('saldo')
		];
		$this->db->where('id', $this->input->post('id'));
		$q = $this->db->update('user', $data);
		if ($q) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Updated!</div>');
			redirect('admin/user','refresh');
		}
	}

	public function search() {
		$keyword =  $this->input->post('search');

		$this->load->library('pagination');
		$this->data['title'] = 'User';
		$limit = $this->setting()['total_pagination'];

		//pagination transaksi
		$config['base_url'] = base_url().'admin/user/index';
		$config['total_rows'] = $this->db->get('user')->num_rows();
		$config['per_page'] = $limit;

		$offset = $this->uri->segment(4);

		$this->pagination->initialize($config);
		$this->data['list_user'] = $this->Tbl_user->getSearch($limit, $offset, $keyword)->result();
		$this->template->admin_render('admin/user/index', $this->data);
	}
}
