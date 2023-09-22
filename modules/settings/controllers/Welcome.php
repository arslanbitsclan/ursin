<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MX_Controller {

    public function __construct()
    {
        parent::__construct();
         $this->title = "Manage Classes";
        $this->scripts = array("class");
        $this->logged_in_user = get_user_id();
        $this->layout = 'settings/views/layouts/ursin';
    }

    public function index()
	{	
		$string = $this->load->view('email/parent_template', '', true);
		$this->phpmailerlib->testmessage($string);
	}
}
