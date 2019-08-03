<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of payroll_model
 *
 * @author NaYeM
 */
class Payroll_Model extends MY_Model
{

    public $_table_name;
    public $_order_by;
    public $_primary_key;

    public function get_department_by_id($departments_id)
    {
        $this->db->select('tbl_departments.deptname', FALSE);
        $this->db->select('tbl_designations.*', FALSE);
        $this->db->from('tbl_departments');
        $this->db->join('tbl_designations', 'tbl_departments.departments_id = tbl_designations.departments_id', 'left');
        $this->db->where('tbl_departments.departments_id', $departments_id);
        $query_result = $this->db->get();
        $result = $query_result->result();

        return $result;
    }

    public function get_emp_info_by_id($designation_id)
    {
        $this->db->select('tbl_account_details.*', FALSE);
        $this->db->select('tbl_designations.designations', FALSE);
        $this->db->from('tbl_account_details');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id  = tbl_account_details.designations_id', 'left');
        $this->db->where('tbl_designations.designations_id', $designation_id);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function get_emp_salary_list($id = NULL, $designation_id = NULL)
    {
        $this->db->select('tbl_employee_payroll.*', FALSE);
        $this->db->select('tbl_account_details.*', FALSE);
        $this->db->select('tbl_salary_template.*', FALSE);
        $this->db->select('tbl_hourly_rate.*', FALSE);
        $this->db->select('tbl_designations.*', FALSE);
        $this->db->select('tbl_departments.deptname', FALSE);
        $this->db->from('tbl_employee_payroll');
        $this->db->join('tbl_account_details', 'tbl_employee_payroll.user_id = tbl_account_details.user_id', 'left');
        $this->db->join('tbl_salary_template', 'tbl_employee_payroll.salary_template_id = tbl_salary_template.salary_template_id', 'left');
        $this->db->join('tbl_hourly_rate', 'tbl_employee_payroll.hourly_rate_id = tbl_hourly_rate.hourly_rate_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id  = tbl_account_details.designations_id', 'left');
        $this->db->join('tbl_departments', 'tbl_departments.departments_id  = tbl_designations.departments_id', 'left');

        if (!empty($designation_id)) {
            $this->db->where('tbl_designations.designations_id', $designation_id);
        }
        if (!empty($id)) {
            $this->db->where('tbl_employee_payroll.user_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->row();
        } else {
            if (!empty($_POST["length"]) && $_POST["length"] != -1) {
                $this->db->limit($_POST['length'], $_POST['start']);
            }
            $query_result = $this->db->get();
            $result = $query_result->result();
        }
        return $result;
    }

    public function get_salary_payment_info($salary_payment_id, $result = NULL, $search_type = null)
    {

        $this->db->select('tbl_salary_payment.*', FALSE);
        $this->db->select('tbl_account_details.*', FALSE);
        $this->db->select('tbl_designations.*', FALSE);
        $this->db->select('tbl_departments.deptname', FALSE);
        $this->db->from('tbl_salary_payment');
        $this->db->join('tbl_account_details', 'tbl_salary_payment.user_id = tbl_account_details.user_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id  = tbl_account_details.designations_id', 'left');
        $this->db->join('tbl_departments', 'tbl_departments.departments_id  = tbl_designations.departments_id', 'left');
        if (!empty($search_type)) {
            if ($search_type == 'employee') {
                $this->db->where("tbl_salary_payment.user_id", $salary_payment_id);
            } elseif ($search_type == 'month') {
                $this->db->where("tbl_salary_payment.payment_month", $salary_payment_id);
            } elseif ($search_type == 'period') {
                $this->db->where("tbl_salary_payment.payment_month >=", $salary_payment_id['start_month']);
                $this->db->where("tbl_salary_payment.payment_month <=", $salary_payment_id['end_month']);
            }
        } else {
            $this->db->where("tbl_salary_payment.salary_payment_id", $salary_payment_id);
        }
        if (!empty($_POST["length"]) && $_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query_result = $this->db->get();
        if (!empty($result)) {
            $result = $query_result->result();
        } else {
            $result = $query_result->row();
        }
        return $result;
    }
    public function get_Last_Month_salary($date)
    {
        $this->db->select('tbl_salary_payment.*', FALSE);
        $this->db->from('tbl_salary_payment');
        $this->db->where("tbl_salary_payment.payment_month", $date);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
 
    }
    public function get_Last_Month_allowance($payment_id){
        return $this->db->select('sum(salary_payment_allowance_value) as totalallowance')->where('salary_payment_id',$payment_id)->get('tbl_salary_payment_allowance')->row();
    }
    public function get_Last_Month_deduction($payment_id){
        return $this->db->select('sum(salary_payment_deduction_value) as totaldeduction')->where('salary_payment_id',$payment_id)->get('tbl_salary_payment_deduction')->row();
    }
    public function get_Last_Basic_Daily($payment_id){
        
        $res = $this->db->where('salary_payment_id',$payment_id)->where('salary_payment_details_label','Basic Salary')->get('tbl_salary_payment_details')->row();
        $value = $res->salary_payment_details_value; 
        if(empty($value)){
            $grade = $this->db->where('salary_payment_id',$payment_id)->where('salary_payment_details_label','Hourly Grade')->get('tbl_salary_payment_details')->row();
           
            $days = $this->db->where('hourly_grade',$grade->salary_payment_details_value)->get('tbl_hourly_rate')->row();
            $rate = $this->db->where('salary_payment_id',$payment_id)->where('salary_payment_details_label','hourly_rates')->get('tbl_salary_payment_details')->row();

            $value = $days->days * $rate->salary_payment_details_value;
            
        }
        return (double)$value;
    }
    public function get_advance_salary_info_by_date($payment_month = NULL, $id = NULL, $user_id = NULL)
    {
        $this->db->select('tbl_advance_salary.*', FALSE);
        $this->db->select('tbl_account_details.*', FALSE);
        $this->db->from('tbl_advance_salary');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_advance_salary.user_id', 'left');
        if ($this->session->userdata('user_type') != 1) {
            $this->db->where('tbl_advance_salary.user_id', $this->session->userdata('user_id'));
            $this->db->where('tbl_advance_salary.deduct_month', $payment_month);
            $query_result = $this->db->get();
            $result = $query_result->result();
        } elseif (!empty($id)) {
            $this->db->where('tbl_advance_salary.advance_salary_id', $id);
            $query_result = $this->db->get();
            $result = $query_result->row();
        } elseif (!empty($user_id)) {
            $this->db->where('tbl_advance_salary.status', '1');
            $this->db->where('tbl_account_details.user_id', $user_id);
            $query_result = $this->db->get();
            $result = $query_result->result();
        } else {
            $this->db->where('tbl_advance_salary.deduct_month', $payment_month);
            $query_result = $this->db->get();
            $result = $query_result->result();
        }
        return $result;
    }

    public function view_advance_salary($id = NULL)
    {
        $this->db->select('tbl_advance_salary.*', FALSE);
        $this->db->select('tbl_account_details.*', FALSE);
        $this->db->from('tbl_advance_salary');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_advance_salary.user_id', 'left');
        $this->db->where('tbl_advance_salary.advance_salary_id', $id);
        $query_result = $this->db->get();
        $result = $query_result->row();

        return $result;
    }

    public function my_advance_salary_info($all = null)
    {
        $this->db->select('tbl_advance_salary.*', FALSE);
        $this->db->select('tbl_account_details.*', FALSE);
        $this->db->from('tbl_advance_salary');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id = tbl_advance_salary.user_id', 'left');
        if (!empty($all)) {
            $this->db->order_by('tbl_advance_salary.request_date', "DESC");
        } else {
            $this->db->where('tbl_advance_salary.user_id', $this->session->userdata('user_id'));
        }
        if (!empty($_POST["length"]) && $_POST["length"] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;

    }

    public function get_attendance_info_by_date($start_date, $end_date, $user_id)
    {
        $this->db->select('tbl_attendance.*', FALSE);
        $this->db->select('tbl_clock.*', FALSE);
        $this->db->from('tbl_attendance');
        $this->db->join('tbl_clock', 'tbl_clock.attendance_id  = tbl_attendance.attendance_id', 'left');
        $this->db->where('tbl_attendance.date_in >=', $start_date);
        $this->db->where('tbl_attendance.date_in <=', $end_date);
        $this->db->where('tbl_attendance.user_id', $user_id);
        $this->db->where('tbl_attendance.attendance_status', 1);
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }

    public function get_provident_fund_info_by_date($start_date, $end_date, $user_id = null)
    {
        $this->db->select('tbl_salary_payment.*', FALSE);
        $this->db->select('tbl_salary_payment_deduction.*', FALSE);
        $this->db->select('tbl_account_details.*', FALSE);
        $this->db->from('tbl_salary_payment');
        $this->db->join('tbl_salary_payment_deduction', 'tbl_salary_payment_deduction.salary_payment_id  = tbl_salary_payment.salary_payment_id', 'left');
        $this->db->join('tbl_account_details', 'tbl_account_details.user_id  = tbl_salary_payment.user_id', 'left');
        $this->db->where('tbl_salary_payment.payment_month >=', $start_date);
        $this->db->where('tbl_salary_payment.payment_month <=', $end_date);
        $this->db->where('tbl_salary_payment_deduction.salary_payment_deduction_label', lang('provident_fund'));
        if (!empty($user_id)) {
            $this->db->where('tbl_salary_payment.user_id', $user_id);
        }
        $query_result = $this->db->get();
        $result = $query_result->result();
        return $result;
    }
    public function get_salary_list($employee_type  , $fund_source  , $team_id , $experience )
    {
        $this->db->select('tbl_employee_payroll.*', FALSE);
        $this->db->select('tbl_account_details.*', FALSE);
        $this->db->select('tbl_salary_template.*', FALSE);
        $this->db->select('tbl_hourly_rate.*', FALSE);
        $this->db->select('tbl_designations.*', FALSE);
        $this->db->select('tbl_departments.deptname', FALSE);
        $this->db->select('tbl_teams.teams', FALSE);
        $this->db->select('tbl_fundsources.fund_name', FALSE);
        //new added
        $this->db->select('tbl_experience.employee,sum(DATEDIFF(tbl_experience.toDate , tbl_experience.fromDate)) as expdays', FALSE);
      
        $this->db->from('tbl_employee_payroll');

        //new added

        $this->db->join('tbl_experience', 'tbl_employee_payroll.user_id = tbl_experience.employee', 'left');
      
        $this->db->join('tbl_account_details', 'tbl_employee_payroll.user_id = tbl_account_details.user_id', 'left');
        $this->db->join('tbl_salary_template', 'tbl_employee_payroll.salary_template_id = tbl_salary_template.salary_template_id', 'left');
        $this->db->join('tbl_hourly_rate', 'tbl_employee_payroll.hourly_rate_id = tbl_hourly_rate.hourly_rate_id', 'left');
        $this->db->join('tbl_designations', 'tbl_designations.designations_id  = tbl_account_details.designations_id', 'left');
        $this->db->join('tbl_departments', 'tbl_departments.departments_id  = tbl_designations.departments_id', 'left');
        $this->db->join('tbl_teams', 'tbl_teams.teams_id = tbl_account_details.team_id', 'left');
        $this->db->join('tbl_fundsources', 'tbl_fundsources.fundsources_id = tbl_account_details.fund_source', 'left');
       
        if(!empty($employee_type) && empty($fund_source) && empty($team_id) && empty($experience)){
            $this->db->where('tbl_account_details.employee_type', $employee_type);
            $query_result = $this->db->get();
            $result = $query_result->result();
        }
        if(!empty($fund_source) && empty($employee_type) && empty($team_id) && empty($experience)){
            $this->db->where('tbl_account_details.fund_source', $fund_source);
            $query_result = $this->db->get();
            $result = $query_result->result();
        }
        if(!empty($employee_type) && !empty($fund_source) && empty($team_id) && empty($experience) ){
         
            $this->db->where('tbl_account_details.employee_type', $employee_type);
            $this->db->where('tbl_account_details.fund_source', $fund_source);
            $query_result = $this->db->get();
            $result = $query_result->result();
        }
        
        if(!empty($team_id) && empty($employee_type) && empty($fund_source)  &&  empty($experience)){
            $this->db->where('tbl_account_details.team_id', $team_id);
            $query_result = $this->db->get();
            $result = $query_result->result();
        }
        //new added
        if(empty($team_id) && empty($employee_type) && empty($fund_source)  &&  !empty($experience)){
            if($experience == "1"){
                $expFrom = 0;
                $expTo = 365; 
            }
            if($experience == "1-5"){
                $expFrom = 365;
                $expTo = 1825; 
            }
            if($experience == "5-10"){
                $expFrom = 1825;
                $expTo = 3650; 
            }
            if($experience == "11"){
                $expFrom = 3650;
                $expTo = 10000; 
            }
            //$this->db->where('tbl_account_details.team_id', $experience);
            $this->db->having('expdays > ',$expFrom);
            $this->db->having('expdays <', $expTo);
            $this->db->group_by('tbl_employee_payroll.user_id');
            $query_result = $this->db->get();
            $result = $query_result->result();
        }

        
        if(!empty($employee_type) && !empty($fund_source) && !empty($team_id) && empty($experience)){
           
            $this->db->where('tbl_account_details.employee_type', $employee_type);
            $this->db->where('tbl_account_details.fund_source', $fund_source);
            $this->db->where('tbl_account_details.team_id', $team_id);
            $query_result = $this->db->get();
            $result = $query_result->result();
        }
        
        if(!empty($employee_type) && !empty($fund_source) && !empty($team_id) && !empty($experience)){
            $this->db->where('tbl_account_details.employee_type', $employee_type);
            $this->db->where('tbl_account_details.fund_source', $fund_source);
            $this->db->where('tbl_account_details.team_id', $team_id);
            //$this->db->where('tbl_account_details.experience', $experience);
            //new added
            if($experience == "1"){
                $expFrom = 0;
                $expTo = 365; 
            }
            if($experience == "1-5"){
                $expFrom = 365;
                $expTo = 1825; 
            }
            if($experience == "5-10"){
                $expFrom = 1825;
                $expTo = 3650; 
            }
            if($experience == "11"){
                $expFrom = 3650;
                $expTo = 10000; 
            }
            $this->db->having('expdays > ',$expFrom);
            $this->db->having('expdays <', $expTo);
            $this->db->group_by('tbl_employee_payroll.user_id');
            
            $query_result = $this->db->get();
            $result = $query_result->result();
        }
        // if(!empty($experience) && empty($employee_type) && empty($fund_source) && empty($team_id)){
        //     $this->db->where('tbl_account_details.experience', $experience);
        //     $query_result = $this->db->get();
        //     $result = $query_result->result();
        // }
        if(empty($employee_type) && empty($fund_source) && empty($team_id) &&  empty($experience)){
           
            $this->db->group_by('tbl_employee_payroll.user_id');
            $query_result = $this->db->get();
            $result = $query_result->result();
     
        }
        // else{
        //     $query_result = $this->db->get();
        //     $result = $query_result->result();

        // }
        return $result;
    }


}
