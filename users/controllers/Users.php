<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Users extends AdminController
{
     public function __construct()
    {
        parent::__construct();
        $this->load->model('person_model');
    }

    

    public function index()
    {
        $data['title'] = _l('Users');
        $this->load->view('manage');
    }


    public function member()
    {

       $this->load->view('member');
    }

    public function table()
    {
    
        $this->app->get_table_data(module_views_path('users', 'persons'));
        
    }


    public function Persons($id = '')
    {

        if (!has_permission('users', '', 'view')) {
            access_denied('users');
    }
        if ($this->input->post() || !$this->input->is_ajax_request()) {
            if ($id == '') {
                if (!has_permission('users', '', 'create')) {
                    access_denied('users');
                }
                $this->load->model('person_model');
                $data = $this->input->post();
                $id = $this->person_model->add($data);

                if($id){
                     set_alert('success', _l('Person_Create' ));
                  echo json_encode([
                        'url'       => admin_url('users/users/' . $id),
                        'id' => $id,
                    ]);
                    exit();
                
          }
            } else {
                if (!has_permission('persons', '', 'edit')) {
                    access_denied('persons');
                }
                $success = $this->person_model->update($this->input->post(), $id);
                if ($success == true) {

                    echo json_encode([
                        'url'       => admin_url('users/Users/' . $id),
                        'id' => $id,
                    ]);
                    exit();
                }
                  }

                redirect('users/Users/');
        }
    }

         
    public function editPerson($id = '')
    {
        $this->load->model('person_model');
        $data['data'] = $this->person_model->get($id);
        $this->load->view('member', $data);
    }

    

    public function deleteperson($id)

   {
       $this->load->model('person_model');
       $this->person_model->delete($id);
       set_alert('warning', _l('Person_Deleted' ));
       redirect('users/Users');
   }

    public function bulk_action()
    {

      
        $total_deleted = 0;
        if ($this->input->post()) {
            $ids    = $this->input->post('ids');

            if (is_array($ids)) {
                foreach ($ids as $id) {
                    if ($this->input->post('mass_delete')) {
                        if ($this->person_model->delete($id)) {
                            $total_deleted++;
                        }
                      }

                    }
                }
            }


        if ($this->input->post('mass_delete')) {
            set_alert('success', _l('total_clients_deleted', $total_deleted));
        }
    }

    public function add_person_attachment($id)
    {
       
       handle_person_attachments($id);
        echo json_encode([
            'url' => admin_url('users/Persons/' . $id),
        ]);     
    }


    


  public function delete_person_attachment($attachment_id)
    {

        $this->person_model->delete_person_attachment($attachment_id);
        return redirect('users/editPerson/'.$attachment_id);
    }


}










    

   


   






