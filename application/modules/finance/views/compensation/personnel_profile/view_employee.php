<?php
    $modulename = array('','HR','Financial','Officer','Executive','Employee');
    load_plugin('css',array('select','datepicker'));
    $this_page = $this->uri->segment(4);
    $month = isset($_GET['month']) ? $_GET['month'] : date('m');
    $yr = isset($_GET['yr']) ? $_GET['yr'] : date('Y');

    $datefrom = isset($_GET['datefrom']) ? $_GET['datefrom'] : date('Y-m').'-01';
    $dateto = isset($_GET['dateto']) ? $_GET['dateto'] : date('Y-m').'-'.cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

    $show_monyr = 0;
    $show_dates = 0;
?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <?php 
             $page_name = $this_page;
            $breadcrumbs = array();
            if($page_name == 'deduction_summary'):
                $page_name = 'Deduction Summary';
            elseif($page_name == 'premium_loan'):
                $page_name = 'Premium Loan';
            elseif($page_name == 'employee'):
                $page_name = 'Personnel Profile';
            endif;

            switch (check_module()):
                case 'hr officer':
                case 'finance':
                    $breadcrumbs = array('Home','Compensation',ucwords($page_name),getfullname($arrData['firstname'],$arrData['surname'],$arrData['middlename'],$arrData['middleInitial'],$arrData['nameExtension'],''));
                    break;
                default:
                    $breadcrumbs = array('Home','Compensation',ucwords($page_name));
                    break;
            endswitch;

            foreach($breadcrumbs as $key => $bc):
                echo '<li><span>'.$bc.'</span>';
                if($key != count($breadcrumbs)-1):
                    echo '<i class="fa fa-circle"></i>';
                endif;    
                echo '</li>';
            endforeach;
         ?>
    </ul>
</div>
<!-- END PAGE BAR -->
<br>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-dark">
                            <span class="caption-subject bold uppercase"> Compensation</span>
                        </div>
                    </div>
                    <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                    <div style="height: 560px;" id="div_hide"></div>
                    <div class="portlet-body"  id="employee_view" style="display: none">
                        <div class="row">
                            <div class="tabbable-line tabbable-full-width col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="<?=$this_page == 'employee' ? 'active' : ''?>">
                                        <a href="<?=base_url('finance/compensation/personnel_profile/employee/').$this->uri->segment(5)?>"> Personnel Profile </a>
                                    </li>
                                    <li class="<?=$this_page == 'income' ? 'active' : ''?>">
                                        <a href="<?=base_url('finance/compensation/personnel_profile/income/').$this->uri->segment(5)?>"> Income </a>
                                    </li>
                                    <li class="<?=$this_page == 'deduction_summary' ? 'active' : ''?>">
                                        <a href="<?=base_url('finance/compensation/personnel_profile/deduction_summary/').$this->uri->segment(5)?>"> Deduction Summary </a>
                                    </li>
                                    <li class="<?=$this_page == 'premium_loan' ? 'active' : ''?>">
                                        <a href="<?=base_url('finance/compensation/personnel_profile/premium_loan/').$this->uri->segment(5)?>"> Premiums/Loans </a>
                                    </li>
                                    <li class="<?=$this_page == 'remittances' ? 'active' : ''?>">
                                        <a href="<?=base_url('finance/compensation/personnel_profile/remittances/').$this->uri->segment(5)?>"> Remittances </a>
                                    </li>
                                    <?php if($_SESSION['sessUserLevel'] == '2'): ?>
                                        <li class="<?=($this_page == 'tax_details' or $this_page == 'edit_tax_details') ? 'active' : ''?>">
                                            <a href="<?=base_url('finance/compensation/personnel_profile/tax_details/').$this->uri->segment(5)?>"> Tax Details </a>
                                        </li>
                                        <li class="<?=$this_page == 'dtr' ? 'active' : ''?>">
                                            <a href="<?=base_url('finance/compensation/personnel_profile/dtr/').$this->uri->segment(5)?>"> DTR </a>
                                        </li>
                                        <li class="<?=$this_page == 'adjustments' ? 'active' : ''?>">
                                            <a href="<?=base_url('finance/compensation/personnel_profile/adjustments/').$this->uri->segment(5)?>"> Adjustments </a>
                                        </li>
                                    <?php else: if(check_module() == 'employee'): ?>
                                        <li class="<?=$this_page == 'reports' ? 'active' : ''?>">
                                            <a href="<?=base_url('finance/compensation/personnel_profile/reports/').$this->uri->segment(5)?>"> Reports </a>
                                        </li>
                                    <?php endif; endif; ?>
                                </ul>

                                <div class="tab-content">
                                    <div class="col-md-12" style="margin-bottom: 20px;" <?=$this->uri->segment(4)=='dtr'?'':'hidden'?>>
                                        <center>
                                            <?=form_open('', array('class' => 'form-inline', 'method' => 'get'))?>
                                                <input type="hidden" name="mode" value="<?=isset($_GET['mode']) ? $_GET['mode'] : check_module()?>">
                                                <div class="form-group" style="display: inline-flex;">
                                                    <label style="padding: 6px;">Date From</label>
                                                    <input class="form-control date-picker form-required" data-date-format="yyyy-mm-dd" name="datefrom" type="text" style="width: 140px !important;"
                                                            value="<?=$datefrom?>">
                                                </div>
                                                <div class="form-group" style="display: inline-flex;margin-left: 10px;">
                                                    <label style="padding: 6px;">Date To</label>
                                                    <input class="form-control date-picker form-required" data-date-format="yyyy-mm-dd" name="dateto" type="text" style="width: 140px !important;"
                                                            value="<?=$dateto?>">
                                                </div>
                                                &nbsp;
                                                <button type="submit" class="btn btn-primary" style="margin-top: -3px;">Search</button>
                                            <?=form_close()?>
                                        </center>
                                    </div>

                                    <div class="tab-pane fade active in" id="tab-profile">
                                        <?php
                                            if($this_page == 'employee'): include('_personnelProfile.php'); endif;
                                            if($this_page == 'income'): include('_income.php'); endif;
                                            if($this_page == 'deduction_summary'): include('_deduction_summary.php'); endif;
                                            if($this_page == 'premium_loan'): include('_premiumLoans.php'); endif;
                                            if($this_page == 'remittances'): include('_remittances.php'); endif;
                                            if($_SESSION['sessUserLevel'] == '2'):
                                                if($this_page == 'tax_details' or $this_page == 'edit_tax_details'): include('_tax_details.php'); endif;
                                                if($this_page == 'dtr'): $this->load->view('hr/attendance/attendance_summary/_dtr'); endif;
                                                if($this_page == 'adjustments'): include('_adjustments.php'); endif;
                                            endif;
                                            if($this_page == 'reports'): include('_reports.php'); endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php load_plugin('js',array('select','datepicker'));?>
<script>
    $(document).ready(function() {
        $('.loading-image, #div_hide').hide();
        $('#employee_view').show();

        $('.date-picker').datepicker();
        $('.date-picker').on('changeDate', function(){
            $(this).datepicker('hide');
        });
    });
</script>