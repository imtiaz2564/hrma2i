<?php include_once 'assets/admin-ajax.php'; ?>
<?= message_box('success'); ?>
<?= message_box('error');
$created = can_action('24', 'created');
$edited = can_action('24', 'edited');
$deleted = can_action('24', 'deleted');
if (!empty($created) || !empty($edited)){
    ?>
    <?php $is_department_head = is_department_head();
    if ($this->session->userdata('user_type') == 1 || !empty($is_department_head)) { ?>
        <div class="btn-group pull-right btn-with-tooltip-group _filter_data filtered" data-toggle="tooltip"
             data-title="<?php echo lang('filter_by'); ?>">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-filter" aria-hidden="true"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-right group animated zoomIn"
                style="width:300px;">
                <li class="filter_by"><a href="#"><?php echo lang('all'); ?></a></li>
                <li class="divider"></li>

                <li class="filter_by" id="admin"><a href="#"><?php echo lang('admin'); ?></a></li>
                <li class="filter_by" id="client"><a href="#"><?php echo lang('client'); ?></a></li>
                <li class="filter_by" id="staff"><a href="#"><?php echo lang('staff'); ?></a></li>
                <li class="filter_by" id="active"><a href="#"><?php echo lang('active'); ?></a></li>
                <li class="filter_by" id="deactive"><a href="#"><?php echo lang('deactive'); ?></a></li>
                <li class="filter_by" id="banned"><a href="#"><?php echo lang('banned'); ?></a></li>
                <div class="clearfix"></div>
            </ul>
        </div>
    <?php } ?>
    <div class="nav-tabs-custom">
        <!-- Tabs within a box -->
        <ul class="nav nav-tabs">
            <li class="<?= $active == 1 ? 'active' : ''; ?>"><a href="#manage"
                                                                data-toggle="tab"><?= lang('all_users') ?></a></li>
            <li class="<?= $active == 2 ? 'active' : ''; ?>"><a href="#new"
                                                                data-toggle="tab"><?= lang('new_user') ?></a>
            </li>
        </ul>
        <div class="tab-content bg-white">
            <!-- ************** general *************-->
            <div class="tab-pane <?= $active == 1 ? 'active' : ''; ?>" id="manage">
                <?php } else { ?>
                <div class="panel panel-custom">
                    <header class="panel-heading ">
                        <div class="panel-title"><strong><?= lang('all_users') ?></strong></div>
                    </header>
                    <?php } ?>
                    <table class="table table-striped DataTables " id="DataTables" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th class="col-sm-1"><?= lang('photo') ?></th>
                            <th><?= lang('name') ?></th>
                            <th class="col-sm-2"><?= lang('username') ?></th>
                            <th class="col-sm-1"><?= lang('active') ?></th>
                            <th class="col-sm-1"><?= lang('user_type') ?></th>
                            <?php $show_custom_fields = custom_form_table(13, null);
                            if (!empty($show_custom_fields)) {
                                foreach ($show_custom_fields as $c_label => $v_fields) {
                                    if (!empty($c_label)) {
                                        ?>
                                        <th><?= $c_label ?> </th>
                                    <?php }
                                }
                            }
                            ?>
                            <th class="col-sm-2"><?= lang('action') ?></th>

                        </tr>
                        </thead>
                        <tbody>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                list = base_url + "admin/user/userList";
                                $('.filtered > .dropdown-toggle').on('click', function () {
                                    if ($('.group').css('display') == 'block') {
                                        $('.group').css('display', 'none');
                                    } else {
                                        $('.group').css('display', 'block')
                                    }
                                });
                                $('.filter_by').on('click', function () {
                                    $('.filter_by').removeClass('active');
                                    $('.group').css('display', 'block');
                                    $(this).addClass('active');
                                    var filter_by = $(this).attr('id');
                                    if (filter_by) {
                                        filter_by = filter_by;
                                    } else {
                                        filter_by = '';
                                    }
                                    table_url(base_url + "admin/user/userList/" + filter_by);
                                });
                            });
                        </script>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($created) || !empty($edited)){ ?>
                    <div class="tab-pane <?= $active == 2 ? 'active' : ''; ?>" id="new">
                        <form role="form" data-parsley-validate="" novalidate="" id="userform"
                              enctype="multipart/form-data"
                              action="<?php echo base_url(); ?>admin/user/save_user" method="post"
                              class="form-horizontal form-groups-bordered">

                            <?php
                            if (!empty($login_info->user_id)) {
                                $profile_info = $this->user_model->check_by(array('user_id' => $login_info->user_id), 'tbl_account_details');
                            }
                            ?>
                            <input type="hidden" id="username_flag" value="">
                            <input type="hidden" id="user_id" name="user_id" value="<?php
                            if (!empty($login_info)) {
                                echo $login_info->user_id;
                            }
                            ?>">
                            <input type="hidden" name="account_details_id" value="<?php
                            if (!empty($profile_info)) {
                                echo $profile_info->account_details_id;
                            }
                            ?>">
                            
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong><?= lang('fund_sources') ?></strong></label>
                                <div class="col-lg-5">
                                    <select class="  form-control select_box" style="width: 100%" name="fund_source">

                                        <?php
                                        $funds = $this->db->get('tbl_fundsources')->result();
                                        foreach ($funds as $fund) :
                                            ?>
                                            <option value="<?= $fund->fundsources_id ?>" <?php
                                            if (!empty($profile_info)) {
                                                if ($profile_info->fund_source == $fund->fundsources_id) {
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
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label"><?= lang('employment') ?> <span
                                        class="text-danger">*</span></label>
                                <div id="employee_type" class="col-lg-5">
                                    <select name="employee_type" onchange="get_billing_value(this.value)"
                                            class="form-control select_box" style="width: 100%" required="">
                                        <option
                                            <?php
                                            if (!empty($profile_info->employee_type)) {
                                                echo $profile_info->employee_type == '' ? 'selected' : null;
                                            } ?>
                                            value="null">None</option>
                                        <option
                                            <?php
                                            if (!empty($profile_info->employee_type)) {
                                                echo $profile_info->employee_type == 'individual_contract' ? 'selected' : null;
                                            } ?>
                                            value="individual_contract">Individual Contract</option>
                                        <option
                                            <?php
                                            if (!empty($profile_info->employee_type)) {
                                                echo $profile_info->employee_type == 'service_contract' ? 'selected' : null;
                                            } ?>
                                            value="service_contract">Service Contract</option>
                                        <option
                                            <?php
                                            if (!empty($profile_info->employee_type)) {
                                                echo $profile_info->employee_type == 'young_professional' ? 'selected' : null;
                                            } ?>
                                            value="young_professional">Young Professional</option>
                                    </select>
                                </div>
                            </div>
                            <div id ="gob_type" class="form-group">
                                <label class="col-lg-3 control-label">GoB/Non-GoB<span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <select name="gob_type" onchange="cadre_type_value(this.value)"
                                            class="form-control select_box" style="width: 100%" required="">
                                        <option
                                            <?php
                                            if (!empty($profile_info->gob_type)) {
                                                echo $profile_info->gob_type == '' ? 'selected' : null;
                                            } ?>
                                            value="">None</option>
                                        <option
                                            <?php
                                            if (!empty($profile_info->gob_type)) {
                                                echo $profile_info->gob_type == 'gob' ? 'selected' : null;
                                            } ?>
                                            value="gob">GoB</option>
                                        <option
                                            <?php
                                            if (!empty($profile_info->gob_type)) {
                                                echo $profile_info->gob_type == 'non-gob' ? 'selected' : null;
                                            } ?>
                                            value="non-gob">Non-GoB</option>
                                    </select>
                                </div>
                            </div>
                            <div id="cadre_type" class="form-group">
                                <label class="col-lg-3 control-label">Cadre/Non-Cadre<span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <select name="cadre_type" onchange="get_cadre_value(this.value)"
                                            class="form-control select_box" style="width: 100%" required="">
                                        <option
                                            <?php
                                            if (!empty($profile_info->cadre_type)) {
                                                echo $profile_info->cadre_type == 'cadre' ? 'selected' : null;
                                            } ?>
                                            value="null">None</option>
                                        <option
                                            <?php
                                            if (!empty($profile_info->cadre_type)) {
                                                echo $profile_info->cadre_type == 'cadre' ? 'selected' : null;
                                            } ?>
                                            value="cadre">Cadre</option>
                                        <option
                                            <?php
                                            if (!empty($profile_info->cadre_type)) {
                                                echo $profile_info->cadre_type == 'non-cadre' ? 'selected' : null;
                                            } ?>
                                            value="non-cadre">Non-Cadre</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div id="cadre_type" class="form-group">
                                <label class="col-lg-3 control-label">IT/Non-IT<span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <select name="itNonIT" 
                                            class="form-control select_box" style="width: 100%" required="">
                                        <option
                                            <?php
                                            if (!empty($profile_info->itNonIT)) {
                                                echo $profile_info->itNonIT == 'IT' ? 'selected' : null;
                                            } ?>
                                            value="IT">IT</option>
                                        <option
                                            <?php
                                            if (!empty($profile_info->itNonIT)) {
                                                echo $profile_info->itNonIT == 'Non IT' ? 'selected' : null;
                                            } ?>
                                            value="Non IT">Non IT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong><?= lang('full_name') ?> </strong><span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->fullname;
                                    }
                                    ?>"
                                           placeholder="<?= lang('eg') ?> <?= lang('enter_your') . ' ' . lang('full_name') ?>"
                                           name="fullname"
                                           required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label
                                    class="col-sm-3 control-label"><strong><?= lang('employment_id') ?> </strong></label>
                                <div class="col-sm-5">
                                    <input type="text" id="check_employment_id"
                                           class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->employment_id;
                                    }
                                    ?>" placeholder="<?= lang('eg') ?> 15351" name="employment_id">
                                    <span class="required" id="employment_id_error"></span>
                                </div>
                            </div>

                            <?php if (empty($login_info->user_id)) { ?>
                                <div class="form-group">
                                    <label
                                        class="col-sm-3 control-label"><strong> <?= lang('username'); ?></strong><span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="text" name="username" id="check_username"
                                               placeholder="<?= lang('eg') ?> <?= lang('enter_your') . ' ' . lang('username') ?>"
                                               value="<?php
                                               if (!empty($login_info)) {
                                                   echo $login_info->username;
                                               }
                                               ?>" class="input-sm form-control" required>
                                        <span class="required" id="check_username_error"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label"><strong><?= lang('password') ?> </strong><span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="password" id="new_password" placeholder="<?= lang('password') ?>"
                                               name="password" class="input-sm form-control" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label
                                        class="col-sm-3 control-label"><strong><?= lang('confirm_password') ?> </strong><span
                                            class="text-danger">*</span></label>
                                    <div class="col-sm-5">
                                        <input type="password" data-parsley-equalto="#new_password"
                                               placeholder="<?= lang('confirm_password') ?>"
                                               name="confirm_password" class="input-sm form-control" required>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <input type="hidden" name="username"
                                       placeholder="<?= lang('eg') ?> <?= lang('user_placeholder_username') ?>"
                                       value="<?php
                                       if (!empty($login_info)) {
                                           echo $login_info->username;
                                       }
                                       ?>" class="input-sm form-control" required>
                            <?php } ?>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong><?= lang('email') ?> </strong><span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-5">
                                    <input type="email" id="check_email_addrees"
                                           placeholder="<?= lang('eg') ?> <?= lang('user_placeholder_email') ?>"
                                           name="email" value="<?php
                                    if (!empty($login_info)) {
                                        echo $login_info->email;
                                    }
                                    ?>" class="input-sm form-control" required>
                                    <span class="required" id="email_addrees_error"></span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong><?= lang('locale') ?></strong></label>
                                <div class="col-lg-5">
                                    <select class="  form-control select_box" style="width: 100%" name="locale">

                                        <?php
                                        $locales = $this->db->get('tbl_locales')->result();
                                        foreach ($locales as $loc) :
                                            ?>
                                            <option lang="<?= $loc->code ?>" value="<?= $loc->locale ?>" <?php
                                            if (!empty($profile_info)) {
                                                if ($profile_info->locale == $loc->locale) {
                                                    echo 'selected';
                                                }
                                            } else {
                                                echo($this->config->item('locale') == $loc->locale ? 'selected="selected"' : '');
                                            }
                                            ?>><?= $loc->name ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong><?= lang('language') ?></strong></label>
                                <div class="col-sm-5">
                                    <select name="language" class="form-control select_box" style="width: 100%">
                                        <?php foreach ($languages as $lang) : ?>
                                            <option value="<?= $lang->name ?>"<?php
                                            if (!empty($profile_info)) {
                                                if ($profile_info->language == $lang->name) {
                                                    echo 'selected';
                                                }
                                            } else {
                                                echo($this->config->item('language') == $lang->name ? ' selected="selected"' : '');
                                            }
                                            ?>><?= ucfirst($lang->name) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong><?= lang('phone') ?> </strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->phone;
                                    }
                                    ?>" name="phone"
                                           placeholder="<?= lang('eg') ?> <?= lang('user_placeholder_phone') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong><?= lang('mobile') ?> </strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->mobile;
                                    }
                                    ?>" name="mobile"
                                           placeholder="<?= lang('eg') ?> <?= lang('user_placeholder_mobile') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong><?= lang('skype_id') ?> </strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->skype;
                                    }
                                    ?>" name="skype"
                                           placeholder="<?= lang('eg') ?> <?= lang('user_placeholder_skype') ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-3 control-label"><strong><?= lang('profile_photo') ?></strong><span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail" style="width: 210px;">
                                            <?php
                                            if (!empty($profile_info)) :
                                                ?>
                                                <img src="<?php echo base_url() . $profile_info->avatar; ?>">
                                            <?php else: ?>
                                                <img src="http://placehold.it/350x260"
                                                     alt="Please Connect Your Internet">
                                            <?php endif; ?>
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"
                                             style="width: 210px;"></div>
                                        <div>
                                        <span class="btn btn-default btn-file">
                                            <span class="fileinput-new">
                                                <input type="file" name="avatar" value="upload"
                                                       data-buttonText="<?= lang('choose_file') ?>" id="myImg"/>
                                                <span class="fileinput-exists"><?= lang('change') ?></span>    
                                            </span>
                                            <a href="#" class="btn btn-default fileinput-exists"
                                               data-dismiss="fileinput"><?= lang('remove') ?></a>

                                        </div>

                                        <div id="valid_msg" style="color: #e11221"></div>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="field-1"
                                       class="col-sm-3 control-label"><strong><?= lang('user_type') ?></strong><span
                                        class="required">*</span></label>
                                <div class="col-sm-5">
                                    <select id="user_type" name="role_id" class="form-control" required>
                                        <option value=""><?= lang('select_user_type') ?></option>
                                        <?php
                                        $admin = admin();
                                        if (!empty($admin)) {
                                            ?>
                                            <option <?php
                                            if (!empty($login_info)) {
                                                echo $login_info->role_id == 1 ? 'selected' : '';
                                            }
                                            ?> value="1"><?= lang('admin') ?></option>
                                        <?php } ?>
                                        <option <?php
                                        if (!empty($login_info)) {
                                            echo $login_info->role_id == 3 ? 'selected' : '';
                                        }
                                        ?> value="3"><?= lang('staff') ?></option>
                                        <!-- <option <?php
                                        // if (!empty($login_info)) {
                                        //     echo $login_info->role_id == 2 ? 'selected' : '';
                                        // }
                                        ?> value="2"><?//= lang('client') ?></option> -->
                                    </select>
                                </div>
                            </div>
                            <?php
                            // if (!empty($profile_info->direction)) {
                            //     $direction = $profile_info->direction;
                            // } else {
                            //     $RTL = config_item('RTL');
                            //     if (!empty($RTL)) {
                            //         $direction = 'rtl';
                            //     }
                            // }
                            ?>
                            <!-- <div class="form-group">
                                <label for="direction"
                                       class="control-label col-sm-3"><?//= lang('direction') ?></label>
                                <div class="col-sm-5">
                                    <select name="direction" class="selectpicker"
                                            data-width="100%">
                                        <option <?php
                                        // if (!empty($direction)) {
                                        //     echo $direction == 'ltr' ? 'selected' : '';
                                        // }
                                        ?> value="ltr"><?//= lang('ltr') ?></option>
                                        <option <?php
                                        // if (!empty($direction)) {
                                        //     echo $direction == 'rtl' ? 'selected' : '';
                                        // }
                                        ?> value="rtl"><?//= lang('rtl') ?></option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-sm-12" <?php
                            if (!empty($login_info) && $login_info->role_id == 2) {
                                echo 'style="display:block"';
                            }
                            ?>>
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6 row">
                                    <div id="client_permission" class="panel panel-custom ">
                                        <div class="panel-heading">
                                            <h4 class="modal-title"
                                                id="myModalLabel"><?= lang('select') . ' ' . lang('client') . ' &  ' . lang('permission') ?></h4>
                                        </div>
                                        <style type="text/css">
                                            .toggle.btn-xs {
                                                min-width: 59px;
                                            }
                                        </style>
                                        <div class="form-horizontal">
                                            <div class="form-group">
                                                <label
                                                    class="col-sm-3 control-label"><strong><?= lang('companies') ?> </strong></label>
                                                <div class="col-sm-6">
                                                    <select class="form-control select_box" style="width: 100%"
                                                            name="company">
                                                        <option value="-"><?= lang('select_client') ?></option>
                                                        <?php
                                                        if (!empty($all_client_info)) {
                                                            foreach ($all_client_info as $v_client) {
                                                                ?>
                                                                <option value="<?= $v_client->client_id ?>"
                                                                    <?php
                                                                    if (!empty($profile_info)) {
                                                                        if ($profile_info->company == $v_client->client_id) {
                                                                            echo 'selected';
                                                                        }
                                                                    }
                                                                    ?>
                                                                ><?= $v_client->name ?></option>
                                                                <?php
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                            $all_client_menu = $this->db->where('parent', 0)->order_by('sort')->get('tbl_client_menu')->result();
                                            if (!empty($login_info)) {
                                                $user_menu = $this->db->where('user_id', $login_info->user_id)->get('tbl_client_role')->result();
                                            }

                                            foreach ($all_client_menu as $key => $v_menu) {
                                                ?>
                                                <div class="form-group">
                                                    <label
                                                        class="col-lg-3 control-label"><?= lang($v_menu->label) ?></label>
                                                    <div class="col-lg-6 checkbox">
                                                        <input class="client_permission"
                                                               data-toggle="toggle"
                                                               name="<?= $v_menu->label ?>"
                                                               value="<?= $v_menu->menu_id ?>" <?php
                                                        if (!empty($user_menu)) {
                                                            foreach ($user_menu as $v_u_menu) {
                                                                if ($v_u_menu->menu_id == $v_menu->menu_id) {
                                                                    echo 'checked';
                                                                }
                                                            }
                                                        } ?> data-on="<?= lang('yes') ?>"
                                                               data-off="<?= lang('no') ?>"
                                                               data-onstyle="success btn-xs"
                                                               data-offstyle="danger btn-xs" type="checkbox">
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>
                            </div>


                            <div class="form-group" id="department" <?php
                            if (!empty($login_info) && $login_info->role_id != 2) {
                                echo 'style="display:block"';
                            }
                            ?> >
                                <label class="col-sm-3 control-label"><strong><?= lang('designation') ?> </strong><span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-5">
                                    <select class="form-control select_box department" required style="width: 100%"
                                            name="designations_id">
                                        <option value=""><?= lang('select') . ' ' . lang('designation'); ?></option>
                                        <?php
                                        if (!empty($all_designation_info)) {
                                            foreach ($all_designation_info as $dept_name => $v_designation_info) {
                                                ?>
                                                <optgroup label="<?= $dept_name ?>">
                                                    <?php if (!empty($v_designation_info)) {
                                                        foreach ($v_designation_info as $v_designation) { ?>
                                                            <option value="<?= $v_designation->designations_id ?>" <?php
                                                            if (!empty($profile_info)) {
                                                                if ($profile_info->designations_id == $v_designation->designations_id) {
                                                                    echo 'selected';
                                                                }
                                                            }
                                                            ?>><?= $v_designation->designations; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </optgroup>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <?php
                                if (!empty($profile_info->designations_id)) {
                                    $designation_info = $this->db->where('designations_id', $profile_info->designations_id)->get('tbl_designations')->row();

                                    if (!empty($designation_info)) {
                                        $departments_info = $this->db->where('departments_id', $designation_info->departments_id)->get('tbl_departments')->row();
                                    }
                                }
                                ?>
                                <div class="col-sm-4">
                                    <div class="checkbox-inline c-checkbox">
                                        <label class="needsclick">
                                            <input <?php if (!empty($departments_info) && $profile_info->user_id == $departments_info->department_head_id) {
                                                echo 'checked';
                                            } ?> name="department_head_id" value="1" type="checkbox"
                                                 style="margin-right: 8px;" class="">
                                            <span class="fa fa-check"></span>
                                            <?= lang('is_he_department_head') ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Team</strong></label>
                                <div class="col-lg-5">
                                    <select class="  form-control select_box" style="width: 100%" name="team_id">

                                        <?php
                                        $teamsInfo = $this->db->get('tbl_teams')->result();
                                        foreach ($teamsInfo as $team) :
                                            ?>
                                            <option lang="<?= $loc->code ?>" value="<?= $team->teams_id ?>" <?php
                                            if (!empty($profile_info)) {
                                                if ($profile_info->team_id == $team->teams_id) {
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
                            </div>
                            
                            <div class="form-group">
                                <label class="col-lg-3 control-label">Gender<span
                                        class="text-danger">*</span></label>
                                <div class="col-lg-5">
                                    <select name="gender" onchange=""
                                            class="form-control select_box" style="width: 100%" required="">
                                        <option
                                            <?php
                                            if (!empty($profile_info->gender)) {
                                                echo $profile_info->gender == 'male' ? 'selected' : null;
                                            } ?>
                                            value="male">Male</option>
                                        <option
                                            <?php
                                            if (!empty($profile_info->gender)) {
                                                echo $profile_info->gender == 'female' ? 'selected' : null;
                                            } ?>
                                            value="female">Female</option>
                                        <option
                                            <?php
                                            if (!empty($profile_info->gender)) {
                                                echo $profile_info->gender == 'other' ? 'selected' : null;
                                            } ?>
                                            value="other">Other</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" col-lg-3 control-label">Contract Starts<span
                                        class="required">*</span></label>
                                <div class="col-lg-5">
                                    <div class="input-group ">
                                        <input  type="text" name="joining_date" class="form-control start_date" required
                                        value="<?php if (!empty($profile_info->joining_date)) echo $profile_info->joining_date; ?>"/>
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="fa fa-calendar"></i></a>
                                                </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" col-lg-3 control-label">Contract Ends</label>
                                <div class="col-lg-5">
                                    <div class="input-group ">
                                        <input  type="text" name="contract_ends" class="form-control start_date"
                                        value="<?php if (!empty($profile_info->contract_ends)) echo $profile_info->contract_ends; else echo Date('Y-m-d'); ?>"/>
                                                <div class="input-group-addon">
                                                    <a href="#"><i class="fa fa-calendar"></i></a>
                                                </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Job Location</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->jobLocation;
                                    }
                                    ?>" name="jobLocation">
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Experience before a2i</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    // if (!empty($profile_info)) {
                                    //     echo $profile_info->expb4a2i;
                                    // }
                                    ?>" name="expb4a2i">
                                </div>
                            </div> -->
                            <!-- <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Total Experience</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    // if (!empty($profile_info)) {
                                    //     echo $profile_info->experience;
                                    // }
                                    ?>" name="experience">
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Contract Number</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->contract_no;
                                    }
                                    ?>" name="contract_no">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Re Agreement Notification</strong></label>
                                <div class="col-sm-5">
                                    <!-- <input type="text" class="input-sm form-control" value="<?php
                                    // if (!empty($profile_info)) {
                                    //     echo $profile_info->reAgreement;
                                    // }
                                    ?>" name="reAgreement"> -->
                                    <input data-id="3" data-toggle="toggle" name="reAgreement" value="1" checked="" data-on="Yes" data-off="No" data-onstyle="success btn-xs" data-offstyle="danger btn-xs" type="checkbox">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Education</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->education;
                                    }
                                    ?>" name="education">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Training</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->training;
                                    }
                                    ?>" name="training">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>PMO ID Card</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->pmoID;
                                    }
                                    ?>" name="pmoID">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>UNDP ID Card</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->undpID;
                                    }
                                    ?>" name="undpID">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>OWN Cloud</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->ownCloud;
                                    }
                                    ?>" name="ownCloud">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Google Group</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->googleGroup;
                                    }
                                    ?>" name="googleGroup">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>Phone Bill</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->phoneBill;
                                    }
                                    ?>" name="phoneBill">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>a2i Email ID</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->a2imail;
                                    }
                                    ?>" name="a2imail">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label"><strong>UN Email ID</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->unmail;
                                    }
                                    ?>" name="unmail">
                                </div>
                            </div>
                            <div id = "performanceBonus" class="scbatch form-group">
                                <label class="col-sm-3 control-label"><strong>Performace Bonus Due</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->performanceBonus;
                                    }
                                    ?>" name="performanceBonus">
                                </div>
                            </div>
                            <div id = "securityTest" class="scbatch form-group">
                                <label class="col-sm-3 control-label"><strong>Security Test</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->securityTest;
                                    }
                                    ?>" name="securityTest">
                                </div>
                            </div>
                            <div id = "medicalTest" class="scbatch form-group">
                                <label class="col-sm-3 control-label"><strong>Medical Test</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->medicalTest;
                                    }
                                    ?>" name="medicalTest">
                                </div>
                            </div>
                            <div id="vendorID" class="scbatch form-group">
                                <label class="col-sm-3 control-label"><strong>Vendor ID</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->vendorID;
                                    }
                                    ?>" name="vendorID">
                                </div>
                            </div>
                            <div id="unID" class="scbatch form-group">
                                <label class="col-sm-3 control-label"><strong>UN ID</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->unID;
                                    }
                                    ?>" name="unID">
                                </div>
                            </div>
                            <div id="positionNumber" class="scbatch form-group">
                                <label class="col-sm-3 control-label"><strong>Position Number</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->positionNumber;
                                    }
                                    ?>" name="positionNumber">
                                </div>
                            </div>
                            <div id="cignaInsurance" class="scbatch form-group">
                                <label class="col-sm-3 control-label"><strong>Cigna Insurance Card</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->cignaInsurance;
                                    }
                                    ?>" name="cignaInsurance">
                                </div>
                            </div>
                            <div id="sharePoint" class="scbatch form-group">
                                <label class="col-sm-3 control-label"><strong>Share Point</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->sharePoint;
                                    }
                                    ?>" name="sharePoint">
                                </div>
                            </div>
                            <div id="level" class="scbatch form-group">
                                <label class="col-sm-3 control-label"><strong>Level</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->level;
                                    }
                                    ?>" name="level">
                                </div>
                            </div>
                            <div id="quartile" class="scbatch form-group">
                                <label class="col-sm-3 control-label"><strong>Quartile</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->quartile;
                                    }
                                    ?>" name="quartile">
                                </div>
                            </div>
                            <div id ="gob_designation" class="form-group">
                                <label class="col-sm-3 control-label"><strong>GOB Designation</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->gobDesignation;
                                    }
                                    ?>" name="gobDesignation">
                                </div>
                            </div>
                            <div id ="cadre_name" class="form-group">
                                <label class="col-sm-3 control-label"><strong>Cadre Name</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->cadreName;
                                    }
                                    ?>" name="cadreName">
                                </div>
                            </div>
                            <div id ="cadre_batch" class="form-group">
                                <label class="col-sm-3 control-label"><strong>Cadre Batch</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->cadreBatch;
                                    }
                                    ?>" name="cadreBatch">
                                </div>
                            </div>
                            <div id ="cadre_id" class="form-group">
                                <label class="col-sm-3 control-label"><strong>Cadre ID</strong></label>
                                <div class="col-sm-5">
                                    <input type="text" class="input-sm form-control" value="<?php
                                    if (!empty($profile_info)) {
                                        echo $profile_info->cadreID;
                                    }
                                    ?>" name="cadreID">
                                </div>
                            </div>
                            <?php if (!empty($login_info->username)) { ?>
                            <div class="form-group" align="center">
                            <a href="<?= base_url() ?>admin/experience/experience_details/<?=$profile_info->user_id?>">Add Experience</a>
                            <a href="<?= base_url() ?>admin/experience/index/<?=$profile_info->user_id?>">View Experience</a>
                             
                            </div>
                            <? } ?>
                            <?php
                            if (!empty($profile_info->user_id)) {
                                $user_id = $profile_info->user_id;
                            } else {
                                $user_id = null;
                            }
                            ?>
                            <?= custom_form_Fields(13, $user_id); ?>

                            <!-- <div class="form-group" id="border-none">
                                <label for="field-1" class="col-sm-3 control-label"><?= lang('permission') ?> <span
                                        class="required">*</span></label>
                                <div class="col-sm-5">
                                    <div class="checkbox c-radio needsclick">
                                        <label class="needsclick">
                                            <input <?php
                                            // if (!empty($login_info->permission) && $login_info->permission == 'all') {
                                            //     echo 'checked';
                                            // } elseif (empty($login_info)) {
                                            //     echo 'checked';
                                            // }
                                            ?> type="radio" name="permission" value="everyone">
                                            <span class="fa fa-circle"></span><?//= lang('everyone') ?>
                                            <i title="<?//= lang('permission_for_all') ?>"
                                               class="fa fa-question-circle" data-toggle="tooltip"
                                               data-placement="top"></i>
                                        </label>
                                    </div>
                                    <div class="checkbox c-radio needsclick">
                                        <label class="needsclick">
                                            <input <?php
                                            // if (!empty($login_info->permission) && $login_info->permission != 'all') {
                                            //     echo 'checked';
                                            // }
                                            ?> type="radio" name="permission" value="custom_permission"
                                            >
                                            <span class="fa fa-circle"></span><?//= lang('custom_permission') ?> <i
                                                title="<?//= lang('permission_for_customization') ?>"
                                                class="fa fa-question-circle" data-toggle="tooltip"
                                                data-placement="top"></i>
                                        </label>
                                    </div>
                                </div>
                            </div> -->
<!-- 
                            <div class="form-group <?php
                            if (!empty($login_info->permission) && $login_info->permission != 'all') {
                                echo 'show';
                            }
                            ?>" id="permission_user">
                                <label for="field-1"
                                       class="col-sm-3 control-label"><?//= lang('select') . ' ' . lang('users') ?>
                                    <span
                                        class="required">*</span></label>
                                <div class="col-sm-9">
                                    <?php
                                    // if (!empty($assign_user)) {
                                    //     foreach ($assign_user as $key => $p_user) {
                                    //         if ($p_user->role_id == 1) {
                                    //             $disable = true;
                                    //             $role = '<strong class="badge btn-danger">' . lang('admin') . '</strong>';
                                    //         } else {
                                    //             $disable = false;
                                    //             $role = '<strong class="badge btn-primary">' . lang('staff') . '</strong>';
                                    //         }

                                            ?>
                                            <div class="checkbox c-checkbox needsclick">
                                                <label class="needsclick">
                                                    <input type="checkbox"
                                                        <?php
                                                        // if (!empty($login_info->permission) && $login_info->permission != 'all') {
                                                        //     $get_permission = json_decode($login_info->permission);
                                                        //     if (is_array($get_permission)) {
                                                        //         foreach ($get_permission as $user_id => $v_permission) {
                                                        //             if ($user_id == $p_user->user_id) {
                                                        //                 echo 'checked';
                                                        //             }
                                                        //         }
                                                        //     }

                                                        // }
                                                        ?>
                                                           value="<?//= $p_user->user_id ?>"
                                                           name="assigned_to[]"
                                                           class="needsclick">
                                                        <span
                                                            class="fa fa-check"></span><?//= $p_user->username . ' ' . $role ?>
                                                </label>

                                            </div>
                                            <div class="action_1 p
                                                <?php 
                                            //     if (!empty($login_info->permission) && $login_info->permission != 'all') {
                                            //     $get_permission = json_decode($login_info->permission);
                                            //     if (is_array($get_permission)) {
                                            //         foreach ($get_permission as $user_id => $v_permission) {
                                            //             if ($user_id == $p_user->user_id) {
                                            //                 echo 'show';
                                            //             }
                                            //         }
                                            //     }
                                            // } 
                                            ?>" id="action_1<?//= $p_user->user_id ?>">
                                                <label class="checkbox-inline c-checkbox">
                                                    <input checked type="checkbox"
                                                           name="action_1<?//= $p_user->user_id ?>[]"
                                                           disabled
                                                           value="view">
                                                        <span
                                                            class="fa fa-check"></span><?//= lang('can') . ' ' . lang('view') ?>
                                                </label>
                                                <label class="checkbox-inline c-checkbox">
                                                    <input
                                                        <?php

                                                        // if (!empty($login_info->permission) && $login_info->permission != 'all') {
                                                        //     $get_permission = json_decode($login_info->permission);
                                                        //     if (is_array($get_permission)) {
                                                        //         foreach ($get_permission as $user_id => $v_permission) {
                                                        //             if ($user_id == $p_user->user_id) {
                                                        //                 if (in_array('edit', $v_permission)) {
                                                        //                     echo 'checked';
                                                        //                 };

                                                        //             }
                                                        //         }
                                                        //     }

                                                        // }
                                                        ?>
                                                        type="checkbox"
                                                        value="edit" name="action_<?//= $p_user->user_id ?>[]">
                                                        <span
                                                            class="fa fa-check"></span><?//= lang('can') . ' ' . lang('edit') ?>
                                                </label>
                                                <label class="checkbox-inline c-checkbox">
                                                    <input
                                                        <?php
                                                        // if (!empty($login_info->permission) && $login_info->permission != 'all') {
                                                        //     $get_permission = json_decode($login_info->permission);
                                                        //     if (is_array($get_permission)) {
                                                        //         foreach ($get_permission as $user_id => $v_permission) {
                                                        //             if ($user_id == $p_user->user_id) {
                                                        //                 if (in_array('delete', $v_permission)) {
                                                        //                     echo 'checked';
                                                        //                 };
                                                        //             }
                                                        //         }
                                                        //     }
                                                        // }
                                                        ?>
                                                        name="action_<?//= $p_user->user_id ?>[]"
                                                        type="checkbox"
                                                        value="delete">
                                                        <span
                                                            class="fa fa-check"></span><?//= lang('can') . ' ' . lang('delete') ?>
                                                </label>

                                            </div>

                                            <?php
                                    //     }
                                    // }
                                    ?>
                                </div>
                            </div> -->

                            <div class="btn-bottom-toolbar text-right">
                                <?php
                                if (!empty($user_id)) { ?>
                                    <button type="submit"
                                            class="btn btn-sm btn-primary"><?= lang('update_user') ?></button>
                                    <button type="button" onclick="goBack()"
                                            class="btn btn-sm btn-danger"><?= lang('cancel') ?></button>
                                <?php } else {
                                    ?>
                                    <button type="submit"
                                            class="btn btn-sm btn-primary"><?= lang('create_user') ?></button>
                                <?php }
                                ?>
                            </div>
                        </form>
                    </div>
                <?php } else { ?>
            </div>
            <?php } ?>
        </div>
    </div>

    <script>
    //    $(document).ready(function () {
    //     $('#experience').dataTable({
    //         "processing": true,
    //     "serverSide": true,
    //     "deferLoading": 57
    //     });
    // $("#experience").load("<?//= base_url()?>admin/experience");
    //    });
    <?php //if(empty($project_info)){?>
    //$('.hourly_rate').hide();
    <?php //}?>
    // $(document).ready(function () {

    //var dat =$("#experience").serialize(); 
      
    // $.ajax({
    //     type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
    //     url: '<?//= base_url()?>admin/experience', 
    //     dataType: 'json', // what type of data do we expect back from the server
    //     data: dat,
    //     encode: true,
    //     success: function (res) {
    //         console.log(res);
    //         if (res) {
    //             toastr[res.status](res.message);
    //         } else {
    //             alert('There was a problem with AJAX');
    //         }
    //     }
    // });
     //});
    // $( document ).ready(function() {
    //     // Handler for .ready() called.
    //     if($('#gob_type option:selected').val() == "gob"){
    //         $('#gob_designation').show();
    //         $('#cadre_type').show();
    //         $('#cadre_batch').show();
    //         $('#cadre_id').show();
    //     }
        
    // });
    $('#gob_type').hide();
    $('#cadre_type').hide();
     
    $('#gob_designation').hide();
    $('#cadre_name').hide();
    $('#cadre_batch').hide();
    $('#cadre_id').hide();
    $('.scbatch').hide();
    <? if($this->uri->segment(4)=="edit_user") {?>
        if($('#gob_type option:selected').val() != "null" ){
            $('#gob_type').show();
        }
        if($('#cadre_type option:selected').val() != "null" ){
            $('#cadre_type').show();
        }
        if($('input[name=gobDesignation]').val() != ""){
            $('#gob_designation').show();
        }
        if($('input[name=cadreName]').val() != ""){
            $('#cadre_name').show();
        }
        if($('input[name=cadreBatch]').val() != ""){
            $('#cadre_batch').show();
        }
        if($('input[name=cadreID]').val() != ""){
            $('#cadreID').show();
        }
        if($('#employee_type option:selected').val()=="service_contract"){
            $('.scbatch').show();
        }
    <?}?>
    function cadre_type_value(val){
        if(val == "gob"){
            $('#cadre_type').show();
            $('#gob_designation').show();
        }
        else{
            $('#cadre_type').hide();
            $('#gob_designation').hide();
        }
    }
    function get_cadre_value(val){
        if(val == "cadre"){
            $('#cadre_name').show();
            $('#cadre_batch').show();
            $('#cadre_id').show();
        }
        else{
            $('#cadre_name').hide();
            $('#cadre_batch').hide();
            $('#cadre_id').hide();
        }
    }
    function get_billing_value(val) {
        $('#gob_type').show();
        if (val == 'individual_contract') {
            $('.individual_contract').show();
            $(".individual_contract").removeAttr('disabled');
            $('.service_contract').hide();
            $(".service_contract").attr('disabled', 'disabled');
            $('.young_professional').hide();
      
            $('.scbatch').hide();
        
        } else if (val == 'service_contract') {
            $('.individual_contract').hide();
            $(".individual_contract").attr('disabled', 'disabled');
            $('.young_professional').hide();
            $(".young_professional").attr('disabled', 'disabled');
            $('.service_contract').show();
          
            $('.scbatch').show();
          
        } 
        else {
            $('.young_professional').show();
            $(".young_professional").removeAttr('disabled');
            $('.individual_contract').hide();
            $(".individual_contract").attr('disabled', 'disabled');
            $('.service_contract').hide();
            $(".service_contract").attr('disabled', 'disabled');
            $('.scbatch').hide();
        
        }
    }
        $(document).on("click", function () {
            $('.change_user_status input[type="checkbox"]').change(function () {
                var user_id = $(this).data().id;
                var status = $(this).is(":checked");
                if (status == true) {
                    status = 1;
                } else {
                    status = 0;
                }
                $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url: '<?= base_url()?>admin/user/change_status/' + status + '/' + user_id, // the url where we want to POST
                    dataType: 'json', // what type of data do we expect back from the server
                    encode: true,
                    success: function (res) {
                        console.log(res);
                        if (res) {
                            toastr[res.status](res.message);
                        } else {
                            alert('There was a problem with AJAX');
                        }
                    }
                })

            });

        })
        <?php if (!empty($edited)) { ?>
        $(document).ready(function () {
            
            $('#department').hide();
            $('#client_permission').hide();
            var user_flag = document.getElementById("user_type").value;
            // on change user type select action
            $('#user_type').on('change', function () {
                if (this.value == '3' || this.value == '1') {
                    $("#department").show();
                    $(".department").removeAttr('disabled');
                    $('#client_permission').hide();
                    $(".client_permission").attr('disabled', 'disabled');
                    $(".department").attr('required', true);
                } else if (this.value == '2') {
                    $('#client_permission').show();
                    $(".client_permission").removeAttr('disabled');
                    $("#department").hide();
                    $(".department").attr('disabled', 'disabled');
                    $(".department").removeAttr('required');

                } else {
                    $('#client_permission').hide();
                    $(".client_permission").attr('disabled', 'disabled');
                    $("#department").hide();
                    $(".department").attr('disabled', 'disabled');
                }
            });
        });
        <?php }?>
    </script>
<?php
if (!empty($login_info) && $login_info->role_id != 2) { ?>
    <script>
        $(document).ready(function () {
            $('#department').show();
            $(".department").removeAttr('disabled');
            $('#client_permission').hide();
            $(".client_permission").attr('disabled', 'disabled');
        });
    </script>
<?php }
?><?php
if (!empty($login_info) && $login_info->role_id == 2) { ?>
    <script>
        $(document).ready(function () {
            $('#client_permission').show();
            $(".client_permission").removeAttr('disabled');
            $("#department").hide();
            $(".department").attr('disabled', 'disabled');
            $(".department").removeAttr('required');
        });
    </script>
<?php }
?>