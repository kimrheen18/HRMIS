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
            <span><?=ucfirst($action)?> Income</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
       &nbsp;
    </div>
</div>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> <?=$action?> Income</span>
                        </div>
                    </div>
                    <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                    <div class="portlet-body" id="income" style="display: none" v-cloak>
                        <div class="table-toolbar">
                            <?=form_open($action == 'edit' ? 'finance/libraries/income/edit/'.$this->uri->segment(5) : '', array('method' => 'post', 'id' => 'frm_addincome')); ?>
                                <input type="hidden" id='txtcode' value="<?=$this->uri->segment(5)?>" />
                                <div class="form-group <?=isset($err) ? 'has-error': ''?>">
                                    <label class="control-label">Income Code <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips <?=isset($err) ? '' : 'hidden'?>" <?=isset($err) ? 'data-original-title="'.$err.'"' : ''?>></i>
                                        <input type="text" class="form-control form-required" name="txtinccode" id="txtinccode" <?=$action == 'edit' || $action == 'delete' ? 'disabled' : ''?>
                                            maxlength="15" value="<?=isset($arrData) ? $arrData['incomeCode'] : set_value('txtinccode')?>">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label">Income Description <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control form-required" name="txtincdesc" id="txtincdesc" <?=$action == 'delete' ? 'disabled' : ''?>
                                            maxlength="50" value="<?=isset($arrData) ? $arrData['incomeDesc'] : set_value('txtinccode')?>">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label">Income Type <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <select class="bs-select form-control form-required" name="selinctype" id="selinctype" <?=$action == 'delete' ? 'disabled' : ''?>>
                                            <option value="">-- SELECT INCOME TYPE --</option>
                                            <?php foreach(income_type() as $type): ?>
                                                <option value="<?=$type?>" <?=isset($arrData) ? $type == $arrData['incomeType'] ? 'selected' : '' : $type == set_value('selinctype') ? 'selected' : ''?>>
                                                    <?=$type?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <?php if($action == 'edit'): ?>
                                    <div class="form-group">
                                        <label><input type="checkbox" name="chkisactive" <?=$arrData['hidden'] == 1 ? 'checked' : ''?>>Inactive</label>
                                    </div>
                                <?php endif; ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <?php if($action=='delete'): $code = isset($arrData)?$arrData['incomeCode']:''; ?>
                                                    <a href="<?=base_url('finance/libraries/income/delete/').$this->uri->segment(5).'?code='.$code?>" class="btn red"><i class="icon-trash"></i> Delete</a>
                                            <?php else: ?>
                                                    <button class="btn green" type="submit" id="btn_add_income"><i class="fa fa-plus"></i> <?=strtolower($action)=='add'?'Add':'Save'?> </button>
                                            <?php endif; ?>
                                            <a href="<?=base_url('finance/libraries/income')?>" class="btn blue"><i class="icon-ban"></i> Cancel</a>
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
<?php load_plugin('js',array('select','form_validation'));?>

<script>
    $(document).ready(function() {
        $('.loading-image').hide();
        $('.portlet-body').show();

        $('#txtinccode').on('keyup keypress change', function() {
            check_null('#txtinccode','Agency must not be empty.');
        });
        $('#txtincdesc').on('keyup keypress change', function() {
            check_null('#txtincdesc','Deduction Code must not be empty.');
        });
        $('#selinctype').on('keyup keypress change', function() {
            check_null('#selinctype','Deduction Description must not be empty.');
        });

        $('#btn_add_income').on('click', function(e) {
            var total_error = 0;
            total_error = total_error + check_null('#txtinccode','Income Code must not be empty.');
            total_error = total_error + check_null('#txtincdesc','Income Description must not be empty.');
            total_error = total_error + check_null('#selinctype','Income Type must not be empty.');
            
            if(total_error > 0){
                e.preventDefault();
            }
        });
    });
</script>