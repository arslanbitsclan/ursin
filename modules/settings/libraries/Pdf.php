<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require(dirname(__file__).'/tcpdf/tcpdf.php');
class Pdf extends TCPDF {

	protected $ci;

	public function __construct()
	{
		$this->ci =& get_instance();
		
	}







	
}
