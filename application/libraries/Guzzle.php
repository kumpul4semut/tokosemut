<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  class Guzzle {

  	function __construnct(){
     set_include_path(get_include_path() . PATH_SEPARATOR . APPPATH . 'libraries/Dor/vendor');
     include(APPPATH . 'libraries/Dor/vendor/autoload.php');
  	}
    // public function Guzzle() {
    //   require_once('vendor/autoload.php');
    // }
  }
?>  
