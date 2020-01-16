<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Profile user
 * kumpul4semut
 * 27 juli 2019
 */
class Profile extends User_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->data['title'] = 'Profil';
		$this->data['user'] = $this->email_login;
		$this->template->user_render('user/profile','user/_templates/footer-profile', $this->data);
	}

	/**
	*-----------------
	*Method changename
	*-----------------
	* @param name
	*/
	public function changeName()
	{
		$this->form_validation->set_rules('name', 'Name', 'required|trim|min_length[5]|max_length[10]|alpha_numeric_spaces', ['alpha_numeric_spaces' => "Data Not Allowed"]);
		if ($this->form_validation->run() == false) {
			$message = validation_errors();
			$data = [
				'response'=>[
					'code'=>0,
					'message'=>$message
				]
			];
			echo json_encode($data);
		}else{
			$email = $this->email_login->email;
			$name = $this->input->post('name');
			
			$query = $this->Tbl_user->changeName($email,$name);
			if ($query) {
				$message = "Name Updated";
				$data = [
					'response'=>[
						'code'=>1,
						'message'=>$message
					]
				];
				echo json_encode($data);
			}else{
				$message = "something error";
				$data = [
					'response'=>[
						'code'=>0,
						'message'=>$message
					]
				];
				echo json_encode($data);
			}
		}
	}

	/**
	*----------------------
	*Method change password
	*----------------------
	* @param old pass
	* @param new pass
	* @param confirm pass
	*/

	public function changePassword()
	{
		$oldPass = $this->input->post('oldPass');
		$newPass = $this->input->post('newPass');
		$confirmPass = $this->input->post('confirmPass');

		//db pass user and session email
		$dbPass = $this->email_login->password;
		$email = $this->email_login->email;

		if (password_verify($oldPass, $dbPass)) {
	        
	        //valid new password
		     $this->form_validation->set_rules('newPass', 'New Password', 'required|trim|min_length[6]|matches[confirmPass]|max_length[20]', [
	            'matches' => 'Password dont match!',
	            'min_length' => 'Password too short!',
	            'max_length' =>'Password too long'
	        ]);

        	$this->form_validation->set_rules('confirmPass', 'Confirm Password', 'required|trim|min_length[6]|max_length[20]');
	        if ($this->form_validation->run() == false) {
	        	$message = validation_errors();
				$data = [
					'response'=>[
						'code'=>0,
						'message'=>$message
					]
				];
				echo json_encode($data);
	        }else{

	        	//password old == new
	        	if ($oldPass == $newPass) {
	        		$message = "The password is still the same";
					$data = [
						'response'=>[
							'code'=>0,
							'message'=>$message
						]
					];
					echo json_encode($data);
	        	}else{

	        		$new_password = password_hash($newPass, PASSWORD_DEFAULT);

	        		//update password
	        		$query = $this->Tbl_user->changePassword($email,$new_password);
	        		if ($query) {
	        			# echo success update password
	        			$message = "Password Updated";
				        $data = [
									'response'=>[
									'code'=>1,
									'message'=>$message
								]
							];
						echo json_encode($data);
	        		}else{
	        			$message = "something Error";
				        $data = [
									'response'=>[
									'code'=>0,
									'message'=>$message
								]
							];
						echo json_encode($data);
	        		}
	        	}
			}
        } else {
           $data = [
					'response'=>[
					'code'=>0,
					'message'=>'Wrong old Password'
				]
			];
			echo json_encode($data);
        }
	}
}