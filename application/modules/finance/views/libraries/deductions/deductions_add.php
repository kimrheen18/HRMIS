<?php load_plugin('css',array('select'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Libraries</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?=$action?> Deduction</span>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
	   &nbsp;
	</div>
</div>
<div class="clearfix"></div>
<div class="row profile-account">
    <div class="col-md-12">
        <div class="tab-content portlet light bordered">
            <div class="tabbable tabbable-tabdrop">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a href="#tab-deduction" data-toggle="tab">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase"> Deductions</span>
                            </div>
                        </a>
                    </li>
                    <li>
                        <a href="<?=base_url('finance/libraries/deductions?tab=agency')?>">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase"> Agency </span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div id="tab-deduction" class="tab-pane active">
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <span class="caption-subject bold uppercase"> <?=$action?> Deduction</span>
                                </div>
                            </div>
                            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                            <div class="portlet-body" style="display: none;">
                                <?=form_open($action == 'edit' ? 'finance/libraries/deductions/edit/'.$this->uri->segment(5) : '', array('method' => 'post'))?>
                                    <!-- <input type="hidden" id='txtcode' value="<?=$this->uri->segment(5)?>" /> -->
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="control-label">Agency <span class="required"> * </span></label>
                                                    <div class="input-icon right">
                                                        <select class="bs-select form-control form-required" name="selAgency" id="selAgency" <?=$action == 'delete' ? 'disabled' : ''?>>
                                                            <option value="">-- SELECT AGENCY --</option>
                                                            <?php foreach($agency as $agency): ?>
                                                                <option value="<?=$agency['deductionGroupCode']?>"
                                                                    <?=isset($data) ? $agency['deductionGroupCode'] == $data['deductionGroupCode'] ? 'selected' : '' : $agency['deductionGroupCode'] == set_value('selAgency') ? 'selected' : ''?>>
                                                                    <?=$agency['deductionGroupDesc']?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group <?=isset($err) ? 'has-error': ''?>">
                                                    <label class="control-label">Deduction Code <span class="required"> * </span></label>
                                                    <div class="input-icon right">
                                                        <input type="text" class="form-control form-required" name="txtddcode" id="txtddcode"
                                                            maxlength="20" value="<?=isset($data) ? $data['deductionCode'] : set_value('txtddcode')?>" <?=$action == 'edit' || $action == 'delete' ? 'disabled' : ''?>>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Deduction Description <span class="required"> * </span></label>
                                                    <div class="input-icon right">
                                                        <input type="text" class="form-control form-required" name="txtdesc" id="txtdesc"
                                                            maxlength="50" value="<?=isset($data) ? $data['deductionDesc'] : set_value('txtdesc')?>" <?=$action == 'delete' ? 'disabled' : ''?>>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Account Code <span class="required"> * </span></label>
                                                    <div class="input-icon right">
                                                        <input type="text" class="form-control form-required" name="txtacctcode" id="txtacctcode"
                                                            maxlength="50" value="<?=isset($data) ? $data['deductionAccountCode'] : set_value('txtacctcode')?>" <?=$action == 'delete' ? 'disabled' : ''?>>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Type <span class="required"> * </span></label>
                                                    <div class="input-icon right">
                                                        <select class="bs-select form-control form-required" name="seltype" id="seltype" <?=$action == 'delete' ? 'disabled' : ''?>>
                                                            <option value="">-- SELECT TYPE --</option>
                                                            <?php foreach(deduction_type() as $type): ?>
                                                                <option value="<?=$type?>" <?=isset($data) ? $type == $data['deductionType'] ? 'selected' : '' : $type == set_value('seltype') ? 'selected' : ''?>>
                                                                    <?=$type?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <?php if($action == 'edit'): ?>
                                                <div class="form-group">
                                                    <label><input type="checkbox" name="chkisactive" <?=isset($data) ? $data['hidden'] == 1 ? 'checked' : '' : ''?>>Inactive</label>
                                                </div>
                                                <?php endif; ?>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <?php if($action=='delete'): ?>
                                                                    <a href="<?=base_url('finance/libraries/deductions/delete?tab=&id='.$data['deduction_id'].'&code='.$data['deductionCode'])?>" class="btn red"><i class="icon-trash"></i> Delete</a>
                                                            <?php else: ?>
                                                                    <button class="btn green" type="submit" id="btn_add_deduction"><i class="fa fa-plus"></i> <?=strtolower($action)=='add'?'Add':'Save'?> </button>
                                                            <?php endif; ?>
                                                            <a href="<?=base_url('finance/libraries/deductions')?>"><button class="btn blue" type="button"><i class="icon-ban"></i> Cancel</button></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?=form_close()?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php load_plugin('js',array('select','form_validation'));?>

<script>
    $(document).ready(function() {
        $('.loading-image').hide();
        $('.portlet-body').show();

        $('#selAgency').on('keyup keypress change', function() {
            check_null('#selAgency','Agency must not be empty.');
        });
        $('#txtddcode').on('keyup keypress change', function() {
            check_null('#txtddcode','Deduction Code must not be empty.');
        });
        $('#txtdesc').on('keyup keypress change', function() {
            check_null('#txtdesc','Deduction Description must not be empty.');
        });
        $('#txtacctcode').on('keyup keypress change', function() {
            check_null('#txtacctcode','Account Code must not be empty.');
        });
        $('#seltype').on('keyup keypress change', function() {
            check_null('#seltype','Type must not be empty.');
        });

        $('#btn_add_deduction').on('click', function(e) {
            var total_error = 0;
            total_error = total_error + check_null('#selAgency','Agency must not be empty.');
            total_error = total_error + check_null('#txtddcode','Deduction Code must not be empty.');
            total_error = total_error + check_null('#txtdesc','Deduction Description must not be empty.');
            total_error = total_error + check_null('#txtacctcode','Account Code must not be empty.');
            total_error = total_error + check_null('#seltype','Type must not be empty.');
            
            if(total_error > 0){
                e.preventDefault();
            }
        });
    });
</script>