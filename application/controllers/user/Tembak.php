<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tembak extends User_Controller {

	private $countnow;

	function __construct() {
		parent::__construct();
		$now = new DateTime();
	    $time = $now->format('Y-m-d');
		$this->db->where('time', $time);
		$this->data['count'] = $this->db->get('xl')->num_rows();

		$persen = ($this->data['count'] / 50 * 100);
		$this->data['persen'] = $persen.'%';
		$this->countnow = $this->data['count'];
	}

	private function _request($url,$data,$header) {
		if ($this->countnow >= 50) {
			echo "limit today comeback tommorow!";
			die;
		}
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	 //    curl_setopt($ch, CURLOPT_HEADER, 1);
		// curl_setopt($ch, CURLINFO_HEADER_OUT, true);
	    $data =curl_exec($ch);
	    return $data;
    }

    private function _request2($url,$data,$header,$method)
    {
    	if ($this->countnow >= 50) {
			echo "limit today comeback tommorow!";
			die;
		}
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, 'https://'.$url);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
    	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $data =curl_exec($ch);
   	 	return $data;
    }

	public function index()
	{
		$token = $this->session->userdata('token');
		
		if (isset($token)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-warning" role="alert">If error req otp again!</div>');
		     	redirect('user/tembak/beli','refresh');
		}
		$this->data['title'] = "XL v.2";
		$this->template->user_render('user/tembak/index', 'user/_templates/footer', $this->data);
	}

	public function login()
	{
		$number = $this->session->userdata('number');
		if (!isset($number)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">please req otp!</div>');
		     	redirect('user/tembak','refresh');
		}
		$this->data['title'] = "XL v.2";
		$this->template->user_render('user/tembak/login', 'user/_templates/footer', $this->data);
	}

	public function beli()
	{
		$token = $this->session->userdata('token');
		if (!isset($token)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">please login!</div>');
		     	redirect('user/tembak/login','refresh');
		}
		$this->data['title'] = "XL v.2";
		$this->template->user_render('user/tembak/beli', 'user/_templates/footer', $this->data);
	}

	public function action_getotp() {
		$number = $this->input->post('number');
		$getotp = $_POST['getotp'];

		if (isset($getotp)) {
			$exec = $this->_getOtp($number);
			$respon =json_decode($exec,true);
	        if($respon['statusCode'] == 200){
		        $data = array(
		        	'number' => $number
		        );
		        $this->session->set_userdata( $data );
		        $this->session->set_flashdata('msg', '<div class="alert alert-success" role="alert">otp sended cek your sms!</div>');
		        redirect('user/tembak/login','refresh');
		     }else{ 
		     	$this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">'.$respon['result']['message'].'</div>');
		     	redirect('user/tembak/','refresh');
		     }
		}else{
			echo "error click";
		}
	}

	public function action_login() {
		$number = $this->session->userdata('number');
		if (!isset($number)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">please req otp!</div>');
		     	redirect('user/tembak','refresh');
		}
		$otp = $this->input->post('otp');

		$login = $_POST['login'];

		if (isset($login)) {
			$exec = $this->_login($number, $otp);
			$respon =json_decode($exec,true);

	        if($respon['statusCode']==200){
		        $data = array(
		        	'number' => $respon['result']['user']['msisdn_enc'],
		        	'token' => $respon['result']['accessToken']

		        );
		        $this->session->set_userdata( $data );
		        $this->session->set_flashdata('msg', '<div class="alert alert-success" role="alert">login success!</div>');
		        redirect('user/tembak/beli','refresh');
		     }else{
		     	// print_r($respon);
		     	// die;
		     	if (empty($respon['result']['error'])) {
		     		$msg = $respon['result']['errorMessage'];
		     	}else{
			     	$msg = $respon['result']['error'];
		     	}


		     	$this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">'.$msg.'</div>');
		     	redirect('user/tembak/login','refresh');
		     }
		}else{
			echo "error click";
		}

	}

	public function action_beli() {
		$select = $this->input->post('reg');

		$number = $this->session->userdata('number');
		$id = $this->serviceid($select);
		$token = $this->session->userdata('token');
		
		if (!isset($token)) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">please login!</div>');
		     	redirect('user/tembak/login','refresh');
		}

		$beli = $_POST['beli'];

		if (isset($beli)) {
			// $exec = $this->_beli($number, $id, $token);
			$exec = $this->_bestoffer($number, $id, $token);
			$respon =json_decode($exec,true);
			print_r($respon);
			die;
	        if($respon['statusCode']==200){
	        	//save data to xl
	        	$now = new DateTime();
	            $time = $now->format('Y-m-d');
	        	$data = [
	        		'user_id' => $this->email_login->id,
	        		'time'	  => $time
	        	];

	        	$this->db->insert('xl', $data);

	        	//auto logout
	        	$token = $this->session->userdata('token');
	        	$exec_logout = $this->_logout($token);
	        	if ($exec_logout == true) {
			        $this->session->set_flashdata('msg', '<div class="alert alert-success" role="alert">success! 
			        	Thanks for support! Login again for dor</div>');

			        redirect('user/tembak','refresh');
	        	}
		        
		     }else{ 
		     	$this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">'.$respon['statusMessage'].'</div>');
		     	redirect('user/tembak/beli','refresh');
		     }
		}else{
			echo "error click";
		}

	}

	private function _getOtp($no) {
		$uro='https://otp-service.apps.dp.xl.co.id/v1/generate/'.$no.'/MYXLAPP_LOGIN_ID';

		//header
        $hro=[
               'origin: http://localhost:9634',
               'x-apicache-bypass: true',
               'authorization: Basic ZGVtb2NsaWVudDpkZW1vY2xpZW50c2VjcmV0',
               'content-type: application/json',
               'accept: application/json, text/plain, */*',
               'cache-control: no-cache',
               'user-agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
               'referer: http://localhost:9634/login',
               //accept-encoding: gzip, deflate
               'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
               'x-requested-with: id.co.xl.myXL'
             ];

        //body
        $jro=['test'=>'""'];
        $dro=json_encode($jro);
        $rro=$this->_request($uro,$dro,$hro,null);
        return $rro;
	}

	private function _login($no, $otp) {
		$imei1 = "d4e7f273-abb0-4128-8671-430372103258";
		$imei2 = "15a70479-a65b-553e-3583-100737497658";
		$imei3 = "83ba7ece-513f-eff2-0219-969156000090";

		$imeiArray = array($imei1, $imei2, $imei3);
		$imeirand = $imeiArray[rand(0, count($imeiArray)-1)];

		$ulog='login-controller-service.apps.dp.xl.co.id/v1/login/otp/auth?msisdn='.$no.'&imei='.$imeirand.'&otp='.$otp.'&channel=MYXLAPP_LOGIN_ID';
        $dlog='';
        $hlog=[
                'h2',
                'accept: application/json, text/plain, */*',
                'cache-control: no-cache',
                'origin: http://localhost:9634',
                'x-apicache-bypass: true',
                'authorization: Basic ZGVtb2NsaWVudDpkZW1vY2xpZW50c2VjcmV0',
                'user-agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
                'referer: http://localhost:9634/login',
                //'accept-encoding: gzip, deflate',
                'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
                'x-requested-with: id.co.xl.myXL'
              ];
         $rlog = $this->_request2($ulog,$dlog,$hlog,'GET');
         return $rlog;
	}

	private function _beli($number, $id, $token) {
		$ubuy='https://subscription-service.apps.dp.xl.co.id/v1/package/subscribev3';
         $dbuy=[
                  'msisdn'=>$number,
                  'serviceId'=>$id
               ];
         $dbuy=json_encode($dbuy);
         $hbuy=[
                 'origin: http://localhost:9634',
                 'x-apicache-bypass: true',
                 'authorization: Bearer '.$token,
                 'content-type: application/json',
                 'accept: application/json, text/plain, */*',
                 'cache-control: no-cache',
                 'user-agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
                 'referer: http://localhost:9634/thankyou',
               //'accept-encoding: gzip, deflate',
                 'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
                 'x-requested-with: id.co.xl.myXL'
                ];
         $rbuy=$this->_request($ubuy,$dbuy,$hbuy,null); 
         return $rbuy;
	}

	private function _bestoffer($number, $id, $token) {
		$ubuy='https://subscription-service.apps.dp.xl.co.id/v1/bestoffer/redeem';
         $dbuy=[
                  'msisdn'=>$number,
                  'promo_action'=> 'ACCEPTED',
                  'promo_id'=>$id
               ];
         $dbuy=json_encode($dbuy);
         $hbuy=[
                 'origin: http://localhost:9634',
                 'x-apicache-bypass: true',
                 'authorization: Bearer '.$token,
                 'content-type: application/json',
                 'accept: application/json, text/plain, */*',
                 'cache-control: no-cache',
                 'user-agent: Mozilla/5.0 (Linux; Android 7.1.2; Redmi Note 5A Build/N2G47H; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/74.0.3729.157 Mobile Safari/537.36',
                 'referer: http://localhost:9634/thankyou',
               //'accept-encoding: gzip, deflate',
                 'accept-language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7',
                 'x-requested-with: id.co.xl.myXL'
                ];
         $rbuy=$this->_request($ubuy,$dbuy,$hbuy,null); 
         return $rbuy;
	}

	public function logout() {
		$token = $this->session->userdata('token');
		
		$uro='login-controller-service.apps.dp.xl.co.id/v1/login/token/logout';

		//header
        $hro=[
               	// 'Host: login-controller-service.apps.dp.xl.co.id',
				// 'content-length: 2',
				'origin: http://localhost:9634',
				'x-apicache-bypass: true',
				'authorization: Bearer '.$token,
				'content-type: application/json',
				'accept: application/json, text/plain, */*',
				'cache-control: no-cache',
				'user-agent: Mozilla/5.0 (Linux; Android 5.1.1; SM-J105F Build/LMY47V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/66.0.3359.126 Mobile Safari/537.36',
				'referer: http://localhost:9634/navigation',
				// 'accept-encoding: gzip, deflate',
				'accept-language: id-ID,en-US;q=0.9',
				'x-requested-with: id.co.xl.myXLq'
             ];

        //body
        $dro='{}';
        $rro=$this->_request2($uro,$dro,$hro,'POST');

        $respon =json_decode($rro,true);
        if($respon['statusCode'] == 200){
	        $this->session->unset_userdata('number');
	        $this->session->unset_userdata('token');

	        $this->session->set_flashdata('msg', '<div class="alert alert-success text-center" role="alert">You have been logged out please support with buy my produk!</div>');
	        redirect('user/tembak');
	     }else{ 
	     	$this->session->unset_userdata('number');
	        $this->session->unset_userdata('token');
	     	$this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">Logout server gagal</div>');
	     	redirect('user/tembak/','refresh');
	     }
        
	}

	private function _logout($token) {
		
		$uro='login-controller-service.apps.dp.xl.co.id/v1/login/token/logout';

		//header
        $hro=[
               	// 'Host: login-controller-service.apps.dp.xl.co.id',
				// 'content-length: 2',
				'origin: http://localhost:9634',
				'x-apicache-bypass: true',
				'authorization: Bearer '.$token,
				'content-type: application/json',
				'accept: application/json, text/plain, */*',
				'cache-control: no-cache',
				'user-agent: Mozilla/5.0 (Linux; Android 5.1.1; SM-J105F Build/LMY47V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/66.0.3359.126 Mobile Safari/537.36',
				'referer: http://localhost:9634/navigation',
				// 'accept-encoding: gzip, deflate',
				'accept-language: id-ID,en-US;q=0.9',
				'x-requested-with: id.co.xl.myXLq'
             ];

        //body
        $dro='{}';
        $rro=$this->_request2($uro,$dro,$hro,'POST');

        $respon =json_decode($rro,true);
        if($respon['statusCode'] == 200){
	        $this->session->unset_userdata('number');
	        $this->session->unset_userdata('token');

	        return true;
	     }else{ 
	     	$this->session->unset_userdata('number');
	        $this->session->unset_userdata('token');
	     	
	     	return false;
	     }
        
	}

	protected function serviceid($select) {
		switch ($select) {
			case 1:
				return "pJbYYAgsywYL89OTmdUNd4y56OKCpE65M7eLWIHURlFpcEUOt6npKZgYYqFsTrIlKwjbEfh8rajiZ4nHuq9pnQ%3D%3D";
				break;
			case 2:
				return "hjXKAEP%2BxNvvhV5g0Ny5jOxjSSvyiNzqK7Uye3wxRIINt6UMlV%2Fo977ymNJExTDmKB%2FKhhCqytaQpckdV%2FK7ug%3D%3D";
				break;
			case 3:
				return "cHyjGhHERyoX9dwi2h1DjgYh1PGMSqxNOxejPJLkLt0tCxxYtGZuccWQwMNpUcENNCUgoNyG1M0OPBe04d0X6g%3D%3D";
			case 4:
				return "Iw0VN33dh8ipK6XPNutekiojX42r0lmqSY51Qs65CVGoq7WO8XgZOpy86pgoL3If%2B8Y678zxWD90RaK8JPjgjQ%3D%3D";
				break;
			case 5:
				return "b7xIzJu0m%2F%2FtSasiYnNRRCWrd%2BIzhFR4MZz%2F1llNcEtgvX4xQU9hFqsK%2F8NLypfiyU%2BS9djZZN4%2F6%2Bfj7vJdVA%3D%3D";
				break;
			case 6:
				return "yyztU3He4CPpwgv0F1q5lg8uk44c6SPfIe6W87sbBkkyfNVOnC11GbL0tUU7%2FiCouw%2FYehwG3Zp3CLgO4VD7jA%3D%3D"; //10gb 53rb
				break;
			case 7:
				return "7svpwSipUaPVaW41N9JVxQ8uk44c6SPfIe6W87sbBkkyfNVOnC11GbL0tUU7%2FiCoJu2zDniIcoX5we5BDm6ivQ%3D%3D"; //0 50mb wa
				break;
			case 8:
				return "SMq%2FnJeVGXYasL04%2BMZkig8uk44c6SPfIe6W87sbBkkyfNVOnC11GbL0tUU7%2FiCoVgziYaxzuViAif0eLraBtQ%3D%3D"; //0 iflix 500MB
				break;
			case 9:
				return "hV3Nz60%2FTrjKhci3oroltA8uk44c6SPfIe6W87sbBkkyfNVOnC11GbL0tUU7%2FiCoVgziYaxzuViAif0eLraBtQ%3D%3D"; //0 Joox 500MB
				break;
			case 10:
				return "PFThtbGpJLBann5erro%2Bag8uk44c6SPfIe6W87sbBkkyfNVOnC11GbL0tUU7%2FiCoVgziYaxzuViAif0eLraBtQ%3D%3D"; //0 AOV 500MB
				break;
			case 11:
				return "64U%2FOWfgllQV%2FbJhihvYyg8uk44c6SPfIe6W87sbBkkyfNVOnC11GbL0tUU7%2FiCoVgziYaxzuViAif0eLraBtQ%3D%3D"; //0 Smule 500MB
				break;
			case 12:
				return "7FRRZJc6gt3Xz5a%2BjFmzkg8uk44c6SPfIe6W87sbBkkyfNVOnC11GbL0tUU7%2FiCoVgziYaxzuViAif0eLraBtQ%3D%3D"; //0 Tokopedia 50MB
				break;
			case 13:
				return "FqcC4czDpx%2B%2FSFSHwrYvug8uk44c6SPfIe6W87sbBkkyfNVOnC11GbL0tUU7%2FiCoVgziYaxzuViAif0eLraBtQ%3D%3D"; //0 Google Duo 50MB
				break;
			case 14:
				return "hDBqLUNyElr4vmgm8OBJbp0vNYrjeXRD6qdiJJ8Gm6ALa9uDy9ALUtO03uOqEEON2h2wntgeqDWB2pnN0l0W9A%3D%3D"; //0 Facebook 500MB
				break;
			case 15:
				return "I%2BtGcE5IfXVMmpStjhCqPj6fhBvFvMKLE9%2B7%2FEoBkTh2GD5P%2BSb5a7J0ASJ%2FJZGMhtx8ZxrdwgEbtvhBSu9yHw%3D%3D"; //Xtra Kuota 30GB
				break;
			
		}
	}

}

/* End of file Tembak.php */
/* Location: ./application/controllers/user/Tembak.php */
