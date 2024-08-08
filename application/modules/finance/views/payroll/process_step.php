<?=load_plugin('css', array('select','select2','datepicker'));$page = $this->uri->segment(3);?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Reports</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Monthly Report</span>
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
<div class="row profile-account">
    <div class="col-md-12">
        <div class="portlet light bordered" id="form_wizard_1">
            <div class="portlet-title">
                <div class="caption">
                    <i class=" icon-layers font-red"></i>
                    <span class="caption-subject font-red bold uppercase"> Process Payroll -
                        <span class="step-title"> 
                            <?php 
                                switch ($page):
                                    case 'process':
                                        echo 'STEP 1 OF 4';
                                        break;
                                    case 'select_benefits_perm':
                                    case 'select_benefits_nonperm':
                                    case 'select_benefits_nonperm_trc':
                                        echo 'STEP 2 OF 4';
                                        break;
                                    case 'compute_benefits_perm':
                                    case 'save_benefits_perm':
                                    case 'compute_benefits_nonperm_trc':
                                        echo 'STEP 2 OF 4';
                                        break;
                                    case 'select_deductions_perm':
                                    case 'select_deductions_nonperm':
                                    case 'select_deduction_nonperm_trc':
                                        echo 'STEP 3 OF 4';
                                        break;
                                    case 'reports':
                                        echo 'STEP 4 OF 4';
                                        break;
                                endswitch;
                             ?>
                        </span>
                    </span>
                </div>
            </div>
            <div class="portlet-body form">
                <div class="form-wizard">
                    <div class="form-body">
                        <ul class="nav nav-pills nav-justified steps">
                            <li class="<?=$page=='process'?'active':''?>">
                                <a href="#tab1" data-toggle="tab" class="step">
                                    <span class="number"> 1 </span><br>
                                    <span class="desc">
                                        <i class="fa fa-check"></i> Payroll Period </span>
                                </a>
                            </li>
                            <li class="<?=in_array($page,array('select_benefits_perm','compute_benefits_perm','save_benefits_perm','computation_nonperm','select_benefits_nonperm','select_benefits_nonperm_trc','compute_benefits_nonperm_trc'))?'active':''?>">
                                <a href="#tab2" data-toggle="tab" class="step">
                                    <span class="number"> 2 </span><br>
                                    <span class="desc">
                                        <i class="fa fa-check"></i> Income </span>
                                </a>
                            </li>
                            <li class="<?=in_array($page,array('select_deductions_perm','select_deductions_nonperm','select_deduction_nonperm_trc'))?'active':''?>">
                                <a href="#tab3" data-toggle="tab" class="step">
                                    <span class="number"> 3 </span><br>
                                    <span class="desc">
                                        <i class="fa fa-check"></i> Deductions </span>
                                </a>
                            </li>
                            <li class="<?=$page=='reports'?'active':''?>">
                                <a href="#tab5" data-toggle="tab" class="step">
                                    <span class="number"> 4 </span><br>
                                    <span class="desc">
                                        <i class="fa fa-check"></i> Reports </span>
                                </a>
                            </li>
                        </ul>
                        <div id="bar" class="progress progress-striped" role="progressbar">
                            <div class="progress-bar progress-bar-success"> </div>
                        </div>
                        <!-- begin form -->
                        <?php 
                            switch ($page):
                                case 'process':
                                    $this->load->view('process/_step1-payroll_period');
                                    break;
                                case 'select_benefits_perm':
                                case 'select_benefits_nonperm':
                                case 'select_benefits_nonperm_trc':
                                    $this->load->view('process/_step2-select_benefits_perm');
                                    break;
                                case 'compute_benefits_perm':
                                case 'save_benefits_perm':
                                case 'computation_nonperm':
                                case 'compute_benefits_nonperm_trc':
                                    if($employment_type == 'P'):
                                        $this->load->view('process/_step2-compute_benefits_perm');
                                    else:
                                        $this->load->view('process/_step2-compute_benefits_cont');
                                    endif;
                                    break;
                                case 'select_deductions_perm':
                                case 'select_deductions_nonperm':
                                case 'select_deduction_nonperm_trc':
                                    $this->load->view('process/_step3-select_deductions_perm');
                                    break;
                                case 'reports':
                                    $this->load->view('process/_step4-reports');
                                    break;
                                default:
                                    # code...
                                    break;
                            endswitch;
                            ?>
                        <!-- end form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?=load_plugin('js', array('select','select2','form-wizard','datepicker','form_validation'))?>