<?php
$created = can_action('70', 'created');
$edited = can_action('70', 'edited');
if (!empty($created) || !empty($edited)) {
    // print_r($teamtransfer_info->teamtransfer_id);
    // die();
    ?>
    <form method="post" data-parsley-validate="" novalidate=""
          action="<?= base_url() ?>admin/teamtransfer/save_teamtransfer/<?php
          if (!empty($teamtransfer_info->teamtransfer_id)) {
              echo $teamtransfer_info->teamtransfer_id;
          }
          ?>"
          class="form-horizontal">
        <?php if (!empty($teamtransfer_info)) {
               // $details = $experience_info->employer . ' ⇒ ' . $experience_info->designation . ' ' . lang('details');
               $details = "";
            } else {
            $details = "Team Transfer";
        } ?>
        <div class="panel panel-custom">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <div class="panel-title">
                    <strong><?= $details ?></strocng>
                <span class="pull-right">
                    <button type="submit" name="save" value="1"
                            class="btn btn-primary "><?php echo !empty($teamtransfer_info->employee) ? lang('update') : lang('save') ?></button>

                    <!-- <button type="submit" name="save" value="2"
                            class="btn btn-primary "><?php //echo !empty($funds_info->fund_name) ? lang('update') . ' & ' . lang('add_more') : lang('save') . ' & ' . lang('add_more') ?></button> -->
                </span>
                </div>
            </div>
            <div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Employee</label>
                <div class="col-lg-4">
                <select class="form-control select_box" style="width: 100%" name="employee">
                    <?php
                    $account_details = $this->db->get('tbl_account_details')->result();
                    foreach ($account_details as $details) :
                        ?>
                        <option  value="<?= $details->user_id ?>" <?php
                        if (!empty($teamtransfer_info->employee)) {
                            if ($details->user_id == $teamtransfer_info->employee) {
                                echo 'selected';
                            }
                        } 
                        //  else {
                        //     echo($this->config->item('fund_name') == $fund->fundsources_id ? 'selected="selected"' : '');
                        // }
                        ?>><?= $details->fullname ?></option>
                    <?php endforeach; ?>
                </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Team From</label>
                <div class="col-lg-4">
                <select class="form-control select_box" style="width: 100%" name="teamFrom">
                    <?php
                    $teamsInfo = $this->db->get('tbl_teams')->result();
                    foreach ($teamsInfo as $info) :
                        ?>
                        <option  value="<?= $info->teams_id ?>" <?php
                        if (!empty($teamtransfer_info->teamTo)) {
                            if ($info->teams_id == $teamtransfer_info->teamFrom) {
                                echo 'selected';
                            }
                        } 
                        ?>><?= $info->teams ?></option>
                    <?php endforeach; ?>
                </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label">Team To</label>
                <div class="col-lg-4">
                <select class="form-control select_box" style="width: 100%" name="teamTo">
                    <?php
                    $teamsInfo = $this->db->get('tbl_teams')->result();
                    foreach ($teamsInfo as $info) :
                        ?>
                        <option  value="<?= $info->teams_id ?>" <?php
                        if (!empty($teamtransfer_info->teamTo)) {
                            if ($info->teams_id == $teamtransfer_info->teamTo) {
                                echo 'selected';
                            }
                        } 
                        ?>><?= $info->teams ?></option>
                    <?php endforeach; ?>
                </select>
                </div>
            </div>
            <div class="form-group from_date">
                <label class=" col-sm-4 control-label">From<span
                        class="required">*</span></label>
                <div class="col-sm-4">
                    <div class="input-group ">
                        <input  type="text" name="start_date" class="form-control start_date" required
                        value="<?php if (!empty($teamtransfer_info->dateFrom)) echo $teamtransfer_info->dateFrom; ?>"/>
                                <div class="input-group-addon">
                                    <a href="#"><i class="fa fa-calendar"></i></a>
                                </div>
                    </div>
                </div>
            </div>
            <div class="form-group from_date">
                <label class=" col-sm-4 control-label">To</label>
                <div class="col-sm-4">
                    <div class="input-group ">
                        <input  type="text" name="end_date" class="form-control end_date"
                        value="<?php if (!empty($teamtransfer_info->dateTo)) echo $teamtransfer_info->dateTo; else echo Date('Y-m-d'); ?>"/>
                                <div class="input-group-addon">
                                    <a href="#"><i class="fa fa-calendar"></i></a>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </form>        
<?php } ?>