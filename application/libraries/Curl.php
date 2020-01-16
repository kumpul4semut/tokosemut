<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * Curl library
 * Kumpul4semut
 * 27 juli 2019
 */
class Curl
{
	
	/*Kimnoon api */
	/**
	 * [kimnoon description]
	 * @param  [type] $url        [description]
	 * @param  [type] $parameters [description]
	 * @return [type]             [description]
	 */
	public function kimnoon($url, $parameters)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));
		$response = curl_exec($ch);
		curl_close($ch);
		return $response;
	}

	

}