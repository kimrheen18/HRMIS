<?php
    $modulename = array('','HR','Financial','Officer','Executive','Employee');
    load_plugin('css',array('select'));
    $this_page = $this->uri->segment(4);
    $arrData = $arrData[0];

    //$am_timein  = '08:00 AM';
    //$am_timeout = '12:00 PM';
    //$pm_timein  = '01:00 PM';
    //$pm_timeout = '05:00 PM';

    if($arrdtr201!=null):
        $arrdtr201 = $arrdtr201[0];
        $am_timein  = $arrdtr201['inAM']  == '' || $arrdtr201['inAM']  == '00:00:00' ? '-' : date('H:i A',strtotime($arrdtr201['inAM']));
        $am_timeout = $arrdtr201['outBreak'] == '' || $arrdtr201['outBreak'] == '00:00:00' ? '-' : date('H:i A',strtotime($arrdtr201['outBreak']));
        $pm_timein  = $arrdtr201['inBreak']  == '' || $arrdtr201['inBreak']  == '00:00:00' ? '-' : date('h:i A',strtotime($arrdtr201['inBreak']));
        $pm_timeout = $arrdtr201['outPM'] == '' || $arrdtr201['outPM'] == '00:00:00' ? '-' : date('h:i A',strtotime($arrdtr201['outPM']));
    endif;

?>
<!-- BEGIN PAGE BAR -->
<style>
    .tabbable-line > .nav-tabs > li > a {
        padding-left: 3px;
    }
</style>
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>201 File</span>
            <?=!in_array(check_module(),array('officer','employee','executive')) ? '<i class="fa fa-circle"></i>' : ''?>
        </li>
        <?php if(!in_array(check_module(),array('officer','employee','executive'))): ?>
        <li>
            <span>Personnel Profile</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span><?=getfullname($arrData['firstname'],$arrData['surname'],$arrData['middlename'],$arrData['middleInitial'],$arrData['nameExtension'])?></span>
        </li>
        <?php endif; ?>
    </ul>
</div>
<!-- END PAGE BAR -->
<br>
<div class="clearfix"></div>
<?php
   // print_r($arrdtr201);
?>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <i class="icon-user font-dark"></i>
                            <span class="caption-subject bold uppercase"> 201 File</span>
                        </div>
                    </div>
                    <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                    <div style="height: 560px;" id="div_hide"></div>
                    <div class="portlet-body"  id="employee_view" style="display: none">
                        <div class="row">
                            <div class="tab-pane active" id="tab_1_1">
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        <ul class="list-unstyled profile-nav">
                                            <li>
                                                <?php
                                                $strImageUrl = 'uploads/employees/'.$arrData['empNumber'].'.jpg';
                                                    if(file_exists($strImageUrl))
                                                    {
                                                        $strImage = base_url('uploads/employees/'.$arrData['empNumber'].'.jpg');
                                                    }
                                                    else 
                                                    {
                                                      $strImage = base_url('assets/images/DENR-LOGO.png');
                                                    }   
                                                    // $strImage = base_url('uploads/employees/'.$arrData['empNumber'].'.jpg');?>
                                                <img src="<?=$strImage?>" class="img-responsive pic-bordered" width="200px" alt="" />
                                                
                                                <?php if(check_module() == 'hr'): ?>
                                                    <a href="<?=base_url('hr/edit_image/'.$arrData['empNumber'])?>" class="btn dark btn-sm">
                                                            <i class="icon-ban"> </i> Edit Image</a>
                                                <?php endif; ?>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- begin 201 profile -->
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-9 profile-info">
                                                <h1 class="font-green sbold uppercase"><?=fix_fullname($arrData['firstname'],$arrData['surname'],$arrData['middlename'], $arrData['middleInitial'], $arrData['nameExtension'],'')?></h1>
                                                <div class="row">
                                                    <table class="table table-bordered table-striped">
                                                        <tbody>
                                                            <tr>
                                                                <td width="25%"><b>Employee Number</b></td>
                                                                <td width="25%"><?=$arrData['empNumber']?></td>
                                                                <td width="25%"><b>Employment Status</b></td>
                                                                <td width="25%"><?=$arrData['statusOfAppointment']?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Position </b></td>
                                                                <td><?=$arrData['positionDesc']?> - <?=$arrData['positionCode']?></td>
                                                                <td><b>Appointment </b></td>
                                                                <td><?=$arrData['appointmentDesc']?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><b>Office</b></td>
                                                                <!--<td colspan="3">office_name(employee_office($arrData['empNumber']))</td>-->
                                                                <td colspan="3"><?php echo $arrData['officecode']; ?> - <?php echo $arrData['sectionCode']; ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <div>
                                                        <button type="button" value="reportPDSupdate" class="btn blue" data-toggle="modal"
                                                            href="#print-preview-pds-modal">Print Personal Data Sheet</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="portlet sale-summary">
                                                    <div class="portlet-title">
                                                        <div class="caption font-red sbold"> DTR </div>
                                                    </div>
                                                    <div class="portlet-body">
                                                        <ul class="list-unstyled" style="line-height: 15px;">
                                                            <li>
                                                                <span class="sale-info"> LOG IN </span>
                                                                <span class="sale-num"><?=$am_timein?></span>
                                                            </li>
                                                            <li>
                                                                <span class="sale-info"> BREAK OUT </span>
                                                                <span class="sale-num"><?=$am_timeout?></span>
                                                            </li>
                                                            <li>
                                                                <span class="sale-info"> BREAK IN </span>
                                                                <span class="sale-num"><?=$pm_timein?></span>
                                                            </li>
                                                            <li>
                                                                <span class="sale-info"> LOG OUT </span>
                                                                <span class="sale-num"><?=$pm_timeout?></span>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="tabbable-line tabbable-custom-profile">
                                            <ul class="nav nav-tabs">
                                                <li class="active">
                                                    <a href="#personal_info" data-toggle="tab"> Personal Info </a>
                                                </li>
                                                <li>
                                                    <a href="#family_background" data-toggle="tab"> Family Background </a>
                                                </li>
                                                <li>
                                                    <a href="#education" data-toggle="tab"> Education </a>
                                                </li>
                                                <li>
                                                    <a href="#examination" data-toggle="tab"> Eligibility </a>
                                                </li>
                                                <li>
                                                    <a href="#work_experience" data-toggle="tab"> Work Experience </a>
                                                </li>
                                                <li>
                                                    <a href="#voluntary_work" data-toggle="tab"> Voluntary Work </a>
                                                </li>
                                                <li>
                                                    <a href="#trainings" data-toggle="tab"> Trainings </a>
                                                </li>
                                                <li>
                                                    <a href="#other_info" data-toggle="tab"> Other Information </a>
                                                </li>
                                                <li>
                                                    <a href="#position_details" data-toggle="tab"> Position Details </a>
                                                </li>
                                                <li>
                                                    <a href="#duties" data-toggle="tab"> Duties and Responsibilities </a>
                                                </li>
                                                <li>
                                                    <a href="#appoint_issued" data-toggle="tab"> Appointment Issued </a>
                                                </li>
                                                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                                    <li>
                                                        <a href="#emp_number" data-toggle="tab"> Employee Number </a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                            <div class="tab-content">
                                                
                                                <!-- begin personal info -->
                                                <div class="tab-pane active" id="personal_info" style="padding: 0 !important;position: relative;top: -20px;">
                                                    <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                                                        <div class="row">
                                                            <div class="col-md-12" style="padding: 0 30px 10px;">
                                                                <a class="btn green pull-right" data-toggle="modal" href="#editPersonal_modal">
                                                                    <i class="icon-pencil"></i> Edit Personal Info </a>
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="scroller" style="height:350px;" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                                                        <?php $this->load->view('_personal_view.php'); ?>
                                                    </div>
                                                </div>
                                                <!-- end personal info -->

                                                <!-- begin Family Background -->
                                                <div class="tab-pane " id="family_background">
                                                    <div class="scroller" style="height:350px;" data-always-visible="1" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                                                        <?php $this->load->view('_family_background_view.php'); ?>
                                                    </div>
                                                </div>
                                                <!-- end Family Background -->

                                                <!-- begin Education Bacgkround -->
                                                <div class="tab-pane " id="education">
                                                    <div class="scroller" style="height:350px;" data-always-visible="1" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                                                        <?php $this->load->view('_education_view.php'); ?>
                                                    </div>
                                                </div>
                                                <!-- end Education Bacgkround -->

                                                <!-- begin Examination -->
                                                <div class="tab-pane " id="examination">
                                                    <div class="scroller" style="height:350px;" data-always-visible="1" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                                                        <?php $this->load->view('_examination_view.php'); ?>
                                                    </div>
                                                </div>
                                                <!-- end Examination -->

                                                <!-- begin Work Experience -->
                                                <div class="tab-pane " id="work_experience">
                                                    <div class="scroller" style="height:350px;" data-always-visible="1" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                                                        <?php $this->load->view('_work_experience_view.php'); ?>
                                                    </div>
                                                </div>
                                                <!-- end Work Experience -->

                                                <!-- begin Voluntary Work -->
                                                <div class="tab-pane " id="voluntary_work">
                                                    <div class="scroller" style="height:350px;" data-always-visible="1" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                                                        <?php $this->load->view('_voluntary_work_view.php'); ?>
                                                    </div>
                                                </div>
                                                <!-- end Voluntary Work -->

                                                <!-- begin Trainings -->
                                                <div class="tab-pane " id="trainings">
                                                    <div class="scroller" style="height:350px;" data-always-visible="1" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                                                        <?php $this->load->view('_training_view.php'); ?>
                                                    </div>
                                                </div>
                                                <!-- end Trainings -->

                                                <!-- begin other info -->
                                                <div class="tab-pane " id="other_info">
                                                    <div class="scroller" style="height:350px;" data-always-visible="1" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                                                        <?php $this->load->view('_other_info_view.php'); ?>
                                                    </div>
                                                    </div>
                                                </div>
                                                <!-- end other info -->

                                                <!-- begin position details -->
                                                <div class="tab-pane " id="position_details">
                                                    <div class="scroller" style="height:350px;" data-always-visible="1" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                                                        <?php $this->load->view('_position_details_view.php'); ?>
                                                    </div>
                                                </div>
                                                <!-- end position details -->

                                                <!-- begin duties and responsibilities -->
                                                <div class="tab-pane " id="duties">
                                                    <div class="scroller" style="height:350px;" data-always-visible="1" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                                                        <?php $this->load->view('_duties_responsiblities_view.php'); ?>
                                                    </div>
                                                </div>
                                                <!-- end duties and responsibilities -->

                                                <!-- begin appointment issued -->
                                                <div class="tab-pane " id="appoint_issued">
                                                    <div class="scroller" style="height:350px;" data-always-visible="1" data-rail-visible="1" data-rail-color="red" data-handle-color="green">
                                                        <?php $this->load->view('_appointment_issue_view.php'); ?>
                                                    </div>
                                                </div>
                                                <!-- end appointment issued -->

                                                <!-- begin employee number -->
                                                <div class="tab-pane " id="emp_number">
                                                    <div style="height:350px;">
                                                        <?php $this->load->view('_empnumber_view.php'); ?>
                                                    </div>
                                                </div>
                                                <!-- end employee number -->
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end 201 profile -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- begin print-preview modal -->
<div id="print-preview-pds-modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" style="width: 75%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold">Personal Data Sheet</h4>
            </div>
            <div class="modal-body">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <embed src="<?=base_url('employee/reports/generate/?rpt=reportPDSupdate&empNumber='.$arrData['empNumber'])?>" frameborder="0" width="100%" height="500px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?=base_url('employee/reports/generate/?rpt=reportPDSupdate&empNumber='.$arrData['empNumber'])?>"
                    class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end print-preview modal -->

<?php load_plugin('js',array('select'));?>
<script>
    $(document).ready(function() {
        $('.loading-image, #div_hide').hide();
        $('#employee_view').show();

    });

 
</script>