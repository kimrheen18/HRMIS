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
            <span><?=ucfirst($action)?> Project Code</span>
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
                            <span class="caption-subject bold uppercase"> <?=$action?> Project Code</span>
                        </div>
                    </div>
                    <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                    <div class="portlet-body" id="projectcode" style="display: none" v-cloak>
                        <div class="table-toolbar">
                            <?=form_open($action == 'edit' ? 'finance/libraries/projectcode/edit/'.$this->uri->segment(5) : '', array('method' => 'post'))?>
                                <!-- <input type="hidden" id='txtcode' value="<?=$this->uri->segment(4)?>" /> -->
                                <div class="form-group <?=isset($err) ? 'has-error': ''?>">
                                    <label class="control-label">Project Code <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips <?=isset($err) ? '' : 'hidden'?>" <?=isset($err) ? 'data-original-title="'.$err.'"' : ''?>></i>
                                        <input type="text" class="form-control form-required" name="txtcode" id="txtcode" <?=$action == 'edit' || $action == 'delete' ? 'disabled' : ''?>
                                            maxlength="100" value="<?=isset($data) ? $data['projectCode'] : set_value('txtcode')?>" <?=$action?>>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label">Project Description <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <textarea class="form-control form-required" name="txtdesc" id="txtdesc" <?=$action == 'delete' ? 'disabled' : ''?>><?=isset($data) ? $data['projectDesc'] : set_value('txtdesc')?></textarea>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label">Project Order <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control form-required" name="txtorder" id="txtorder" <?=$action == 'delete' ? 'disabled' : ''?>
                                            maxlength="10" value="<?=isset($data) ? $data['projectOrder'] : set_value('txtorder')?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <?php if($action=='delete'): $code = isset($data)?$data['projectCode']:''; ?>
                                                    <a href="<?=base_url('finance/libraries/projectcode/delete/'.$this->uri->segment(5)).'?code='.$code?>" class="btn red"><i class="icon-trash"></i> Delete</a>
                                            <?php else: ?>
                                                <button class="btn green" type="submit" id="btn_add_projectcode"><i class="fa fa-plus"></i> <?=strtolower($action)=='add'?'Add':'Save'?> </button>
                                            <?php endif; ?>
                                            <a href="<?=base_url('finance/libraries/projectcode')?>" class="btn blue">
                                                <i class="icon-ban"></i> Cancel</a>
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
<?php load_plugin('js',array('form_validation'));?>

<script>
    $(document).ready(function() {
        $('.loading-image').hide();
        $('.portlet-body').show();

        $('#txtcode').on('keyup keypress change', function() {
            check_null('#txtcode','Project Code must not be empty.');
        });
        $('#txtdesc').on('keyup keypress change', function() {
            check_null('#txtdesc','Project Description must not be empty.');
        });
        $('#txtorder').on('keyup keypress change', function() {
            check_number('#txtorder','Project Order must not be empty.');
        });

        $('#btn_add_projectcode').on('click', function(e) {
            var total_error = 0;
            total_error = total_error + check_null('#txtcode','Project Code must not be empty.');
            total_error = total_error + check_null('#txtdesc','Project Description must not be empty.');
            total_error = total_error + check_number('#txtorder','Project Order must not be empty.');
            if(total_error > 0){
                e.preventDefault();
            }
        });
    });
</script>