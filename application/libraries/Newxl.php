<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newxl
{
	protected $ci;

  private $imei;

	public function __construct()
	{
      $this->ci =& get_instance();
	    $this->imei = "15a70479-a65b-553e-3583-100737497658"; 
  }

	private function _request($url,$data,$header) {
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

    private function _request2($url,$data,$header,$method, $headOut)
    {
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, 'https://'.$url);
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	    curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
    	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
      if ($headOut) {
        # minta respon  head out
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
      }
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	    $data =curl_exec($ch);
   	 	return $data;
    }

    public function getPass($no) {
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

	public function login($no, $otp) {
		$imei1 = "d4e7f273-abb0-4128-8671-430372103258";
		$imei2 = "15a70479-a65b-553e-3583-100737497658";
		$imei3 = "83ba7ece-513f-eff2-0219-969156000090";

		$imeiArray = array($imei1, $imei2, $imei3);
		$imeirand = $imeiArray[rand(0, count($imeiArray)-1)];

		$ulog='login-controller-service.apps.dp.xl.co.id/v1/login/otp/auth?msisdn='.$no.'&imei='.$imei2.'&otp='.$otp.'&channel=MYXLAPP_LOGIN_ID';
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
         $rlog = $this->_request2($ulog, $dlog, $hlog, 'GET', false);
         return $rlog;
	}

	public function mutasi() {
		$dat = $this->ci->db->get_where('mutasi', ['id' => 2])->row();
    if (json_decode($this->_loginFirebase($dat->token), true)['statusCode'] == '401') {
      #refresh token
		  $rq = json_decode( $this->_refreshToken($dat->refresh_token), true);
      $this->db->where('id', 2);
      $this->db->update('mutasi', [
        'token' => $rq['result']['accessToken'],
        'number_enc' => $rq['result']['user']['msisdn_enc'],
        'refresh_token' => $rq['result']['refreshToken']
      ]); 
    }
    $this->_opMutasi($dat->number_enc); 
		$ulog='subscriber-info-service.apps.dp.xl.co.id/v1/inbox/transaction-history/'.$dat->number_enc.'';
    $dlog='';
    $hlog = [
      'Host: subscriber-info-service.apps.dp.xl.co.id',
      'cache-control: no-cache',
      'pragma: no-cache',
      'origin: http://localhost:9634',
      'x-apicache-bypass: true',
      "authorization: Bearer $dat->token",
      // 'accept: application/json, text/plain, */*',
      'lang: id',
      'if-modified-since: 0',
      'user-agent: Mozilla/5.0 (Linux; Android 5.1.1; SM-J105F Build/LMY47V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/66.0.3359.126 Mobile Safari/537.36',
      'expires: Sat, 01 Jan 2000 00:00:00 GMT',
      'referer: http://localhost:9634/inbox/notification',
      // 'accept-encoding: gzip, deflate',
      'accept-language: id-ID,en-US;q=0.9',
      'x-requested-with: id.co.xl.myXL'


    ];

    $rlog = $this->_request2($ulog, $dlog, $hlog, 'GET', false);
    // return $rlog;
    $arrays = json_decode($rlog, true);

    $yesterday = date('Y-m-d', strtotime("-1 days"));
    $today = date('Y-m-d',time());

     $dataMutasi = [];
     foreach ($arrays['result']['data'] as $arr) {
     $date = date('Y-m-d', strtotime($arr['processDate']));
     	if ($date == $yesterday || $date == $today) {
            array_push($dataMutasi, $arr);
        }
     }
     return $dataMutasi;
	}

  private function _opMutasi($enc_number){
    $ulog='subscriber-info-service.apps.dp.xl.co.id/v1/inbox/transaction-history/'.$enc_number.'';
    $dlog='';
    $hlog = [
      'Host: subscriber-info-service.apps.dp.xl.co.id',
      'access-control-request-method: GET',
      'origin: http://localhost:9634',
      'user-agent: Mozilla/5.0 (Linux; Android 5.1.1; SM-J105F Build/LMY47V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/66.0.3359.126 Mobile Safari/537.36',
      'access-control-request-headers: authorization,cache-control,expires,if-modified-since,lang,pragma,x-apicache-bypass',
      'accept: */*',
      // 'accept-encoding: gzip, deflate',
      'accept-language: id-ID,en-US;q=0.9',
      'x-requested-with: id.co.xl.myXL'
    ];

    $rlog = $this->_request2($ulog,$dlog,$hlog,'OPTIONS', true);
    return $rlog;
  }

  private function _refreshToken($token) {
    $uro='https://login-controller-service.apps.dp.xl.co.id/v1/login/token/refresh';

    //header
    $hro=[
            'Host: login-controller-service.apps.dp.xl.co.id',
            'content-length: 131',
            'cache-control: no-cache',
            'pragma: no-cache',
            'origin: http://localhost:9634',
            'x-apicache-bypass: false',
            'authorization: Basic ZGVtb2NsaWVudDpkZW1vY2xpZW50c2VjcmV0',
            'content-type: application/json',
            'accept: application/json, text/plain, */*',
            'lang: id',
            'if-modified-since: 0',
            'user-agent: Mozilla/5.0 (Linux; Android 5.1.1; SM-J105F Build/LMY47V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/66.0.3359.126 Mobile Safari/537.36',
            'expires: Sat, 01 Jan 2000 00:00:00 GMT',
            'referer: http://localhost:9634/',
            'accept-language: id-ID,en-US;q=0.9',
            'x-requested-with: id.co.xl.myXL'
         ];

        //body
        $jro=[
          'grant_type'    => 'refresh_token',
          'refresh_token' => $token,
          'imei'          => $this->imei
        ];

        $dro=json_encode($jro);
        $rro=$this->_request($uro,$dro,$hro,null);
        return $rro;
  }

  private function _loginFirebase($token) {
    $uro='https://login-controller-service.apps.dp.xl.co.id/v1/login/token/firebase';

    //header
    $hro=[
            'Host: login-controller-service.apps.dp.xl.co.id',
            'content-length: 164',
            'cache-control: no-cache',
            'pragma: no-cache',
            'origin: http://localhost:9634',
            'x-apicache-bypass: true',
            "authorization: Bearer $token",
            'content-type: application/json',
            'accept: application/json, text/plain, */*',
            'lang: id',
            'if-modified-since: 0',
            'user-agent: Mozilla/5.0 (Linux; Android 5.1.1; SM-J105F Build/LMY47V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/66.0.3359.126 Mobile Safari/537.36',
            'expires: Sat, 01 Jan 2000 00:00:00 GMT',
            'referer: http://localhost:9634/',
            'accept-language: id-ID,en-US;q=0.9',
            'x-requested-with: id.co.xl.myXL'
         ];

        //body
        $jro=[
          'token'    => "fBuj08HYxrY:APA91bFQV6_HK9bJlbB_cxSS9Pw3Mx9btuqORkKAplMC3OHo3Wr94ZMyCKUjcjJcIBD4zcb3HnBxaYsCanKdeoYXPgopyMU_ThUrMjAg23rHRjBkrVqeYdBGbbTX2lXVxIvdL1LaRQ2m"
        ];
        $dro=json_encode($jro);
        $rro=$this->_request($uro,$dro,$hro,null);
        return $rro;
  }

  private function _logVersion(){
    $ulog='login-controller-service.apps.dp.xl.co.id/v1/login/version/status/1.3.4';
    $dlog='';
    $hlog = [
      'Host: login-controller-service.apps.dp.xl.co.id',
      'cache-control: no-cache',
      'pragma: no-cache',
      'origin: http://localhost:9634',
      'x-apicache-bypass: true',
      'authorization: Basic ZGVtb2NsaWVudDpkZW1vY2xpZW50c2VjcmV0',
      'accept: application/json, text/plain, */*',
      'lang: id',
      'if-modified-since: 0',
      'user-agent: Mozilla/5.0 (Linux; Android 5.1.1; SM-J105F Build/LMY47V; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/66.0.3359.126 Mobile Safari/537.36',
      'expires: Sat, 01 Jan 2000 00:00:00 GMT',
      'referer: http://localhost:9634/dashboard',
      'accept-language: id-ID,en-US;q=0.9',
      'x-requested-with: id.co.xl.myXL'
    ];

    $rlog = $this->_request2($ulog,$dlog,$hlog,'GET', true);
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

	

}

/* End of file Newxl.php */
/* Location: ./application/libraries/Newxl.php */
