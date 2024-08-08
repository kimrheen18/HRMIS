<?php 
/** 
Purpose of file:    PDS Update View
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
$pds_details = isset($arrrequest) ? explode(';',$arrrequest['requestDetails']) : array();

$hrmodule = isset($_GET['module']) ? $_GET['module'] == 'hr' ? 1 : 0 : 0;
// $form = $action == 'add' ? 'employee/leave/add_leave' : 'employee/leave/edit?req_id='.$arrrequest['requestID'];
$pds_type = count($pds_details) > 0 ? end($pds_details) : '';
?>
<?=load_plugin('css', array('datepicker','datatables','timepicker','select','select2'))?>
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
            <span>PDS Update</span>
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
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase">PDS Update</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="form-group">
                           <label class="control-label bold">Type of Profile : <span class="required"> * </span></label>
                                <select name="strProfileType" id="strProfileType" type="text" class="form-control bs-select form-required" <?=$action=='add'?'':'disabled'?>>
                                <option value="">-- SELECT PERSONAL DATA --</option>
                                <option value="Profile" <?=isset($arrrequest) ? ($pds_type == PDS_PROFILE ? 'selected' : '') : ''?>>
                                            Profile</option>
                                <option value="Family" <?=isset($arrrequest) ? ($pds_type == PDS_FAMILY ? 'selected' : '') : ''?>>
                                            Family Background (Parents/Spouse)</option>
                                <option value="Educational" <?=isset($arrrequest) ? ($pds_type == PDS_EDUC ? 'selected' : '') : isset($_GET['educ_id']) ? 'selected' : ''?>>
                                            Educational Attainment</option>
                                <option value="Trainings" <?=isset($arrrequest) ? ($pds_type == PDS_TRAIN ? 'selected' : '') : isset($_GET['tra_id']) ? 'selected' : ''?>>
                                            Trainings</option>
                                <option value="Examinations" <?=isset($arrrequest) ? ($pds_type == PDS_ELIGIBILITY ? 'selected' : '') : isset($_GET['exam_id']) ? 'selected' : ''?>>
                                            Eligibility</option>
                                <option value="Children" <?=isset($arrrequest) ? ($pds_type == PDS_CHILD ? 'selected' : '') : isset($_GET['child_id']) ? 'selected' : ''?>>
                                            Family Background (Children)</option>
                                <option value="Community" <?=isset($arrrequest) ? ($pds_type == PDS_TAX ? 'selected' : '') : ''?>>
                                            Community Tax Certification</option>
                                <option value="References" <?=isset($arrrequest) ? ($pds_type == PDS_REF ? 'selected' : '') : isset($_GET['ref_id']) ? 'selected' : ''?>>
                                            References</option>
                                <option value="Voluntary" <?=isset($arrrequest) ? ($pds_type == PDS_VOLUNTEER ? 'selected' : '') : isset($_GET['vol_id']) ? 'selected' : ''?>>
                                            Voluntary Works</option>
                                <option value="WorkExp" <?=isset($arrrequest) ? ($pds_type == PDS_WORKXP ? 'selected' : '') : isset($_GET['wxp_id']) ? 'selected' : ''?>>
                                            Work Experience</option>
                            </select>
                        </div>
                    </div>

                    <!-- Begin Profile -->
                    <?php $divprof_show = isset($arrrequest) ? ($pds_type == PDS_PROFILE) ? 1 : 0 : 0; ?>
                    <div id="divprof" <?=$divprof_show ? '' : 'hidden' ?>>
                        <?=$this->load->view('_profile.php',$divprof_show ? array('pds_details'=>$pds_details,'action'=>$action) : array())?>
                    </div>
                    <!-- End Profile -->

                    <!-- Begin Family -->
                    <?php $divfam_show = isset($arrrequest) ? ($pds_type == PDS_FAMILY) ? 1 : 0 : 0; ?>
                    <div id="divfam" <?=$divfam_show ? '' : 'hidden' ?>>
                        <?=$this->load->view('_family.php',$divfam_show ? array('pds_details'=>$pds_details,'action'=>$action) : array())?>
                    </div>
                    <!-- End Family -->

                    <!-- Begin Educational -->
                    <?php $diveduc_show = isset($arrrequest) ? ($pds_type == PDS_EDUC) ? 1 : 0 : 0; ?>
                    <div id="diveduc" <?=$diveduc_show ? '' : 'hidden' ?>>
                        <?=$this->load->view('_educational.php',$diveduc_show ? array('pds_details'=>$pds_details,'action'=>$action) : array())?>
                    </div>
                    <!-- End Educational -->

                    <!-- Begin Training -->
                    <?php $divtra_show = isset($arrrequest) ? ($pds_type == PDS_TRAIN) ? 1 : 0 : 0; ?>
                    <div class="row" id="divtra" <?=$divtra_show ? '' : 'hidden' ?>>
                        <?=$this->load->view('_training.php',$divtra_show ? array('pds_details'=>$pds_details,'action'=>$action) : array())?>
                    </div>
                    <!-- End Training -->

                    <!-- Begin Examinations -->
                    <?php $diveligib_show = isset($arrrequest) ? ($pds_type == PDS_ELIGIBILITY) ? 1 : 0 : 0; ?>
                    <div class="row" id="divexam" <?=$diveligib_show ? '' : 'hidden' ?>>
                        <?=$this->load->view('_examination.php',$diveligib_show ? array('pds_details'=>$pds_details,'action'=>$action) : array())?>
                    </div>
                    <!-- End Examinations -->

                    <!-- Begin Children -->
                    <?php $divchild_show = isset($arrrequest) ? ($pds_type == PDS_CHILD) ? 1 : 0 : 0; ?>
                    <div class="row" id="divchildren" <?=$divchild_show ? '' : 'hidden' ?>>
                        <?=$this->load->view('_children.php',$divchild_show ? array('pds_details'=>$pds_details,'action'=>$action) : array())?>
                    </div>
                    <!-- End Children -->

                    <!-- Begin Community -->
                    <?php $divcomm_show = isset($arrrequest) ? ($pds_type == PDS_TAX) ? 1 : 0 : 0; ?>
                    <div class="row" id="divcomm" <?=$divcomm_show ? '' : 'hidden' ?>>
                        <?=$this->load->view('_community.php',$divcomm_show ? array('pds_details'=>$pds_details,'action'=>$action) : array())?>
                    </div>
                    <!-- End Community -->

                    <!-- Begin References -->
                    <?php $divref_show = isset($arrrequest) ? ($pds_type == PDS_REF) ? 1 : 0 : 0; ?>
                    <div class="row" id="divref" <?=$divref_show ? '' : 'hidden' ?>>
                        <?=$this->load->view('_reference.php',$divref_show ? array('pds_details'=>$pds_details,'action'=>$action) : array())?>
                    </div>
                    <!-- End References -->

                    <!-- Begin Voluntary -->
                    <?php $divvol_show = isset($arrrequest) ? ($pds_type == PDS_VOLUNTEER) ? 1 : 0 : 0; ?>
                    <div class="row" id="divvol" <?=$divvol_show ? '' : 'hidden' ?>>
                        <?=$this->load->view('_voluntary.php',$divvol_show ? array('pds_details'=>$pds_details,'action'=>$action) : array())?>
                    </div>
                    <!-- End Voluntary -->

                    <!-- Begin WorkExp -->
                    <?php $divwxp_show = isset($arrrequest) ? ($pds_type == PDS_WORKXP) ? 1 : 0 : 0; ?>
                    <div class="row" id="divxp" <?=$divwxp_show ? '' : 'hidden' ?>>
                        <?=$this->load->view('_workexp.php',$divwxp_show ? array('pds_details'=>$pds_details,'action'=>$action) : array())?>
                    </div>
                    <!-- End WorkExp -->
                </div>
            </div>
        </div>
    </div>
</div>

<?=load_plugin('js',array('form_validation','datatables','datepicker','select','select2'));?>
<script type="text/javascript" src="<?=base_url('assets/js/pds_update.js')?>">
