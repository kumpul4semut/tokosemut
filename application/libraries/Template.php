<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template {

    protected $CI;

    public function __construct()
    {	
		$this->CI =& get_instance();
    }

    public function public_render($content,$footer, $data = NULL)
    {
        if ( ! $content)
        {
            return NULL;
        }
        else
        {
            $this->template['header']  = $this->CI->load->view('public/_templates/header', $data, TRUE);
            $this->template['content'] = $this->CI->load->view($content, $data, TRUE);
            $this->template['footer']  = $this->CI->load->view($footer, $data, TRUE);

            return $this->CI->load->view('public/_templates/template', $this->template);
        }
	}

    public function auth_render($content, $data = NULL)
    {
        if ( ! $content)
        {
            return NULL;
        }
        else
        {
            $this->template['header']  = $this->CI->load->view('public/auth/_templates/header', $data, TRUE);
            $this->template['content'] = $this->CI->load->view($content, $data, TRUE);
            $this->template['footer']  = $this->CI->load->view('public/auth/_templates/footer', $data, TRUE);

            return $this->CI->load->view('public/_templates/template', $this->template);
        }
    }

    public function admin_render($content, $data = NULL)
    {
        if ( ! $content)
        {
            return NULL;
        }
        else
        {
            $this->template['header']  = $this->CI->load->view('admin/_templates/header', $data, TRUE);
            $this->template['sidebar'] = $this->CI->load->view('admin/_templates/sidebar', $data, TRUE);
            $this->template['content'] = $this->CI->load->view($content, $data, TRUE);
            $this->template['footer']  = $this->CI->load->view('admin/_templates/footer', $data, TRUE);

            return $this->CI->load->view('admin/_templates/template', $this->template);
        }
    }

    public function user_render($content,$footer, $data = NULL)
    {
        if ( ! $content)
        {
            return NULL;
        }
        else
        {
            $this->template['header']  = $this->CI->load->view('admin/_templates/header', $data, TRUE);
            $this->template['sidebar'] = $this->CI->load->view('user/_templates/sidebar', $data, TRUE);
            $this->template['content'] = $this->CI->load->view($content, $data, TRUE);
            $this->template['footer']  = $this->CI->load->view($footer, $data, TRUE);

            return $this->CI->load->view('admin/_templates/template', $this->template);
        }
    }



    

}
