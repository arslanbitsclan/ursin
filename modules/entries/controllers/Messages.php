<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Messages extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->title = "Messages";
        $this->scripts = array("class");	
     	
       	$this->layout = 'entries/views/layouts/ursin_messages';
        $this->logged_in_user = get_user_id();
        $this->logged_in_teacher_id = get_teacher_id();

	}

	public function index(){
        $class_where['array_teachers'] = $this->logged_in_teacher_id;
        $data['classes'] = $this->crud_model->get('class',$class_where);	

        if(!empty($_GET)){
            $data['selectclass'] = $_GET['classid'];
        }
        
		$this->load->view('messages',$data);
	}


	public function manage()
    {
		$userdata = $this->session->userdata("user_session");
    
       	$dataofarray['title'] = $_POST['title'];
        
        if(!empty($_POST['date'])){
            $date = date_create($_POST['date']);
            $_POST['date'] =  date_format($date,"Y-m-d");
       	    $dataofarray['expirationdate'] = $_POST['date'];
        }
       	$dataofarray['message'] = $_POST['message'];

        if(isset($_POST['recipient_identifier']) && $_POST['recipient_identifier'] == '2'){
                $dataofarray['recipient_identifier'] = '2';
        }else{
                $dataofarray['recipient_identifier'] = '0';
        }

        $where_teacher_name['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
        $get_teacher_namefind = $this->crud_model->get('class',$where_teacher_name);

        $dataofarray['creation_date'] = date('Y-m-d');
       	$dataofarray['teachers_name'] = get_teacher_name();
       	$dataofarray['teachers_id'] = $this->logged_in_teacher_id;
       	$pushColumn = 'messages4class';
        $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);

		$class_id = $this->crud_model->push('class',$class_where,$pushColumn,array($dataofarray));

   		if(@$_POST['publichallclass'] == '1'){
             $where_teacher_name['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
             $get_teacher_name = $this->crud_model->get('class',$where_teacher_name);


    	    $class = $this->crud_model->get('class');
    	    foreach ($class as $key => $value) {
                if($get_teacher_name[0]['teacher_name'] == $value['teacher_name']){
    	    	 	 if(in_array($this->logged_in_teacher_id, $value['array_teachers']) && $value['_id'] != $_POST['class_id'] ){

    	    	 	 	$idofclass['_id'] = new MongoDB\BSON\ObjectID($value['_id']);
    	    	 	 	$dataofarray['allclasmessae'] = '1';
    	    	 	 	$class_id = $this->crud_model->push('class',$idofclass,$pushColumn,array($dataofarray));

    	    	 	 }
                }
    		}
        }

        if(@$_POST['emailsendofall'] == 'mail' && @$_POST['recipient_identifier'] == '2' && @$_POST['publichallclass'] != '1'){

            $emailsendofall = $_POST['emailsendofall'];
            $teacherfullname = get_teacher_name();
            $data1[0]['teacher_name'] = $teacherfullname;
            $data1[0]['title'] = $dataofarray['title'] ;
            $data1[0]['message'] = $dataofarray['message'];

            $datamesg['datamessage'] = $data1;
            $body = $this->load->view('email/message_tamplate',$datamesg, true);
            
            $class = $this->crud_model->get('class',$class_where);
            
            
            foreach ($class as $key => $valueofstudent) {
                 if($get_teacher_namefind[0]['teacher_name'] == $valueofstudent['teacher_name']){

                    foreach ($valueofstudent['array_students'] as $key => $value) {
                            $whereofstudent['_id'] = new MongoDB\BSON\ObjectID($value);
                            $studentdata = $this->crud_model->get('student',$whereofstudent);
                            
                            if(!empty($studentdata[0]['parents_email'])){
                                $parentemails = '';
                            if(!empty($studentdata[0]['parents_email'][0]['family'])){
                            $parentemails .= $studentdata[0]['parents_email'][0]['family'].',';
                            }
                           if(!empty($studentdata[0]['parents_email'][0]['mother'])){
                           $parentemails .= $studentdata[0]['parents_email'][0]['mother'].',';
                           }
                           if(!empty($studentdata[0]['parents_email'][0]['father'])){
                           $parentemails .= $studentdata[0]['parents_email'][0]['father'].',';
                            }

                                if(!empty($parentemails)){
                                    $subject = "New message from ".$teacherfullname.": ".$data1[0]['title']; 
                                    $headers = "MIME-Version: 1.0" . "\r\n";
                                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                    $headers .= 'From: EdTools <notification@edtools.io>';
                                    $sts = mail($parentemails,$subject,$body,$headers);
                                }

                            }
                  }

                 }
            }
        }        

        if(@$_POST['emailsendofall'] == 'mail' && @$_POST['publichallclass'] == '1'){
            
        	$emailsendofall = $_POST['emailsendofall'];
            $teacherfullname = get_teacher_name();
        	$data1[0]['teacher_name'] = $teacherfullname;
        	$data1[0]['title'] = $dataofarray['title'] ;
        	$data1[0]['message'] = $dataofarray['message'];

        	$datamesg['datamessage'] = $data1;
        	$body = $this->load->view('email/message_tamplate',$datamesg, true);
        	
        	$class = $this->crud_model->get('class');
        	
        	
        	foreach ($class as $key => $valueofstudent) {
	    	 	 if($get_teacher_namefind[0]['teacher_name'] == $valueofstudent['teacher_name']){

	    	 	 	foreach ($valueofstudent['array_students'] as $key => $value) {
	    	 	 			$whereofstudent['_id'] = new MongoDB\BSON\ObjectID($value);
	    	 	 			$studentdata = $this->crud_model->get('student',$whereofstudent);
	    	 	 			
	    	 	 		if(!empty($studentdata[0]['parents_email'])){
                                $parentemails = '';

                            if(!empty($studentdata[0]['parents_email'][0]['family'])){
                            $parentemails .= $studentdata[0]['parents_email'][0]['family'].',';
                            }
                            if(!empty($studentdata[0]['parents_email'][0]['mother'])){
	    	 	 			$parentemails .= $studentdata[0]['parents_email'][0]['mother'].',';
                            }
                            if(!empty($studentdata[0]['parents_email'][0]['father'])){
	    	 	 			$parentemails .= $studentdata[0]['parents_email'][0]['father'].',';
                            }

                                if(!empty($parentemails)){
                                    $subject = "New message from ".$teacherfullname.": ".$data1[0]['title']; 
                                    $headers = "MIME-Version: 1.0" . "\r\n";
                                    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                                    $headers .= 'From: EdTools <notification@edtools.io>';
                                    $sts = mail($parentemails,$subject,$body,$headers);
                                }

	    	 	 			}
	    	 	 	}

	    	 	 }
    		}
			//$sts = $this->phpmailerlib->message_email_all_parent($parentemails,$body);
            // $subject = "New message from ".$teacherfullname.": ".$data1[0]['title']; 
            // $headers = "MIME-Version: 1.0" . "\r\n";
            // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            // $headers .= 'From: EdTools <notification@edtools.io>';
            // $sts = mail($parentemails,$subject,$body,$headers);
        }	
        
        if($class_id){
            $msg = 'Messages Successfully send';
            $response['status'] = true;
            $response['msg'] = $msg;
            $this->session->set_flashdata('success',$msg);
        }else{
            $msg = 'Something Went Wrong';
            $response['status'] = false;
            $response['msg'] = $msg;
            $this->session->set_flashdata('error',$msg);
        }
        redirect('entries/Messages?classid='.$_POST['class_id']);
    }

    public function get_accessofclass($class_id){

        $class_where['_id'] = new MongoDB\BSON\ObjectID($class_id);
        $data['classes'] = $this->crud_model->get('class',$class_where);
        $retnval = '';
        if($data['classes'][0]['show_tools'][1] == 1){
             $retnval = '0';

        }else{
             $retnval = '1';
        }
       return $retnval;
    }

    public function limitofusers($class_id){
        $class_where['_id'] = new MongoDB\BSON\ObjectID($class_id);
        $data['classes'] = $this->crud_model->get('class',$class_where);
        $retnval = '';
        if($data['classes'][0]['show_tools'][1] == 1){
            
            $totalsum = 0;
            foreach ($data['classes'][0]['messages4class'] as $key => $value) {
                if($value['teachers_id'] == get_teacher_id())
                {
                    $totalsum++;
                }
            }

            $check_limit = get_count_messages();
           
            if($check_limit <= $totalsum){
                $retnval = '<br/><br/>Only '.$check_limit.' messages at a time are possible so that it stays simple. Please delete messages that are no longer needed<br/><br/><a onclick="loadclasswithreload();" style="cursor:pointer; text-decoration:underline;">Check Again</a>';
            }else{
                $retnval = '';
            }   

        }
       return $retnval;
    }

    public function get_messages_data(){
    	
        $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
        $firstcollectdata = $this->crud_model->get('class',$class_where);	

        $datacollect['mesagedata'] = $firstcollectdata[0]['messages4class'];
        $datacollect['classname'] = $firstcollectdata[0]['class_name'];
        $datacollect['idofclass'] = $firstcollectdata[0]['_id'];
        $datacollect['connectedclass'] = $firstcollectdata[0]['connectedclass'];

        
        $response['data'] = $this->load->view('content/message_table', $datacollect, TRUE);
        $response['messageaccess'] = $this->get_accessofclass($_POST['class_id']);
        $response['messagelimit'] = $this->limitofusers($_POST['class_id']);
        $response['status'] = TRUE;
        echo json_encode($response);
        exit();
	}



	public function get_all_teacher_data(){
        $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
        $firstcollectdata = $this->crud_model->get('class',$class_where);	

        $datacollect['mesagedata'] = $firstcollectdata[0]['messages4class'];
        $datacollect['classname'] = $firstcollectdata[0]['class_name'];
        $datacollect['idofclass'] = $firstcollectdata[0]['_id'];
        $datacollect['connectedclass'] = $firstcollectdata[0]['connectedclass'];
        $datacollect['checkboxchecked'] = '1';

        $connteddata = $firstcollectdata[0]['connectedclass'];

        foreach ($connteddata as $key => $value) {
           
        	$classid['_id'] = new MongoDB\BSON\ObjectID($value);
        	$othermessage = $this->crud_model->get('class',$classid);

        	foreach ($othermessage[0]['messages4class'] as $key => $value) {
        		array_push($value, "othermessage");
        		array_push($datacollect['mesagedata'], $value);
        	}
        }

     
        $response['data'] = $this->load->view('content/message_table', $datacollect, TRUE);
        $response['status'] = TRUE;
        echo json_encode($response);
        exit();
	}


	public function delete()
    {
        $deletearray[0] = array();
        $where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
        $delete =  $this->crud_model->delete_indexof_array('class',$where,'messages4class',$_POST['key']);

    	if($delete){
            $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
            $firstcollectdata = $this->crud_model->get('class',$class_where);   
            $datacollect['mesagedata'] = $firstcollectdata[0]['messages4class'];
            $datacollect['classname'] = $firstcollectdata[0]['class_name'];
            $datacollect['idofclass'] = $firstcollectdata[0]['_id'];
            $datacollect['connectedclass'] = $firstcollectdata[0]['connectedclass'];

            if($_POST['check'] == '1'){
                $datacollect['checkboxchecked'] = '1';
                $connteddata = $firstcollectdata[0]['connectedclass'];
                foreach ($connteddata as $key => $value) {
                    $classid['_id'] = new MongoDB\BSON\ObjectID($value);
                    $othermessage = $this->crud_model->get('class',$classid);
                    foreach ($othermessage[0]['messages4class'] as $key => $value) {
                    
                        array_push($value, "othermessage");
                        array_push($datacollect['mesagedata'], $value);
                    }
                }
            }

            $response['data'] = $this->load->view('content/message_table', $datacollect, TRUE);
            $response['status'] = TRUE;
            
        }else{
            
        }
        echo json_encode($response);
        exit();
    }




}