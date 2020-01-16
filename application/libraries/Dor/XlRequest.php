<?php

set_include_path(get_include_path() . PATH_SEPARATOR . APPPATH . 'libraries/Dor/vendor');
include(APPPATH . 'libraries/Dor/vendor/autoload.php');
use GuzzleHttp\Client;

class XlRequest {
	
	private $imei; 
	
	private $msisdn;
	
	private $client;
	
	private $header;
	
	private $session;
	
	private $date;

	private $subscriber1;

	private $subscriber2;

	private $subscriber3;

	private $subscriber4;
	
	public function __construct() {

		
		$this->client =new Client(['base_uri' => 'https://my.xl.co.id']); 
		
		$this->imei = '406126004'; 
		
		// a26f8bbe24104a6d
		// 3606249865
		// 1317504728
		// 1578577304
		// 1317504728
		// 1578577304
		// 406126004
		
		
		$this->date = date('Ymdhis');
		
		$this->header=array (
			'Host' => 'my.xl.co.id',
			'Accept'=> 'application/json, text/plain, */*',
			'User-Agent'=>'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:59.0) Gecko/20100101 Firefox/59.0',
			'Accept-Language'=> 'en-US,en;q=0.5',
			'Accept-Encoding'=> 'gzip, deflate, br',
			'Content-Type'=> 'application/json'
		);
		// $this->subscriber1 = '2058493708'; //combo lite 29k
		// $this->subscriber1 = '172912844'; //combo lite 49k
		$this->subscriber1 = '1172736593'; //biz


		$this->subscriber2 = '1233998462'; //combo27k 6gb
		//$this->subscriber2 = '1020470348'; //combo35k 6gb
		 //$this->subscriber3 = '1993207749'; //combo lit 19k
		//$this->subscriber3 = '172913525'; //combo lit 19k 2
		$this->subscriber3 = '1195120184';
		$this->subscriber4 = '1751644430'; //hotrod 1.5gb 20k 8211107
		//$this->subscriber5 = '2058493708'; //TEST 30GB
		$this->subscriber5 = '2064724400'; //TEST 30GB
		$this->subscriber6 = '172912844'; //combo lite
		//$this->subscriber6 = '1993207749'; //new waze
		//1247709489 test waze

		
	}
	public function getPass($msisdn) {
		
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
				
				try {
					$response = $this->client->post('pre/LoginSendOTPRq',[
						'debug' => FALSE,
						'json' => $payload,
						'headers' => $this->header,
					 	'timeout' => 5, 
      					'connect_timeout' => 5
				  ]);
				  $body = json_decode((string)$response->getBody());
				  return $body;
				}catch(Exception $e) { 
					return $e;
				}
				
	}
	
	public function login($msisdn, $otpCode) {
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
	                            "appVersion"=>"3.8.1",
	                            "sourceName"=>"Firefox",
	                            "sourceVersion"=>"",
	                            "screenName"=>"login.enterLoginOTP",
	                            "mbb_category"=>""
	                            );
	   try {
            $response = $this->client->post('pre/LoginValidateOTPRq',
				[
					'debug' => FALSE,
					'json' => $payload,
					'headers' =>$this->header,
				]);
				$body = json_decode((string)$response->getBody());
				return $body;
				// if ($body->responseCode === '00') {
				// 		$this->session == $body->sessionId;
				// 	}else{
				// 		return false;
				// 	}
			}catch (Exception $e) {
				return $e; 
			}
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
						   "Subscriber_Number"=>$this->subscriber1,
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
		try {
			$response = $this->client->post('/pre/opPurchase',[
					'debug' => FALSE,
					'json' => $payload,
					'headers' => $this->header,
		 		'timeout' => 5, 
      'connect_timeout' => 5
			]);
			$status = json_decode((string) $response->getBody());
			return $status;
		}
		catch(Exception $e) {
			return $e;
		}
	}

	public function register2($msisdn, $serviceID, $session) {

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
						   "Subscriber_Number"=>$this->subscriber2,
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
		try {
			$response = $this->client->post('/pre/opPurchase',[
					'debug' => FALSE,
					'json' => $payload,
					'headers' => $this->header,
					'timeout' => 5, 
      'connect_timeout' => 5
			]);
			$status = json_decode((string) $response->getBody());
			return $status;
		}
		catch(Exception $e) {
			return $e;
		}
	}


	public function register3($msisdn, $serviceID, $session) {

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
							"Subscriber_Number"=>$this->subscriber3,
						   "Source"=>"mapps",
						   "Trans_ID"=>'119520832111',
						   "Home_P0C"=>'BTO',
						   "PRICE_PLAN"=>'513738114',
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
		 try {
			 $response = $this->client->post('/pre/opPurchase',[
					 'debug' => FALSE,
					 'json' => $payload,
					 'headers' => $this->header,
					 'timeout' => 5, 
      'connect_timeout' => 5
			 ]);
			 $status = json_decode((string) $response->getBody());
			 return $status;
		 }
		 catch(Exception $e) {
			 return $e;
		 }
	 }
	public function register4($msisdn, $serviceID, $session) {

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
						   "Subscriber_Number"=>$this->subscriber4,
						   "Source"=>"mapps",
						   "Trans_ID"=>'119520832111',
						   "Home_P0C"=>'MA1',
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
		try {
			$response = $this->client->post('/pre/opPurchase',[
					'debug' => FALSE,
					'json' => $payload,
					'headers' => $this->header,
					'timeout' => 5, 
      'connect_timeout' => 5
			]);
			$status = json_decode((string) $response->getBody());
			return $status;
		}
		catch(Exception $e) {
			return $e;
		}
	}

	public function register5($msisdn, $serviceID, $session) {

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
						   "Subscriber_Number"=>$this->subscriber5,
						   "Source"=>"mapps",
						   "Trans_ID"=>'119520832111',
						   "Home_P0C"=>'BD0',
						   "PRICE_PLAN"=>'513728664',
						   "PayCat"=>"PRE-PAID",
						   "Active_End"=>'20190403',
						   "Active_End"=>'20190503',
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
	                    "reloadAmt"=>"10000",
	                    "platform"=>"02",
	                    "appVersion"=>"3.8.1",
	                    "sourceName"=>"Others",
	                    "sourceVersion"=>"",
	                    "msisdn_Type"=>"P",
	                    "screenName"=>"home.storeFrontReviewConfirm",
	                    "mbb_category"=>""
	                    );
		try {
			$response = $this->client->post('/pre/opPurchase',[
					'debug' => FALSE,
					'json' => $payload,
					'headers' => $this->header,
					'timeout' => 5, 
      'connect_timeout' => 5
			]);
			$status = json_decode((string) $response->getBody());
			return $status;
		}
		catch(Exception $e) {
			return $e;
		}
	}


	public function register6($msisdn, $serviceID, $session) {

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
						   "Subscriber_Number"=>$this->subscriber6,
						   "Source"=>"mapps",
						   "Trans_ID"=>'119520832111',
						   "Home_P0C"=>'SB4',
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
		try {
			$response = $this->client->post('/pre/opPurchase',[
					'debug' => FALSE,
					'json' => $payload,
					'headers' => $this->header,
					'timeout' => 5, 
      'connect_timeout' => 5
			]);
			$status = json_decode((string) $response->getBody());
			return $status;
		}
		catch(Exception $e) {
			return $e;
		}
	}

}

?>
