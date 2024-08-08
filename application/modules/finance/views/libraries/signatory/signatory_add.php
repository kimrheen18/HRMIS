<?php load_plugin('css',array('select2'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?=$this->session->userdata('sessUserLevel')==1 ? 'HR' : 'Finance'?> Module</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Libraries</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?=ucfirst($action)?> Signatory</span>
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
                            <span class="caption-subject bold uppercase"> <?=$action?> Signatory</span>
                        </div>
                    </div>
                    <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                    <div class="portlet-body" id="signatory" style="display: none" v-cloak>
                        <div class="table-toolbar">
                            <?=form_open($action == 'edit' ? 'finance/libraries/signatory/edit/'.$this->uri->segment(5) : '', array('method' => 'post'))?>
                                <input type="hidden" id='txtsig_id' value="<?=$this->uri->segment(5)?>" />
                                <div class="form-group ">
                                    <label class="control-label">Signatory Name<span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control form-required" name="txtsignatory" id="txtsignatory" <?=$action=='delete'?'disabled':''?>
                                            value="<?=isset($data) ? $data['signatory'] : set_value('txtsignatory')?>">
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label">Position <span class="required"> * </span></label>
                                    <div class="input-icon right">
                                        <input type="text" class="form-control form-required" name="txtposition" id="txtposition" <?=$action=='delete'?'disabled':''?>
                                            value="<?=isset($data) ? $data['signatoryPosition'] : set_value('txtposition')?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <?php if($action=='delete'): ?>
                                                    <a href="<?=base_url('finance/libraries/signatory/delete/'.$this->uri->segment(5))?>" class="btn red"><i class="icon-trash"></i> Delete</a>
                                            <?php else: ?>
                                                <button class="btn green" type="submit" id="btn_add_signatory">
                                                    <i class="fa fa-plus"></i> <?=strtolower($action)=='add'?'Add':'Save'?> </button>
                                            <?php endif; ?>
                                            <a href="<?=base_url('finance/libraries/signatory')?>"><button class="btn blue" type="button">
                                                <i class="icon-ban"></i> Cancel</button></a>
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
<?php load_plugin('js',array('select2','form_validation'));?>

<script>
    $(document).ready(function() {
        $('.loading-image').hide();
        $('.portlet-body').show();

        $('#txtsignatory').on('keyup keypress change', function() {
            check_null('#txtsignatory','Signatory must not be empty.');
        });
        $('#txtposition').on('keyup keypress change', function() {
            check_null('#txtposition','Position must not be empty.');
        });

        $('#btn_add_signatory').on('click', function(e) {
            var total_error = 0;
            total_error = total_error + check_null('#txtsignatory','Signatory must not be empty.');
            total_error = total_error + check_null('#txtposition','Position must not be empty.');
            
            if(total_error > 0){
                e.preventDefault();
            }
        });
    });
</script>