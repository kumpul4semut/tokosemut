<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Tembak xl 2019
 * @author kumpul4semut
 */
class Xl extends CI_Controller
{
    /*
    * template load
    */
    private function _template($content, $footer, $data=null)
    {
        $this->template->public_render($content, $footer, $data);
    }
	
	function __construct()
	{
        parent::__construct();
        redirect('','refresh');
        $this->load->library('Xlcurl','','xl');
        // $this->load->library('Dor/XlRequest','','xl');
    }

	public function index()
	{
		$data['title'] = 'Tembak Paket Xl - ' .ucwords($_SERVER['HTTP_HOST']);
        $data['keywords'] = 'Belajar programing, javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';
        $data['description'] = 'Belajar programing, pemrograman javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';

		$this->_template('public/req_otp_xl', 'public/_templates/footer', $data);
		
        
	}

	public function login()
	{
		$data['title'] = 'Tembak Paket Xl - ' .ucwords($_SERVER['HTTP_HOST']);
        $data['keywords'] = 'Belajar programing, javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';
        $data['description'] = 'Belajar programing, pemrograman javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';

        $msisdn = $this->session->userdata('msisdn');

        if ($msisdn) {
            $this->_template('public/login_xl','public/_templates/footer',$data);
        }else{
            redirect('xl', 'refresh');
            exit;
        }
        
        
	}

	public function beli()
	{
		$data['title'] = 'Tembak Paket Xl - ' .ucwords($_SERVER['HTTP_HOST']);
        $data['keywords'] = 'Belajar programing, javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';
        $data['description'] = 'Belajar programing, pemrograman javascript, python, php, bash shell, css, codeigniter, boostrap, react, node js';

        $session = $this->session->userdata('dor');
        $msisdn = $this->session->userdata('no');
        if ($session && $msisdn) {
            $this->_template('public/req_paket_xl','public/_templates/footer',$data);
        }else{
            redirect('xl');
            exit;
        }
        
	}

	public function req_otp()
	{

        $msisdn = $this->input->post('msisdn');
        if($msisdn == "")
        {
            echo "nomor kosong";
        }else {
            $pass = $this->xl->getPass($msisdn);
            $respon = $pass->LoginSendOTPRs->headerRs;

            if ($respon->responseCode == 0)
            {
                $this->session->set_userdata('msisdn', $msisdn);
                echo ($respon->responseMessage);
            }
            else 
            {
                foreach($respon as $key=>$value) 
                {
                    echo $key . ' : ' . $value . "<br>";
                }
            }
        }
	}

	public function req_login()
	{
		$msisdn = $this->session->userdata('msisdn');
        $otpCode = $this->input->post('otpCode');
        if($msisdn == "" && $otpCode == "")
        {
        echo "INVALID_OTP";
        }else{
                try
                {
                    $login = $this->xl->login($msisdn,$otpCode);
                    print_r($login);
                    // if ($login->LoginValidateOTPRs->responseCode == 00) {
                    //     $sesi = $login->sessionId;
                    //     $this->session->set_userdata('dor', $sesi);
                    //     $this->session->set_userdata('no', $msisdn);
                    //     echo "Success Login";
                    // }else{
                    //     echo "INVALID_OTP";
                    // }
                }catch(Exception $e) {}
                    
            } 
	}

	public function req_paket()
	{
		$reg = $this->input->post('reg');
        if($reg == ""){
            echo "Paket Tidak Dipilih";
        }else{
            $session = $this->session->userdata('dor');
            $msisdn = $this->session->userdata('no');
            $serviceID = $this->service($reg);
            if ($serviceID == "diskon") {
                $exec = $this->xl->diskon($session);
                print_r($exec);
            }else{
                try
                {
                    $register = $this->xl->register($msisdn, $serviceID, $session);
                    $register2 = $this->xl->register2($msisdn, $serviceID, $session);
                    $register3 = $this->xl->register3($msisdn, $serviceID, $session);
                    $register4 = $this->xl->register4($msisdn, $serviceID, $session);
                    $register5 = $this->xl->register5($msisdn, $serviceID, $session);
                    $register6 = $this->xl->register6($msisdn, $serviceID, $session);
                    if (!isset($register->responseCode)){
                        echo "Paket Berhasil Dibeli Jangan Lupa Dukung Semut!";
                    }elseif (!isset($register2->responseCode)) {
                        echo "Paket Berhasil Dibeli Jangan Lupa Dukung Semut!";
                    }elseif (!isset($register3->responseCode)) {
                        echo "Paket Berhasil Dibeli Jangan Lupa Dukung Semut!";
                    }elseif (!isset($register4->responseCode)) {
                        echo "Paket Berhasil Dibeli Jangan Lupa Dukung Semut!";
                    }elseif (!isset($register5->responseCode)) {
                        echo "Paket Berhasil Dibeli Jangan Lupa Dukung Semut!";
                    }elseif (!isset($register6->responseCode)) {
                        echo "Paket Berhasil Dibeli Jangan Lupa Dukung Semut!";
                    }else{
                        $pesan = $register->message;
                        $pesan2 = $register2->message;
                        $pesan3 = $register3->message;
                        $pesan4 = $register4->message;
                        $pesan5 = $register5->message;
                        $pesan6 = $register6->message;
                        echo "$pesan"."|"."$pesan2"."|"."$pesan3"."|"."$pesan4"."<br>";
                         }
                        
                }catch(Exception $e) {}
            }    
        }
	}

	public function xl_logout()
	{
		$_SESSION = [];
        session_unset();
        session_destroy();

        redirect('xl', 'refresh');
        exit;
	}

	public function service($str) {
        
        switch ((int) $str) {
            
        case 1: return 8110671;
        break;
        
        case 2: return 8211010;
        break;
        
        case 3: return 8211011;
        break;

        case 4: return 8211012;
        break;
        
        case 5: return 8211013;
        break;

        case 6: return 8211014;
        break;

        case 7: return 8211170;
        break;
        
        case 8: return 8211171;
        break;
        
        case 9: return 8211172;
        break;
        
        case 10: return 8211173;
        break;
        
        case 11: return 8211116;
        break;


         case 12: return 8211365;
        break;

        case 13: return 8211366;
        break;
        
        case 14: return 8211367;
        break;
        
        case 15: return 8211368;
        break;
        
        case 16: return 8211369;
        break;
        
        case 17: return 8211370;
        break;
        
        case 18: return 8211371;
        break;
        
        case 19: return 8211372;
        break;

        case 20: return 8211373;
        break;

        case 21: return 8211374;
        break;

        case 22: return 8211375;
        break;
        
        case 23: return 8211376;
        break;
   
        case 24: return 8211377;
        break;
        
        case 25: return 8211378;
        break;

        case 26: return 8211379;
        break;

        case 27: return 8211380;
        break;

        case 28: return 8211381;
        break;

        case 29: return 8211382;
        break;

        case 30: return 8211383;
        break;

        case 31: return 8211384;
        break;

        case 32: return 8211345;
        break;

        case 33: return 8211386;
        break;

        case 34: return 8211387;
        break;

        case 35: return 8211388;
        break;

        case 36: return 8211389;
        break;

        case 37: return 8211472; //6gb 27k
        break;

        case 38: return 8211473;
        break;

        case 39: return 8211474;
        break;

        case 40: return 8211475;
        break;
        
        case 41: return 8210882;
        break;

        case 42: return 8210883;
        break;
        
        case 43: return 8210884;
        break;

        case 44: return 8210885;
        break;
        
        case 45: return 8210886;
        break;

        case 46: return 8210883;
        break;
        
        case 47: return 8210884;
        break;

        case 48: return 8210885;
        break;

        case 49: return 8210886;
        break;

        case 50: return 8211107;
        break;

        case 51: return 8211108;
        break;
        
        case 52: return 8211109;
        break;

        case 53: return 8211110;
        break;

        case 54: return 8211111;
        break;

        case 55: return 8210962;
        break;

        case 56: return 8110801; //waze
        break;

        case 57: return 9120319; //boster
        break;

        case 58: return 8211309; //biz
        break;

        case 59: return 8211482; //6gb 35k
        break;

        case 60: return 8211483;
        break;

        case 61: return 8211484;
        break;

        case 62: return 8211485;
        break;

        case 63: return 8211486;
        break;

        case 64: return 8210962; //sms unli
        break;

        case 65: return 8110799; //fb 2gb 10k
        break;

        case 66: return 8110800; 
        break;

        case 67: return 8110801; 
        break;

        case 68: return 8110803;
        break;

        case 69: return 8110813;
        break;

        case 70: return 8110810;
        break;

        case 71: return 8110811;
        break;

        case 72: return 8110812;
        break;
        
       case 73: return 1210863;
        break; 
        
       case 74: return 1210864;
        break; 
        
        case 75: return 8110912; //vip club joox 2gb
        break;
        
        case 76: return 8110919;
        break;
        
        case 77: return 8110923;
        break;
        
        case 78:return 8110926;
        break;
        
        case 79:return 8110913;
        break;
        
        case 80:return 8110935;
        break;
        
        case 81:return 8110936;
        break;
        
        case 82:return 8110916;
        break;
        
        case 83:return 8211285; //20gb 89rb
        break;

        case 84:return "diskon"; //diskon
        break;

        case 85:return 8220260; //
        break;
        
                       
        default;
            
        }
    }
}
