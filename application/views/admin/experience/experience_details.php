<?php
$created = can_action('70', 'created');
$edited = can_action('70', 'edited');
if (!empty($created) || !empty($edited)) {
    ?>
    <form method="post" data-parsley-validate="" novalidate=""
          action="<?= base_url() ?>admin/experience/save_experience/<?php
          if (!empty($experience_info->experience_id)) {
              echo $experience_info->experience_id;
          }
          ?>"
          class="form-horizontal">
        <?php if (!empty($experience_info)) {
                $details = $experience_info->employer . ' ⇒ ' . $experience_info->designation . ' ' . lang('details');
        } else {
            $details = "New Experience";
        } ?>
        <div class="panel panel-custom">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <div class="panel-title">
                    <strong><?= $details ?></strong>
                <span class="pull-right">
                    <button type="submit" name="save" value="1"
                            class="btn btn-primary "><?php echo !empty($experience_info->employer) ? lang('update') : lang('save') ?></button>

                    <!-- <button type="submit" name="save" value="2"
                            class="btn btn-primary "><?php //echo !empty($funds_info->fund_name) ? lang('update') . ' & ' . lang('add_more') : lang('save') . ' & ' . lang('add_more') ?></button> -->
                </span>
                </div>
            </div>
            <input type="hidden" name="employee_id" class="form-control"
                       value="<?php echo $id; ?>"/>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?= lang('employer') ?></label>
                <div class="col-sm-4">
                    <input type="text" name="employer" class="form-control employer"
                        value="<?php if (!empty($experience_info->employer)) echo $experience_info->employer; ?>"/>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?= lang('designation') ?></label>
                <div class="col-sm-4">
                    <input type="text" name="designation" class="form-control designation"
                        value="<?php if (!empty($experience_info->designation)) echo $experience_info->designation; ?>"/>
                </div>
            </div>
            <div class="form-group from_date">
                <label class=" col-sm-4 control-label">From<span
                        class="required">*</span></label>
                <div class="col-sm-4">
                    <div class="input-group ">
                        <input  type="text" name="start_date" class="form-control start_date" required
                        value="<?php if (!empty($experience_info->fromDate)) echo $experience_info->fromDate; ?>"/>
                                <div class="input-group-addon">
                                    <a href="#"><i class="fa fa-calendar"></i></a>
                                </div>
                    </div>
                </div>
            </div>
            <div class="form-group from_date">
                <label class=" col-sm-4 control-label">To<span
                        class="required">*</span></label>
                <div class="col-sm-4">
                    <div class="input-group ">
                        <input  type="text" name="end_date" class="form-control end_date" required
                        value="<?php if (!empty($experience_info->toDate)) echo $experience_info->toDate; ?>"/>
                                <div class="input-group-addon">
                                    <a href="#"><i class="fa fa-calendar"></i></a>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </form>        
<?php } ?>