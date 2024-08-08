<?php 
/** 
Purpose of file:    Compensaroy Leave View
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
$emp_att_scheme = emp_att_scheme($_SESSION['sessEmpNo']);
?>
<?=load_plugin('css',array('datepicker','timepicker','select','select2'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="javascript:;">Request</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Compensatory Time off</span>
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
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">Compensatory Time off</span>
                </div>
            </div>
            <div class="portlet-body">
                <?=form_open(base_url('employee/compensatory_leave/submit'), array('method' => 'post', 'id' => 'frmCompensatoryLeave'))?>
                <input class="hidden" name="strStatus" value="Filed Request">
                <input class="hidden" name="strCode" value="CTO">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Date : <span class="required"> * </span></label>
                            <div class="input-icon right">
                                  <input class="form-control date-picker" name="dtmComLeave" id="dtmComLeave" size="16" type="text" value="" data-date-format="yyyy-mm-dd" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Offset balance: <?=count($arrLB) > 0 ? $arrLB[0]['off_bal'] : '0'?></label> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Morning Time In :</label>
                            <input type="text" class="form-control timepicker timepicker-default" name="dtmMorningIn" id="dtmMorningIn" value="<?=date('h:i:A',strtotime($emp_att_scheme['amTimeinTo']))?>" autocomplete="off">
                        </div>
                    </div>
                </div>      
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Morning Time Out :</label>
                            <input type="text" class="form-control timepicker timepicker-default" name="dtmMorningOut" id="dtmMorningOut" value="<?=date('h:i:A',strtotime($emp_att_scheme['nnTimeinTo']))?>" autocomplete="off">
                        </div>
                    </div>
                </div>  
                 <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Afternoon Time In :</label>
                            <input type="text" class="form-control timepicker timepicker-default" name="dtmAfternoonIn" id="dtmAfternoonIn" value="<?=date('h:i:A',strtotime($emp_att_scheme['nnTimeoutTo']))?>" autocomplete="off">
                        </div>
                    </div>
                </div>
                  <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label class="control-label">Afternoon Time Out :</label>
                            <input type="text" class="form-control timepicker timepicker-default" name="dtmAfternoonOut" id="dtmAfternoonOut" value="<?=date('h:i:A',strtotime($emp_att_scheme['pmTimeoutTo']))?>" autocomplete="off">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Purpose/Target Deliverables :</label>
                            <textarea name="strPurpose" id="strPurpose" type="text" size="20" maxlength="100" class="form-control" value="<?=!empty($this->session->userdata('strPurpose'))?$this->session->userdata('strPurpose'):''?>"></textarea>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Recommending Approval : </label>
                            <select name="strRecommend" id="strRecommend" type="text" class="form-control select2 form-required" value="<?=!empty($this->session->userdata('strRecommend'))?$this->session->userdata('strRecommend'):''?>">
                                <option value="0">-- SELECT --</option>
                                <?php foreach($arrEmployees as $i=>$data): ?>
                                    <option value="<?=$data['empNumber']?>">
                                        <?=(strtoupper($data['surname']).', '.($data['firstname']).' '.($data['middleInitial']).' '.($data['nameExtension']))?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>      
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label">Approval / Disapproval : </label>
                            <select name="strApproval" id="strApproval" type="text" class="form-control select2 form-required" value="<?=!empty($this->session->userdata('strApproval'))?$this->session->userdata('strApproval'):''?>">
                                <option value="0">-- SELECT --</option>
                                <?php foreach($arrEmployees as $i=>$data): ?>
                                    <option value="<?=$data['empNumber']?>"><?=(strtoupper($data['surname']).', '.($data['firstname']).' '.($data['middleInitial']).' '.($data['nameExtension']))?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row"><div class="col-sm-8"><hr></div></div>

                <div class="row">
                    <div class="col-sm-8">
                        <button type="submit" class="btn btn-success" id="btn-request-cto"
                            <?=count($arrLB) > 0 ? $arrLB[0]['off_bal'] > 0 ? '' : 'disabled' : 'disabled'?> >
                            <i class="icon-check"></i>
                            <?=$this->uri->segment(3) == 'edit' ? 'Save' : 'Submit'?></button>
                        <a href="<?=base_url('employee/compensatory_leave')?>" class="btn blue"> <i class="icon-ban"></i> Cancel</a>
                        <button type="button" id="printreport" value="reportOB" class="btn grey-cascade pull-right"><i class="icon-magnifier"></i> Print/Preview</button>
                    </div>
                </div>
                <?=form_close()?>
            </div>
        </div>
    </div>
</div>

<!-- begin cto form modal -->
<div id="cto-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" style="width: 60%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Request to Render Compensatory Time Off</h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <embed src="" id="cto-embed" frameborder="0" width="100%" height="500px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="" id="cto-embed-fullview" class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end cto form modal -->

<?=load_plugin('js',array('form_validation','datepicker','timepicker','select','select2'));?>
<script>
$(document).ready(function() {
    $('.timepicker').timepicker({
        timeFormat: 'HH:mm:ss A',
        minuteStep: 1,
        secondStep: 1,
        disableFocus: true,
        showInputs: false,
        showSeconds: true,
        showMeridian: true,
        // defaultValue: '12:00:00 a'
    });
    $('.date-picker').datepicker();
    $('.date-picker').on('changeDate', function(){
        $(this).datepicker('hide');
    });

    $('#dtmComLeave').on('keyup keypress change',function() {
        check_null('#dtmComLeave','Date must not be empty.');
    });

    $('#btn-request-cto').click(function(e) {
        if(check_null('#dtmComLeave','Date must not be empty.') > 0){
            e.preventDefault();
        }
    });
  
    $('#printreport').click(function(){
        var comleave=$('#dtmComLeave').val();
        var oldmorin=$('#dtmMorningIn').val();
        var oldmorout=$('#dtmMorningOut').val();
        var oldafin=$('#dtmAfternoonIn').val();
        var oldafout=$('#dtmAfternoonOut').val();
        var purpose=$('#strPurpose').val();
        var reco=$('#strRecommend').val();
        var approval=$('#strApproval').val();

        var link = "<?=base_url('employee/reports/generate/?rpt=reportCL&comleave=')?>"+comleave+"&oldmorin="+oldmorin+"&oldmorout="+oldmorout+"&oldafin="+oldafin+"&oldafout="+oldafout+"&morningin="+"&morningout="+"&aftrnoonin="+"&aftrnoonout="+"&purpose="+purpose+"&reco="+reco+"&approval="+approval;

        $('#cto-embed').attr('src',link);
        $('#cto-embed-fullview').attr('href',link);
        $('#cto-form').modal('show');
    
    });
});
</script>
