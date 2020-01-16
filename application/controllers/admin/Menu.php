<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends Admin_Controller
{

    public function index()
    {
        $this->data['title'] = 'Menu Management';

        $this->data['menu_management'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {
            $this->template->admin_render('admin/menu/index', $this->data);
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('admin/menu');
        }
    }


    public function submenu()
    {
        $this->data['title'] = 'Submenu Management';

        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                  FROM `user_sub_menu` JOIN `user_menu`
                  ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                ";
        $this->data['subMenu'] = $this->db->query($query)->result_array();

        $this->data['menuManagement'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'icon', 'required');

        if ($this->form_validation->run() ==  false) {
            $this->template->admin_render('admin/menu/submenu', $this->data);
        } else {
            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New sub menu added!</div>');
            redirect('admin/menu/submenu');
        }
    }

    public function dropsubmenu($id) {
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Sub Menu Deleted!</div>');
            redirect('admin/menu/submenu');
    }

    public function edit($id) {
        $this->data['title'] = "Edit";
        $this->data['edit'] = $this->db->get_where('user_sub_menu', ['id' =>$id])->row_array();
        foreach ($this->data['edit'] as $key => $value) {
            $this->data['edit']['menu_id'] = $this->db->get('user_menu')->result_array();
        }
        $this->template->admin_render('admin/edit', $this->data);
    }

    public function update() {
        $tbl = $this->db->get('user_sub_menu')->row();

        //create dinamis data for update from db
        foreach ($tbl as $k => $v) {
            $array[]= $k;
        }

        foreach ($tbl as $k => $v) {
            $array2[]= $this->input->post($k);
        }
        $data = array_combine($array,$array2);

        $this->db->where('id',$this->input->post('id'));
        $q = $this->db->update('user_sub_menu', $data);
        if ($q) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Updated!</div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
}
