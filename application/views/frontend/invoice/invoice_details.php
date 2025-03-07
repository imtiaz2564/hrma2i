<?= message_box('success') ?>
<?= message_box('error') ?>
<div class="row mb">

    <div class="col-sm-8">
        <?php
        $client_info = $this->invoice_model->check_by(array('client_id' => $invoice_info->client_id), 'tbl_client');
        if (!empty($client_info)) {
            $currency = $this->invoice_model->client_currency_sambol($invoice_info->client_id);
            $client_lang = $client_info->language;
        } else {
            $client_lang = 'english';
            $currency = $this->invoice_model->check_by(array('code' => config_item('default_currency')), 'tbl_currencies');
        }
        unset($this->lang->is_loaded[5]);
        $language_info = $this->lang->load('sales_lang', $client_lang, TRUE, FALSE, '', TRUE);
        $allow_customer_edit_amount = config_item('allow_customer_edit_amount');
        ?>
        <?php if ($this->invoice_model->get_invoice_cost($invoice_info->invoices_id) > 0) { ?>
            <div class="btn-group">
                <button class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                    <?= lang('pay_invoice') ?>
                    <span class="caret"></span></button>
                <ul class="dropdown-menu animated zoomIn">
                    <?php if ($invoice_info->allow_paypal == 'Yes') {
                        ?>
                        <li><a data-toggle="modal" data-target="#myModal"
                               href="<?= base_url() ?>payment/paypal/pay/<?= $invoice_info->invoices_id ?>"
                               title="<?= lang('paypal') ?>"><?= lang('paypal') ?></a></li>
                        <?php
                    }
                    if ($invoice_info->allow_2checkout == 'Yes') {
                        ?>
                        <li><a href="<?= base_url() ?>payment/checkout/pay/<?= $invoice_info->invoices_id ?>"
                               title="<?= lang('2checkout') ?>"><?= lang('2checkout') ?></a></li>

                    <?php }
                    if ($invoice_info->allow_stripe == 'Yes') {
                        ?>
                        <li>
                            <a data-toggle="modal" data-target="#myModal"
                               href="<?= base_url() ?>payment/stripe/pay/<?= $invoice_info->invoices_id ?>"><?= lang('stripe') ?></a>
                        </li>
                    <?php }
                    if ($invoice_info->allow_authorize == 'Yes') { ?>
                        <li><a href="<?= base_url() ?>payment/authorize/pay/<?= $invoice_info->invoices_id ?>"
                               title="<?= lang('authorize') ?>"><?= lang('authorize') ?></a></li>
                    <?php }
                    if ($invoice_info->allow_ccavenue == 'Yes') { ?>
                        <li><a href="<?= base_url() ?>payment/ccavenue/pay/<?= $invoice_info->invoices_id ?>"
                               title="<?= lang('ccavenue') ?>"><?= lang('ccavenue') ?></a></li>
                    <?php }
                    if ($invoice_info->allow_braintree == 'Yes') { ?>
                        <li><a href="<?= base_url() ?>payment/braintree/pay/<?= $invoice_info->invoices_id ?>"
                               title="<?= lang('braintree') ?>"><?= lang('braintree') ?></a></li>
                    <?php }
                    if ($invoice_info->allow_mollie == 'Yes') { ?>
                        <?php if (!empty($allow_customer_edit_amount) && $allow_customer_edit_amount == 'No') { ?>
                            <li><a href="<?= base_url() ?>payment/mollie/pay/<?= $invoice_info->invoices_id ?>"
                                   title="<?= lang('mollie') ?>"><?= lang('mollie') ?></a></li>
                        <?php } else { ?>
                            <li><a data-toggle="modal" data-target="#myModal"
                                   href="<?= base_url() ?>payment/mollie/pay/<?= $invoice_info->invoices_id ?>"
                                   title="<?= lang('mollie') ?>"><?= lang('mollie') ?></a></li>
                        <?php } ?>
                    <?php }
                    if ($invoice_info->allow_payumoney == 'Yes') { ?>
                        <li><a href="<?= base_url() ?>payment/payumoney/pay/<?= $invoice_info->invoices_id ?>"
                               title="<?= lang('PayUmoney') ?>"><?= lang('PayUmoney') ?></a></li>
                    <?php } ?>
                </ul>
            </div>

        <?php } ?>
        <?php
        if (!empty($invoice_info->project_id)) {
            $project_info = $this->db->where('project_id', $invoice_info->project_id)->get('tbl_project')->row();
            ?>
            <strong><?= lang('project') ?>:</strong>
            <a
                    href="<?= base_url() ?>client/project/project_details/<?= $invoice_info->project_id ?>"
                    class="">
                <?= $project_info->project_name ?>
            </a>
        <?php } ?>
    </div>
    <div class="col-sm-4 pull-right">
        <a onclick="print_invoice('print_invoice')" href="#" data-toggle="tooltip" data-placement="top" title=""
           data-original-title="Print" class="btn btn-sm btn-danger pull-right">
            <i class="fa fa-print"></i>
        </a>

        <a
                href="<?= base_url() ?>frontend/pdf_invoice/<?= $invoice_info->invoices_id ?>"
                data-toggle="tooltip" data-placement="top" title="" data-original-title="PDF"
                class="btn btn-sm btn-success pull-right mr-sm">
            <i class="fa fa-file-pdf-o"></i>
        </a>
    </div>
</div>

<?php
$payment_status = $this->invoice_model->get_payment_status($invoice_info->invoices_id);
if (strtotime($invoice_info->due_date) < strtotime(date('Y-m-d')) && $payment_status != lang('fully_paid')) {
    ?>
    <div class="alert bg-danger-light hidden-print">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <i class="fa fa-warning"></i>
        <?= lang('invoice_overdue') ?>
    </div>
    <?php
}
?>

<div class="panel" id="print_invoice">
    <div class="show_print ">
        <div class="col-xs-12">
            <h4 class="page-header">
                <img class="mr" style="width: 60px;width: 60px;margin-top: -10px;"
                     src="<?= base_url() . config_item('invoice_logo') ?>"><?= config_item('company_name') ?>
            </h4>
        </div><!-- /.col -->
    </div>
    <div class="panel-body">

        <h3 class="mt0 mb-sm"><?= $invoice_info->reference_no ?></h3>
        <hr class="m0">
        <div class="row mb-lg">
            <div class="col-lg-4 col-xs-6 br pv">
                <div class="row">
                    <div class="col-md-2 text-center visible-md visible-lg">
                        <em class="fa fa-truck fa-4x text-muted"></em>
                    </div>
                    <div class="col-md-10">
                        <h4 class="ml-sm"><?= (config_item('company_legal_name_' . $client_lang) ? config_item('company_legal_name_' . $client_lang) : config_item('company_legal_name')) ?></h4>
                        <address></address><?= (config_item('company_address_' . $client_lang) ? config_item('company_address_' . $client_lang) : config_item('company_address')) ?>
                        <br><?= (config_item('company_city_' . $client_lang) ? config_item('company_city_' . $client_lang) : config_item('company_city')) ?>
                        , <?= config_item('company_zip_code') ?>
                        <br><?= (config_item('company_country_' . $client_lang) ? config_item('company_country_' . $client_lang) : config_item('company_country')) ?>
                        <br/><?= $language_info['phone'] ?> : <?= config_item('company_phone') ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-xs-6 br pv">
                <div class="row">
                    <div class="col-md-2 text-center visible-md visible-lg">
                        <em class="fa fa-plane fa-4x text-muted"></em>
                    </div>
                    <?php
                    if (!empty($client_info)) {
                        $client_name = $client_info->name;
                        $address = $client_info->address;
                        $city = $client_info->city;
                        $zipcode = $client_info->zipcode;
                        $country = $client_info->country;
                        $phone = $client_info->phone;
                    } else {
                        $client_name = '-';
                        $address = '-';
                        $city = '-';
                        $zipcode = '-';
                        $country = '-';
                        $phone = '-';
                    }
                    ?>
                    <div class="col-md-10">
                        <h4><?= $client_name ?></h4>
                        <address></address><?= $address ?>
                        <br> <?= $city ?>, <?= $zipcode ?>
                        <br><?= $country ?>
                        <br><?= $language_info['phone'] ?>: <?= $phone ?>
                    </div>
                </div>
            </div>
            <div class="clearfix hidden-md hidden-lg">
                <hr>
            </div>
            <div class="col-lg-4 col-xs-12 pv">
                <div class="clearfix">
                    <p class="pull-left">INVOICE NO.</p>
                    <p class="pull-right mr"><?= $invoice_info->reference_no ?></p>
                </div>
                <div class="clearfix">
                    <p class="pull-left"><?= $language_info['invoice_date'] ?></p>
                    <p class="pull-right mr"><?= display_date($invoice_info->invoice_date); ?></p>
                </div>
                <div class="clearfix">
                    <p class="pull-left"><?= $language_info['due_date'] ?></p>
                    <p class="pull-right mr"><?= display_date($invoice_info->due_date); ?></p>
                </div>
                <?php if (!empty($invoice_info->user_id)) { ?>
                    <div class="clearfix">
                        <p class="pull-left"><?= lang('sales') . ' ' . lang('agent') ?></p>
                        <p class="pull-right mr"><?php

                            $profile_info = $this->db->where('user_id', $invoice_info->user_id)->get('tbl_account_details')->row();
                            if (!empty($profile_info)) {
                                echo $profile_info->fullname;
                            }
                            ?></p>
                    </div>
                <?php } ?>
                <div class="clearfix">
                    <?php
                    if ($payment_status == lang('fully_paid')) {
                        $label = 'success';
                    } else {
                        $label = 'danger';
                    }
                    ?>
                    <p class="pull-left"><?= $language_info['payment_status'] ?></p>
                    <p class="pull-right mr"><span class="label label-<?= $label ?>"><?= $payment_status ?></span></p>
                </div>
            </div>
        </div>
        <div class="table-responsive table-bordered mb-lg">

            <table class="table items invoice-items-preview" page-break-inside: auto;>
                <thead style="background: #3a3f51;color: #fff;">
                <tr>
                    <th><?= $language_info['items'] ?></th>
                    <?php
                    $invoice_view = config_item('invoice_view');
                    if (!empty($invoice_view) && $invoice_view == '2') {
                        ?>
                        <th><?= $language_info['hsn_code'] ?></th>
                    <?php } ?>
                    <?php
                    $qty_heading = $language_info['qty'];
                    if (isset($invoice_info) && $invoice_info->show_quantity_as == 'hours' || isset($hours_quantity)) {
                        $qty_heading = lang('hours');
                    } else if (isset($invoice_info) && $invoice_info->show_quantity_as == 'qty_hours') {
                        $qty_heading = lang('qty') . '/' . lang('hours');
                    }
                    ?>
                    <th><?php echo $qty_heading; ?></th>
                    <th class="col-sm-1"><?= $language_info['price'] ?></th>
                    <th class="col-sm-2"><?= $language_info['tax'] ?></th>
                    <th class="col-sm-1"><?= $language_info['total'] ?></th>
                </tr>
                </thead>
                <tbody>
                <?php
                $invoice_items = $this->invoice_model->ordered_items_by_id($invoice_info->invoices_id);

                if (!empty($invoice_items)) :
                    foreach ($invoice_items as $key => $v_item) :
                        $item_name = $v_item->item_name ? $v_item->item_name : $v_item->item_desc;
                        $item_tax_name = json_decode($v_item->item_tax_name);
                        ?>
                        <tr class="sortable item" data-item-id="<?= $v_item->items_id ?>">
                            <td><strong class="block"><?= $item_name ?></strong>
                                <?= nl2br($v_item->item_desc) ?>
                            </td>
                            <?php
                            $invoice_view = config_item('invoice_view');
                            if (!empty($invoice_view) && $invoice_view == '2') {
                                ?>
                                <td><?= $v_item->hsn_code ?></td>
                            <?php } ?>
                            <td><?= $v_item->quantity . '   &nbsp' . $v_item->unit ?></td>
                            <td><?= display_money($v_item->unit_cost) ?></td>
                            <td><?php
                                if (!empty($item_tax_name)) {
                                    foreach ($item_tax_name as $v_tax_name) {
                                        $i_tax_name = explode('|', $v_tax_name);
                                        echo '<small class="pr-sm">' . $i_tax_name[0] . ' (' . $i_tax_name[1] . ' %)' . '</small>' . display_money($v_item->total_cost / 100 * $i_tax_name[1]) . ' <br>';
                                    }
                                }
                                ?></td>
                            <td><?= display_money($v_item->total_cost) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8"><?= lang('nothing_to_display') ?></td>
                    </tr>
                <?php endif ?>
                </tbody>
            </table>
        </div>
        <div class="row" style="margin-top: 35px">
            <div class="col-xs-8">
                <p class="well well-sm mt">
                    <?= $invoice_info->notes ?>
                </p>
            </div>
            <div class="col-sm-4 pv">
                <div class="clearfix">
                    <p class="pull-left"><?= $language_info['sub_total'] ?></p>
                    <p class="pull-right mr">
                        <?= display_money($this->invoice_model->calculate_to('invoice_cost', $invoice_info->invoices_id)); ?>
                    </p>
                </div>
                <?php if ($invoice_info->discount_total > 0): ?>
                    <div class="clearfix">
                        <p class="pull-left"><?= $language_info['discount'] ?>
                            (<?php echo $invoice_info->discount_percent; ?>
                            %)</p>
                        <p class="pull-right mr">
                            <?= display_money($this->invoice_model->calculate_to('discount', $invoice_info->invoices_id)); ?>
                        </p>
                    </div>
                <?php endif ?>
                <?php
                $tax_info = json_decode($invoice_info->total_tax);
                $tax_total = 0;
                if (!empty($tax_info)) {
                    $tax_name = $tax_info->tax_name;
                    $total_tax = $tax_info->total_tax;
                    if (!empty($tax_name)) {
                        foreach ($tax_name as $t_key => $v_tax_info) {
                            $tax = explode('|', $v_tax_info);
                            $tax_total += $total_tax[$t_key];
                            ?>
                            <div class="clearfix">
                                <p class="pull-left"><?= $tax[0] . ' (' . $tax[1] . ' %)' ?></p>
                                <p class="pull-right mr">
                                    <?= display_money($total_tax[$t_key]); ?>
                                </p>
                            </div>
                        <?php }
                    }
                } ?>
                <?php if ($tax_total > 0): ?>
                    <div class="clearfix">
                        <p class="pull-left"><?= $language_info['total'] . ' ' . $language_info['tax'] ?></p>
                        <p class="pull-right mr">
                            <?= display_money($tax_total); ?>
                        </p>
                    </div>
                <?php endif ?>
                <?php if ($invoice_info->adjustment > 0): ?>
                    <div class="clearfix">
                        <p class="pull-left"><?= $language_info['adjustment'] ?></p>
                        <p class="pull-right mr">
                            <?= display_money($invoice_info->adjustment); ?>
                        </p>
                    </div>
                <?php endif ?>

                <div class="clearfix">
                    <p class="pull-left"><?= $language_info['total'] ?></p>
                    <p class="pull-right mr">
                        <?= display_money($this->invoice_model->calculate_to('total', $invoice_info->invoices_id), $currency->symbol); ?>
                    </p>
                </div>

                <?php
                $paid_amount = $this->invoice_model->calculate_to('paid_amount', $invoice_info->invoices_id);
                if ($paid_amount > 0) {
                    $total = $language_info['total_due'];
                    if ($paid_amount > 0) {
                        $text = 'text-danger';
                        ?>
                        <div class="clearfix">
                            <p class="pull-left"><?= $language_info['paid_amount'] ?> </p>
                            <p class="pull-right mr">
                                <?= display_money($paid_amount, $currency->symbol); ?>
                            </p>
                        </div>
                    <?php } else {
                        $text = '';
                    } ?>
                    <div class="clearfix">
                        <p class="pull-left h3 <?= $text ?>"><?= $total ?></p>
                        <p class="pull-right mr h3"><?= display_money($this->invoice_model->calculate_to('invoice_due', $invoice_info->invoices_id), $currency->symbol); ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <?= !empty($invoice_view) && $invoice_view > 0 ? $this->gst->summary($invoice_items) : ''; ?>
</div>
<?php if ($invoice_info->allow_braintree == 'Yes') { ?>
    <script src="https://js.braintreegateway.com/js/braintree-2.21.0.min.js"></script>
<?php } ?>

<?php if ($invoice_info->allow_stripe == 'Yes') { ?>
    <!-- START STRIPE PAYMENT -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>

    <!-- END STRIPE CHECKOUT -->
<?php } ?>

<script type="text/javascript">
    function print_invoice(print_invoice) {
        var printContents = document.getElementById(print_invoice).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>

