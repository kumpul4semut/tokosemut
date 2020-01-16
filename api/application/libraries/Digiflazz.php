<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Digiflazz
{
	private $CI;

	private $username;

	private $key;

	private $_head;

	private function _request($url, $head, $data)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $head);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		// curl_setopt($ch, CURLOPT_HEADER, 1);
		// curl_setopt($ch, CURLINFO_HEADER_OUT, true);
		$result = curl_exec($ch);

		return $result;
	}

	function __construct() {
		$this->_head = array(
			'Content-Type:application/json'
		);
		$this->CI =& get_instance();

		$dataSRV = $this->CI->db->get_where('server', ['id' => 6])->row();
		
		$this->username = $dataSRV->secret;
		$this->key 		= $dataSRV->key;
	}

	public function getSaldo() {
		$url = "https://api.digiflazz.com/v1/cek-saldo";

		$sign = $this->username.$this->key.'depo';

		$data = json_encode( array( 
		    'cmd'=> 'deposit',
		    'username'=> $this->username,
		    'sign'=> md5($sign)
		) );
		$exec = $this->_request($url, $this->_head, $data);
		return $exec;
	}

	public function getListHarga() {
		
		$url = "https://api.digiflazz.com/v1/price-list";

		$sign = $this->username.$this->key.'pricelist';

		$data = json_encode( array( 
		    'username'=> $this->username,
		    'sign'=> md5($sign)
		) );
		$exec = $this->_request($url, $this->_head, $data);
		return $exec;
	}

	public function getTopUp($trxid, $customer_no, $trx_code) {
		$url = "https://api.digiflazz.com/v1/transaction";

		$sign = $this->username.$this->key.$trxid;
		
		$data = json_encode( array( 
		    'username'=> $this->username,
		    'buyer_sku_code'=> $trx_code,
    		'customer_no'=> $customer_no,
    		'ref_id'=> $trxid,
		    'sign'=> md5($sign),
		    'msg'=>''
		) );
		$exec = $this->_request($url, $this->_head, $data);
		return $exec;
	}

	public function getStatus($trxid, $customer_no, $trx_code) {
		$url = "https://api.digiflazz.com/v1/transaction";
		$sign = $this->username.$this->key.$trxid;

		$data = json_encode( array(
		    'username'=> $this->username,
		    'buyer_sku_code'=> $trx_code,
    		'customer_no'=> $customer_no,
    		'ref_id'=> $trxid,
		    'sign'=> md5($sign),
		    'msg'=>''
		) );
		$exec = $this->_request($url, $this->_head, $data);
		return $exec;
	}


	

}

/* End of file Portal.php */
/* Location: ./application/libraries/Portal.php */
