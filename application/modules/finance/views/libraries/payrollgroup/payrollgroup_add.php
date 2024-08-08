<?=load_plugin('css',array('select'));?>
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
            <span><?=$action?> Payroll Group</span>
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
                            <span class="caption-subject bold uppercase"> <?=$action?> Payroll Group</span>
                        </div>
                    </div>
                    <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                    <div class="portlet-body" id="payrollgroup" style="display: none" v-cloak>
                        <div class="table-toolbar">
                            <?=form_open($action == 'edit' ? 'finance/libraries/payrollgroup/edit/'.$this->uri->segment(4) : '', array('method' => 'post'))?>
                                <input type="hidden" id='txtcode' value="<?=$this->uri->segment(4)?>" />
                                <div class="form-group">
                                    <label class="control-label">Project <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <select class="bs-select form-control form-required" name="selprojdesc">
                                            <option value="null">-- SELECT PROJECT --</option>
                                            <?php foreach($projectcode as $code): ?>
                                                <option value="<?=$code['projectCode']?>"
                                                    <?=isset($data) ? $data['projectCode'] == $code['projectCode'] ? 'selected' : '' : set_value('selprojdesc') == $code['projectCode'] ? 'selected' : ''?>>
                                                    <?=$code['projectDesc']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group <?=isset($err) ? 'has-error': ''?>">
                                    <label class="control-label">Payroll Group Code <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips <?=isset($err) ? '' : 'i-required'?>" <?=isset($err) ? 'data-original-title="'.$err.'"' : ''?>></i>
                                        <input type="text" class="form-control form-required" name="txtcode"
                                            value="<?=isset($data) ? $data['payrollGroupCode'] : set_value('txtcode')?>" <?=$action == 'edit' ? 'disabled' : ''?>>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label">Payroll Group Description <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input type="text" class="form-control form-required" name="txtdesc"
                                            value="<?=isset($data) ? $data['payrollGroupName'] : set_value('txtdesc')?>">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label">Payroll Group Order <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input type="text" class="form-control form-required" name="txtorder"
                                            value="<?=isset($data) ? $data['payrollGroupOrder'] : set_value('txtorder')?>">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label">Resposibility Center <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <i class="fa fa-warning tooltips i-required"></i>
                                        <input type="text" class="form-control form-required" name="txtrc"
                                            value="<?=isset($data) ? $data['payrollGroupRC'] : set_value('txtrc')?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <button class="btn green" type="submit" v-bind:class="[error ? 'disabled' : '']" :disabled="error">
                                                <i class="fa fa-plus"></i> <?=strtolower($action)=='add'?'Add':'Save'?> </button>
                                            <a href="<?=base_url('finance/libraries/payrollgroup')?>" class="btn blue" type="button">
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
<?php load_plugin('js',array('select','form_validation'));?>