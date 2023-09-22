<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Calendar extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->title = "Calendar";
        $this->scripts = array("class");	
     	
        $this->layout = 'entries/views/layouts/ursin_calendar';
        $this->logged_in_user = get_user_id();
        $this->logged_in_teacher_id = get_teacher_id();

	}

	public function index(){

        // $dataofallclass = $this->crud_model->get('class');
        // $index_arr =  array();
        // foreach ($dataofallclass as $key => $examdata) {
        //     $class_id['_id'] = new MongoDB\BSON\ObjectID($examdata['_id']);
        //     if(!empty($examdata['calendar4class'])){
        //         foreach ($examdata['calendar4class'] as $keyofclndr => $value) {

        //             if($value['activity_date'] < date('Y-m-d'))
        //             {    
        //                 array_push($index_arr,$keyofclndr);
        //                 //$this->crud_model->delete_indexof_array('class',$class_id,'calendar4class',$keyofclndr); 

        //             }     
        //         }

        //         if(!empty($index_arr)){
        //             $this->crud_model->unset_column('class',$class_id,'calendar4class',$index_arr);
        //         }
        //     }
        // }

        

        // exit();

        $class_where['array_teachers'] = $this->logged_in_teacher_id;
        $data['classes'] = $this->crud_model->get('class',$class_where);

        if(!empty($_GET)){
            $data['selectclass'] = $_GET['classid'];
        }

		$this->load->view('calendar',$data);
	}


	public function manage()
    {
                $userdata = $this->session->userdata("user_session");
                
                $date = date_create($_POST['activity_date']);
                $_POST['activity_date'] =  date_format($date,"Y-m-d");
                $_POST['activity_date'] = $_POST['activity_date']." ".date("H:i:s");

                $dataofarray['title'] = $_POST['title'];
                $dataofarray['activity_date'] = $_POST['activity_date'];
                $dataofarray['description'] = $_POST['description'];
                
                $dataofarray['teachers_name'] = get_teacher_name();
                $dataofarray['teachers_id'] = $this->logged_in_teacher_id;

                $pushColumn = 'calendar4class';
                $dataofarray['recipient_identifier'] = 0;

                if(isset($_POST['visibleforparents'])){
                    $dataofarray['recipient_identifier'] = 2;
                }

                if(isset($_POST['possibilityofregister'])){
                    $dataofarray['recipient_identifier'] = 3;
                }

                 $where_teacher_name['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
                 $get_teacher_namefind = $this->crud_model->get('class',$where_teacher_name);

                if(isset($_POST['emailsendofall']) && isset($_POST['visibleforparents']) &&      @$_POST['publishforall'] != '1'){
                    $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
                    
                        $emailsendofall = $_POST['emailsendofall'];
                        $teacherfullname = get_teacher_name();
                        $data1[0]['teacher_name'] = $teacherfullname;
                        $data1[0]['title'] = $dataofarray['title'] ;
                        $data1[0]['message'] = $dataofarray['description'];
                        $data1[0]['date'] = $dataofarray['activity_date'];

                        $datamesg['datamessage'] = $data1;
                        $body = $this->load->view('email/calendar_tamplate',$datamesg, true);
                        
                        $class = $this->crud_model->get('class', $class_where);
                        
                        
                        foreach ($class as $key => $valueofstudent) {
                             if($get_teacher_namefind[0]['teacher_name'] == $valueofstudent['teacher_name']){
                                 

                                foreach ($valueofstudent['array_students'] as $key => $value) {
                                        $whereofstudent['_id'] = new MongoDB\BSON\ObjectID($value);
                                        $studentdata = $this->crud_model->get('student',$whereofstudent);
                                        
                                        if(!empty($studentdata[0]['parents_email'])){
                                            // echo $studentdata[0]['parents_email'][0]['family'].'<br/>';
                                            // echo $studentdata[0]['parents_email'][0]['mother'].'<br/>';
                                            // echo $studentdata[0]['parents_email'][0]['father'].'<br/>';
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
                                $subject = "New event from ".$teacherfullname.": ".$data1[0]['title']; 
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
                }


                 if(isset($_POST['emailsendofall']) && @$_POST['publishforall'] == '1'){
                    
                        $emailsendofall = $_POST['emailsendofall'];
                        $teacherfullname = get_teacher_name();
                        $data1[0]['teacher_name'] = $teacherfullname;
                        $data1[0]['title'] = $dataofarray['title'] ;
                        $data1[0]['message'] = $dataofarray['description'];
                        $data1[0]['date'] = $dataofarray['activity_date'];

                        $datamesg['datamessage'] = $data1;
                        $body = $this->load->view('email/calendar_tamplate',$datamesg, true);
                  
    $class = $this->crud_model->get('class');  
    foreach ($class as $key => $valueofstudent) {
    if($get_teacher_namefind[0]['teacher_name'] == $valueofstudent['teacher_name']){
            

            foreach ($valueofstudent['array_students'] as $key1 => $value) {
                    $whereofstudent['_id'] = new MongoDB\BSON\ObjectID($value);

                    $studentdata = $this->crud_model->get('student',$whereofstudent);
                    
                    if(!empty($studentdata[0]['parents_email'])){
                       // echo $studentdata[0]['parents_email'][0]['family'].'<br/>';
                       // echo $studentdata[0]['parents_email'][0]['mother'].'<br/>';
                       // echo $studentdata[0]['parents_email'][0]['father'].'<br/>';
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
                       
                        $subject = "New event from ".$teacherfullname.": ".$data1[0]['title']; 
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
                }
               
       


        if($_POST['publishforall'] == '1'){
               $where_teacher_name['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
               $get_teacher_name = $this->crud_model->get('class',$where_teacher_name);
               
               $dataforall = $this->crud_model->get('class'); 
               foreach ($dataforall as $key => $valueofcls) {
                if($get_teacher_name[0]['teacher_name'] == $valueofcls['teacher_name']){
                      if(count($valueofcls['calendar4class']) <= 200){
                        $class_where['_id'] = new MongoDB\BSON\ObjectID($valueofcls['_id']);
                        $class_id = $this->crud_model->push('class',$class_where,$pushColumn,array($dataofarray));
                      }
                  }
               }
            $msg = 'Calendar successfully created for all classes';
            $response['status'] = true;
            $response['msg'] = $msg;
            $this->session->set_flashdata('success',$msg);
        }else{
       
            $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
            $data = $this->crud_model->get('class',$class_where);
        
            if(count($data[0]['calendar4class']) <= 200){
        		$class_id = $this->crud_model->push('class',$class_where,$pushColumn,array($dataofarray));
                if($class_id){
                    $msg = 'Calendar Successfully Created';
                    $response['status'] = true;
                    $response['msg'] = $msg;
                    $this->session->set_flashdata('success',$msg);
                }else{
                    $msg = 'Something Went Wrong';
                    $response['status'] = false;
                    $response['msg'] = $msg;
                    $this->session->set_flashdata('error',$msg);
                }

            }else{
                    $msg = 'Limit Reached. Only 200 entries are possible in calendar';
                    $response['status'] = false;
                    $response['msg'] = $msg;
                    $this->session->set_flashdata('error',$msg);
            }
        }

        redirect('entries/Calendar?classid='.$_POST['class_id']);
    }

    public function get_accessofclass($class_id){

        $class_where['_id'] = new MongoDB\BSON\ObjectID($class_id);
        $data['classes'] = $this->crud_model->get('class',$class_where);
        $retnval = '';
        if($data['classes'][0]['show_tools'][5] == 1){
             $retnval = '0';

        }else{
             $retnval = '1';
        }
       return $retnval;
    }


    public function get_calendar_data(){
    	
        $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
        $firstcollectdata = $this->crud_model->get('class',$class_where);	

        $datacollect['mesagedata'] = $firstcollectdata[0]['calendar4class'];
        $datacollect['classname'] = $firstcollectdata[0]['class_name'];
        $datacollect['idofclass'] = $firstcollectdata[0]['_id'];
        $datacollect['connectedclass'] = $firstcollectdata[0]['connectedclass'];

        $response['data'] = $this->load->view('content/calendar_table', $datacollect, TRUE);
        $response['messageaccess'] = $this->get_accessofclass($_POST['class_id']);
        $response['status'] = TRUE;
        echo json_encode($response);
        exit();
	}



	public function get_all_calendar_data(){
    	
        $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
        $firstcollectdata = $this->crud_model->get('class',$class_where);	

        $datacollect1['mesagedata'] = $firstcollectdata[0]['calendar4class'];
        $datacollect1['classname'] = $firstcollectdata[0]['class_name'];
        $datacollect1['idofclass'] = $firstcollectdata[0]['_id'];
        $datacollect1['connectedclass'] = $firstcollectdata[0]['connectedclass'];
        $datacollect1['checkboxchecked'] = '1';

        $connteddata = $firstcollectdata[0]['connectedclass'];
        foreach ($connteddata as $key => $value) {

        	$classid['_id'] = new MongoDB\BSON\ObjectID($value);
        	$othermessage = $this->crud_model->get('class',$classid);
        	
        	foreach ($othermessage[0]['calendar4class'] as $key => $value) {
        	
        		array_push($value, "othermessage");
        		array_push($datacollect1['mesagedata'], $value);
        	}
        }

     
        $response['data'] = $this->load->view('content/calendar_table', $datacollect1, TRUE);
        $response['status'] = TRUE;
        echo json_encode($response);
        exit();
	}


	public function delete()
    {
        $where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
        $delete =  $this->crud_model->delete_indexof_array('class',$where,'calendar4class',$_POST['key']);
    	if($delete){
            $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
            $firstcollectdata = $this->crud_model->get('class',$class_where);   
            $datacollect['mesagedata'] = $firstcollectdata[0]['calendar4class'];
            $datacollect['classname'] = $firstcollectdata[0]['class_name'];
            $datacollect['idofclass'] = $firstcollectdata[0]['_id'];
            $datacollect['connectedclass'] = $firstcollectdata[0]['connectedclass'];


            if($_POST['check'] == '1'){
                 $datacollect['checkboxchecked'] = '1';
                $connteddata = $firstcollectdata[0]['connectedclass'];
                foreach ($connteddata as $key => $value) {

                    $classid['_id'] = new MongoDB\BSON\ObjectID($value);
                    $othermessage = $this->crud_model->get('class',$classid);
                    
                    foreach ($othermessage[0]['calendar4class'] as $key => $value) {
                    
                        array_push($value, "othermessage");
                        array_push($datacollect['mesagedata'], $value);
                    }
                }
            }

             $response['data'] = $this->load->view('content/calendar_table', $datacollect, TRUE);
             $response['status'] = TRUE;
            
        }else{
            
        }
        echo json_encode($response);
        exit();
    }




}