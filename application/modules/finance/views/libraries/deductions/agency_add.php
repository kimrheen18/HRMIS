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
            <span><?=$action?> Agency</span>
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
                    <li>
                        <a href="<?=base_url('finance/libraries/deductions')?>">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase"> Deductions</span>
                            </div>
                        </a>
                    </li>
                    <li class="active">
                        <a data-toggle="tab" href="#tab-agency">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase"> Agency </span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <div id="tab-agency" class="tab-pane active" v-cloak>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12">
                        <br>
                        <div class="portlet">
                            <div class="portlet-title">
                                <div class="caption font-dark">
                                    <span class="caption-subject bold uppercase"> <?=$action?> Agency</span>
                                </div>
                            </div>
                            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                            <div class="portlet-body" style="display: none;">
                                <?=form_open($action == 'edit' ? 'finance/libraries/agency/edit/'.$this->uri->segment(5) : base_url('finance/libraries/agency/add'), array('method' => 'post'))?>
                                    <input type="hidden" id='txtcode' value="<?=$this->uri->segment(5)?>" />
                                    <div class="form-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group <?=isset($err) ? 'has-error': ''?>">
                                                    <label class="control-label">Agency Code <span class="required"> * </span></label>
                                                    <div class="input-icon right">
                                                        <input type="text" class="form-control form-required" name="agency-code" id="agency-code" <?=$action == 'edit' || $action == 'delete' ? 'disabled' : ''?>
                                                            maxlength="20" value="<?=isset($arrData) ? $arrData['deductionGroupCode'] : set_value('agency-code')?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Agency Description <span class="required"> * </span></label>
                                                    <div class="input-icon right">
                                                        <input type="text" class="form-control form-required" name="agency-desc" id="agency-desc" <?=$action == 'delete' ? 'disabled' : ''?>
                                                            maxlength="50" value="<?=isset($arrData) ? $arrData['deductionGroupDesc'] : set_value('agency-desc')?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="control-label">Account Code <span class="required"> * </span></label>
                                                    <div class="input-icon right">
                                                        <input type="text" class="form-control form-required" name="acct-code" id="acct-code" <?=$action == 'delete' ? 'disabled' : ''?>
                                                            maxlength="50" value="<?=isset($arrData) ? $arrData['deductionGroupAccountCode'] : set_value('acct-code')?>">    
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group">
                                                            <?php if($action=='delete'): ?>
                                                                    <a href="<?=base_url('finance/libraries/deductions/delete?tab=agency&id='.$arrData['deduct_id'].'&code='.$arrData['deductionGroupCode'])?>" class="btn red"><i class="icon-trash"></i> Delete</a>
                                                            <?php else: ?>
                                                                    <button class="btn green" id="btn_add_agency" type="submit"><i class="fa fa-plus"></i> <?=strtolower($action)=='add'?'Add':'Save'?> </button>
                                                            <?php endif; ?>
                                                            <a href="<?=base_url('finance/libraries/deductions?tab=agency')?>" class="btn blue"><i class="icon-ban"></i> Cancel</a>
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
<?php load_plugin('js',array('form_validation'));?>

<script>
    $(document).ready(function() {
        $('.loading-image').hide();
        $('.portlet-body').show();

        $('#agency-code').on('keyup keypress change', function() {
            check_null('#agency-code','Agency must not be empty.');
        });
        $('#agency-desc').on('keyup keypress change', function() {
            check_null('#agency-desc','Deduction Code must not be empty.');
        });
        $('#acct-code').on('keyup keypress change', function() {
            check_null('#acct-code','Deduction Description must not be empty.');
        });

        $('#btn_add_agency').on('click', function(e) {
            var total_error = 0;
            total_error = total_error + check_null('#agency-code','Agency Code must not be empty.');
            total_error = total_error + check_null('#agency-desc','Agency Description must not be empty.');
            total_error = total_error + check_null('#acct-code','Account Code must not be empty.');
            
            if(total_error > 0){
                e.preventDefault();
            }
        });

    });
</script>