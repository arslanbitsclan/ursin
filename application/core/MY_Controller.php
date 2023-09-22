<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{

	function __construct(){
		parent::__construct();

		
		if(file_exists(SERVER_URL.'user/library/Am/Lite.php')){

				require_once SERVER_URL.'user/library/Am/Lite.php'; 
		if(Am_Lite::getInstance()->isLoggedIn()){
			$user = Am_Lite::getInstance()->getUser();
			$usermeta = Am_Lite::getInstance()->getAccess();
			$userporduct = Am_Lite::getInstance()->getProducts();
		
			foreach ($userporduct as $k => $v) {
				if($k == $usermeta[0]['product_id']){
					$productname = $v;
				}
			}

			$username = $user['name_f']." ".$user['name_l'];
			$teacher = array("teacher_id" => (int)$user['user_id'],
				"teacher_full_name" => $username,
				"teacher_name" => $user['login'],
				"array_students" => array(),
				"array_classes" => array(),
				"last_login" => $user['last_login'] 
			);

			$where['teacher_id'] = (int)$user['user_id'];
				
			$check = $this->crud_model->get('teacher',$where);
			if(!empty($check)){
				$data['last_login'] = $user['last_login'];
				$this->crud_model->update("teacher",$where,$data);
			}else{
				$this->crud_model->insert("teacher",$teacher);
			}
			
		
			$session_array = array(
				"user_id" => (int)$user['user_id'],
				"login" => $user['login'],
				"status" => $user['status'],
				"is_approved" => $user['is_approved'],
				"name" => $username,
				"product" => $usermeta[0]['product_id'],
				"product_name" => $productname,
			);
			$this->session->set_userdata("user_session",$session_array);


		}else{
			$sessionData = $this->session->all_userdata();
			foreach($sessionData as $key =>$val){
				$this->session->unset_userdata($key);
			}
			$url = "https://edtools.io/user/member";
			redirect($url);
		}

		}else{


			$username = "Adeel Raiz";
			$teacher = array("teacher_id" => 10,
				"teacher_full_name" => $username,
				"teacher_name" => 'adeel-raiz',
				"array_students" => array(),
				"array_classes" => array(),
				"last_login" => date("Y-m-d") 
			);

			$where['teacher_id'] = 10;
			$check = $this->crud_model->get('teacher',$where);
			
			if(!empty($check)){
				$data['last_login'] = date("Y-m-d");
				$this->crud_model->update("teacher",$where,$data);
			}else{
				$this->crud_model->insert("teacher",$teacher);
			}
			$session_array = array(
				"user_id" => 10,
				"login" => 'adeel-raiz',
				"status" => 1,
				"is_approved" => 1,
				"name" => 'Adeel Raiz',
				"product" => 2,
				"product_name" => 'Membership Pro',
			);
			$this->session->set_userdata("user_session",$session_array);

		}


	}
	
	public function index(){
		$this->load->view('welcome_message');
	}



}



