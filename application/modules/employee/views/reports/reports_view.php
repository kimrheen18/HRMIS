<?php 
/** 
Purpose of file:    Reports View
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<!-- BEGIN PAGE BAR -->
<?=load_plugin('css',array('select','select2'));?>
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
            <span>Reports</span>
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
                    <span class="caption-subject bold uppercase">Reports</span>
                </div>
            </div>
            <div class="portlet-body">
                <?=form_open(base_url('employee/reports/submit'), array('method' => 'post', 'id' => 'frmReports', 'onsubmit' => 'return checkForBlank()'))?>
                </br>
                     
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                            <label class="control-label"><strong>Type of Reports : </strong><span class="required"> * </span></label>
                                 <select name="strReporttype" id="strReporttype" type="text" class="form-control bs-select form-required" value="<?=!empty($this->session->userdata('strReporttype'))?$this->session->userdata('strReporttype'):''?>">
                                <option value="">-- SELECT REPORT TYPE --</option>
                                <option>Daily Time Record</option>
                                <option>Service Record</option>
                                <option>Remittances</option>
                                <option>Payslip</option>
                                <option>Certificate of Compensation</option>
                                </select>
                                <font color='red'> <span id="errortype"></span></font>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group remit">
                           <label class="control-label">Type of Remittances : </label>
                                 <select name="strRemittype" id="strRemittype" type="text" class="form-control bs-select form-required" value="<?=!empty($this->session->userdata('strRemittype'))?$this->session->userdata('strRemittype'):''?>">
                                <option value="">-- SELECT REMITTANCE --</option>
                                <option>Conso Loan</option>
                                <option>E-Cash</option>
                                <option>GSIS Educational</option>
                                <option>GSIS Emergency</option>
                                <option>Pag-ibig Loan</option>
                                </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                           <label class="control-label">Month : <span class="required"> * </span></label>
                                 <select id="month" name="month" class="form-control bs-select form-required" style="width: 40%;">
                                    <option value="">-- SELECT MONTH --</option>
                                    <?php
                                    $monthArray = range(1, 12);
                                    foreach ($monthArray as $month) {
                                      $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
                                      $fdate = date("F", strtotime("2015-$monthPadding-01"));
                                        echo '<option value="'.$monthPadding.'">'.$fdate.'</option>';
                                    }?>
                                </select>
                                <font color='red'> <span id="errormonth"></span></font>
                        </div>
                    </div>
                </div>
                 <div class="row">
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label class="control-label">Date : <span class="required"> * </span></label>
                                  <?php
                                $already_selected_value = date("Y");
                                $earliest_year = 2003;

                                print '<select name="date" id="date" class="form-control bs-select form-required">';
                                foreach (range(date('Y'), $earliest_year) as $x) {
                                    print '<option value="'.$x.'"'.($x === $already_selected_value ? ' selected="selected"' : '').'>'.$x.'</option>';
                                }
                                print '</select>'; ?>
                                <font color='red'> <span id="erroryear"></span></font>
                        </div>
                    </div>
                </div>
                <br><br>
                     <div class="row">
                        <div class="col-sm-8 text-center">
                            <input class="hidden" name="strStatus" value="Filed Request">
                            <input class="hidden" name="strCode" value="Reports">

                            <button type="submit" class="btn blue">Submit</button>
                            <a href="<?=base_url('employee/reports')?>"/><button type="reset" class="btn blue">Clear</button></a>    
                        </div>            
                    </div>
               
               <?=form_close()?>
            </div>
        </div>
    </div>
</div>
<?=load_plugin('js',array('select','select2','form_validation'));?>

<script>
$(document).ready(function()
{
$('.remit').hide();
  $('#strReporttype').on('change',function()
  {
    var country = $("#strReporttype").find("option:selected").text();
    //alert(state);
    if(country=='Remittances')
      $('.remit').show();
    else
      $('.remit').hide();
  });
}); 

</script>
<script>

function checkForBlank()
{
   var spaceCount = 0;

    $type= $('#strReporttype').val();
    $month= $('#month').val();

    $('#errortype','errormonth').html('');

    if($type=="")
    {
      $('#errortype').html('This field is required!');
      return false;
    }
    if($month=="")
    {
      $('#errormonth').html('This field is required!');
      return false;
    }
    
    else
    {
      return true;
    }

}
</script>