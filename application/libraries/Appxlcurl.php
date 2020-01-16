<?php 
/**
 * 
 */
class appXlcurl
{
	
	private $imei; 
	
	private $date;

	private $head;

	private $urlReg;

	private $subscriber;
		
	function __construct() {
		$this->imei = '15a70479a65b553e';	
		$this->date = date('Ymdhis');
		$this->head = array(
    		'Host: my.xl.co.id',
			'Accept:application/json, text/plain, *',
			'User-Agent:Mozilla/5.0 (Linux; Android 8.0.0; Pixel 2 XL Build/OPD1.170816.004) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.75 Mobile Safari/537.36',
			'Accept-Language:en-US,en;q=0.5',
			'Accept-Encoding:gzip, deflate, br',
			'Content-Type:application/json'
		);
		$this->urlReg = "https://my.xl.co.id/prepaid/opPurchase";
		$this->subscriber = '1172736593'; 
		
	}

	private function _curl($data, $url){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$this->head);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');
        $server_output = curl_exec ($ch);
        curl_close ($ch);
        return json_decode($server_output);
	}

	public function getPass($msisdn){
    $payload = array (
		'header'=> null,
			'Body'=> array (
				'Header'=> array (
					'ReqID'=>substr($this->date, 11),
					'IMEI'=>$this->imei
					),
				'LoginSendOTPRq'=> array (
					'msisdn'=>$msisdn
				)
			),
			'sessionId'=>null,
            'onNet' => 'False',
            'platform' => '04',
            'serviceId' => '',
            'packageAmt' => '',
            'reloadType' => '',
            'reloadAmt' => '',
            'packageRegUnreg' => '',
            'appVersion' => '3.7.0',
            'sourceName' => 'Chrome',
            'sourceVersion' => '',
            'screenName' => 'login.enterLoginNumber'
		);
        
        $data = json_encode($payload, true);
        $url = "https://my.xl.co.id/prepaid/LoginSendOTPRq";
        $exec = $this->_curl($data, $url);

        return $exec;        
     }

    public function login($msisdn, $otpCode){

	   $payload = array (
	    "Header"=>null,
	    "Body"=>array (
	        "Header" => array(
	            "ReqID"=> substr($this->date, 10),
	            "IMEI"=> $this->imei
	            ),
	            "LoginValidateOTPRq"=> array(
	                "headerRq"=>array(
	                    "requestDate"=> substr($this->date, 8),
	                    "requestId" =>substr($this->date, 10),
						"channel" => "MYXLPRELOGIN"
					),
	                "msisdn" => $msisdn,
	                "otp" => $otpCode
	                )
	        	),
        "sessionId"=>null,
        "platform"=>"04",
        "msisdn_Type"=>"P",
        "serviceId"=>"",
        "packageAmt"=>"",
        "reloadType"=>"",
        "reloadAmt"=>"",
        "packageRegUnreg"=>"",
        "appVersion"=>"3.8.6",
        "sourceName"=>"Android",
        "sourceVersion"=>"5.1.1",
        "screenName"=>"login.enterLoginOTP",
        "mbb_category"=>""
        );
        
        $data = json_encode($payload, true);
        $url  = "https://my.xl.co.id/prepaid/LoginValidateOTPRq";
        $exec = $this->_curl($data, $url);

        return $exec;
     }

     public function register($msisdn, $serviceID, $session) {

	   $payload = array(
	       "Header"=>null,
	       "Body"=> array(
	           "HeaderRequest"=>array(
	               "applicationID"=>"3",
	               "applicationSubID"=>"1",
	               "touchpoint"=>"MYXL",
	               "requestID"=>substr($this->date, 10),
	               "msisdn"=>$msisdn,
	               "serviceID"=>$serviceID
	               ),
	                 "opPurchase"=> array(
	                   "msisdn"=>$msisdn,
	                    "serviceid"=>$serviceID
	                    ),
	                   "XBOXRequest"=>array(
						   "requestName"=>"GetSubscriberMenuId",
						   "Subscriber_Number"=>$this->subscriber,
						   "Source"=>"mapps",
						   "Trans_ID"=>'119520832111',
						   "Home_P0C"=>'LB0',
						   "PRICE_PLAN"=>'513698684',
						   "PayCat"=>"PRE-PAID",
						   "Rembal"=>"0",
						   "IMSI"=>'510110032177230',
						   "IMEI"=>'3571250436519001',
						   "Shortcode"=>"mapps"
						),
	                     "Header"=>array(
	                         "IMEI"=> $this->imei,
	                         "ReqID"=>substr($this->date, 10)
	                    )
	                    ),
        "sessionId" => $session,
        "serviceId"=> $serviceID,
        "packageRegUnreg"=>"Reg",
        "reloadType"=>"",
        "reloadAmt"=>"",
        "platform"=>"04",
        "appVersion"=>"3.8.1",
        "sourceName"=>"Firefox",
        "sourceVersion"=>"",
        "msisdn_Type"=>"P",
        "screenName"=>"home.storeFrontReviewConfirm",
        "mbb_category"=>""
        );

		$data = json_encode($payload, true);
        $url  = $this->urlReg;
        $exec = $this->_curl($data, $url);

        return $exec;
	}

	public function roda($msisdn,$session) {

	   $payload = array (
	    "Header"=>null,
	    "Body"=>array (
	        "Header" => array(
	            "ReqID"=> substr($this->date, 10),
	            "IMEI"=> $this->imei
	            ),
	            "opGetGamingOffersRq"=> array(
	                "msisdn" => $msisdn,
	            )
	        	),
        "sessionId"=>$session,
        "platform"=>"00",
        "serviceId"=>"",
        "packageAmt"=>"",
        "reloadType"=>"",
        "reloadAmt"=>"",
        "packageRegUnreg"=>"",
        "appVersion"=>"3.8.6",
        "sourceName"=>"Android",
        "sourceVersion"=>"5.1.1",
        "msisdn_Type"=>"P",
        "screenName"=>"myXlPlay",
        "mbb_category"=>""
        );

		$data = json_encode($payload, true);
        $url  = "https://my.xl.co.id/prepaid/opGetGamingOffersRq";
        $exec = $this->_curl($data, $url);

        return $exec;
	}

}