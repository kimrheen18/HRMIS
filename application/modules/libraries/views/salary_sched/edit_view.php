<?php 
/** 
Purpose of file:    Edit page for Salary Schedule Library
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<!-- BEGIN PAGE BAR -->
<?php load_plugin('css',array('datepicker','datatables'));?>

<div class="row">

    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Edit Salary Schedule</span>
                </div>
            </div>
            <?=form_open(base_url('libraries/salary_sched/edit'), array('method' => 'post', 'id' => 'frmSalary', 'name' => 'frmSalary','onSubmit'=>'return checkonsubmit();'))?>
            <div class="form-body">
               <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label"><b>Version :</b></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    
                                     <select type="text" class="form-control" name="intVersion" value="<?=!empty($this->session->userdata('intVersion'))?$this->session->userdata('intVersion'):''?>">
                                         <option value="">Select</option>

                                        <?php foreach($arrVersion as $version)
                                        {
                                          echo '<option value="'.$version['version'].'" '.($version['version']==$arrSalarySched[0]['version']?'selected':'').'>'.$version['version'].'</option>';
                                        }?>
                                  </select>
                                </div>
                            </div>
                        </div>
                    </div>
                 <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label"><b>Salary Grade Number:</b></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <select type="text" class="form-control" name="strSG" value="<?=!empty($this->session->userdata('strSG'))?$this->session->userdata('strSG'):''?>">
                                        <option value="">Select</option>
                                        <?php foreach($arrSG as $sg)
                                        {
                                          echo '<option value="'.$sg['salaryGradeNumber'].'" '.($sg['salaryGradeNumber']==$arrSalarySched[0]['salaryGradeNumber']?'selected':'').'>'.$sg['salaryGradeNumber'].'</option>';
                                        }?>
                            
                                  </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label"><b>Step Number:</b></label>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <select type="text" class="form-control" name="intStepNum" value="<?=!empty($this->session->userdata('intStepNum'))?$this->session->userdata('intStepNum'):''?>">
                                        <option value="">Select</option>
                                        <?php foreach($arrStep as $step)
                                        {
                                          echo '<option value="'.$step['stepNumber'].'" '.($step['stepNumber']==$arrSalarySched[0]['stepNumber']?'selected':'').'>'.$step['stepNumber'].'</option>';
                                        }?>
                                  </select>
                                </div>
                            </div>
                        </div>
                    </div>
                <div class="row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="control-label"><b>Actual Salary:</b></label>
                                 <div>
                                    <font size="2" color="blue">(Note : Do not put comma (,) )</font>
                                </div>
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input type="text" class="form-control" name="intActualSalary" value="<?=$arrSalarySched[0]['actualSalary']?>">
                                </div>
                            </div>
                        </div>
                    </div>
                <br>
                 
                     <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" name="stepNum" value="<?=$arrSalarySched[0]['stepNumber']?>">
                                <input type="hidden" name="SG" value="<?=$arrSalarySched[0]['salaryGradeNumber']?>">
                                <input type="hidden" name="ver" value="<?=$arrSalarySched[0]['version']?>">
                                <button class="btn btn-success" type="submit"><i class="icon-check"></i> Save</button>
                                <a href="<?=base_url('libraries/salary_sched')?>"><button class="btn btn-primary" type="button"><i class="icon-ban"></i> Cancel</button></a>
                            </div>
                        </div>
                    </div>
                    </div>

                </div>

            </div>
            <?=form_close();?>   
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<?php load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#libraries_salary_sched').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#libraries_salary_sched').css('visibility', 'visible');
            }} );
        $("#updateSalary").click(function(){
           
            var x=confirm("Warning: This will update Plantilla library and salaries of employees. Do you want to continue?");
            if (!x) return;
            var vid=$("#version").val();
            $("#updatediv").html("checking <img src='../images/indicator.gif'>  ");
            $("#updatediv").load("salary_sched.php?strEmpNmbr=<? echo $strEmpNmbr;?>&mode=updatesalary&version="+vid);
        
            });

    
        // $('form[name="frmSalary"]').on('submit',function(e){
            
        // });
});


// function checkonsubmit()
// {
//     alert('aa');
//     $("form[name='frmSalary'] input").each(function(){
//       $this = $(this);
//       inputObj[$this.id] = $this.val();
//     });
//     console.log(inputObj);
//     alert(inputObj);
//     //e.preventDefault();
//     return false;
// }
</script>


<!--  -->