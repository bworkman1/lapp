<div class="row">
    <div id="base_url" data-base="<?php echo base_url(); ?>"></div>
    <div class="col-lg-4 col-md-6">

        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-bars"></i> Add New Form</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <!-- required for floating -->
                <!-- Nav tabs -->
                <ul class="nav nav-tabs bar_tabs">
                    <li class="active"><a href="#settings" data-toggle="tab" aria-expanded="true">Form Settings</a>
                    </li>
                    <li class=""><a href="#inputs" data-toggle="tab" aria-expanded="false">Form Inputs</a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="clearfix"></div>

                <div class="tab-content">
                    <!-- FORM SETTINGS -->
                    <div class="tab-pane active" id="settings">
                        <div class="form-group">
                            <label><span class="text-danger">*</span> Form Name</label>
                            <input type="text" class="form-control" maxlength="50" minlength="2" name="form_name" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span class="text-danger">*</span> Cost</label>
                                    <input type="text" class="form-control" maxlength="50" minlength="2" name="form_cost" required placeholder="0.00">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label><span class="text-danger">*</span> Min. Payment</label>
                                    <input type="text" class="form-control" maxlength="50" minlength="2" name="min_payment" required placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Form Header</label>
                            <textarea name="form_header" class="form-control" style="min-height:100px"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Form Footer</label>
                            <textarea name="form_footer" class="form-control" style="min-height:100px"></textarea>
                        </div>
                        <div class="checkbox">
                            <label><input type="checkbox" name="is_active"> Activate Form</label>
                        </div>
                    </div>

                    <!-- FORM INPUTS -->
                    <div class="tab-pane fade" data-url="<?php echo base_url('forms/add-input'); ?>" id="inputs">

                        <div class="form-group">
                            <label><span class="text-danger">*</span> Input Label</labeL>
                            <input type="text" required class="form-control" name="input_label" maxlength="255" minlength="2">
                        </div>
                        <div class="form-group">
                            <label><span class="text-danger">*</span> Input Name <small>(must be unique)</small></labeL>
                            <input type="text" required class="form-control" name="input_name" maxlength="20" minlength="2">
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="validation">
                                    <button class="btn btn-info" data-toggle="modal" data-target="#validationRules">Set Validation Rules</button>
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="clear-validation">
                                    <button class="btn btn-warning pull-right">Clear Rules</button>
                                </div>
                            </div>
                        </div>


                        <br>

                        <label>Input Validations Selected</label>
                        <div class="form-group">
                            <input type="text" id="input_validations" value="" class="form-control" name="input_validations" readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Custom Class</label>
                                    <input type="text" class="form-control" name="input_class" maxlength="50">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label><span class="text-danger">*</span> Input Type</labeL>
                                    <select name="input_type" class="form-control">
                                        <option value="">Select One</option>
                                        <?php
                                        $inputType = array('text' => 'Single Line Input', 'select' => 'Select Box', 'textarea' => 'Multi-line Text Input', 'checkbox' => 'Check Boxes', 'radio' => 'Radio Buttons');
                                        foreach($inputType as $key => $type) {
                                            echo '<option value="'.$key.'">'.ucwords($type).'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-12 col-lg-6">
                                <div class="form-group">
                                    <label><span class="text-danger">*</span> Column Width</labeL>
                                    <select name="input_columns" class="form-control">
                                        <option value="">Select One</option>
                                        <?php
                                            $columns = array(
                                                'col-md-1',
                                                'col-md-2',
                                                'col-md-3',
                                                'col-md-4',
                                                'col-md-5',
                                                'col-md-6',
                                                'col-md-7',
                                                'col-md-8',
                                                'col-md-9',
                                                'col-md-10',
                                                'col-md-11',
                                                'col-md-12',
                                            );
                                            foreach($columns as $key => $column) {
                                                echo '<option value="'.$column.'">'.($key+1).' Columns Wide</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <label><input type="checkbox" name="encrypt_data"> <i class="fa fa-question-circle" data-toggle="tooltip" data-title="If checked the input data that the user submits will be encrypted in the database and un-encrypted
                         when you view it for safer storage."></i> Encrypt Input Data?</label>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <label>Sequence</label>
                                    <select id="inputSequence" name="sequence" class="form-control">
                                        <?php
                                        if(!empty($inputs)) {
                                            for($i=0;$i<count($inputs);$i++) {
                                                echo '<option>'.($i+1).'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="inputOptions" class="hide well well-sm">
                            <p><b><span class="text-danger">*</span> Add Input Values</b></p>
                            <div id="inlineElement" class="checkbox hide">
                                <label><input type="checkbox" name="inline-element" value="yes"> Inline Elements</label>
                            </div>
                            <div class="modelInput row">
                                <div class="col-xs-5">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Label</label>
                                        <input type="text" id="inputOptionLabel" name="option_label_1" class="form-control" maxlength="40">
                                    </div>
                                </div>
                                <div class="col-xs-5">
                                    <div class="form-group">
                                        <label><span class="text-danger">*</span> Value</label>
                                        <input type="text" id="inputOptionValue" name="option_value_1" class="form-control" maxlength="40">
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <button class="btn btn-info insertNewOption pull-right"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>

                            <ul id="inputValuesSet" class="list-group">
                            </ul>
                            <input type="hidden" id="formInputId">
                            <input type="hidden" id="formId">
                            <input type="hidden" id="sequenceId">
                        </div>

                        <hr>
                        <button id="addInput" class="btn btn-info pull-right"><i class="fa fa-forward"></i> Save Input</button>
                        <div class="clearfix"></div>
                    </div>

                </div>
                <hr>
                <button id="saveNewForm" class="btn btn-primary">Save Form</button>
            </div>
        </div>

    </div>

    <div class="col-lg-8 col-md-6">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-file-o"></i> <span id="formName">Form Preview</span></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <div id="form-header"></div>
                <hr>
                <div id="form-inputs" class="row grid-stack">

                    <?php
                        if(!empty($inputs)) {
                            foreach($inputs as $key => $val) {
                                switch($val['input_type']) {
                                    case 'text':
                                        echo '<div class="'.$val['input_columns'].' grid-stack formInputObject" data-sequence="'.$val['sequence'].'" data-validation="'.$val['input_validation'].'" data-id="'.$val['id'].'">';
                                            echo '<div class="form-group">';
                                                $required = '';
                                                if (strpos($val['input_validation'], 'required') !== false) {
                                                    $required = '<span class="text-danger">*</span> ';
                                                }
                                                echo '<label>'.$required.$val['input_label'].'</label>';
                                                echo '<input class="'.$val['custom_class'].' form-control" name="'.$val['input_name'].'"/>';
                                            echo '</div>';
                                            if($val['encrypt_data']) {
                                                echo '<i class="encryptedIcon fa fa-lock"></i>';
                                            }
                                        echo '</div>';
                                        break;

                                    case 'select':
                                        echo '<div class="'.$val['input_columns'].' grid-stack formInputObject" data-sequence="'.$val['sequence'].'" data-validation="'.$val['input_validation'].'" data-id="'.$val['id'].'">';
                                            echo '<div class="form-group">';
                                                $required = '';
                                                if (strpos($val['input_validation'], 'required') !== false) {
                                                    $required = '<span class="text-danger">*</span> ';
                                                }
                                                echo '<label>'.$required.$val['input_label'].'</label>';
                                                echo '<select class="'.$val['custom_class'].' form-control" name="'.$val['input_name'].'">';
                                                    echo '<option value="">Select One</option>';
                                                    foreach($val['options'] as $option) {
                                                        echo '<option  value="'.$option['value'].'">'.$option['name'].'</option>';
                                                    }
                                                echo '</select>';
                                            echo '</div>';
                                            if($val['encrypt_data']) {
                                                echo '<i class="encryptedIcon fa fa-lock"></i>';
                                            }
                                        echo '</div>';
                                        break;

                                    case 'textarea':
                                        echo '<div class="'.$val['input_columns'].' grid-stack formInputObject" data-sequence="'.$val['sequence'].'" data-validation="'.$val['input_validation'].'" data-id="'.$val['id'].'">';
                                            echo '<div class="form-group">';
                                                echo '<label>'.$val['input_label'].'</label>';
                                                echo '<textarea class="'.$val['custom_class'].' form-control" name="'.$val['input_name'].'"></textarea>';
                                            echo '</div>';
                                            if($val['encrypt_data']) {
                                                echo '<i class="encryptedIcon fa fa-lock"></i>';
                                            }
                                        echo '</div>';
                                        break;

                                    case 'checkbox':
                                        echo '<div class="'.$val['input_columns'].' grid-stack formInputObject" data-sequence="'.$val['sequence'].'" data-validation="'.$val['input_validation'].'" data-id="'.$val['id'].'">';
                                        $required = '';
                                        if (strpos($val['input_validation'], 'required') !== false) {
                                            $required = '<span class="text-danger">*</span> ';
                                        }
                                        echo '<label>'.$required.$val['input_label'].'</label><br>';
                                        foreach($val['options'] as $option) {
                                            $inline = 'checkbox';
                                            if($val['input_inline']) {
                                                $inline = 'checkbox-inline';
                                            }
                                                echo '<div class="'.$inline.'">';
                                                echo '<label><input type="checkbox" class="' . $val['custom_class'] . '" name="' . $option['name'] . '[]" value="'.$option['value'].'"> ' . $option['name'] . '</label>';
                                            echo '</div>';
                                        }
                                        if($val['encrypt_data']) {
                                            echo '<i class="encryptedIcon fa fa-lock"></i>';
                                        }
                                        echo '</div>';

                                        break;
                                    default:
                                        break;
                                }
                            }
                        }
                    ?>

                </div>
                <div class="clearfix"></div>
                <hr>
                <div id="form-footer"></div>
            </div>
        </div>
    </div>

</div>
</div>


<div id="validationRules" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-check-circle-o"></i> Input Validation Rules</h4>
            </div>
            <div class="modal-body">
                <form id="validationForm" action="<?php echo base_url('forms/format_validation_rules'); ?>">
                    <div class="row">
                    <?php $i=0; foreach($validation_options as $option) { ?>
                        <div class="col-md-6">
                            <div class="row">
                                <?php
                                    if($option->parameter) {
                                        echo '<div class="col-md-8">';
                                    } else {
                                        echo '<div class="col-md-12">';
                                    }
                                ?>

                                    <div class="checkbox">
                                        <label style="padding-left:0">
                                            <input type="checkbox" name="type_<?= $i ?>" value="<?= $option->type; ?>"> <b style="font-size: 1.4em;"><?= $option->label; ?></b>
                                        </label>
                                    </div>
                                    <span><i class="fa fa-question-circle fa-fw"></i> <?= str_replace('Returns FALSE', 'Fails the forms submission', $option->description); ?></span>

                                </div>

                                <?php
                                    if($option->parameter) {
                                        echo '<div class="col-md-4">';
                                            echo '<div class="form-group param">';
                                                echo '<label>';
                                                    echo 'Parameter';
                                                echo '</label>';
                                                $maxLength = '';
                                                if($option->param_type == 'number') {
                                                    $maxLength = 'max=255';
                                                }
                                                echo '<input type="'.$option->param_type.'" '.$maxLength.' class="form-control" name="parameter_'.$i.'">';
                                                echo '<div class="formErrors text-danger"></div>';
                                            echo '</div>';
                                        echo '</div>';
                                    }
                                ?>
                            </div>
                            <hr>
                        </div>
                        <?php if($i%2) { echo '</div><div class="row">';} ?>
                    <?php $i++; } ?>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-info" id="addValidationToInput">Add Rules</button>
            </div>
        </div>
    </div>
</div>