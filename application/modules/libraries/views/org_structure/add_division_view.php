<?php 
/** 
Purpose of file:    Add page for Org Structure Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="<?=base_url('libraries/agency_profile')?>">Libraries</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Add <?=$_ENV['Group3']?> Name</span>
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
                    <span class="caption-subject bold uppercase"> Add <?=$_ENV['Group3']?> Name</span>
                </div>
                
            </div>
            <div class="portlet-body">
             <?=form_open(base_url('libraries/org_structure/add_division'), array('method' => 'post', 'id' => 'frmOrgStructure'))?>
                <div class="form-body">
                    <?php //print_r($arrPost);?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group1']?><span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                  <select type="text" class="form-control" name="strExecDivision" value="<?=!empty($this->session->userdata('strExecDivision'))?$this->session->userdata('strExecDivision'):''?>" required>
                                        
                                         <option value="">Select</option>
                                        <?php foreach($arrOrganization as $org)
                                        {
                                          echo '<option value="'.$org['group1Code'].'">'.$org['group1Name'].'</option>';
                                        }?>
                                  </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group2']?><span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select type="text" class="form-control" name="strSerDivision" value="<?=!empty($this->session->userdata('strSerDivision'))?$this->session->userdata('strSerDivision'):''?>" required>
                                        
                                         <option value="">Select</option>
                                        <?php foreach($arrService as $service)
                                        {
                                          echo '<option value="'.$service['group2Code'].'">'.$service['group2Name'].'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group3']?> Code <span class="required"> * </span></label>
                                <div class="input-icon right">
                                <i class="fa"></i>
                                    <input type="text" class="form-control" name="strDivCode"  id="strDivCode" value="<?=!empty($this->session->userdata('strDivCode'))?$this->session->userdata('strDivCode'):''?>">
                                    <font color='red'> <span id="errorCode"></span></font>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group3']?> Name <span class="required"> * </span></label>
                                <div class="input-icon right">
                                <i class="fa"></i>
                                    <input type="text" class="form-control" name="strDivName" id="strDivName" value="<?=!empty($this->session->userdata('strDivName'))?$this->session->userdata('strDivName'):''?>">
                                    <font color='red'> <span id="errorName"></span></font>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group3']?> Head<span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                      <select type="text" class="form-control" name="strDivHead" value="<?=!empty($this->session->userdata('strDivHead'))?$this->session->userdata('strDivHead'):''?>" required>
                                        <option value="">Select</option>
                                        <?php foreach($arrEmployees as $i=>$data): ?>
                                        <option value="<?=$data['empNumber']?>"><?=(strtoupper($data['surname']).', '.($data['firstname']).' '.($data['middleInitial']).' '.($data['nameExtension']))?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group3']?> Head Title<span class="required"> * </span></label>
                                <div class="input-icon right">
                                <i class="fa"></i>
                                    <input type="text" class="form-control" name="strDivHeadTitle" id="strDivHeadTitle" value="<?=!empty($this->session->userdata('strDivHeadTitle'))?$this->session->userdata('strDivHeadTitle'):''?>">
                                    <font color='red'> <span id="errorTitle"></span></font>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group3']?> Secretary</label>
                                <div class="input-icon right">
                                <i class="fa"></i>
                                  <select type="text" class="form-control" name="strDivSecretary" value="<?=!empty($this->session->userdata('strDivSecretary'))?$this->session->userdata('strDivSecretary'):''?>">
                                        <option value="">Select</option>
                                        <?php foreach($arrEmployees as $i=>$data): ?>
                                        <option value="<?=$data['empNumber']?>"><?=(strtoupper($data['surname']).', '.($data['firstname']).' '.($data['middleInitial']).' '.($data['nameExtension']))?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <button class="btn btn-success" type="submit"><i class="fa fa-plus"></i> Add</button>
                                <a href="<?=base_url('libraries/org_structure/  ')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
                            </div>
                        </div>
                    </div>
                </div>
               <?=form_close()?>
            </div>
        </div>
    </div>
</div>
            <!-- <table class="table table-striped table-bordered table-hover table-checkable order-column" id="libraries_org_structure">
                    <thead>
                        <tr>
                            <th> No. </th>
                            <th> Level 1 </th>
                            <th> Level 2 </th>
                            <th> Division Code </th>
                            <th> Division Name </th>
                            <th> Division Head Title</th>
                            <th> Division Head </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i=1;
                    foreach($arrDivision as $div):?>
                        <tr class="odd gradeX">
                            <td> <?=$i?> </td>
                            <td> <?=$div['group1Code']?> </td>
                            <td> <?=$div['group2Code']?> </td>   
                            <td> <?=$div['group3Code']?> </td>   
                            <td> <?=$div['group3Name']?> </td>   
                            <td> <?=$div['group3HeadTitle']?> </td>   
                            <td> <?=$div['surname'].' '.$div['firstname']?> </td>                            
                            <td>
                                <a href="<?=base_url('libraries/org_structure/edit_division/'.$div['group3Code'])?>"><button class="btn btn-sm btn-success"><span class="fa fa-edit" title="Edit"></span> Edit</button></a>
                                <a href="<?=base_url('libraries/org_structure/delete_division/'.$div['group3Code'])?>"><button class="btn btn-sm btn-danger"><span class="fa fa-edit" title="Delete"></span> Delete</button></a>
                            
                            </td>

                        </tr>
                    <?php 
                    $i++;
                    endforeach;?>
                    </tbody>
            </table> -->

<?php load_plugin('js',array('validation'));?>
<script type="text/javascript">
    jQuery.validator.addMethod("noSpace", function(value, element) { 
  return value.indexOf(" ") < 0 && value != ""; 
}, "No space please and don't leave it empty");
var FormValidation = function () {

    // validation using icons
    var handleValidation = function() {
        // for more info visit the official plugin documentation: 
            // http://docs.jquery.com/Plugins/Validation

            var form2 = $('#frmOrgStructure');
            var error2 = $('.alert-danger', form2);
            var success2 = $('.alert-success', form2);

            form2.validate({
                errorElement: 'span', //default input error message container
                errorClass: 'help-block help-block-error', // default input error message class
                focusInvalid: false, // do not focus the last invalid input
                ignore: "",  // validate all fields including form hidden input
                rules: {
                    strExecDivision: {
                        minlength: 1,
                        required: true
                    },
                    strSerDivision: {
                        minlength: 1,
                        required: true,
                    },
                    strDivCode: {
                        minlength: 1,
                        required: true,
                    },
                    strDivName: {
                        minlength: 1,
                        required: true,
                    },
                    strDivHead: {
                        minlength: 1,
                        required: true,
                    },
                    strDivHeadTitle: {
                        minlength: 1,
                        required: true,
                    }
                },

                invalidHandler: function (event, validator) { //display error alert on form submit              
                    success2.hide();
                    error2.show();
                    App.scrollTo(error2, -200);
                },

                errorPlacement: function (error, element) { // render error placement for each input type
                    var icon = $(element).parent('.input-icon').children('i');
                    icon.removeClass('fa-check').addClass("fa-warning");  
                    icon.attr("data-original-title", error.text()).tooltip({'container': 'body'});
                },

                highlight: function (element) { // hightlight error inputs
                    $(element)
                        .closest('.form-group').removeClass("has-success").addClass('has-error'); // set error class to the control group   
                },

                unhighlight: function (element) { // revert the change done by hightlight
                    
                },

                success: function (label, element) {
                    var icon = $(element).parent('.input-icon').children('i');
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success'); // set success class to the control group
                    icon.removeClass("fa-warning").addClass("fa-check");
                },

                submitHandler: function (form) {
                    success2.show();
                    error2.hide();
                    form[0].submit(); // submit the form
                }
            });


    }

    return {
        //main function to initiate the module
        init: function () {
            handleValidation();

        }

    };

}();

jQuery(document).ready(function() {
    FormValidation.init();
});
</script>
