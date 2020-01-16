<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * Auth 
 * @Author kumpul4semut
 * 18 juli 2019
 */
class Auth extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->helper("cookie");
        
    }

    private function _login_is($email)
    {
        $user=$this->db->get_where('user', ['email' => $email])->row();
        if ($email) {
            if ($user->role_id == 1) {
                $this->session->unset_userdata('email');
                $this->session->unset_userdata('role_id');
                redirect('auth/secure_admin');
            }else{
                redirect('user/dashboard');
            }
        }
    }

    protected function _cek_login()
    {
        $email = $this->session->userdata('email');
        $cookie = get_cookie('remember');
        if ($email) {
            $this->_login_is($email);
        }elseif($cookie <> ''){
            $user = $this->db->get_where('user', ['remember' => $cookie])->row_array();
            $data = [
                'email' => $user['email'],
                'role_id' => $user['role_id']
            ];
            $this->session->set_userdata($data);
            $email = $this->session->userdata('email');
            $this->_login_is($email);
        }
    }

    public function index()
    {
        $this->_cek_login();
        $data['title'] = 'Login';
        $data['keywords'] = 'Belajar programing, javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';
        $data['description'] = 'Belajar programing, pemrograman javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';

        $this->template->auth_render('public/auth/login', $data);
        
    }

    public function register()
    {
        $this->_cek_login();
        $data['title'] = 'Register';
        $data['keywords'] = 'Belajar programing, javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';
        $data['description'] = 'Belajar programing, pemrograman javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';

        $this->template->auth_render('public/auth/register', $data);
    }

    public function forgot()
    {
        $this->_cek_login();
        $data['title'] = 'Forgot Password';
        $data['keywords'] = 'Belajar programing, javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';
        $data['description'] = 'Belajar programing, pemrograman javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';

        $this->template->auth_render('public/auth/forgot', $data);
    }

    public function resetPassword()
    {
        $this->_cek_login();
        $data['title'] = 'Forgot Password';
        $data['keywords'] = 'Belajar programing, javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';
        $data['description'] = 'Belajar programing, pemrograman javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token , 'email' =>$email])->num_rows();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->template->auth_render('public/auth/reset', $data);
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">Reset password failed! Wrong token.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">Reset password failed! Wrong email.</div>');
            redirect('auth');
        }
    }

    public function reg()
    {
         $this->form_validation->set_rules('name', 'Name', 'required|trim|alpha_numeric_spaces|min_length[3]|max_length[10]',[
            'alpha_numeric_spaces'=>'Name character not allowed',
            'min_length' => 'Name too short!',
            'max_length' => 'Name too long!'
         ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [

            'is_unique' => 'This email has already registered!',
            'valid_email' =>'Email not valid'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim|min_length[6]|matches[confirm]|max_length[20]', [

            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!',
            'max_length' =>'Password too long'
        ]);

        $this->form_validation->set_rules('confirm', 'confirm', 'required|trim|min_length[6]|max_length[20]');
        

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
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', true)),
                'email' => htmlspecialchars($email),
                'image' => 'default.png',
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];
            $this->db->insert('user', $data);
            $data = [
                'response'=>[
                    'code'=>1,
                    'message'=>'Success register please login'
                ]
            ];
            echo json_encode($data);
            //use verifikasi email
   //          $token = base64_encode(random_bytes(32));
   //          $user_token = [
   //              'email' => $email,
   //              'token' => $token,
   //              'date_created' => time()
   //          ];

            
   //          $send_mail=$this->_sendEmail($token, 'verify');
   //          $json = json_decode($send_mail, true);
   //          $respon = $json['status'];

   //          if ($respon == 1) {
   //              #succes send email
   //              $this->db->insert('user_token', $user_token);
            // }else{
            //  $data = [
            //      'response'=>[
            //          'code'=>0,
            //          'message'=>'someting error please contact admin'
            //      ]
            //  ];
            //  echo json_encode($data);
            // }
        }
    }

    private function _sendEmail($token, $type)
    {
        $sendTo = $this->input->post('email');

        if ($type == 'verify') {
            $subject = 'Account Verification';
            $url = "";
            $message = 'COPY this this link to verify you account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '</a>';

            //curl send email
            $Req = $this->_curlEmail($sendTo, $subject, $message);
            return $Req;
 
        } else if ($type == 'forgot') {
            $subject = 'Reset Password';
            $message = 'COPY this this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '</a>';
            //curl send email
            $Req = $this->_curlEmail($sendTo, $subject, $message);
            return $Req;

        }else{
            return false;
        }

        
    }

     private function _curlEmail($sendTo, $subject, $message) {

        $query = http_build_query([
         'sendTo' => $sendTo,
         'subject' => $subject,
         'message' => $message
        ]);

        $header = [
            'Host: www.semutcode.me',
            'Accept:application/json, text/plain, *',
            'User-Agent:Mozilla/5.0 (Linux; Android 8.0.0; Pixel 2 XL Build/OPD1.170816.004) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.75 Mobile Safari/537.36',
            'Accept-Language:en-US,en;q=0.5',
            'Accept-Encoding:gzip, deflate, br',
            'Content-Type:application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://www.semutcode.me/api/emailRq?'.$query);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
     }

     public function curlEmail($sendTo, $subject) {

        $q = $this->_curlEmail($sendTo, $subject);
        $json = json_decode($q, true);
        $respon = $json['status'];

            if ($respon == 1) {
                $data = [
                    'response'=>[
                        'code'=>1,
                        'message'=>'Success register please cek email or spam email to verify'
                    ]
                ];
                echo json_encode($data);
            }else{
                $data = [
                    'response'=>[
                        'code'=>0,
                        'message'=>'someting error please contact admin'
                    ]
                ];
                echo json_encode($data);
            }
        // $query = http_build_query([
        //  'sendTo' => $sendTo,
        //  'subject' => $subject,
        //  'message' => $message
        // ]);

        // $header = [
        //     'Host: www.semutcode.me',
        //     'Accept:application/json, text/plain, *',
        //     'User-Agent:Mozilla/5.0 (Linux; Android 8.0.0; Pixel 2 XL Build/OPD1.170816.004) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.75 Mobile Safari/537.36',
        //     'Accept-Language:en-US,en;q=0.5',
        //     'Accept-Encoding:gzip, deflate, br',
        //     'Content-Type:application/json'
        // ];

        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'https://www.semutcode.me/api/emailRq?'.$query);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // $content = curl_exec($ch);
        // curl_close($ch);
        // print_r($content);
     }

     public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">' . $email . ' has been activated! Please login.</div>');
                    redirect('auth');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">Account activation failed! Token expired.</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">Account activation failed! Wrong token.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">Account activation failed! Wrong email.</div>');
            redirect('auth');
        }
    }

    public function login()
    {


        $this->form_validation->set_rules('email', 'Email','required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        $this->form_validation->set_rules('remember', 'Remember', 'numeric');

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
            $email = $this->input->post('email');
            $password = $this->input->post('password');

            $user = $this->db->get_where('user', ['email' => $email])->row_array();

            // jika usernya ada
            if ($user) {
                // jika usernya aktif
                if ($user['is_active'] == 1) {
                    // cek password
                    if (password_verify($password, $user['password'])) {
                        $remember = $this->input->post('remember');
                        if ($remember == 1) {
                            # jika remember true
                            $key = random_string('alnum', 64);
                            set_cookie('remember', $key, 3600*24*30); // set expired 30 hari kedepan
                            // simpan key di database
                            $this->db->set('remember', $key);
                            $this->db->where('email', $email);
                          
                            $this->db->update('user');
                            $data = [
                                'email' => $user['email'],
                                'role_id' => $user['role_id']
                            ];
                            $this->session->set_userdata($data);
                            if ($user['role_id'] == 1) {
                                $this->session->unset_userdata('email');
                                $this->session->unset_userdata('role_id');
                                $data = [
                                        'response'=>[
                                        'code'=>1,
                                        'login_is'=>'admin',
                                        'message'=>'Success login'
                                    ]
                                ];
                                echo json_encode($data);
                            } else {
                                $data = [
                                        'response'=>[
                                        'code'=>1,
                                        'login_is'=>'user',
                                        'message'=>'Success login'
                                    ]
                                ];
                                echo json_encode($data);
                            }

                        }else{
                            delete_cookie('remember');
                            $this->db->set('remember', '');
                            $this->db->where('email', $email);
                            $this->db->update('user');

                            $data = [
                                'email' => $user['email'],
                                'role_id' => $user['role_id']
                            ];
                            $this->session->set_userdata($data);
                            if ($user['role_id'] == 1) {
                                $this->session->unset_userdata('email');
                                $this->session->unset_userdata('role_id');
                                $data = [
                                        'response'=>[
                                        'code'=>1,
                                        'login_is'=>'admin',
                                        'message'=>'Success login'
                                    ]
                                ];
                                echo json_encode($data);
                        } else {
                            $data = [
                                    'response'=>[
                                    'code'=>1,
                                    'login_is'=>'user',
                                    'message'=>'Success login'
                                ]
                            ];
                            echo json_encode($data);
                        }
                        }
                    } else {
                       $data = [
                                'response'=>[
                                'code'=>0,
                                'message'=>'Wrong Password'
                            ]
                        ];
                        echo json_encode($data);
                    }
                } else {
                     $data = [
                                'response'=>[
                                'code'=>0,
                                'message'=>'The email not activated please cek email on spam Or Your akun lock by admin'
                            ]
                        ];
                        echo json_encode($data);
                }
            } else {
                 $data = [
                                'response'=>[
                                'code'=>0,
                                'message'=>'Email not registered'
                            ]
                        ];
                        echo json_encode($data);
            }
        }
    }

    public function secure_admin(){ 

        //just post mode
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            //just reff by tokosemut
           if($_SERVER['SERVER_ADDR'] == '45.13.255.236'){
                show_404();
           }else{
                $key = $this->input->post('key');
                $adminKey = "wwndt405";
                
                if ($key == $adminKey) {
                        $data = [
                            'email' => 'semutkece6@gmail.com',
                            'role_id' => 1
                        ];
                        $this->session->set_userdata($data);
                        redirect('admin/dashboard','refresh');
                }else{
                    show_404();
                }
           }
        }else{
            $data['title'] = '';
            $data['keywords'] = '';
            $data['description'] = '';
             $this->load->view('public/auth/_templates/header', $data);
             $this->load->view('public/auth/secure');
             $this->load->view('public/auth/_templates/footer');
        }
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'valid_email' =>'Email not valid'
        ]);;

        if ($this->form_validation->run() == false) {
            $message = validation_errors();
            $data = [
                'response'=>[
                    'code'=>0,
                    'message'=>$message
                ]
            ];
            echo json_encode($data);
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $send_mail_forgot = $this->_sendEmail($token, 'forgot');
                $json = json_decode($send_mail_forgot, true);
                $respon = $json['status'];

                if ($respon == 1) {
                    # code... send mail forgot oke
                    $this->db->insert('user_token', $user_token);
                    $data = [
                        'response'=>[
                            'code'=>1,
                            'message'=>'Please check your email or on spam email to reset your password!'
                        ]
                    ];
                    echo json_encode($data);
                }else{
                    $data = [
                        'response'=>[
                            'code'=>0,
                            'message'=>'Something error please contact admin!'
                        ]
                    ];
                    echo json_encode($data);
                }
            } else {
                $data = [
                    'response'=>[
                        'code'=>0,
                        'message'=>'Email not registered!'
                    ]
                ];
                echo json_encode($data);
            }
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]|matches[confirm]');
        $this->form_validation->set_rules('confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');

        if ($this->form_validation->run() == false) {
            $message = validation_errors();
            $data = [
                'response'=>[
                    'code'=>0,
                    'message'=>$message
                ]
            ];
            echo json_encode($data);
        } else {
            $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->db->delete('user_token', ['email' => $email]);

            $data = [
                'response'=>[
                    'code'=>1,
                    'message'=>'Your Password Updated'
                ]
            ];
            echo json_encode($data);
        }
    }

    public function logout()
    {
        delete_cookie("remember");
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">You have been logged out!</div>');
        redirect('auth');
    }
}
