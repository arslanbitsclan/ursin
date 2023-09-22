<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Homework extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->title = "Homework";
        $this->scripts = array("class");	
     	
       $this->layout = 'entries/views/layouts/ursin_homework';
        $this->logged_in_user = get_user_id();
        $this->logged_in_teacher_id = get_teacher_id();

	}

	public function index(){
        $dataofallclass = $this->crud_model->get('class');
         $index_arr =  array();
        foreach ($dataofallclass as $key => $examdata) {
            $class_id['_id'] = new MongoDB\BSON\ObjectID($examdata['_id']);
            
            if(!empty($examdata['homework4class'])){
                foreach ($examdata['homework4class'] as $keyofexam => $value) {

                        if(date('Y-m-d', strtotime("-5 days")) > $value['due_date'])
                        {
                             array_push($index_arr,$keyofexam);
                          //$delete =  $this->crud_model->delete_indexof_array('class',$class_id,'homework4class',$keyofexam);
                        }
               }

               // code here
                if(!empty($index_arr)){
                $this->crud_model->unset_column('class',$class_id,'homework4class',$index_arr);
                }

            }
        } 
       
        $class_where['array_teachers'] = $this->logged_in_teacher_id;
        $data['classes'] = $this->crud_model->get('class',$class_where);
     //    if($data['classes'][0]['show_tools'][2] == 1){
           
           

    	// }else{
     //        $data['showbanner'] = 'false';
     //    }

        if(!empty($_GET)){
            $data['selectclass'] = $_GET['classid'];
        }

		 $this->load->view('homework',$data);
	}


	public function manage()
    {
        
        $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
        $data = $this->crud_model->get('class',$class_where);
    
        if(count($data[0]['homework4class']) <= 200){
    		$userdata = $this->session->userdata("user_session");
            
            $date = date_create($_POST['due_date']);
            $_POST['due_date'] =  date_format($date,"Y-m-d");

           	$dataofarray['subject'] = $_POST['subject'];
           	$dataofarray['due_date'] = $_POST['due_date'];
           	$dataofarray['description'] = $_POST['description'];
           	$dataofarray['teachers_name'] = get_teacher_name();
            $dataofarray['teachers_id'] = $this->logged_in_teacher_id;
           	$pushColumn = 'homework4class';

    		$class_id = $this->crud_model->push('class',$class_where,$pushColumn,array($dataofarray));
            if($class_id){
                $msg = 'Homework Successfully Created';
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
                $msg = 'Limit Reached. Only 200 entries are possible in homework';
                $response['status'] = false;
                $response['msg'] = $msg;
                $this->session->set_flashdata('error',$msg);
        }

        redirect('entries/Homework?classid='.$_POST['class_id']);

    }

    public function get_accessofclass($class_id){

        $class_where['_id'] = new MongoDB\BSON\ObjectID($class_id);
        $data['classes'] = $this->crud_model->get('class',$class_where);
        $retnval = '';
        
        if($data['classes'][0]['show_tools'][4] == 1){

             $retnval = '0';

        }else{
             $retnval = '1';
        }
       return $data['classes'][0]['show_tools'][4];
    }


    public function get_homework_data(){
    	
        $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
        $firstcollectdata = $this->crud_model->get('class',$class_where);	

        $datacollect['mesagedata'] = $firstcollectdata[0]['homework4class'];
        $datacollect['classname']  = $firstcollectdata[0]['class_name'];
        $datacollect['idofclass']  = $firstcollectdata[0]['_id'];
        $datacollect['connectedclass'] = $firstcollectdata[0]['connectedclass'];

        $response['data'] = $this->load->view('content/homework_table', $datacollect, TRUE);
        $response['messageaccess'] = $this->get_accessofclass($_POST['class_id']);
        $response['status'] = TRUE;
        echo json_encode($response);
        exit();
	}



	public function get_all_homework_data(){
    	
        $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
        $firstcollectdata = $this->crud_model->get('class',$class_where);	

        $datacollect['mesagedata'] = $firstcollectdata[0]['homework4class'];
        $datacollect['classname'] = $firstcollectdata[0]['class_name'];
        $datacollect['idofclass'] = $firstcollectdata[0]['_id'];
        $datacollect['connectedclass'] = $firstcollectdata[0]['connectedclass'];
        $datacollect['checkboxchecked'] = '1';

        $connteddata = $firstcollectdata[0]['connectedclass'];
        foreach ($connteddata as $key => $value) {

        	$classid['_id'] = new MongoDB\BSON\ObjectID($value);
        	$othermessage = $this->crud_model->get('class',$classid);
        	
        	foreach ($othermessage[0]['homework4class'] as $key => $value) {
        	
        		array_push($value, "othermessage");
        		array_push($datacollect['mesagedata'], $value);
        	}
        }
       	
     
        $response['data'] = $this->load->view('content/homework_table', $datacollect, TRUE);
        $response['status'] = TRUE;
        echo json_encode($response);
        exit();
	}


	public function delete()
    {
        $where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
    	$delete =  $this->crud_model->delete_indexof_array('class',$where,'homework4class',$_POST['key']);
    	if($delete){
            $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
            $firstcollectdata = $this->crud_model->get('class',$class_where);   
            $datacollect['mesagedata'] = $firstcollectdata[0]['homework4class'];
            $datacollect['classname'] = $firstcollectdata[0]['class_name'];
            $datacollect['idofclass'] = $firstcollectdata[0]['_id'];
            $datacollect['connectedclass'] = $firstcollectdata[0]['connectedclass'];

            if($_POST['check'] == '1'){
                $datacollect['checkboxchecked'] = '1';
                $connteddata = $firstcollectdata[0]['connectedclass'];
                foreach ($connteddata as $key => $value) {
                    $classid['_id'] = new MongoDB\BSON\ObjectID($value);
                    $othermessage = $this->crud_model->get('class',$classid);
                    foreach ($othermessage[0]['homework4class'] as $key => $value) {
                    
                        array_push($value, "othermessage");
                        array_push($datacollect['mesagedata'], $value);
                    }
                }
            }

            $response['data'] = $this->load->view('content/homework_table', $datacollect, TRUE);
            $response['status'] = TRUE;
            
        }else{
            
        }
        echo json_encode($response);
        exit();
    }




}