
<?php
$created = can_action('70', 'created');
$edited = can_action('70', 'edited');
if (!empty($created) || !empty($edited)) {
    ?>
    <form method="post" data-parsley-validate="" novalidate=""
          action="<?= base_url() ?>admin/funds/save_new_fund/<?php
          if (!empty($funds_info->fund_id)) {
              echo $funds_info->fund_id;
          }
          ?>"
          class="form-horizontal">
        <?php if (!empty($funds_info)) {
                $details = $funds_info->fund_name . ' ⇒ ' . $funds_info->total_amount . ' ' . lang('details');
        } else {
            $details = lang('new_fund_source');
        } ?>
        <div class="panel panel-custom">
            <!-- Default panel contents -->
            <div class="panel-heading">
                <div class="panel-title">
                    <strong><?= $details ?></strong>
                <span class="pull-right">
                    <button type="submit" name="save" value="1"
                            class="btn btn-primary "><?php echo !empty($funds_info->fund_name) ? lang('update') : lang('save') ?></button>

                    <button type="submit" name="save" value="2"
                            class="btn btn-primary "><?php echo !empty($funds_info->fund_name) ? lang('update') . ' & ' . lang('add_more') : lang('save') . ' & ' . lang('add_more') ?></button>
                </span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><strong><?= lang('fund_sources') ?></strong></label>
                <div class="col-lg-4">
                    <select class="  form-control select_box" style="width: 100%" name="fund_name">

                        <?php
                        $funds = $this->db->get('tbl_fundsources')->result();
                        foreach ($funds as $fund) :
                            ?>
                            <option lang="<?//= $loc->code ?>" value="<?= $fund->fundsources_id ?>" <?php
                            if (!empty($funds_info->fund_name)) {
                                if ($funds_info->fund_name == $fund->fundsources_id) {
                                    echo 'selected';
                                }
                            } 
                            //  else {
                            //     echo($this->config->item('fund_name') == $fund->fundsources_id ? 'selected="selected"' : '');
                            // }
                            ?>><?= $fund->fund_name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 control-label"><?= lang('amount') ?></label>
                <div class="col-sm-4">
                    <input type="text" name="amount" class="form-control new_fund_source"
                        value="<?php if (!empty($funds_info->amount)) echo $funds_info->amount; ?>"/>
                </div>
            </div>
            <div class="form-group new_fund_date">
                <label class=" col-sm-4 control-label"><?= lang('date') ?><span
                        class="required">*</span></label>
                <div class="col-sm-4">
                    <div class="input-group ">
                        <input  type="text" name="fund_date" class="form-control start_date" required
                        value="<?php if (!empty($funds_info->date)) echo $funds_info->date; ?>"/>
                                <div class="input-group-addon">
                                    <a href="#"><i class="fa fa-calendar"></i></a>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </form>        
<?php } ?>