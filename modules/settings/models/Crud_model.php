<?php

class Crud_model extends CI_Model{

	public function __construct() {
		parent::__construct();
		$this->load->library('mongo_db', array('activate'=>'default'),'mongo_db2');
	}


	public function insert($collection,$data)
	{
 		try {

   		$insert = $this->mongo_db2->insert($collection,$data);
   		return $insert;

   		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";
			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}
	}

	public function insert_batch($collection,$data)
	{
 		try {

   		$insert_batch = $this->mongo_db2->batch_insert ($collection,$data);
   		return $insert_batch;

   		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";
			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}
	}

	public function update($collection,$where="",$data="",$push="",$pushData="",$pop="",$popData="")
	{	
		try {
			if(!empty($where))
				$this->mongo_db2->where($where);
			if(!empty($push)){
				$this->mongo_db2->pushAll($push,$pushData);
			}
			if(!empty($pop)){
				$this->mongo_db2->pop($pop,$popData);
			}
			if(!empty($data)){
				$this->mongo_db2->set($data);
			}
			$update = $this->mongo_db2->update($collection);
			return $update;

		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";
			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}
	}


	public function pop($collection,$where,$pop,$popData)
	{	
		try {
			$this->mongo_db2->where($where);
			$this->mongo_db2->pop($pop,$popData);
			$update = $this->mongo_db2->update($collection);
			return $update;

		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";
			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}
	}


	public function push($collection,$where,$push,$pushData)
	{	
		try {
			$this->mongo_db2->where($where);
			$this->mongo_db2->pushAll($push,$pushData);
			$update = $this->mongo_db2->update($collection);
			return $update;

		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";
			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}
	}


	public function push_new($collection,$where,$pushColumn,$pushData)
	{	
	
		$update = $this->mongo_db2->pushAll($pushColumn,$pushData,['sort' => 'ASC'])->where('_id',$where)->update($collection);
		return $update;
	}



	public function pull_new($collection,$where,$pullColumn,$pullData)
	{	
		if(!empty($where)){
			$update = $this->mongo_db2->pullAll($pullColumn,[$pullData])->where('_id',$where)->update($collection);
		}else{
			$update = $this->mongo_db2->pullAll($pullColumn,[$pullData])->update($collection);
		}
		
		return $update;
	}
	

	public function get($collection,$where='',$select="",$where_in="",$like='',$order_by='',$order='DESC',$limit='')
	{	
		try {
		if(!empty($select))
			$this->mongo_db2->select($select);
		if(!empty($where))
			$this->mongo_db2->where($where);
		if(!empty($where_in))
			$this->mongo_db2->where_in($where_in);
		if(!empty($like))
			$this->mongo_db2->like($like);
		if(!empty($order_by))
			$this->mongo_db2->sort($order_by,$order);
		if(!empty($limit))
			$this->mongo_db2->limit($limit);

		$data = $this->mongo_db2->get($collection);
		return $data;

		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";
			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}

	}


	public function delete($collection,$where)
	{
		try {
			$this->mongo_db2->where($where);
			$this->mongo_db2->delete($collection);
			return true;

		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";
			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}
	}


	


	public function delete_student($student_id,$class_id)
	{	

		$where['_id'] = new MongoDB\BSON\ObjectID($student_id);
		$student = $this->get('student',$where);


		if(sizeof($student[0]['array_teachers']) > 1 || sizeof($student[0]['array_classes']) > 1) {
			
			$logged_in_teacher = get_user_id();
			$teacherwhere['teacher_id'] = $logged_in_teacher;
			$teacher = $this->get('teacher',$teacherwhere);
			$logged_in_teacher_id = new MongoDB\BSON\ObjectID($teacher[0]['_id']);
			$class_id_formed = new MongoDB\BSON\ObjectID($class_id);
			$student_id_formed = new MongoDB\BSON\ObjectID($student_id);

			//remove student form current loggedin teacher 
			$this->pull_new('teacher',$logged_in_teacher_id,'array_students',$student_id);

			//remove student from clicked class
			$this->pull_new('class',$class_id_formed,'array_students',$student_id);

			//remove class from student
			$delete = $this->pull_new('student',$student_id_formed,'array_classes',$class_id);

			//remove teacher form clicked classs
			//$delete = $this->pull_new('class',$class_id_formed,'array_teachers',$logged_in_teacher);


		}else{
			//remove from teachers
			$this->pull_new('teacher','','array_students',$student_id);

			//remove from class
			$this->pull_new('class','','array_students',$student_id);	

			//remove from student
			$delete = $this->delete('student',$where);

		}

		
		if($delete){
			return true;
		}else{
			return false;
		}

	}


	//for cronjob

	public function delete_student_cron($student_id)
	{	

		$where['_id'] = new MongoDB\BSON\ObjectID($student_id);
		
		$teachers =  $this->crud_model->get('teacher');
		foreach ($teachers as $s => $teacher) {
			//remove from teachers
			$this->pull_new('teacher',new MongoDB\BSON\ObjectID($teacher['_id']),'array_students',$student_id);
		}
		
		$classes =  $this->crud_model->get('class');
		foreach ($classes as $c => $class) {
			//remove from class
			$this->pull_new('class',new MongoDB\BSON\ObjectID($class['_id']),'array_students',$student_id);
		}
				

		//remove from student
		$delete = $this->delete('student',$where);

		
		if($delete){
			return true;
		}else{
			return false;
		}

	}

	public function unset_column($collection,$where,$pullColumn,$indexs)
	{	
		try {
			$this->mongo_db2->where($where);
			for ($i=0; $i < sizeof($indexs); $i++) { 
				//debug($indexs[$i]);
				$this->mongo_db2->unset($pullColumn.'.'.$indexs[$i]);
			}
			//exit();
			$this->mongo_db2->update($collection);
			$update = $this->mongo_db2->pullAll($pullColumn,[null])->where($where)->update($collection);
			return $update;

		} catch (MongoDB\Driver\Exception\Exception $e) {

			$filename = basename(__FILE__);

			echo "The $filename script has experienced an error.\n"; 
			echo "It failed with the following exception:\n";
			echo "Exception:", $e->getMessage(), "\n";
			echo "In file:", $e->getFile(), "\n";
			echo "On line:", $e->getLine(), "\n";       
		}
	}







}



?>