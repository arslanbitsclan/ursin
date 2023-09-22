<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->title = 'Manage Students';
		$this->scripts = array('student');
		$this->logged_in_user = get_user_id();
		$this->layout = 'settings/views/layouts/ursin';
		$this->logged_in_teacher_id = get_teacher_id();

	}


    public function index()
	{	
		//get classes of teacher
		$where['array_teachers'] =  $this->logged_in_teacher_id;
		$data['classes'] = $this->crud_model->get('class',$where);

		//get students of teacher
		$students = $this->crud_model->get('student',$where);
		
		$student_array = array();
		foreach ($students as $student) { 
			if(!empty($student['array_classes'])){
				foreach ($student['array_classes'] as $k => $class) {
					$class_info = class_info_teacher($class);
					if(!empty($class_info)){
						$info = array('student_name' => $student['student_name'],
						'class_name'=> $class_info['class_name'],
						'class_id' => $class_info['_id'],
						'student_id'=>$student['_id'],
						'student_code' => $student['code'],
						'student_emails' => $student['parents_email'],
						'unq' => uniqid()
					);
					array_push($student_array,$info);
					}
					
				}
			}
      	}
      	//sort students by class name
      	$sorting = array_column($student_array, 'class_name');
        array_multisort($sorting, SORT_ASC, $student_array);
        $data['student_info'] = $student_array;
		$this->load->view('manage-students',$data);
	}



	public function manage()
	{	
		
		$class_id = $this->input->post('class_id');
		$student_names = $this->input->post('student_names');

		//explode students with next line
		$student_names_with_next_lines = explode("\n", $student_names);
		$student_full_names = array();

		//explode students with ,
		foreach ($student_names_with_next_lines as $key => $value) {
			$student_with_comma_seprate = explode(",",$value);
			foreach ($student_with_comma_seprate as $k => $v) {
				array_push($student_full_names, trim(ucfirst($v)));
			}
		}

		foreach ($student_full_names as $student_name) {
			//insert in student collection
			$data['student_name'] = $student_name;
			$data['code'] = alphanumeric(6);
			$data['parents-code'] = alphanumeric(6);
			$data['array_classes'] =  array($class_id);
			$data['array_teachers'] = array( $this->logged_in_teacher_id);
			$data['timestamp'] = date('Y-m-d');
			$data['parents_email'] = array();
			$data['sick'] =  array();
			$data['last_login'] = date("Y-m-d");
			$student_id = $this->crud_model->insert('student',$data);

			$pushColumn = 'array_students';
			$pushData = [$student_id];
			$where['teacher_id'] =  $this->logged_in_user;
			$datas['last_login'] = date("Y-m-d H:i:s");
			//update teacher json 
			$this->crud_model->update('teacher',$where,$datas,$pushColumn,$pushData);
			$classWhere['_id'] = new MongoDB\BSON\ObjectID($class_id);

			//update class json
			$update = $this->crud_model->push_new('class',new MongoDB\BSON\ObjectID($class_id),$pushColumn,$pushData);

			if($update){
				$msg = 'Students Created Successfully';
				$response['status'] = true;
				$response['msg'] = $msg;
				$this->session->set_flashdata('success',$msg);
			}else{
				$msg = 'Something Went Wrong';
				$response['status'] = false;
				$response['msg'] = $msg;
				$this->session->set_flashdata('error',$msg);
			}
		
		}
		redirect('settings/Student');
	}


	public function transfer()
	{
		$student_name = $_POST['student_name'];
		$code = $_POST['code'];
		$class_id = $_POST['class_id'];
		$where['code'] = $code;
		$where['student_name'] = $student_name;
		$student = $this->crud_model->get('student',$where);
		
		if(!empty($student)){
			
			//update class json array_students
			$student_id = $student[0]['_id'];
			$pushColumn = 'array_students';
			$pushData = [$student_id];
			$classWhere['_id'] = new MongoDB\BSON\ObjectID($class_id);
			$this->crud_model->push_new('class',new MongoDB\BSON\ObjectID($class_id),$pushColumn,$pushData);

			//add student on teacher json
			$teacherwhere['teacher_id'] = $this->logged_in_user;
			$teacher = $this->crud_model->get('teacher',$teacherwhere);
			if(!in_array($student_id, $teacher[0]['array_students'])){
				$this->crud_model->push_new('teacher',new MongoDB\BSON\ObjectID($this->logged_in_teacher_id),$pushColumn,$pushData);
			}

			

			//update student json array_classes
			$student_where['_id'] = new MongoDB\BSON\ObjectID($student_id);
			$pushClassColumn = 'array_classes';
			$pushClass = [$class_id];
			$this->crud_model->push_new('student',new MongoDB\BSON\ObjectID($student_id),$pushClassColumn,$pushClass);

			//update student json array_teachers
			if(!in_array($this->logged_in_teacher_id, $student[0]['array_teachers'])){
				$pushTeacherColumn = 'array_teachers';
				$pushTeacher = [$this->logged_in_teacher_id];
				$this->crud_model->push_new('student',new MongoDB\BSON\ObjectID($student_id),$pushTeacherColumn,$pushTeacher);
			}

			$response['status'] = true;
			$response['msg'] = $student_name.' was successfully transfered.';

		}else{
			$response['status'] = false;
			$response['msg'] = 'The student does not exist and can not be copied.';
		}

		echo json_encode($response);
		exit();

	}



	public function print_codelist()
	{	
		$this->layout = '';
		$data = $this->input->post();
		$class_id = $data['class'];
		$class['_id'] = new MongoDB\BSON\ObjectID($class_id);
		$class_data = $this->crud_model->get('class',$class);
		$class_students = $class_data[0]['array_students'];
		$data['students'] = array();
		foreach ($class_students as $k => $v) {
			$student_info = student_info($v);
			array_push($data['students'], $student_info);

		}
		$sorting = array_column($data['students'], 'student_name');
        array_multisort($sorting, SORT_ASC, $data['students']);
		$this->load->view('codelist',$data); 

	}



	public function delete()
	{	

		$student_id = $_POST['id'];
		$class_id = $_POST['classid'];
		$where['_id'] = new MongoDB\BSON\ObjectID($student_id);
		$student = $this->crud_model->get('student',$where);

		//debug($student);

		$logged_in_teacher_id = new MongoDB\BSON\ObjectID($this->logged_in_teacher_id);
		$class_id_formed = new MongoDB\BSON\ObjectID($class_id);
		$student_id_formed = new MongoDB\BSON\ObjectID($student_id);


		/* Case 1
			If there are several teachers in array_teachers, 
			- delete the ID of this teacher from this array.
			- Then look in all classes JSON files of this teacher to see if the student_id appears in the variable array_students in one of his own classes and remove the ID of the student 		from the class. 
			- The student JSON file is not deleted because it is needed by other teachers in other classes.
		*/

		if(sizeof($student[0]['array_teachers']) > 1) {
			
			//remove the teacher id form array_teacher in student json
			$this->crud_model->pull_new('student',$student_id_formed,'array_teachers',$this->logged_in_teacher_id);

			//remove student from clicked class
			$this->crud_model->pull_new('class',$class_id_formed,'array_students',$student_id);

			//remove student form teacher json
			$this->crud_model->pull_new('teacher',$logged_in_teacher_id,'array_students',$student_id);

			//remove class from student
			$this->crud_model->pull_new('student',$student_id_formed,'array_classes',$class_id);
			
		}


		/* Case 2
			If there are several classes in array_classes, 
			- delete id from this class.
			- delete the class id form student. 
		*/

		if(sizeof($student[0]['array_classes']) > 1){

			//remove student from clicked class
			$this->crud_model->pull_new('class',$class_id_formed,'array_students',$student_id);

			//remove class from student
			$this->crud_model->pull_new('student',$student_id_formed,'array_classes',$class_id);
			
		}


		


		/* Case 3
			If the variable array_teachers of the Student JSON file contains only this teacher
			- first remove the student_id from the teacher JSON file.
			- Then remove the student_id from all class JSON files of the listed classes in the student file in the array_classes variable.
			- Then delete the complete student Json file.
		*/

		if(sizeof($student[0]['array_teachers']) == 1 && sizeof($student[0]['array_classes']) == 1){

			//remove the student id form this teacher json
			$this->crud_model->pull_new('teacher',$logged_in_teacher_id,'array_students',$student_id);

			//get Student classes
			$studentClasses = $student[0]['array_classes'];

			foreach ($studentClasses as $c => $studentClass) {
				//remove student id form class
				$this->crud_model->pull_new('class',new MongoDB\BSON\ObjectID($studentClass),'array_students',$student_id);
			}

			//delete the student
			$delete = $this->crud_model->delete('student',$where);

			if($delete){
				$msg = 'Student successfully Deleted! ';
				$response['status'] = true;
				$response['msg'] = $msg;
				$this->session->set_flashdata('success',$msg);
			}else{
				$msg = 'Something Went Wrong';
				$response['status'] = false;
				$response['msg'] = $msg;
				$this->session->set_flashdata('error',$msg);
			}

			echo json_encode($response);
			exit();

		}

		$delete = true;

		if($delete){

			$msg = 'Student successfully Deleted! ';
			$response['status'] = true;
			$response['msg'] = $msg;
			$this->session->set_flashdata('success',$msg);
		}else{

			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}

		echo json_encode($response);
		exit();
		
	}



	public function setting($id)
	{	
		$student_where['_id'] = new MongoDB\BSON\ObjectID($id);
		$data['student'] = $this->crud_model->get('student',$student_where);
		$this->title = "Settings Students";
		$this->load->view('settings-students',$data);
	}


	public function family_emails()
	{
		$student_id = new MongoDB\BSON\ObjectID($this->input->post('student_id'));
		$emails = $this->input->post();
		unset($emails['student_id']);
		$student_where['_id'] = $student_id;
		$data['student'] = $this->crud_model->get('student',$student_where);
		$student_where['_id'] = $student_id;
		$update_data['parents_email'] = [$emails]; 
		$update = $this->crud_model->update('student',$student_where,$update_data);
		if($update){

			$student = $this->crud_model->get('student',$student_where);
			$familyEmail = "";
			$motherEmail = "";
			$fatherEmail = "";
			$mails = array($familyEmail,$motherEmail,$fatherEmail);
			if(!empty($student[0]['parents_email'])){

				if($student[0]['parents_email'][0]['family']){
					$familyEmail = $student[0]['parents_email'][0]['family'];
				}
				if($student[0]['parents_email'][0]['mother']){
					$motherEmail = $student[0]['parents_email'][0]['mother'];
				}
				if($student[0]['parents_email'][0]['father']){
					$fatherEmail = $student[0]['parents_email'][0]['father'];
				}
				$mails = array($familyEmail,$motherEmail,$fatherEmail);
			}

			$datas['student'] = $student;
			if(!empty($mails)){
				$mails1 = implode(",",$mails);

				$body = $this->load->view('email/parent_template',$datas, true);
				// $this->phpmailerlib->parent_email_added($mails,$body);
				$subject = 'Security message: New parent email added';
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: EdTools <notification@edtools.io>';
                $sts = mail($mails1,$subject,$body,$headers);
			}
			
			$msg = 'Students Emails Added Successfully';
			$response['status'] = true;
			$response['msg'] = $msg;
			$this->session->set_flashdata('success',$msg);
		}else{
			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}

		$redirect_url = "settings/Student/setting/".$this->input->post('student_id');
		redirect($redirect_url);


	}


	public function change_code()
	{
		$data['code'] = alphanumeric(6);
		$student_where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
		$update = $this->crud_model->update('student',$student_where,$data);
		if($update){
			$body = $this->load->view('email/change_parent_code',$data, true);
			$this->phpmailerlib->testmessage($body);
			$msg = 'Password successfully changed! New password for '.$_POST['student'].' : '.strval($data['code']).'';
			$string = trim(preg_replace('/\s\s+/', ' ', $msg));
			$response['status'] = true;
			$response['msg'] = $string;
			$this->session->set_flashdata('success',$string);
		}else{
			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}

		echo json_encode($response);
		exit();
	}



	public function change_parent_code()
	{
		$data['parents-code'] = alphanumeric(6);

		$student_where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
		$update = $this->crud_model->update('student',$student_where,$data);
		if($update){
			$student = $this->crud_model->get('student',$student_where);
			$familyEmail = "";
			$motherEmail = "";
			$fatherEmail = "";
			$mails = array($familyEmail,$motherEmail,$fatherEmail);
			if(!empty($student[0]['parents_email'])){

				if($student[0]['parents_email'][0]['family']){
					$familyEmail = $student[0]['parents_email'][0]['family'];
				}
				if($student[0]['parents_email'][0]['mother']){
					$motherEmail = $student[0]['parents_email'][0]['mother'];
				}
				if($student[0]['parents_email'][0]['father']){
					$fatherEmail = $student[0]['parents_email'][0]['father'];
				}
				$mails = array($familyEmail,$motherEmail,$fatherEmail);
			}

			if(!empty($mails)){
				$mails2 = implode(",",$mails);

				$data['code'] = $data['parents-code'];
				$body = $this->load->view('email/change_parent_code',$data, true);

				//$this->phpmailerlib->parent_code_changed($mails,$body);
				$subject = 'EdTools Parent Code Dear Parents';
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: EdTools <notification@edtools.io>';
                $sts = mail($mails2,$subject,$body,$headers);
			}
			

			$msg = 'Parents-code successfully changed! ';
			$response['status'] = true;
			$response['msg'] = $msg;
			$this->session->set_flashdata('success',$msg);
		}else{
			$msg = 'Something Went Wrong';
			$response['status'] = false;
			$response['msg'] = $msg;
			$this->session->set_flashdata('error',$msg);
		}

		echo json_encode($response);
		exit();
	}


	public function student($clid = '')
	{
		$where['array_teachers'] =  $this->logged_in_teacher_id;
		$data['classes'] = $this->crud_model->get('class',$where);
		$classWhere['array_teachers'] =  $this->logged_in_teacher_id;
		$classWhere['standard'] = 1;
		$data['class_tools'] = $this->crud_model->get('class',$classWhere);
		$this->title = "Student Page";

		if(!empty($clid)){
            $data['selectclass'] = $clid;
        }

		$this->load->view('student-page',$data);
	}

	public function options()
	{
		
		$classTools['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
		$class_tools = $this->crud_model->get('class',$classTools,array('show_tools'));
		$tools = $class_tools[0]['show_tools'];
		unset($tools[(int)$_POST['index']]);
		$tools[(int)$_POST['index']] = (int)$_POST['value'];
		$data['show_tools'] = $tools;
		$classWhere['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
		$update = $this->crud_model->update('class',$classWhere,$data);
		if($update){

			$response['status'] = true;

		}else{

			$response['status'] = false;
			
		}
		echo json_encode($response);
		exit();

		
	}




}
