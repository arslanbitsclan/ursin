<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron_job extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->title = "Cron Job";
        $this->layout = 'entries/views/layouts/ursin_messages';
        $this->logged_in_user = get_user_id();
    }

    public function index()
    {
        $firstcollectdata = $this->crud_model->get('class'); 
        $index_arr =  array();  
         foreach ($firstcollectdata as $keyvl => $val) {
            if(!empty($val['messages4class'])){
                 $where['_id'] = new MongoDB\BSON\ObjectID($val['_id']);
                foreach ($val['messages4class'] as $key => $value) {
                    if(isset($value['expirationdate'])){
                        $date = date('Y-m-d');
                        if($value['expirationdate'] < $date){
                            //$delete =  $this->crud_model->delete_indexof_array('class',$where,'messages4class',$key);
                            array_push($index_arr,$key);
                        }
                        
                    }
                }
                if(!empty($index_arr)){
                // code  here
                    $this->crud_model->unset_column('class',$where,'messages4class',$index_arr);
                }
            }
         }

         // Delete Exams

        $array_indexes =  array();
        $dataofallclass = $this->crud_model->get('class');
        foreach ($dataofallclass as $key => $examdata) {
            $class_id['_id'] = new MongoDB\BSON\ObjectID($examdata['_id']); 
            if(!empty($examdata['exams4class'])){
                foreach ($examdata['exams4class'] as $keyofexam => $value) {
                    $t1 = strtotime( date('Y-m-d H:i:s') );
                    $t2 = strtotime( $value['exam_date'] );
                    $diff = $t1 - $t2;
                    $hours = $diff / ( 60 * 60 );
                    if($hours > 24){
                        array_push($array_indexes,$keyofexam);
                        // $delete =  $this->crud_model->delete_indexof_array('class',$class_id,'exams4class',$keyofexam);
                    }
                }
                if(!empty($array_indexes)){
                    //code here
                    $this->crud_model->unset_column('class',$class_id,'exams4class',$array_indexes);
                }

            }
        }


        //Delete Calander


        $dataofallclass = $this->crud_model->get('class');
        $calander_indexes =  array();
        foreach ($dataofallclass as $key => $examdata) {
            $class_id['_id'] = new MongoDB\BSON\ObjectID($examdata['_id']);
            if(!empty($examdata['calendar4class'])){
                foreach ($examdata['calendar4class'] as $keyofclndr => $value) {

                    $t1 = strtotime( date('Y-m-d H:i:s') );
                    $t2 = strtotime( $value['activity_date'] );
                    $diff = $t1 - $t2;
                    $hours = $diff / ( 60 * 60 );
                    if($hours > 24){    
                        array_push($calander_indexes,$keyofclndr);
                        //$this->crud_model->delete_indexof_array('class',$class_id,'calendar4class',$keyofclndr); 
                    }     
                }

                if(!empty($calander_indexes)){
                    $this->crud_model->unset_column('class',$class_id,'calendar4class',$calander_indexes);
                }
            }
        }

    }
}
