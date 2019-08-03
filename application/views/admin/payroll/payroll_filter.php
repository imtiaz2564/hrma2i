<?
// print_r($test);
?>
<div class="row">
    <div class="col-sm-12" data-spy="scroll" data-offset="0">
        <div class="panel panel-custom"><!-- *********     Employee Search Panel ***************** -->
            <div class="panel-heading">
                <div class="panel-title">
                    <strong>Payroll Filter</strong>
                </div>
            </div>
            <form id="form" role="form" enctype="multipart/form-data"
                  action="<?php echo base_url() ?>admin/payroll/payroll_filter" method="post"
                  class="form-horizontal form-groups-bordered">
                <div class="panel-body">
                    <div class="row">
                    <!-- <div class="form-group"> -->
                        <!-- <label class="col-lg-3 control-label"><?//= lang('employment') ?></label> -->
                        <div class="col-lg-3">
                            <select name="employee_type" class="form-control select_box" style="width: 100%">
                                <option value="">Contract Type</option>
                                <option
                                    <?php
                                    if (!empty($employee_type)) {
                                        echo $employee_type == 'individual_contract' ? 'selected' : null;
                                    } ?>
                                    value="individual_contract">Individual Contract</option>
                                <option
                                    <?php
                                    if (!empty($employee_type)) {
                                        echo $employee_type == 'service_contract' ? 'selected' : null;
                                    } ?>
                                    value="service_contract">Service Contract</option>
                                <option
                                    <?php
                                    if (!empty($employee_type)) {
                                        echo $employee_type == 'young_professional' ? 'selected' : null;
                                    } ?>
                                    value="young_professional">Young Professional</option>
                            </select>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="form-group"> -->
                        <!-- <label class="col-sm-3 control-label"><strong><?//= lang('fund_sources') ?></strong></label> -->
                        <div class="col-lg-3">
                            <select class="  form-control select_box" style="width: 100%" name="fund_source">
                            <option value="">Fund Sources</option>
                             
                                <?php
                                $funds = $this->db->get('tbl_fundsources')->result();
                                foreach ($funds as $fund) :
                                    ?>
                                    <option value="<?= $fund->fundsources_id ?>" <?php
                                    if (!empty($fund_source)) {
                                        if ($fund_source == $fund->fundsources_id) {
                                            echo 'selected';
                                        }
                                        } 
                                    //  else {
                                    //     echo($this->config->item('fund_sources') == $fund->fundsources_id ? 'selected="selected"' : '');
                                    // }
                                    ?>><?= $fund->fund_name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="form-group"> -->
                        <!-- <label class="col-sm-3 control-label"><strong>Team</strong></label> -->
                        <div class="col-lg-3">
                            <select class="  form-control select_box" style="width: 100%" name="team_id">
                            <option value="">Team</option>
                                <?php
                                $teamsInfo = $this->db->get('tbl_teams')->result();
                                foreach ($teamsInfo as $team) :
                                    ?>
                                    <option lang="<?//= $loc->code ?>" value="<?= $team->teams_id ?>" <?php
                                    if (!empty($team_id)) {
                                        if ($team_id == $team->teams_id) {
                                            echo 'selected';
                                            }
                                        } 
                                    //  else {
                                    //     echo($this->config->item('fund_sources') == $fund->fundsources_id ? 'selected="selected"' : '');
                                    // }
                                    ?>><?= $team->teams ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <!-- </div> -->
                    <!-- <div class="form-group"> -->
                        <!-- <label class="col-lg-3 control-label">Experience</label> -->
                        <div class="col-lg-3">
                            <select name="experience"
                                    class="form-control select_box" style="width: 100%" >
                                <option value="">Experience</option>
                                <option
                                    <?php
                                    //if (!empty($profile_info->employee_type)) {
                                     //   echo $profile_info->employee_type == 'individual_contract' ? 'selected' : null;
                                    //} ?>
                                    value="1"> < 1 Year</option>
                                <option
                                    <?php
                                    // if (!empty($profile_info->employee_type)) {
                                    //     echo $profile_info->employee_type == 'service_contract' ? 'selected' : null;
                                    // } ?>
                                    value="1-5"> < 1-5 Year</option>
                                <option
                                    <?php
                                    // if (!empty($profile_info->employee_type)) {
                                    //     echo $profile_info->employee_type == 'young_professional' ? 'selected' : null;
                                    // } ?>
                                    value="5-10"> < 5-10 Year</option>
                                <option
                                    <?php
                                    // if (!empty($profile_info->employee_type)) {
                                    //     echo $profile_info->employee_type == 'young_professional' ? 'selected' : null;
                                    // } ?>
                                    value="11"> >10 Year</option>    
                            </select>
                        </div>
                    </div>
                    <div class="row">
                    <!-- <div class="form-group" id="border-none">
                        <label for="field-1" class="col-sm-2 control-label"></label> -->
                        <div style="margin-top:15px" class="pull-right col-sm-3">
                            <button  id="submit" type="submit" name="flag" value="1"
                                    class="btn btn-primary btn-block">Search
                            </button>
                        </div>
                    <!-- </div> -->
                    </div>
                </div>
            </div>
            </form>
        </div><!-- ******************** Employee Search Panel Ends ******************** -->
    </div>
</div>
<?php 
if (!empty($search_type) && $search_type != 'activities') {
if ($search_type == 'period') {
    $by = ' - ' . ' ' . date('F-Y', strtotime($start_month)) . ' ' . lang('TO') . ' ' . date('F-Y', strtotime($end_month));
    $pdf = $start_month . 'n' . $end_month;
}
if ($search_type == 'month') {
    $by = ' - ' . ' ' . date('F-Y', strtotime($by_month));
    $pdf = $by_month;
}
if ($search_type == 'employee') {
    $user_info = $this->db->where('user_id', $user_id)->get('tbl_account_details')->row();
    $by = ' - ' . ' ' . ' ' . $user_info->fullname;
    $pdf = $user_id;
}
?>
<div id="payment_history" class="all_payment_history">
    <div class="show_print" style="width: 100%; border-bottom: 2px solid black;margin-bottom: 30px">
        <!-- show when print start-->
        <table style="width: 100%; vertical-align: middle;">
            <tr>
                <td style="width: 50px; border: 0px;">
                    <img style="width: 50px;height: 50px;margin-bottom: 5px;"
                         src="<?= base_url() . config_item('company_logo') ?>" alt="" class="img-circle"/>
                </td>

                <td style="border: 0px;">
                    <p style="margin-left: 10px; font: 14px lighter;"><?= config_item('company_name') ?></p>
                </td>
            </tr>
        </table>
    </div>
    <!--  **************** show when print End ********************* -->
        <!-- Table -->
    <!--************ Payment History End***********-->
    <script type="text/javascript">
        function payment_history(payment_history) {
            var printContents = document.getElementById(payment_history).innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
        }
    </script>
    <?php } ?>
</div>
<div class="by_activities"
     style="display: <?//= !empty($search_type) && $search_type == 'service_contract' ? 'block' : 'none' ?>">
    <div class="col-sm-15" data-spy="scroll" data-offset="0">
        <div class="panel panel-custom">
            <div class="panel-heading">
                <div class="panel-title">Payroll Details
                    <!-- <a onclick="return confirm('<?//= lang('delete_alert') ?>')"
                       href="<?//= base_url() ?>admin/payroll/clear_activities"
                       class="btn btn-xs btn-primary pull-right"><?//= lang('clear') ?></a> -->
                </div>
            </div>
            <table class="table table-striped" id="Transation_DataTables">
            <thead>
                <tr>
                    <th class="col-xs-2">Name</th>
                    <th class="col-xs-3">Contract</th>
                    <th class="col-xs-1">Salary</th>
                    <th>Salary Source</th>
                    <th>Team</th>
                    <th>Experience</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalSalaryDue = 0;
                    $total_allowance = 0;
                    $total_deduction = 0;
                    $netSalary = 0;
                    if(!empty($employee_payroll))
                    foreach($employee_payroll as $employeepayroll){ ?>
                        <tr>
                            <td><?=$employeepayroll->fullname?></td>
                            <td><?=$employeepayroll->employee_type?></td>
                            <? $allowance_info = $this->db->where('salary_template_id', $employeepayroll->salary_template_id)->get('tbl_salary_allowance')->result();
                            foreach($allowance_info as $allowance){
                                $total_allowance += $allowance->allowance_value;
                            }
                            $deduction_info = $this->db->where('salary_template_id', $employeepayroll->salary_template_id)->get('tbl_salary_deduction')->result();
                            foreach($deduction_info as $deduction){
                                $total_deduction += $deduction->deduction_value;
                            }
                            $total = $employeepayroll->basic_salary + $total_allowance;
                            $netSalary  = $total - $total_deduction;  
                            if(!empty($employeepayroll->basic_salary)){
                            ?>
                            <td><?=$netSalary?></td>
                            <?} else {
                                $netSalary = $employeepayroll->hourly_rate * $employeepayroll->days; 
                                ?>
                                <td><?=$netSalary?></td>
                            <? } ?>
                            <td>
                                <?=$employeepayroll->fund_name?>
                                <strong> <? ?></strong>
                            </td>
                            <td><?=$employeepayroll->teams?></td>
                            <? if( $employeepayroll->expdays < 365) {?>
                                <td><?=number_format($employeepayroll->expdays/30,0)?>&nbspMonths</td>
                            <? } else { ?>
                                <td><?=number_format($employeepayroll->expdays/365,1)?>&nbspYears</td>
                            <? } $totalSalaryDue += $netSalary; ?> 
                        </tr>
                        <?php
                    }
                ?>
                
                <tr>
                    <td></td>
                    <td><b>Total Salary paid last Month</b></td>
                    <td><b><?=$total?></b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td><b>Total Salary Due this Month</b></td>
                    <td><b><?=$totalSalaryDue?></b></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#Transation_DataTables').dataTable({
                //paging: false,
                "bSort": false
            });
        });
    </script>
</div>
