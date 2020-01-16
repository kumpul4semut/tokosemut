<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Deposit extends Admin_Controller {

	public function index()
	{
		$this->data['title'] = 'Deposit Management';

        $this->db->select('deposit.id, deposit_method.method_name, deposit.name, deposit.nomor, deposit.pemilik');
        $this->db->from('deposit');
        $this->db->join('deposit_method', 'deposit.deposit_method_id = deposit_method.id');
        $this->data['deposit'] = $this->db->get()->result_array();
        $this->data['depo_method'] = $this->db->get('deposit_method')->result_array();


        $this->form_validation->set_rules('name', 'Name', 'required');

        if ($this->form_validation->run() ==  false) {
            $this->template->admin_render('admin/deposit/index', $this->data);
        } else {
            $data = [
                'deposit_method_id' => $this->input->post('depo_method'),
                'name'				=> $this->input->post('name'),
                'nomor'				=> $this->input->post('nomor'),
                'pemilik'			=> $this->input->post('pemilik'),
                'invoice_type_id'	=> 1
            ];
            $this->db->insert('deposit', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Deposit added!</div>');
            redirect('admin/deposit');
        }
	}

	public function delete($id) {
		$this->db->where('id', $id);
		$q = $this->db->delete('deposit');
		if ($q) {
			$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Deleted!</div>');
			redirect('admin/deposit','refresh');
		}
	}

	public function edit($id) {
		$this->data['title'] = 'Deposit Management Edit';

        $this->db->where('deposit.id', $id);
        $this->data['deposit'] = $this->db->get('deposit')->row_array();

        $this->data['depo_method'] = $this->db->get('deposit_method')->result_array();
		$this->template->admin_render('admin/deposit/edit', $this->data);
	}

	public function getDepoMethod() {
		$id_depo = $this->input->post('id_depo');
		$this->db->where('deposit_method.id', $id_depo);
		$q = $this->db->get('deposit_method')->row_array();

		echo json_encode($q);
	}

	public function editMethod() {
		$this->db->where('id', $this->input->post('id'));
		$this->db->set('method_name', $this->input->post('method_name'));
		$this->db->update('deposit_method');

		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Method Name Updated!</div>');
		redirect($_SERVER['HTTP_REFERER']);
	}

	public function update() {
		$id = $this->input->post('id');
		$dataUpdate = [
			'deposit_method_id' => $this->input->post('depo_method'),
			'name'				=> $this->input->post('name'),
			'nomor'				=> $this->input->post('nomor'),
			'pemilik'			=> $this->input->post('pemilik')
		];

		$this->db->where('id', $this->input->post('id'));
		$q = $this->db->update('deposit', $dataUpdate);
		$this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Updated!</div>');
         redirect('admin/deposit/edit/'.$id);
	}

}

/* End of file Deposit.php */
/* Location: ./application/controllers/admin/Deposit.php */