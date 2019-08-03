<?= message_box('success'); ?>
<?php echo message_box('error');
$created = can_action('70', 'created');
$edited = can_action('70', 'edited');
$deleted = can_action('70', 'deleted');
?>
<div class="panel panel-custom">
    <div class="panel-heading">
        <?= "Experience List" ?>
        <?php if (!empty($created)) { ?>
            <div class="pull-right">
                <a href="<?= base_url() ?>admin/experience/experience_details/<?=$id?>">Add Experience</a>
                &nbsp
                <a href="<?= base_url() ?>admin/user/user_list/edit_user/<?=$id?>">Back</a>
                
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
                                <td class="text-bold">Employer</td>
                                <td class="text-bold">Designation</td>
                                <td class="text-bold">From</td>
                                <td class="text-bold">To</td>
                                <?php if (!empty($edited) || !empty($deleted)) { ?>
                                    <td class="text-bold col-sm-2"><?= lang('action') ?></td>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?  foreach($experience_info as $info) {?>
                            <tr id ="table_fund_<?= $info->experience_id?>">
                            <? //$fundSource  = $this->db->where('fundsources_id',$fundinfo->fund_name)->get('tbl_fundsources')->row(); ?>
                            <td><?= $info->employer?></td>
                            <td><?= $info->designation?></td>
                            <td><?= $info->fromDate?></td>
                            <td><?= $info->toDate?></td>
                            <?php if (!empty($edited) || !empty($deleted)) { ?>
                            <td>
                                <?php if (!empty($edited)) { ?>
                                    <?php echo btn_edit('admin/experience/experience_details/' . $info->experience_id); ?>
                                <?php }
                                if (!empty($deleted)) { ?>
                                    <?php echo ajax_anchor(base_url("admin/experience/delete_experience/" . $info->experience_id), "<i class='btn btn-xs btn-danger fa fa-trash-o'></i>", array("class" => "", "title" => lang('delete'), "data-fade-out-on-success" => "#table_fund_" . $info->experience_id)); ?>
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