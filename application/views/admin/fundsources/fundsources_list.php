<?= message_box('success'); ?>
<?php echo message_box('error');
$created = can_action('70', 'created');
$edited = can_action('70', 'edited');
$deleted = can_action('70', 'deleted');
?>
<div class="panel panel-custom">
    <div class="panel-heading">
        <?= lang('all') . ' ' . lang('fund_sources') ?>
        <?php if (!empty($created)) { ?>
            <div class="pull-right">
                <a href="<?= base_url() ?>admin/funds/details"><?= lang('new_fund_source') ?></a>
            </div>
        <?php } ?>
    </div>
    <div class="panel-body">
        <!-- NESTED-->
        <div class="box" style="" data-collapsed="0">
            <div class="box-body">
                <!-- Table -->
                <div class="row">
                        <?php 
                        foreach($all_dept_info as $deptinfo)
                            ?>
                            <div class="col-sm-6 mb-lg">
                            <div class="box-heading">
                                <div class="box-title">
                                <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td class="text-bold">Fund Name</td>
                                    <td class="text-bold">Total Amount</td>
                                    <td class="text-bold">Date</td>
                                    <?php if (!empty($edited) || !empty($deleted)) { ?>
                                        <td class="text-bold col-sm-2"><?= lang('action') ?></td>
                                    <?php } ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?  foreach($all_dept_info as $info) {?>
                                <tr id ="table_fundsources_<?=$info->fundsources_id?>">
                                <td><?=$info->fund_name?></td>
                                <td><?=$info->total_amount?></td>
                                <td><?=$info->date?></td>
                                <?php if (!empty($edited) || !empty($deleted)) { ?>
                                <td>
                                    <?php if (!empty($edited)) { ?>
                                        <?php echo btn_edit('admin/funds/details/' . $info->fundsources_id); ?>
                                    <?php }
                                    if (!empty($deleted)) { ?>
                                        <?php echo ajax_anchor(base_url("admin/funds/delete_fund/" . $info->fundsources_id), "<i class='btn btn-xs btn-danger fa fa-trash-o'></i>", array("class" => "", "title" => lang('delete'), "data-fade-out-on-success" => "#table_fundsources_" . $info->fundsources_id)); ?>
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