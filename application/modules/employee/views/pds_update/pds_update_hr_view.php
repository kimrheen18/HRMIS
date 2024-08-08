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
                            <?php 
                                switch (end($pds_details)):
                                    case PDS_PROFILE:
                                        echo '<label class="form-control">Profile</label>';
                                        break;
                                    case PDS_FAMILY:
                                        echo '<label class="form-control">Family Background (Parents/Spouse)</label>';
                                        break;
                                    case PDS_EDUC:
                                        echo '<label class="form-control">Educational Attainment</label>';
                                        break;
                                    case PDS_TRAIN:
                                        echo '<label class="form-control">Trainings</label>';
                                        break;
                                    case PDS_ELIGIBILITY:
                                        echo '<label class="form-control">Eligibility</label>';
                                        break;
                                    case PDS_CHILD:
                                        echo '<label class="form-control">Family Background (Children)</label>';
                                        break;
                                    case PDS_TAX:
                                        echo '<label class="form-control">Community Tax Certification</label>';
                                        break;
                                    case PDS_REF:
                                        echo '<label class="form-control">References</label>';
                                        break;
                                    case PDS_VOLUNTEER:
                                        echo '<label class="form-control">Voluntary Works</label>';
                                        break;
                                    case PDS_WORKXP:
                                        echo '<label class="form-control">Work Experience</label>';
                                        break;
                                endswitch;
                             ?>
                        </div>
                    </div>

                    <!-- Begin Profile -->
                    <?php $divprof_show = $pds_type != '' ? ($pds_type == PDS_PROFILE ? 1 : 0) : 0; ?>
                    <div id="divprof" <?=$divprof_show ? '' : 'hidden' ?> style="margin-top: 85px !important;">
                        <?=$this->load->view('view/_profile.php',$divprof_show ? array('pds_details'=>$pds_details) : array())?>
                    </div>
                    <!-- End Profile -->

                    <!-- Begin Family Background -->
                    <?php $divfam_show = $pds_type != '' ? ($pds_type == PDS_FAMILY ? 1 : 0) : 0; ?>
                    <div id="divprof" <?=$divfam_show ? '' : 'hidden' ?> style="margin-top: 85px !important;">
                        <?=$this->load->view('view/_family.php',$divfam_show ? array('pds_details'=>$pds_details) : array())?>
                    </div>
                    <!-- End Family Background -->

                    <!-- Begin Educational -->
                    <?php $diveduc_show = $pds_type != '' ? ($pds_type == PDS_EDUC ? 1 : 0) : 0; ?>
                    <div id="diveduc" <?=$diveduc_show ? '' : 'hidden' ?> style="margin-top: 85px !important;">
                        <?=$this->load->view('view/_education.php',$diveduc_show ? array('pds_details'=>$pds_details,'emp_educ'=>$emp_educ) : array())?>
                    </div>
                    <!-- End Educational -->

                    <!-- Begin Training -->
                    <?php $divtra_show = $pds_type != '' ? ($pds_type == PDS_TRAIN) ? 1 : 0 : 0; ?>
                    <div id="divtra" <?=$divtra_show ? '' : 'hidden' ?> style="margin-top: 85px !important;">
                        <?=$this->load->view('view/_training.php',$divtra_show ? array('pds_details'=>$pds_details,'emp_tra'=>$emp_tra) : array())?>
                    </div>
                    <!-- End Training -->

                    <!-- Begin Examinations -->
                    <?php $diveligib_show = $pds_type != '' ? ($pds_type ==  PDS_ELIGIBILITY) ? 1 : 0 : 0; ?>
                    <div id="divexam" <?=$diveligib_show ? '' : 'hidden' ?> style="margin-top: 85px !important;">
                        <?=$this->load->view('view/_examination.php',$diveligib_show ? array('pds_details'=>$pds_details,'emp_exam'=>$emp_exam) : array())?>
                    </div>
                    <!-- End Examinations -->

                    <!-- Begin Children -->
                    <?php $divchild_show = $pds_type != '' ? ($pds_type ==  PDS_CHILD) ? 1 : 0 : 0; ?>
                    <div id="divchildren" <?=$divchild_show ? '' : 'hidden' ?> style="margin-top: 85px !important;">
                        <?=$this->load->view('view/_children.php',$divchild_show ? array('pds_details'=>$pds_details,'emp_child'=>$emp_child) : array())?>
                    </div>
                    <!-- End Children -->

                    <!-- Begin Community -->
                    <?php $divcomm_show = $pds_type != '' ? ($pds_type ==  PDS_TAX) ? 1 : 0 : 0; ?>
                    <div id="divcomm" <?=$divcomm_show ? '' : 'hidden' ?> style="margin-top: 85px !important;">
                        <?=$this->load->view('view/_community.php',$divcomm_show ? array('pds_details'=>$pds_details) : array())?>
                    </div>
                    <!-- End Community -->

                    <!-- Begin References -->
                    <?php $divref_show = $pds_type != '' ? ($pds_type ==  PDS_REF) ? 1 : 0 : 0; ?>
                    <div id="divref" <?=$divref_show ? '' : 'hidden' ?> style="margin-top: 85px !important;">
                        <?=$this->load->view('view/_reference.php',$divref_show ? array('pds_details'=>$pds_details,'emp_ref'=>$emp_ref) : array())?>
                    </div>
                    <!-- End References -->

                    <!-- Begin Voluntary -->
                    <?php $divvol_show = $pds_type != '' ? ($pds_type ==  PDS_VOLUNTEER) ? 1 : 0 : 0; ?>
                    <div id="divvol" <?=$divvol_show ? '' : 'hidden' ?> style="margin-top: 85px !important;">
                        <?=$this->load->view('view/_voluntary.php',$divvol_show ? array('pds_details'=>$pds_details,'emp_vol'=>$emp_vol) : array())?>
                    </div>
                    <!-- End Voluntary -->

                    <!-- Begin WorkExp -->
                    <?php $divwxp_show = $pds_type != '' ? ($pds_type ==  PDS_WORKXP) ? 1 : 0 : 0; ?>
                    <div id="divxp" <?=$divwxp_show ? '' : 'hidden' ?> style="margin-top: 85px !important;">
                        <?=$this->load->view('view/_workexp.php',$divwxp_show ? array('pds_details'=>$pds_details,'emp_wxp'=>$emp_wxp) : array())?>
                    </div>
                    <!-- End WorkExp -->
                </div>
            </div>
        </div>
    </div>
</div>
