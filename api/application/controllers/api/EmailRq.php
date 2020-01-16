<?php
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

//To Solve File REST_Controller not found
require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';


class EmailRq extends CI_Controller {
	use REST_Controller {
        REST_Controller::__construct as private __resTraitConstruct;
    }

    private function _sendEmail($sendTo, $subject, $message) {
    	$config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://srv74.niagahoster.com',
            'smtp_user' => 'admin@semutcode.me',
            'smtp_pass' => 'semut405',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => '\r\n',
            'wordwrap' => TRUE
        ];

        $this->email->initialize($config);

        $this->email->from('admin@semutcode.me', 'kumpul4semut');
        $this->email->to($sendTo);

        $this->email->subject($subject);

        $this->email->message($message);
        if ($this->email->send()) {
            return true;
        } else {
            return $this->email->print_debugger();
        }
    }

	public function index_get() {
		$sendTo = $this->get('sendTo');
		$subject = $this->get('subject');
		$message = $this->get('message');
		if ($sendTo == '' OR $subject == '' OR $message == '') {
			$this->response(null, 400);
		}else{
			$Req = $this->_sendEmail($sendTo, $subject, $message);

			if ($Req) {
				 $this->response([
		                    'status' => true,
		                    'message' => "Email Sended"
		                ], 200);
			}else{
				$this->response([
		                    'status' => False,
		                    'message' => $Req
		                ], 500);
			}
		}

	}

}

/* End of file EmailRq.php */
/* Location: ./application/controllers/api/EmailRq.php */