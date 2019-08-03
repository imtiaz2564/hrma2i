<?php

class Teamtransfer extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('teamtransfer_model');

    }
    public function index($id = NULL)
    {
        
        $data['title'] = 'Team Transfer';
        $this->teamtransfer_model->_table_name = "tbl_teamtransfer"; //table name
        $this->teamtransfer_model->_order_by = "teamtransfer_id";
        $data['teamtransfer_info'] = $this->teamtransfer_model->get();
        $data['subview'] = $this->load->view('admin/teamtransfer/teamtransfer_list', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }
    public function teamtransfer_details($id = null)
    {

        $edited = can_action('70', 'edited');
        if (!empty($edited)) {
            $data['title'] = 'Transfer';
            if (!empty($id)) {
                // $role = $this->experience_model->select_user_roll_by_id($id);
                // if ($role) {
                //     foreach ($role as $value) {
                //         $result[$value->menu_id] = $value;
                //     }
                //     $data['roll'] = $result;
                // }
                $data['teamtransfer_info'] = $this->db->where('teamtransfer_id', $id)->get('tbl_teamtransfer')->row();
         
            }
            // $this->teamtransfer_model->_table_name = "tbl_teamtransfer"; //table name
            // $this->teamtransfer_model->_order_by = "teamtransfer_id";
            // $data['teamtransfer_info'] = $this->teamtransfer_model->get();
            $this->teamtransfer_model->_table_name = "tbl_account_details"; //table name
            $this->teamtransfer_model->_order_by = "account_details_id";
            $data['user_info'] = $this->teamtransfer_model->get();
            $data['subview'] = $this->load->view('admin/teamtransfer/teamtransfer_details', $data, TRUE);
        } else {
            $data['subview'] = $this->load->view('admin/settings/not_found');
        }
        $this->load->view('admin/_layout_main', $data);
    }
    public function save_teamtransfer($id=null)
    {
        $teamtransfer_id = $this->input->post('teamtransfer_id', TRUE);
        $employee = $this->input->post('employee', TRUE);
        $teamFrom = $this->input->post('teamFrom', TRUE);
        $teamTo = $this->input->post('teamTo', TRUE);
        $from_date = $this->input->post('start_date', TRUE);
        $end_date = $this->input->post('end_date', TRUE);
        $team_data['employee'] = $employee;
        $team_data['teamFrom'] = $teamFrom;
        $team_data['teamTo'] = $teamTo;
        $team_data['dateFrom'] = $from_date;
        $team_data['dateTo'] = $end_date;
       
        $this->teamtransfer_model->_table_name = "tbl_teamtransfer"; // table name
        $this->teamtransfer_model->_primary_key = "teamtransfer_id"; // $id
       
        if (!empty($id)) {
            $this->teamtransfer_model->save($team_data, $id);
        } else {
            $this->teamtransfer_model->save($team_data);
        } 

        $type = "success";
        $message = 'fund_added';
        set_message($type, $message);
    
        $option = $this->input->post('save', true);
        if ($option == 1) {
            redirect('admin/teamtransfer');
        } elseif ($option == 2) {
            redirect('admin/teamtransfer');
        }
        if (empty($_SERVER['HTTP_REFERER'])) {
            redirect('admin/teamtransfer');
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    
    }
    public function delete_transfer($id)
    {
        $deleted = can_action('70', 'deleted');
        if (!empty($deleted)) {

            $this->teamtransfer_model->_table_name = "tbl_teamtransfer"; // table name
            $this->teamtransfer_model->_primary_key = "teamtransfer_id"; // $id
            $this->teamtransfer_model->delete($id);

            $type = "success";
            $message = "Deleted Transfer";
            echo json_encode(array("status" => $type, 'message' => $message));
            exit();
        } else {
            echo json_encode(array("status" => 'error', 'message' => lang('there_in_no_value')));
            exit();
        }
    }
   
}
