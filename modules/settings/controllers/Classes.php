<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Classes extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->title = "Manage Classes";
        $this->scripts = array("class");
        
        $this->layout = 'settings/views/layouts/ursin';
        $this->logged_in_user = get_user_id();
        $this->logged_in_teacher_id = get_teacher_id();

    
    }


    public function index()
    {    

        $membership = get_user_membership();
        $data['classLimit'] = $membership;

        $teacher_where['_id'] =  new MongoDB\BSON\ObjectID($this->logged_in_teacher_id);
        $data['teacher'] = $this->crud_model->get('teacher',$teacher_where);

        $class_where['array_teachers'] = $this->logged_in_teacher_id;
        $data['classes'] = $this->crud_model->get('class',$class_where);
      
        $this->load->view('manage-classes',$data);
    }



    public function manage()
    {
       
        $membership = get_user_membership();
        $class_where['array_teachers'] = $this->logged_in_teacher_id;
        $classes = $this->crud_model->get('class',$class_where);

        $classesSize =  sizeof($classes);
        if($classesSize >= $membership){
            $msg = 'Limit reached';
            $response['status'] = false;
            $response['msg'] = $msg;
            $this->session->set_flashdata('error',$msg);
            redirect('settings/Classes');
        }

        //insert in class collection
        $data['class_name'] = $this->input->post('class_name');
        $data['array_teachers'] = array($this->logged_in_teacher_id);
        $data['array_students'] = array();
        $data['last_change'] = date("Y-m-d");
        $data['standard'] = 0;
        $data['show_tools'] = array(1, 1, 1, 1, 2, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
        $data['teacher_name'] = $this->input->post('teacher_name');
        $data['classcode'] = alphanumeric(6);
        $data['connectedclass'] = array();
        $data['messages4class'] = array();
        $data['homework4class'] = array();
        $data['calendar4class'] = array();
        $data['exams4class'] = array();
        $data['links4class'] = array();
        $data['shortcuts'] = array();
        $class_id = $this->crud_model->insert('class',$data);

        $teacher_id_formed = new MongoDB\BSON\ObjectID($this->logged_in_teacher_id);

        //update teacher_name in teacher json
        $update_teacher['teacher_full_name'] = $this->input->post('teacher_name');
        $this->crud_model->update('teacher',array('_id'=>$teacher_id_formed),$update_teacher);

        //update teacher json
        $pushColumn = 'array_classes';
        $pushData = array($class_id);
        
        $this->crud_model->push_new('teacher',$teacher_id_formed,$pushColumn,$pushData);

        //update teacher_name in class json
        $data_updated['teacher_name'] = $this->input->post('teacher_name');
        $update = $this->crud_model->update('class',array('array_teachers'=>$this->logged_in_teacher_id),$data_updated);

        if($update){
            $msg = 'Class Created Successfully';
            $response['status'] = true;
            $response['msg'] = $msg;
            $this->session->set_flashdata('success',$msg);
        }else{
            $msg = 'Something Went Wrong';
            $response['status'] = false;
            $response['msg'] = $msg;
            $this->session->set_flashdata('error',$msg);
        }
        
        redirect('settings/Classes');

    }



    public function update()
    {
        $data['class_name'] = $_POST['name'];
        $data['last_change'] = date("Y-m-d H:i:s");
        $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
        //update class json
        $update = $this->crud_model->update('class',$class_where,$data);

        if($update){
            $msg = 'Class Updated Successfully';
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



    public function delete()
    {

        $teacher_id_formed = new MongoDB\BSON\ObjectID($this->logged_in_teacher_id);
        $class_where['_id'] = new MongoDB\BSON\ObjectID($_POST['id']);
        $pullColumn = 'array_classes';
        $pullData = $_POST['id'];

        $studentArray = array();
        //get all classes of this teacher
        $getTeacherClasses = $this->crud_model->get('class',array('array_teachers'=>$this->logged_in_teacher_id));


        foreach ($getTeacherClasses as $tt => $teacherclass) {
            if($teacherclass['_id'] != $_POST['id']){
                foreach ($teacherclass['array_students'] as $ts => $classStudents) {
                    if(!in_array($classStudents, $studentArray)){
                        array_push($studentArray, $classStudents);
                    }
                }
            }
        }


        // remove in connected class
        $classes = $this->crud_model->get('class');
        foreach ($classes as $c => $class) {
            $this->crud_model->pull_new('class',new MongoDB\BSON\ObjectID($class['_id']),'connectedclass',$_POST['id']);
        }


        //remove class id form teacher json array_classes
        $getAllTeachers = $this->crud_model->get('teacher');
        foreach ($getAllTeachers as $t => $teacher) {
            $this->crud_model->pull_new('teacher',new MongoDB\BSON\ObjectID($teacher['_id']),'array_classes',$_POST['id']);
        }


        $getAllStudents = $this->crud_model->get('student');
        foreach ($getAllStudents as $s => $student) {

            if(sizeof($student['array_classes']) == 1 && $student['array_classes'][0] == $_POST['id']){

                /* Case 1 
                 - delete all student if only has these class 
                */

                //delete student
                $this->crud_model->delete('student',array("_id"=>new MongoDB\BSON\ObjectID($student['_id'])));

                //remove student form teacher json array_students
                $this->crud_model->pull_new('teacher',new MongoDB\BSON\ObjectID($this->logged_in_teacher_id),'array_students',$student['_id']);

                //remove teacher from student json array_teachers
                $this->crud_model->pull_new('student','','array_teachers',$this->logged_in_teacher_id);

            }else{

                /* Case 2
                 - remove the class id form all student's array_classes
                 - remove class student ids form this teacher json 
                   Special Case
                 - Student id must not be removed if the student belong to  two classes of same teacher 
                */

                 
                //remove student form teacher json array_students
                if(!in_array($student['_id'], $studentArray)){
                    $this->crud_model->pull_new('teacher',new MongoDB\BSON\ObjectID($this->logged_in_teacher_id),'array_students',$student['_id']);
                    $this->crud_model->pull_new('student',new MongoDB\BSON\ObjectID($student['_id']),'array_teachers',$this->logged_in_teacher_id); 
                }
            
                //remove class id form student json array_classes
                $this->crud_model->pull_new('student',new MongoDB\BSON\ObjectID($student['_id']),'array_classes',$_POST['id']);


                
            }  

        }



        //delete class
        $delete = $this->crud_model->delete('class',$class_where);

        if($delete){
            $msg = 'Class Deleted Successfully';
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



    public function settings($id)
    {   

        $class_where['_id'] = new MongoDB\BSON\ObjectID($id);
        $data['class'] = $this->crud_model->get('class',$class_where);
        $this->title = "Settings Class";
        $this->load->view('settings-class',$data);
    }



    public function standard()
    {   
        $class_id = $this->input->post('standart_class');
        if(empty($class_id)){
            $msg = 'Please select class';
            $response['status'] = true;
            $response['msg'] = $msg;
            $this->session->set_flashdata('error',$msg);
            redirect('Classes');
        }else{

            //turned all classes standard = 0
            $class_before_update['array_teachers'] = $this->logged_in_teacher_id;
            $classes_array = $this->crud_model->get('class',$class_before_update);
            foreach ($classes_array as $key => $class_arr) {
                $class_update_where['_id'] = new MongoDB\BSON\ObjectID($class_arr['_id']);
                $class_updated_data['standard'] = 0;
                $update = $this->crud_model->update('class',$class_update_where,$class_updated_data);
            }
            
            // standard the selected class
            $data['standard'] = 1;
            $class_where['_id'] = new MongoDB\BSON\ObjectID($class_id);
            $update = $this->crud_model->update('class',$class_where,$data);

            if($update){
                $msg = 'Class Standered Successfully';
                $response['status'] = true;
                $response['msg'] = $msg;
                $this->session->set_flashdata('success',$msg);
            }else{
                $msg = 'Something Went Wrong';
                $response['status'] = false;
                $response['msg'] = $msg;
                $this->session->set_flashdata('error',$msg);
            }
            redirect('settings/Classes');
        }
    }



    public function shortcut()
    {
   
        $id = new MongoDB\BSON\ObjectID($this->input->post('id'));
        $class_where['_id'] = $id;
        $class = $this->crud_model->get('class',$class_where);
        $shortcut_limits = get_membership_shortcuts();

        if(sizeof($class[0]['shortcuts']) >= $shortcut_limits){
            if($shortcut_limits == 5){
                $msg = 'Limit reached. Please upgrade the subscription or delete unused shortcuts.';
            }else{
                $msg = "Limit reached. Please delete unused shortcuts.";
            }
            
            $response['status'] = false;
            $response['msg'] = $msg;
            $response['limit'] = $shortcut_limits;
            $response['url'] = "https://edtools.io/user/signup";
            echo json_encode($response);
            exit();
        }else{
            $pushColumn = 'shortcuts';
            $pushData = array($this->input->post('shortcut'));
            $update = $this->crud_model->push_new('class',$id,$pushColumn,$pushData);
            if($update){
                $msg = 'Shortcut added Successfully';
                $response['status'] = true;
                $response['msg'] = $msg;
                $response['url'] = "https://edtools.io/user/signup";
            }else{
                $msg = 'Something Went Wrong';
                $response['status'] = false;
                $response['msg'] = $msg;
                $response['url'] = "https://edtools.io/user/signup";
            }
        }

        echo json_encode($response);
        exit();
       
    }


    public function delete_shortcuts()
    {
        
        $id = new MongoDB\BSON\ObjectID($this->input->post('id'));
        $update = $this->crud_model->pull_new('class',$id,"shortcuts",$this->input->post('shortcut'));
        if($update){

            $msg = 'Shortcut Removed Successfully';
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



    public function connect_class()
    {
        $id = new MongoDB\BSON\ObjectID($this->input->post('id'));
        $class_code = $this->input->post('code');
        $classWhere['classcode'] = $class_code;
        $class = $this->crud_model->get('class',$classWhere);

        if(!empty($class)){
            $pushColumn = 'connectedclass';
            $pushData = array($class[0]['_id']);
            $update = $this->crud_model->push_new('class',$id,$pushColumn,$pushData);
            if($update){
                $msg = 'Class Connected Successfully';
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
            $msg = "This code does not exist. Please ask the partner class.";
            $response['status'] = false;
            $response['msg'] = $msg;
            $this->session->set_flashdata('error',$msg);
        }

        $redirect_url = "settings/Classes/settings/".$this->input->post('id');
        redirect($redirect_url);

       
    }


    public function delete_connected_class()
    {
        
        //debug($_POST,true);
        //remove in connected class
        $classes = $this->crud_model->get('class');
        foreach ($classes as $c => $class) {
            $update = $this->crud_model->pull_new('class',new MongoDB\BSON\ObjectID($class['_id']),'connectedclass',$_POST['id']);
        }
        
        if($update){

            $msg = 'Class Connected Removed Successfully';
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



    public function options()
    {
        $this->layout = '';
        if($_POST['class_id'] == ""){
            echo "Please Select Class";
        }else{
            $classWhere['_id'] = new MongoDB\BSON\ObjectID($_POST['class_id']);
        $data['class_tools'] = $this->crud_model->get('class',$classWhere);
            echo $this->load->view('class-options',$data,true);
        }
         
    }



}
