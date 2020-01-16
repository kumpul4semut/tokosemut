[<?php 
/**
 * 
 */
class Xlcurl
{
	
	private $imei; 
	
	private $date;

	private $head;

	private $urlReg;

	private $subscriber1;

	private $subscriber2;

	private $subscriber3;

	private $subscriber4;

	private $subscriber5;

	private $subscriber6;
		
	function __construct() {
		$this->imei = '2610952189';	
		$this->date = date('Ymdhis');
		$this->head = array(
    		'Host: my.xl.co.id',
			'Accept:application/json, text/plain, *',
			'User-Agent:Mozilla/5.0 (Linux; Android 8.0.0; Pixel 2 XL Build/OPD1.170816.004) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.75 Mobile Safari/537.36',
			'Accept-Language:en-US,en;q=0.5',
			'Accept-Encoding:gzip, deflate, br',
			'Content-Type:application/json'
		);
		$this->urlReg = "https://my.xl.co.id/pre/opPurchase";
		$this->subscriber1 = '1172736593'; //biz
		// $this->subscriber1 = '1119913826'; //30k 6gb
		$this->subscriber2 = '1233998462'; //combo27k 6gb //1191095189
		$this->subscriber3 = '1195120184';
		$this->subscriber4 = '1751644430'; //hotrod 1.5gb 20k 8211107
		$this->subscriber5 = '2064724400'; //TEST 30GB
		$this->subscriber6 = '172912844'; //combo lite
		
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
        $url = "https://my.xl.co.id/pre/LoginSendOTPRq";
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
        "appVersion"=>"3.8.1",
        "sourceName"=>"Firefox",
        "sourceVersion"=>"",
        "screenName"=>"login.enterLoginOTP",
        "mbb_category"=>""
        );
        
        $data = json_encode($payload, true);
        $url  = "https://my.xl.co.id/pre/LoginValidateOTPRq";
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

		$data = json_encode($payload, true);
        $url  = $this->urlReg;
        $exec = $this->_curl($data, $url);

        return $exec;
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
		$data = json_encode($payload, true);
        $url  = $this->urlReg;
        $exec = $this->_curl($data, $url);

        return $exec;
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
		$data = json_encode($payload, true);
        $url  = $this->urlReg;
        $exec = $this->_curl($data, $url);

        return $exec;
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
		$data = json_encode($payload, true);
        $url  = $this->urlReg;
        $exec = $this->_curl($data, $url);

        return $exec;
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
		$data = json_encode($payload, true);
        $url  = $this->urlReg;
        $exec = $this->_curl($data, $url);

        return $exec;
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
		$data = json_encode($payload, true);
        $url  = $this->urlReg;
        $exec = $this->_curl($data, $url);

        return $exec;
	}

	public function mutasi(){
		$CI =& get_instance();
		$sess = $CI->db->get_where('mutasi', ['id' => 3])->row()->token;
		/*
		==== CONFIG
		 */
		$wantdata = 15;
		/*
		==== END CONFIG
		 */
		$unidatas = json_decode($this->_pmutasi($sess), true);
		$dmut = [];
		$rowcount = 0;
		if (!isset($unidatas['SOAP-ENV:Envelope'])) {
			$arr = [
				'status'=> 'false',
				'message' => 'true but server error'
			];
			print_r($arr);
			exit;
		}else{
			$unidatas = $unidatas['SOAP-ENV:Envelope']['SOAP-ENV:Body'][0]['ns0:opRetrieveContactRs'][0]['ns0:contactHeader'];
			foreach ($unidatas as $unidata) {
				if($unidata['ns0:contactSource'][0] == 'cpBalanceTransferV1_0'){
					array_push($dmut, $unidata['ns0:mailboxID'][0]);
					if(++$rowcount >= $wantdata) break;
				}
			}
		}

		$result=[];
		foreach ($dmut as $did) {
			$dmut = $this->_dmutasi($did, $sess);
			$aray = json_decode($dmut, true);
			foreach ($aray as $a) {
				if (!isset($a['SOAP-ENV:Body'][0])) {
					$arr = [
						'status'=> 'false',
						'message' => 'true but server error'
					];
				}else{
					$str = $a['SOAP-ENV:Body'][0]['ns0:opReadContactRs'][0]['ns0:contact'][0]['ns0:contactMessage'][0];
						preg_match_all('!\d+!', $str, $matches);
					$arr = [
						'status'=>'true',
						'date'	=>	date('Y-m-d', strtotime($unidata['ns0:timestamp'][0])),
						'from'	=>	$matches[0][1],
						'amount'=> $matches[0][2]

					];
				}
				array_push($result, $arr);
			}
		}
		$finalresult=[];
		foreach ($result as $r) {
			if ($r['status'] == 'false') {
				continue;
			}
			array_push($finalresult, $r);
		}
		return $finalresult;

	}

	private function _pmutasi($sess){
		$reqID = substr($this->date, 10);
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://my.xl.co.id/pre/opRetrieveContacts');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"Header\":null,\"Body\":{\"Header\":{\"IMEI\":$this->imei,\"ReqID\":\"$reqID\"},\"opRetrieveContacts\":{\"msisdn\":\"6287719850938\",\"maxNotificationCount\":\"100\",\"notificationType\":\"\"}},\"sessionId\":\"$sess\",\"serviceId\":\"\",\"packageAmt\":\"\",\"reloadType\":\"\",\"reloadAmt\":\"\",\"packageRegUnreg\":\"\",\"platform\":\"04\",\"appVersion\":\"3.8.2\",\"sourceName\":\"Others\",\"sourceVersion\":\"\",\"msisdn_Type\":\"P\",\"screenName\":\"home.inbox\",\"mbb_category\":\"\"}");
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

		$headers = array();
		$headers[] = 'Sec-Fetch-Mode: cors';
		$headers[] = 'Sec-Fetch-Site: same-origin';
		$headers[] = 'Origin: https://my.xl.co.id';
		$headers[] = 'Accept-Encoding: gzip, deflate, br';
		$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7,ms;q=0.6';
		$headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/77.0.3865.90 Chrome/77.0.3865.90 Safari/537.36';
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Access-Control-Allow-Origin: True';
		$headers[] = 'Accept: application/json, text/plain, */*';
		$headers[] = 'Referer: https://my.xl.co.id/pre/index1.html';
		$headers[] = 'Connection: keep-alive';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return $result;
	}

	public function _dmutasi($inboxid, $sess){
		$reqID = substr($this->date, 10);
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://my.xl.co.id/pre/opReadContact');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"Header\":null,\"Body\":{\"Header\":{\"IMEI\":$this->imei,\"ReqID\":\"$reqID\"},\"opReadContact\":{\"msisdn\":\"6287719850938\",\"mailboxID\":\"$inboxid\"}},\"sessionId\":\"$sess\",\"serviceId\":\"\",\"packageAmt\":\"\",\"reloadType\":\"\",\"reloadAmt\":\"\",\"packageRegUnreg\":\"\",\"platform\":\"04\",\"appVersion\":\"3.8.2\",\"sourceName\":\"Others\",\"sourceVersion\":\"\",\"msisdn_Type\":\"P\",\"screenName\":\"home.inbox\",\"mbb_category\":\"\"}");
		curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

		$headers = array();
		$headers[] = 'Sec-Fetch-Mode: cors';
		$headers[] = 'Sec-Fetch-Site: same-origin';
		$headers[] = 'Origin: https://my.xl.co.id';
		$headers[] = 'Accept-Encoding: gzip, deflate, br';
		$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7,ms;q=0.6';
		$headers[] = 'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/77.0.3865.90 Chrome/77.0.3865.90 Safari/537.36';
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Access-Control-Allow-Origin: True';
		$headers[] = 'Accept: application/json, text/plain, */*';
		$headers[] = 'Referer: https://my.xl.co.id/pre/index1.html';
		$headers[] = 'Connection: keep-alive';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return $result;
	}
}

	