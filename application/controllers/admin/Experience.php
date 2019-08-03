<?php

class Experience extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('experience_model');

    }
    public function index($id = NULL)
    {
        
        $data['title'] = 'Experience';

        if($id){
            // echo $id;
            // die();
            //$data['experience_info'] = $this->experience_model->getEmpExperience($id);
            $data['id'] = $this->uri->segment(4);
            $data['experience_info'] = $this->db->where('employee', $id)->get('tbl_experience')->result();
        }
        else{
            $this->experience_model->_table_name = "tbl_experience"; //table name
            $this->experience_model->_order_by = "experience_id";
            $data['experience_info'] = $this->experience_model->get();
        }
        $data['subview'] = $this->load->view('admin/experience/experience_list', $data, TRUE);
        
        $this->load->view('admin/_layout_main', $data);
    }
    public function experience_details($id = null)
    {

        $edited = can_action('70', 'edited');
        if (!empty($edited)) {
            $data['title'] = 'Experience';
            if (!empty($id)) {
                // $role = $this->experience_model->select_user_roll_by_id($id);
                // if ($role) {
                //     foreach ($role as $value) {
                //         $result[$value->menu_id] = $value;
                //     }
                //     $data['roll'] = $result;
                // }
                $data['experience_info'] = $this->db->where('experience_id', $id)->get('tbl_experience')->row();
            }
            $data['id'] = $this->uri->segment(4);
         
            $data['subview'] = $this->load->view('admin/experience/experience_details', $data, TRUE);
        } else {
            $data['subview'] = $this->load->view('admin/settings/not_found');
        }
        $this->load->view('admin/_layout_main', $data);
    }
    public function save_experience($id=null)
    {

        $employer = $this->input->post('employer', TRUE);
        $designation = $this->input->post('designation', TRUE);
        $from_date = $this->input->post('start_date', TRUE);
        $to_date = $this->input->post('end_date', TRUE);
      
        $exp_data['employer'] = $employer;
        $exp_data['designation'] = $designation;
        $exp_data['fromDate'] = $from_date;
        $exp_data['toDate'] = $to_date;
       // $exp_data['employee'] = $id;
     
    
        $this->experience_model->_table_name = "tbl_experience"; // table name
        $this->experience_model->_primary_key = "experience_id"; // $id
        if (!empty($id)) {
            $this->experience_model->save($exp_data, $id);
        } else {
            $employee = $this->input->post('employee_id', TRUE);
            $exp_data['employee'] = $employee;
            $this->experience_model->save($exp_data);
            redirect('admin/experience/index/'.$employee);
     
        } 

        $type = "success";
        $message = lang('fund_added');
        set_message($type, $message);
    
        $option = $this->input->post('save', true);
        if ($option == 1) {
             $experience = $this->experience_model->getExperiencedEmp($id);
            redirect('admin/experience/index/'.$experience->employee);
        //redirect('admin/user/user_list/edit_user/'.$employee);
        } 
        elseif ($option == 2) {
            redirect('admin/experience/details');
        }
        if (empty($_SERVER['HTTP_REFERER'])) {
            redirect('admin/experience/index/'.$experience->employee);
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    
    }
    public function delete_experience($id)
    {
        $deleted = can_action('70', 'deleted');
        if (!empty($deleted)) {

            $this->experience_model->_table_name = "tbl_experience"; // table name
            $this->experience_model->_primary_key = "experience_id"; // $id
            $this->experience_model->delete($id);

            $type = "success";
            $message = lang('funds_info_deleted');
            echo json_encode(array("status" => $type, 'message' => $message));
            exit();
        } else {
            echo json_encode(array("status" => 'error', 'message' => lang('there_in_no_value')));
            exit();
        }
    }
   
}
