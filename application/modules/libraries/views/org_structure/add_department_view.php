<?php 
/** 
Purpose of file:    Add page for Org Structure Library
Author:             Francis Nikko V. Perez
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
            <span>Add <?=$_ENV['Group5']?> Name</span>
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
                    <span class="caption-subject bold uppercase"> Add <?=$_ENV['Group5']?> Name</span>
                </div>
                
            </div>
            <div class="portlet-body">
            <?=form_open(base_url('libraries/org_structure/add_department'), array('method' => 'post', 'id' => 'frmOrgStructure'))?>
                <div class="form-body">
                    <?php //print_r($arrPost);?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group1']?> <span class="required"> * </span></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                  <select type="text" class="form-control" name="strExec" value="<?=!empty($this->session->userdata('strExec'))?$this->session->userdata('strExec'):''?>" required>
                                        
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
                                <label class="control-label"><?=$_ENV['Group2']?><!-- <span class="required"> * </span> --></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <!-- required -->
                                    <select type="text" class="form-control" name="strService" value="<?=!empty($this->session->userdata('strService'))?$this->session->userdata('strService'):''?>" >
                                        
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
                                <label class="control-label"><?=$_ENV['Group3']?> <!-- <span class="required"> * </span> --></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <!-- required -->
                                     <select type="text" class="form-control" name="strDivision" value="<?=!empty($this->session->userdata('strDivision'))?$this->session->userdata('strDivision'):''?>" >
                                        
                                         <option value="">Select</option>
                                        <?php foreach($arrDivision as $div)
                                        {
                                          echo '<option value="'.$div['group3Code'].'">'.$div['group3Name'].'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group4']?> <!-- <span class="required"> * </span> --></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <!-- required -->
                                     <select type="text" class="form-control" name="strSection" value="<?=!empty($this->session->userdata('strSection'))?$this->session->userdata('strSection'):''?>" >
                                        
                                         <option value="">Select</option>
                                        <?php foreach($arrSection as $sec)
                                        {
                                          echo '<option value="'.$sec['group4Code'].'">'.$sec['group4Name'].'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group5']?> Code <span class="required"> * </span></label>
                                <div class="input-icon right">
                                <i class="fa"></i>
                                    <input type="text" class="form-control" name="strDeptCode" id="strDeptCode" value="<?=!empty($this->session->userdata('strDeptCode'))?$this->session->userdata('strDeptCode'):''?>">
                                    <font color='red'> <span id="errorCode"></span></font>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group5']?> Name <span class="required"> * </span></label>
                                <div class="input-icon right">
                                <i class="fa"></i>
                                    <input type="text" class="form-control" name="strDeptName" id="strDeptName" value="<?=!empty($this->session->userdata('strDeptName'))?$this->session->userdata('strDeptName'):''?>">
                                    <font color='red'> <span id="errorName"></span></font>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group5']?> Head<!-- <span class="required"> * </span> --></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <!-- required -->
                                      <select type="text" class="form-control" name="strDeptHead" value="<?=!empty($this->session->userdata('strDeptHead'))?$this->session->userdata('strDeptHead'):''?>" >
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
                                <label class="control-label"><?=$_ENV['Group5']?> Head Title<!-- <span class="required"> * </span> --></label>
                                <div class="input-icon right">
                                <i class="fa"></i>
                                    <input type="text" class="form-control" name="strDeptHeadTitle" id="strDeptHeadTitle"  value="<?=!empty($this->session->userdata('strDeptHeadTitle'))?$this->session->userdata('strDeptHeadTitle'):''?>">
                                    <font color='red'> <span id="errorTitle"></span></font>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label"><?=$_ENV['Group5']?> Secretary</label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                  <select type="text" class="form-control" name="strDeptSecretary" value="<?=!empty($this->session->userdata('strDeptSecretary'))?$this->session->userdata('strDeptSecretary'):''?>">
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
                                <a href="<?=base_url('libraries/org_structure')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
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
                            <th> Level 3 </th>
                            <th> Section Code </th>
                            <th> Section Name </th>
                            <th> Section Head Title</th>
                            <th> Section Head </th>
                            <th> Action </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $i=1;
                    foreach($arrSection as $section):?>
                        <tr class="odd gradeX">
                            <td> <?=$i?> </td>
                            <td> <?=$section['group1Code']?> </td>
                            <td> <?=$section['group2Code']?> </td> 
                            <td> <?=$section['group3Code']?> </td>   
                            <td> <?=$section['group4Code']?> </td>   
                            <td> <?=$section['group4Name']?> </td>   
                            <td> <?=$section['group4HeadTitle']?> </td>   
                            <td> <?=$section['surname'].' '.$section['firstname']?> </td>                                        
                            <td>
                                <a href="<?=base_url('libraries/org_structure/edit_section/'.$section['group4Code'])?>"><button class="btn btn-sm btn-success"><span class="fa fa-edit" title="Edit"></span> Edit</button></a>
                                <a href="<?=base_url('libraries/org_structure/delete_section/'.$section['group4Code'])?>"><button class="btn btn-sm btn-danger"><span class="fa fa-edit" title="Delete"></span> Delete</button></a>
                             
                            </td>

                        </tr>
                    <?php 
                    $i++;
                    endforeach;?>
                    </tbody>
            </table>
 -->
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
                    strSecCode: {
                        minlength: 1,
                        required: true,
                    },
                    strSecName: {
                        minlength: 1,
                        required: true,
                    },
                    strSecHead: {
                        minlength: 1,
                        required: true,
                    },
                    strSecHeadTitle: {
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
