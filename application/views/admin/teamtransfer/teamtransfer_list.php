<?= message_box('success'); ?>
<?php echo message_box('error');
$created = can_action('70', 'created');
$edited = can_action('70', 'edited');
$deleted = can_action('70', 'deleted');
?>
<div class="panel panel-custom">
    <div class="panel-heading">
        <?= "All transfer"?>
        <?php if (!empty($created)) { ?>
            <div class="pull-right">
                <a href="<?= base_url() ?>admin/teamtransfer/teamtransfer_details">Team Transfer</a>
            </div>
        <?php } ?>
    </div>
    <div class="panel-body">
        <!-- NESTED-->
        <div class="box" style="" data-collapsed="0">
            <div class="box-body">
                <!-- Table -->
                <div class="row">
                    <div class="col-sm-6 mb-lg">
                        <div class="box-heading">
                            <div class="box-title">
                            <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <td class="text-bold">Employee</td>
                                <td class="text-bold">Team From</td>
                                <td class="text-bold">Team To</td>
                                <td class="text-bold">Form ( Date )</td>
                                <td class="text-bold">To ( Date )</td>
                                <?php if (!empty($edited) || !empty($deleted)) { ?>
                                    <td class="text-bold col-sm-2"><?= lang('action') ?></td>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?  foreach($teamtransfer_info as $info) {?>
                            <tr id ="table_fundsources_<?=$info->teamtransfer_id?>">
                            <? $employeeName  = $this->db->where('user_id',$info->employee)->get('tbl_account_details')->row();?>
                            <td><?=$employeeName->fullname?></td>
                            <? $team  = $this->db->where('teams_id',$info->teamFrom)->get('tbl_teams')->row();?>
                            <td><?=$team->teams?></td>
                            <? $team= $this->db->where('teams_id',$info->teamTo)->get('tbl_teams')->row();?>
                            <td><?=$team->teams?></td>
                            <td><?=$info->dateFrom?></td>
                            <td><?=$info->dateTo?></td>
                            <?php if (!empty($edited) || !empty($deleted)) { ?>
                            <td>
                                <?php if (!empty($edited)) { ?>
                                    <?php echo btn_edit('admin/teamtransfer/teamtransfer_details/' . $info->teamtransfer_id); ?>
                                <?php }
                                if (!empty($deleted)) { ?>
                                    <?php echo ajax_anchor(base_url("admin/teamtransfer/delete_transfer/" . $info->teamtransfer_id), "<i class='btn btn-xs btn-danger fa fa-trash-o'></i>", array("class" => "", "title" => lang('delete'), "data-fade-out-on-success" => "#table_fundsources_" . $info->teamtransfer_id)); ?>
                                <?php } ?>
                            </td>
                            <?php } }?>
                            </tbody>
                            </table> 
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
    </div>