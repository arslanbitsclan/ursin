<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Absent extends MY_Controller{

	function __construct(){
		parent::__construct();
		$this->title = "Absent";
        $this->scripts = array("class");	
     	
        $this->layout = 'entries/views/layouts/ursin_absent';
        $this->logged_in_user = get_user_id();
        $this->logged_in_teacher_id = get_teacher_id();

	}

	public function index(){

        $class_where['array_teachers'] = $this->logged_in_teacher_id;
        $data['classes'] = $this->crud_model->get('class',$class_where);
        
		$this->load->view('absent',$data);
	}




    public function show_students(){
    	
        $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
        $firstcollectdata = $this->crud_model->get('class',$class_where);	

        $datacollect['students'] = $firstcollectdata[0]['array_students'];
        $datacollect['datetoday'] = date('F d');
       
        $response['data'] = $this->load->view('content/absent_students', $datacollect, TRUE);
        $response['status'] = TRUE;
        echo json_encode($response);
        exit();
	}


    public function mark_absent(){
        
        $student_where['_id'] = new MongoDB\BSON\ObjectID($_POST['student_id']);
        $studentdata = $this->crud_model->get('student',$student_where);   

        $dataofarray['date'] =  date('yy-m-d');
        $dataofarray['flag'] =  $_POST['flag'];
        $pushColumn = 'absent';

        $datearray = array();
        foreach ($studentdata[0]['absent'] as $key => $value) {
            array_push($datearray,$value['date']);
        }

         
        if($_POST['flag'] == 1){
                if(in_array(date('yy-m-d'), $datearray)){
                    $where['_id'] = new MongoDB\BSON\ObjectID($_POST['student_id']);
                    $delete =  $this->crud_model->delete_indexof_array('student',$where,'absent',$_POST['indexofabsent']);
                    $class_id = $this->crud_model->push('student',$student_where,$pushColumn,array($dataofarray));
                }else{

                    if(count($studentdata[0]['absent']) < 5){
                        $class_id = $this->crud_model->push('student',$student_where,$pushColumn,array($dataofarray));
                    }else{
                        $where['_id'] = new MongoDB\BSON\ObjectID($_POST['student_id']);
                        $delete =  $this->crud_model->delete_indexof_array('student',$where,'absent',0);
                        $class_id = $this->crud_model->push('student',$student_where,$pushColumn,array($dataofarray));
                    }  
                } 
                   
        }else if($_POST['flag'] == 2){

            $where['_id'] = new MongoDB\BSON\ObjectID($_POST['student_id']);
            $delete =  $this->crud_model->delete_indexof_array('student',$where,'absent',$_POST['indexofabsent']);
            $class_id = $this->crud_model->push('student',$student_where,$pushColumn,array($dataofarray));

        }else if($_POST['flag'] == 3){
            $where['_id'] = new MongoDB\BSON\ObjectID($_POST['student_id']);
            $delete =  $this->crud_model->delete_indexof_array('student',$where,'absent',$_POST['indexofabsent']);
        }



        $response['status'] = TRUE;
        echo json_encode($response);
        exit();
    }

    public function get_all_student_present(){



        $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
        $firstcollectdata = $this->crud_model->get('class',$class_where);   
        
        foreach ($firstcollectdata[0]['array_students'] as $key => $value) {
             $studentdata = student_info($value);
             if(isset($studentdata['absent'])){
                foreach ($studentdata['absent'] as $keyofabsent => $valueofabsent) {
                        if($valueofabsent['date'] == date('yy-m-d')){
                            $where['_id'] = new MongoDB\BSON\ObjectID($studentdata['_id']);
                            $delete =  $this->crud_model->delete_indexof_array('student',$where,'absent',$keyofabsent);
                        }        
                }   
             }
        }

        $firstcollectdata = $this->crud_model->get('class',$class_where);   
        $datacollect['students'] = $firstcollectdata[0]['array_students'];
        $datacollect['datetoday'] = date('F d');
       
        $response['data'] = $this->load->view('content/absent_students', $datacollect, TRUE);
        $response['status'] = TRUE;
        echo json_encode($response);
        exit();

    }
	


}