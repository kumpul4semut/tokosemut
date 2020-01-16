<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Portal
{
	private $_header;

	private $_url;

	private function _request($url, $header, $data)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);

		return $result;
	}

	function __construct() {
		$this->_header	= array(
			'portal-userid: P72672',
			'portal-key: e7bea5124ae092cf2b260fa83f36f6aa',
			'portal-secret: 3d43f4cf9f22641af2d13ffd4e847b45daf3eb495774e10d5af22b0dcd66d014', 
		);
		$this->_url = "https://portalpulsa.com/api/connect/";
	}


	public function buyPulsaData($code, $nomor, $trxid, $no) {

		$data = array( 
		'inquiry' => 'I', // konstan
		'code' => $code, // kode produk
		'phone' => $nomor, // nohp pembeli
		'trxid_api' => $trxid, // Trxid / Reffid dari sisi client
		'no' => $no, // untuk isi lebih dari 1x dlm sehari, isi urutan 1,2,3,4,dst
		);

		$exec = $this->_request($this->_url, $this->_header, $data);
		return $exec;
	}

	public function getPulsa() {

		$data = array( 
		'inquiry' => 'HARGA', // konstan
		'code' => 'pulsa', // pilihan: pln, pulsa, game
		);

		$exec = $this->_request($this->_url, $this->_header, $data);
		return $exec;
	}

	public function getStatusTrx($trxid) {

		$data = array( 
		'inquiry' => 'STATUS', // konstan
		'trxid_api' => $trxid, // Trxid atau Reffid dari sisi client saat transaksi pengisian
		);

		$exec = $this->_request($this->_url, $this->_header, $data);
		return $exec;
	}

	public function getSaldo() {

		$data = array( 
		'inquiry' => 'S', // konstan
		);

		$exec = $this->_request($this->_url, $this->_header, $data);
		return $exec;
	}

	

}

/* End of file Portal.php */
/* Location: ./application/libraries/Portal.php */
