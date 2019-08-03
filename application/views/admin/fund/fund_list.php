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
                <a href="<?= base_url() ?>admin/funds/add_fund">Add Fund</a>
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
                                <td class="text-bold">Fund Source</td>
                                <td class="text-bold">Amount</td>
                                <td class="text-bold">Date</td>
                                <?php if (!empty($edited) || !empty($deleted)) { ?>
                                    <td class="text-bold col-sm-2"><?= lang('action') ?></td>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?  foreach($fund_info as $fundinfo) {?>
                            <tr id ="table_fund_<?= $fundinfo->fund_id?>">
                            <? $fundSource  = $this->db->where('fundsources_id',$fundinfo->fund_name)->get('tbl_fundsources')->row(); ?>
                            <td><?= $fundSource->fund_name?></td>
                            <td><?= $fundinfo->amount?></td>
                            <td><?= $fundinfo->date?></td>
                            <?php if (!empty($edited) || !empty($deleted)) { ?>
                            <td>
                                <?php if (!empty($edited)) { ?>
                                    <?php echo btn_edit('admin/funds/newfund_details/' . $fundinfo->fund_id); ?>
                                <?php }
                                if (!empty($deleted)) { ?>
                                    <?php echo ajax_anchor(base_url("admin/funds/delete_new_fund/" . $fundinfo->fund_id), "<i class='btn btn-xs btn-danger fa fa-trash-o'></i>", array("class" => "", "title" => lang('delete'), "data-fade-out-on-success" => "#table_fund_" . $fundinfo->fund_id)); ?>
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