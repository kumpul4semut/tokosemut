<?php

class Ovoload
{
	// protected $ovoid;

	protected $ci;

	private $ch;

	private $header;

	private $authToken;

	public function __construct() {	
        $this->ch = curl_init();
        $this->ci =& get_instance();
		$this->header = [
            'app-id'      =>'C7UMRSMFRZ46D9GW9IK7',
            'App-Version' =>'3.0.0',
            'OS'	  =>'Android'
        ];
        $this->authToken = $this->ci->db->get_where('mutasi', ['id' => 1])->row()->token;
	}

	private function _aditionalHeader()
    {
        $temp = ['Authorization'=> $this->authToken];

        return array_merge($temp, $this->header);
    }

	public function post($url, $data, $headers)
    {
        $headerJson = ['Content-Type: application/json;charset=UTF-8'];

        $tempHeaders = [];

        foreach ($headers as $key => $value) {
            array_push($tempHeaders, $key . ': ' . $value);
        }
        $headers = array_merge($headerJson, $tempHeaders);
        
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);

        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($this->ch);
        return $result;
        curl_close($this->ch);

    }

    public function get($url, $data, $headers)
    {
        $headerJson = ['Content-Type: application/json;charset=UTF-8'];

        $tempHeaders = [];

        foreach ($headers as $key => $value) {
            array_push($tempHeaders, $key . ': ' . $value);
        }
        $headers = array_merge($headerJson, $tempHeaders);

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, false);
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($this->ch);
        return $result;
    }

    function gen_uuid(){
	    return sprintf(
	        '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
	        // 32 bits for "time_low"
	        mt_rand(0, 0xffff),
	        mt_rand(0, 0xffff),

	        // 16 bits for "time_mid"
	        mt_rand(0, 0xffff),

	        // 16 bits for "time_hi_and_version",
	        // four most significant bits holds version number 4
	        mt_rand(0, 0x0fff) | 0x4000,

	        // 16 bits, 8 bits for "clk_seq_hi_res",
	        // 8 bits for "clk_seq_low",
	        // two most significant bits holds zero and one for variant DCE1.1
	        mt_rand(0, 0x3fff) | 0x8000,

	        // 48 bits for "node"
	        mt_rand(0, 0xffff),
	        mt_rand(0, 0xffff),
	        mt_rand(0, 0xffff)
	    );
	}

	public function reqOtp($mobile_number) {
        $headers = [
            'app-id'      =>'C7UMRSMFRZ46D9GW9IK7',
            'App-Version' =>'3.0.0'
        ];

        $data = [
            'deviceId' => $this->gen_uuid(),
            'mobile'   => $mobile_number
        ];

        $exec = $this->post('https://api.ovo.id/v2.0/api/auth/customer/login2FA', $data, $headers);
        return $exec;

	}

	public function login($otp) {
         $data = [
            'appVersion'        => '3.0.0',
            'deviceId'          => $this->gen_uuid(),
            'macAddress'        => '02:00:00:44:55:66',
            'mobile'            => $this->ci->session->userdata('nomor'),
            'osName'            => 'Android',
            'osVersion'         => '8.1.0',
            'pushNotificationId'=> 'FCM|f4OXYs_ZhuM:APA91bGde-ie2YBhmbALKPq94WjYex8gQDU2NMwJn_w9jYZx0emAFRGKHD2NojY6yh8ykpkcciPQpS0CBma-MxTEjaet-5I3T8u_YFWiKgyWoH7pHk7MXChBCBRwGRjMKIPdi3h0p2z7',
            'refId'             => $this->ci->session->userdata('refId'),
            'verificationCode'  => $otp
        ];

        $exec = $this->post('https://api.ovo.id/v2.0/api/auth/customer/login2FA/verify', $data, $this->header);
        return $exec;

	}

	public function loginSecurity($pin) {
         $data = [
            'deviceUnixtime'   => 1543693061,
            'securityCode'     => $pin,
            'updateAccessToken'=> $this->ci->session->userdata('updateAccessToken'),
            'message'          => ''
        ];

       $exec = $this->post('https://api.ovo.id/v2.0/api/auth/customer/loginSecurityCode/verify', $data, $this->header);
        return $exec;

	}

	public function balanceModel()
    {
        return $this->get('https://api.ovo.id/v1.0/api/front/', null, $this->_aditionalHeader());
    }

    public function getWalletTransaction($page, $limit = 100)
    {
        $url = 'https://api.ovo.id/wallet/v2/transaction?page=' . $page . '&limit=' . $limit . '&productType=001';
        $mutasis = $this->get($url,null,$this->_aditionalHeader());
        $yesterday = date('Y-m-d', strtotime("-1 days"));
        $today = date('Y-m-d',time());
        $arrayMutasis = json_decode($mutasis, true);

        $dataMutasi = []; 
        foreach ($arrayMutasis['data'] as $mutasi) {
            foreach ($mutasi['complete'] as $muta) {
                if ($muta['transaction_date'] == $yesterday || $muta['transaction_date'] == $today) {
                    array_push($dataMutasi, $muta);
                }
            }
        }

        return $dataMutasi;
    }
}

/* End of file Ovoload.php */
/* Location: ./application/libraries/ovo/Ovoload.php */
