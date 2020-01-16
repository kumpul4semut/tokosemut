<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends Admin_Controller {

	public function index()
	{
		$this->data['title'] = 'Role';
        $this->data['role'] = $this->db->get('user_role')->result_array();

        $this->template->admin_render('admin/role/index', $this->data);
	}

	 public function roleAccess($role_id)
    {
        $this->data['title'] = 'Role Access';

        $this->data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();

        $this->db->where('id !=', 1);
        $this->data['menuManagement'] = $this->db->get('user_menu')->result_array();

        $this->template->admin_render('admin/role/role-access', $this->data);
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Access Changed!</div>');
    }

}

/* End of file Role.php */
/* Location: ./application/controllers/admin/Role.php */