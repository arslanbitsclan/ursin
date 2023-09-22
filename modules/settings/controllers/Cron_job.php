<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_job extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->title = "Cron Job";
        $this->layout = '';
        $this->layout = 'settings/views/layouts/ursin';
        $this->logged_in_user = get_user_id();
    }

    public function index()
    {
        $students = $this->crud_model->get('student');
        foreach ($students as $key => $student) {
            $due = date('Y-m-d', strtotime($student['timestamp'].' +5 years'));

            if (date('Y-m-d') >= $due){
                //delete student
                $this->crud_model->delete_student_cron($student['_id']);
            }

        }
    }
}
