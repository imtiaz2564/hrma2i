<?php

class Funds extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('funds_model');

    }
    public function index($id = NULL, $des_id = null)
    {
        $data['title'] =lang('fund_sources');

        $this->funds_model->_table_name = "tbl_fundsources"; //table name
        $this->funds_model->_order_by = "fundsources_id";
        $data['all_dept_info'] = $this->funds_model->get();

        $data['subview'] = $this->load->view('admin/fundsources/fundsources_list', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);
    }

    public function details($id = null)
    {
        $edited = can_action('70', 'edited');
        if (!empty($edited)) {
            $data['title'] = lang('fund_sources');
            if (!empty($id)) {
                $role = $this->funds_model->select_user_roll_by_id($id);
                if ($role) {
                    foreach ($role as $value) {
                        $result[$value->menu_id] = $value;
                    }
                    $data['roll'] = $result;
                }
                $data['funds_info'] = $this->db->where('fundsources_id', $id)->get('tbl_fundsources')->row();
            }
            $data['subview'] = $this->load->view('admin/fundsources/details', $data, TRUE);
        } else {
            $data['subview'] = $this->load->view('admin/settings/not_found');
        }
        $this->load->view('admin/_layout_main', $data);
    }

    public function save_fund($id=null)
    {
        $fund_name = $this->input->post('fund_name', TRUE);
        $total_amount = $this->input->post('total_amount', TRUE);
        $fund_date = $this->input->post('fund_date', TRUE);
    
        $this->funds_model->_table_name = "tbl_fundsources"; // table name
        $this->funds_model->_primary_key = "fundsources_id"; // $id

        $team_data['fund_name'] = $fund_name;
        $team_data['total_amount'] = $total_amount;
        $team_data['date'] = $fund_date;
        if (!empty($fund_name)) {
            $this->funds_model->save($team_data, $id);
        } else {
         $this->funds_model->save($team_data);
        } 

        $type = "success";
        $message = lang('fund_added');
        set_message($type, $message);
    
        $option = $this->input->post('save', true);
        if ($option == 1) {
            redirect('admin/funds');
        } elseif ($option == 2) {
            redirect('admin/funds/details');
        }
        if (empty($_SERVER['HTTP_REFERER'])) {
            redirect('admin/funds');
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }
    
    }
    public function delete_fund($id)
    {
        $deleted = can_action('70', 'deleted');
        if (!empty($deleted)) {

            $this->funds_model->_table_name = "tbl_fundsources"; // table name
            $this->funds_model->_primary_key = "fundsources_id"; // $id
            $this->funds_model->delete($id);

            $type = "success";
            $message = lang('funds_info_deleted');
            echo json_encode(array("status" => $type, 'message' => $message));
            exit();
        } else {
            echo json_encode(array("status" => 'error', 'message' => lang('there_in_no_value')));
            exit();
        }
    }
    public function fund_list($id = NULL)
    {
        $data['title'] =lang('fund');

        $this->funds_model->_table_name = "tbl_fund"; //table name
        $this->funds_model->_order_by = "fund_id";
        $data['fund_info'] = $this->funds_model->get();

        $data['subview'] = $this->load->view('admin/fund/fund_list', $data, TRUE);
        $this->load->view('admin/_layout_main', $data);

    }
    public function add_fund($id = null)
    {
        $edited = can_action('70', 'edited');
        if (!empty($edited)) {
            $data['title'] = lang('fund_sources');
            if (!empty($id)) {
                $role = $this->funds_model->select_user_roll_by_id($id);
                if ($role) {
                    foreach ($role as $value) {
                        $result[$value->menu_id] = $value;
                    }
                    $data['roll'] = $result;
                }
                $data['fund_info'] = $this->db->where('fund_id', $id)->get('tbl_fund')->row();
            }
           // $data['fundsources'] = $this->db->get('tbl_fundsources')->result();
            $data['subview'] = $this->load->view('admin/fund/fund_details', $data, TRUE);
        } else {
            $data['subview'] = $this->load->view('admin/settings/not_found');
        }
        $this->load->view('admin/_layout_main', $data);

    }
    public function save_new_fund($id=null)
    {
        $fund_name = $this->input->post('fund_name', TRUE);
        $amount = $this->input->post('amount', TRUE);
        $fund_date = $this->input->post('fund_date', TRUE);
    
        $this->funds_model->_table_name = "tbl_fund"; // table name
        $this->funds_model->_primary_key = "fund_id"; // $id

        $team_data['fund_name'] = $fund_name;
        $team_data['amount'] = $amount;
        $team_data['date'] = $fund_date;
        
        if (!empty($fund_name)) {
            $this->funds_model->save($team_data, $id);
        } else {
            $this->funds_model->save($team_data);
        } 

        $type = "success";
        $message = lang('fund_added');
        set_message($type, $message);
    
        $option = $this->input->post('save', true);
        if ($option == 1) {
            redirect('admin/funds/fund_list');
        } elseif ($option == 2) {
            redirect('admin/funds/fund_list');
        }
        if (empty($_SERVER['HTTP_REFERER'])) {
            redirect('admin/funds');
        } else {
            redirect($_SERVER['HTTP_REFERER']);
        }

    }
    public function newfund_details($id=null)
    {
        $edited = can_action('70', 'edited');
        if (!empty($edited)) {
            $data['title'] = lang('fund_sources');
            if (!empty($id)) {
                $role = $this->funds_model->select_user_roll_by_id($id);
                if ($role) {
                    foreach ($role as $value) {
                        $result[$value->menu_id] = $value;
                    }
                    $data['roll'] = $result;
                }
                $data['funds_info'] = $this->db->where('fund_id', $id)->get('tbl_fund')->row();
            }
            $data['subview'] = $this->load->view('admin/fund/fund_details', $data, TRUE);
        } else {
            $data['subview'] = $this->load->view('admin/settings/not_found');
        }
        $this->load->view('admin/_layout_main', $data);

    }
    public function delete_new_fund($id)
    {
        $deleted = can_action('70', 'deleted');
        if (!empty($deleted)) {

            $this->funds_model->_table_name = "tbl_fund"; // table name
            $this->funds_model->_primary_key = "fund_id"; // $id
            $this->funds_model->delete($id);

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
