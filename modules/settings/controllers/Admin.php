 <?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Admin extends MX_Controller{

	function __construct(){
		parent::__construct();
	}

	public function index(){
		echo "main root";
		die;
	}


}