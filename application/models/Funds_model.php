<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of department_model
 *
 * @author NaYeM
 */
class Funds_Model extends MY_Model
{

    public $_table_name;
    public $_order_by;
    public $_primary_key;
    public function select_user_roll_by_id($designations_id) {
        $this->db->select('tbl_user_role.*', false);
        $this->db->select('tbl_menu.*', false);
        $this->db->from('tbl_user_role');
        $this->db->join('tbl_menu', 'tbl_user_role.menu_id = tbl_menu.menu_id', 'left');
        $this->db->where('tbl_user_role.designations_id', $designations_id);
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }
    public function get_funds_info(){
        $this->db->from('tbl_fundsources');
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

}
