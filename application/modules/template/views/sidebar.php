<?php 
# set active for menu highlight
$active=$this->uri->segment(1)!=''?$this->uri->segment(1):'home';
$active = strtolower($active);
# set activesub for submenu highlight
$activesub=$this->uri->segment(2)!=''?$this->uri->segment(2):'';
$activesub = strtolower($activesub);
$activetab=$this->uri->segment(3)!=''?$this->uri->segment(3):'';
$activetab = strtolower($activetab);

$user_session = $this->session->userdata();
?>
<!-- <pre> -->
    <!-- <?php 
        echo '<br>active = '.$active;
        echo '<br>activesub = '.$activesub;
        echo '<br>activetab = '.$activetab;
     ?> -->
<!-- </pre> -->
<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper hide">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler"> </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <!-- <li class="heading"><h3 class="uppercase"><?=$this->session->userdata('sessUserPermission')?></h3></li> -->
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <?php if(in_array($this->session->userdata('sessUserLevel'), array(1,2))):?>
                <li class="sidebar-search-wrapper">
                    <!-- DISPLAY MODULE -->
                    
                    <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                    <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                    <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                    <!-- <form class="sidebar-search  " action="<?=base_url('hr/search')?>" method="POST">
                        <a href="javascript:;" class="remove">
                            <i class="icon-close"></i>
                        </a>
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search..." name="strSearch" autocomplete="off">
                            <span class="input-group-btn">
                                <a href="javascript:;" class="btn submit">
                                    <i class="icon-magnifier"></i>
                                </a>
                            </span>
                        </div>
                    </form> -->
                    <!-- END RESPONSIVE QUICK SEARCH FORM -->
                </li>
            <?php endif;?>

            <!-- begin hr module -->
            <?php if(check_module() == 'hr'):?>
                <li class="heading">
                    <h3 class="uppercase"><?=strtoupper(userlevel($this->session->userdata('sessUserLevel')))?> Module</h3>
                </li>
                <li class="nav-item start <?=$active=='home'?'active open':''?>">
                    <a href="<?=base_url('home')?>" class="nav-link nav-toggle">
                        <i class="icon-home"></i>
                        <span class="title">Dashboard</span>
                    </a>                            
                </li>
                <?php if($user_session['sessIsAssistant'] == 0 || ($user_session['sessIsAssistant'] == 1 && (strpos($user_session['sessAccessPermission'], '2') !== false))): ?>
                    <li class="nav-item <?=$active=='pds' || ($active=='hr' && $activesub=='add_employee') || ($active=='hr' && $activesub=='profile') ? 'active' : ''?>">
                        <a href="<?=base_url('pds')?>" class="nav-link nav-toggle">
                            <i class="icon-user"></i>
                            <span class="title">201 File</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if($user_session['sessIsAssistant'] == 0 || ($user_session['sessIsAssistant'] == 1 && (strpos($user_session['sessAccessPermission'], '3') !== false))): ?> 
                    <li class="nav-item <?=$activesub=='attendance' || $activesub=='attendance_summary'?'active open':''?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">Attendance</span>
                            <span class="arrow <?=$activesub=='attendance' || $activesub=='attendance_summary'?'open':''?>"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item <?=$active=='hr' && ($activesub=='attendance_summary' && in_array($activetab, array('index','leave_balance','leave_monetization','filed_request','dtr','qr_code','leave_balance_set','leave_balance_update')) || ($activesub=='attendance' && in_array($activetab, array('view_all','dtrlogs','flag_ceremony','employees_inc_dtr','employees_leave_balance')))) ? 'active open' : ''?>">
                                <a href="<?=base_url('hr/attendance/view_all')?>">
                                    <span class="title">Attendance Summary</span>
                                </a>
                            </li>
                            <li class="nav-item <?=$activetab=='override'?'active open':''?>">
                                <a href="<?=base_url('hr/attendance/override/ob')?>">
                                    <span class="title">Override</span>
                                </a>
                            </li>
                            <li class="nav-item <?=$activetab=='conversion_table'?'active open':''?>">
                                <a href="<?=base_url('hr/attendance/conversion_table')?>">
                                    <span class="title">Conversion Table</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if($user_session['sessIsAssistant'] == 0 || ($user_session['sessIsAssistant'] == 1 && (strpos($user_session['sessAccessPermission'], '4') !== false))): ?> 
                    <li class="nav-item <?=$active == 'hr' && $activesub == 'reports' ? 'active' : '' ?> ">
                         <a href="<?=base_url('hr/reports')?>" class="nav-link nav-toggle">
                            <i class="icon-docs"></i>
                            <span class="title">Reports</span>
                        </a>                            
                    </li>
                <?php endif; ?>

                <?php if($user_session['sessIsAssistant'] == 0 || ($user_session['sessIsAssistant'] == 1 && (strpos($user_session['sessAccessPermission'], '1') !== false))): ?>
                    <li class="nav-item <?=($active == 'hr' && $activesub == 'request') || ($active == 'employee' && in_array($activesub, array('official_business','leave','travel_order','pds_update','leave_monetization'))) ? 'active' : '' ?> ">
                         <a href="<?=base_url('hr/request?request=ob')?>" class="nav-link nav-toggle">
                            <i class="icon-doc"></i>
                            <span class="title">Request</span>
                        </a>                            
                    </li>
                <?php endif; ?>
                
                <?php if($user_session['sessIsAssistant'] == 0 || ($user_session['sessIsAssistant'] == 1 && (strpos($user_session['sessAccessPermission'], '5') !== false))): ?> 
                    <li class="nav-item <?=$active=='libraries' || ($activesub=='libraries' && $activetab=='signatory') ?'active open':''?>">
                        <a href="<?=base_url('libraries')?>" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">Libraries</span>
                            <span class="arrow <?=$active=='libraries' || ($activesub=='libraries' && $activetab=='signatory')?'open':''?>"></span>
                        </a>
                        <ul class="sub-menu">
                            <?php 
                                //get library menu item from menu_helper
                                $signatory_url = $_SESSION['sessUserLevel'] == 1 ? 'hr/libraries/signatory' : 'finance/libraries/signatory';
                                $arrMenu = get_libraries();
                                foreach($arrMenu as $i=>$menuItem):
                                    $baseurl = ($i=="signatories") ? $signatory_url : 'libraries/'.$i;
                                    if($i!="signatories"):?>
                                        <li class="nav-item start <?=$activesub==$i?'active':''?>">
                                            <a href="<?=base_url('libraries/'.$i)?>" class="nav-link ">
                                                <span class="title"><?=$menuItem?></span>
                                            </a>
                                        </li><?php
                                    else:?>
                                        <li class="nav-item start <?=$active=='hr' && $activesub=='libraries' && $activetab=='signatory' ? 'active' : ''?>">
                                            <a href="<?=base_url($signatory_url)?>" class="nav-link ">
                                                <span class="title"><?=$menuItem?></span>
                                            </a>
                                        </li><?php
                                    endif;
                                endforeach; ?>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if($user_session['sessIsAssistant'] == 0 || ($user_session['sessIsAssistant'] == 1 && (strpos($user_session['sessAccessPermission'], '6') !== false))): ?> 
                    <li class="nav-item <?=$activetab=='personnel_profile'?'active open':''?>">
                        <a href="<?=base_url('finance/compensation/personnel_profile')?>">
                            <i class="icon-wallet"></i>
                            <span class="title">Compensation</span>
                        </a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <!-- end hr module -->

            <!-- begin finance module -->
            <?php if($this->session->userdata('sessUserLevel')==2):?>
                <li class="heading">
                    <h3 class="uppercase"><?=strtoupper(userlevel($this->session->userdata('sessUserLevel')))?> Module</h3>
                </li>
                <?php if($user_session['sessIsAssistant'] == 0 || ($user_session['sessIsAssistant'] == 1 && (strpos($user_session['sessAccessPermission'], '1') !== false))): ?>
                    <li class="nav-item <?=$activesub=='notifications'?'active open':''?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-bell"></i>
                            <span class="title">Notifications</span>
                            <span class="arrow <?=$activesub=='notifications'?'open':''?>"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item <?=$activetab=='npayroll'?'active open':''?>">
                                <a href="<?=base_url('finance/notifications/npayroll')?>">
                                    <span class="title">Included in Payroll</span>
                                </a>
                            </li>
                            <li class="nav-item <?=$activetab=='matureloans'?'active open':''?>">
                                <a href="<?=base_url('finance/notifications/matureloans')?>">
                                    <span class="title">Maturing Loans</span>
                                </a>
                            </li>
                            <li class="nav-item <?=$activetab=='nlongi'?'active open':''?>">
                                <a href="<?=base_url('finance/notifications/nlongi')?>">
                                    <span class="title">Increase in Longevity Factor</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if($user_session['sessIsAssistant'] == 0 || ($user_session['sessIsAssistant'] == 1 && (strpos($user_session['sessAccessPermission'], '3') !== false))): ?>
                    <li class="nav-item <?=$activetab=='personnel_profile'?'active open':''?>">
                        <a href="<?=base_url('finance/compensation/personnel_profile')?>">
                            <i class="icon-wallet"></i>
                            <span class="title">Compensation</span>
                        </a>
                    </li>
                <?php endif; ?>

                <?php if($user_session['sessIsAssistant'] == 0 || ($user_session['sessIsAssistant'] == 1 && (strpos($user_session['sessAccessPermission'], '5') !== false))): ?>
                    <li class="nav-item <?=$activesub=='payroll_update'?'active open':''?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-docs"></i>
                            <span class="title">Update</span>
                            <span class="arrow <?=$activesub=='payroll_update'?'open':''?>"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item start <?=$activesub == 'payroll_update' && in_array($activetab, array('process','select_benefits_perm','compute_benefits_perm','save_benefits_perm','select_deductions_perm')) ?'active open':''?>">
                                <a href="<?=base_url('finance/payroll_update/process')?>">
                                    <span class="title">Process Payroll</span>
                                </a>
                            </li>
                            <li class="nav-item start <?=$activesub=='payroll_update' && $activetab=='process_history'?'active open':''?>">
                                <a href="<?=base_url('finance/payroll_update/process_history')?>">
                                    <span class="title">Process History</span>
                                </a>
                            </li>
                            <li class="nav-item start <?=$activesub =='payroll_update' && in_array($activetab, array('update_or','view_or'))?'active open':''?>">
                                <a href="<?=base_url('finance/payroll_update/view_or')?>">
                                    <span class="title">OR Remittances</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if($user_session['sessIsAssistant'] == 0 || ($user_session['sessIsAssistant'] == 1 && (strpos($user_session['sessAccessPermission'], '2') !== false))): ?>
                    <li class="nav-item <?=$activesub=='reports'?'active open':''?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-docs"></i>
                            <span class="title">Reports</span>
                            <span class="arrow <?=$activesub=='reports'?'open':''?>"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item <?=$activetab=='monthlyreports'?'active open':''?>">
                                <a href="<?=base_url('finance/reports/monthlyreports?month='.date("m").'&yr='.date("Y").'&appt=&processid=&period=')?>">
                                    <span class="title">Monthly Reports</span>
                                </a>
                            </li>
                            <li class="nav-item <?=$activetab=='remittance'?'active open':''?>">
                                <a href="<?=base_url('finance/reports/remittance')?>">
                                    <span class="title">Employee Remittances</span>
                                </a>
                            </li>
                            <li class="nav-item <?=$activetab=='loanbalance'?'active open':''?>">
                                <a href="<?=base_url('finance/reports/loanbalance')?>">
                                    <span class="title">Employee Loan balance</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if($user_session['sessIsAssistant'] == 0 || ($user_session['sessIsAssistant'] == 1 && (strpos($user_session['sessAccessPermission'], '4') !== false))): ?>
                    <li class="nav-item <?=$activesub=='libraries' || ($active=='libraries' && $activesub == 'payroll_group')?'active open':''?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">Libraries</span>
                            <span class="arrow <?=$activesub=='libraries' || ($active=='libraries' && $activesub == 'payroll_group')?'open':''?>"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item <?=$activetab=='deductions' || $activetab=='agency'?'active open':''?>">
                                <a href="<?=base_url('finance/libraries/deductions')?>">
                                    <span class="title">Deduction</span>
                                </a>
                            </li>
                            <li class="nav-item <?=$activetab=='income'?'active open':''?>">
                                <a href="<?=base_url('finance/libraries/income')?>">
                                    <span class="title">Income</span>
                                </a>
                            </li>
                            <li class="nav-item <?=$activetab=='payrollprocess'?'active open':''?>">
                                <a href="<?=base_url('finance/libraries/payrollprocess')?>">
                                    <span class="title">Payroll Process</span>
                                </a>
                            </li>
                            <li class="nav-item <?=$activetab=='projectcode'?'active open':''?>">
                                <a href="<?=base_url('finance/libraries/projectcode')?>">
                                    <span class="title">Project Code</span>
                                </a>
                            </li>
                            <li class="nav-item <?=$activetab=='payrollgroup' || ($active=='libraries' && $activesub == 'payroll_group')?'active open':''?>">
                                <a href="<?=base_url('libraries/payroll_group')?>">
                                    <span class="title">Payroll Group</span>
                                </a>
                            </li>
                            <li class="nav-item <?=$active=='finance' && $activesub=='libraries' && $activetab=='signatory'?'active open':''?>">
                                <a href="<?=base_url('finance/libraries/signatory')?>">
                                    <span class="title">Signatory</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <!-- end finance module -->

            <!-- begin officer / executive module -->
            <?php if(in_array(check_module(), array('officer','executive'))):?>
                <li class="heading">
                    <h3 class="uppercase"><?=strtoupper(userlevel($this->session->userdata('sessUserLevel')))?> Module</h3>
                </li>
                <li class="nav-item <?=$active=='hr' && $activesub =='profile' ? 'active': ''?>">
                    <a href="<?=base_url('hr/profile/'.$this->session->userdata('sessEmpNo'))?>" class="nav-link nav-toggle">
                        <i class="icon-user"></i>
                        <span class="title">201 File</span>
                    </a>
                </li>
                <li class="nav-item <?=($active=='hr' && $activesub=='attendance_summary') || ($active=='employee' && $activesub=='leave_balance') || ($active=='officer' && $activesub=='attendance')?'active open':''?>">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">Attendance</span>
                        <span class="selected"></span>
                        <span class="arrow <?=$activesub=='attendance' || $activesub=='attendance_summary'?'open':''?>"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item <?=$activesub=='attendance_summary' && $activetab=='dtr' && (isset($_GET['mode']) ? $_GET['mode'] == 'officer' ? 1 : 0 : 0) ?'active':''?>">
                            <a href="<?=base_url('hr/attendance_summary/dtr/'.$this->session->userdata('sessEmpNo').'?mode=officer')?>">
                                <span class="title">Daily Time Record</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$active=='employee' && $activesub=='leave_balance'?'active':''?>">
                            <a href="<?=base_url('employee/leave_balance/'.$this->session->userdata('sessEmpNo'))?>">
                                <span class="title">Leave Balance</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$activesub=='attendance_summary' && $activetab=='qr_code'?'active':''?>">
                            <a href="<?=base_url('hr/attendance_summary/qr_code/'.$this->session->userdata('sessEmpNo').'?mode=officer')?>">
                                <span class="title">QR Code</span>
                            </a>
                        </li>
                        <li class="nav-item  <?=($active=='officer' && $activesub=='attendance' && in_array($activetab,array('officer_dtr','employees_present','employees_absent','employees_onleave','employees_onottott'))) || (isset($_GET['mode']) ? $_GET['mode']=='employee' ? 1 : 0 : 0)? 'active open' : ''?>">
                            <a href="javascript:;" class="nav-link nav-toggle">
                                <span class="title">Employee</span>
                                <?=$active=='officer' && $activesub=='attendance' && in_array($activetab,array('officer_dtr','employees_present','employees_absent','employees_onleave','employees_onottott')) ? '<span class="selected"></span>' : ''?>
                                <span class="arrow <?=$active=='officer' && $activesub=='attendance' && in_array($activetab,array('officer_dtr','employees_present','employees_absent','employees_onleave','employees_onottott')) ? 'open' : ''?>"></span>
                            </a>
                            <ul class="sub-menu">
                                <li class="nav-item <?=$activesub=='attendance' && $activetab=='officer_dtr' || ($active == 'hr' && $activesub == 'attendance_summary' && $activetab == 'dtr') ? 'active' : ''?>">
                                    <a href="<?=base_url('officer/attendance/officer_dtr')?>">
                                        <span class="title">Daily Time Record</span>
                                    </a>
                                </li>
                                <li class="nav-item <?=$activesub=='attendance' && $activetab=='employees_present' ? 'active' : ''?>">
                                    <a href="<?=base_url('officer/attendance/employees_present')?>">
                                        <span class="title">Present</span>
                                    </a>
                                </li>
                                <li class="nav-item <?=$activesub=='attendance' && $activetab=='employees_absent' ? 'active' : ''?>">
                                    <a href="<?=base_url('officer/attendance/employees_absent')?>">
                                        <span class="title">Absent</span>
                                    </a>
                                </li>
                                <li class="nav-item <?=$activesub=='attendance' && $activetab=='employees_onleave' ? 'active' : ''?>">
                                    <a href="<?=base_url('officer/attendance/employees_onleave')?>">
                                        <span class="title">On Leave</span>
                                    </a>
                                </li>
                                <li class="nav-item <?=$activesub=='attendance' && $activetab=='employees_onottott' ? 'active' : ''?>">
                                    <a href="<?=base_url('officer/attendance/employees_onottott')?>">
                                        <span class="title">On OB/TO</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?=$active=='employee' && !in_array($activesub,array('notification','leave_balance'))?'active open':''?>">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-doc"></i>
                        <span class="title">Request</span>
                        <span class="arrow <?=$active=='employee' && $activesub !='notification'?'open':''?>"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item <?=$active=='employee' && $activesub=='official_business' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/official_business')?>">
                                <span class="title">Official Business</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$active=='employee' && $activesub=='leave' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/leave')?>">
                                <span class="title">Leave</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$active=='employee' && $activesub=='travel_order' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/travel_order')?>">
                                <span class="title">Travel Order</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$active=='employee' && $activesub=='pds_update' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/pds_update')?>">
                                <span class="title">PDS Update</span>
                            </a>
                        </li>
                        <!-- <li class="nav-item <?=$active=='employee' && $activesub=='reports' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/reports')?>">
                                <span class="title">Reports</span>
                            </a>
                        </li> -->
                        <li class="nav-item <?=$active=='employee' && $activesub=='leave_monetization' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/leave_monetization')?>">
                                <span class="title">Leave Monetization</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$active=='employee' && $activesub=='update_dtr' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/update_dtr')?>">
                                <span class="title">DTR Update</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$active=='employee' && $activesub=='compensatory_leave' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/compensatory_leave')?>">
                                <span class="title">Compensatory Time Off</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?=$active=='officer' && $activesub=='tasks' ? 'active' : ''?>">
                    <a href="<?=base_url(check_module() == 'officer' ? 'officer/tasks' : 'officer/tasks/task_executive').'?month='.currmo().'&yr='.curryr()?>">
                        <i class="icon-list"></i>
                        <span class="title">Tasks</span>
                    </a>
                </li>
                <li class="nav-item <?=$activesub =='compensation' && $activetab =='personnel_profile' ? 'active': ''?>">
                    <a href="<?=base_url('finance/compensation/personnel_profile/employee/'.$this->session->userdata('sessEmpNo'))?>" class="nav-link nav-toggle">
                        <i class="icon-wallet"></i>
                        <span class="title">Compensation</span>
                    </a>
                </li>
                <li class="nav-item  ">
                    <a href="<?=base_url('hr/reports')?>" class="nav-link nav-toggle">
                        <i class="icon-docs"></i>
                        <span class="title">Reports</span>
                    </a>
                </li>
            <?php endif; ?>
            <!-- end officer / Executive module -->

            <!-- begin employee module -->
            <?php if($this->session->userdata('sessUserLevel') == 5):?>
                <li class="heading">
                    <h3 class="uppercase"><?=strtoupper(userlevel($this->session->userdata('sessUserLevel')))?> Module</h3>
                </li>
                <li class="nav-item  <?=$active =='hr' && $activesub =='profile' ? 'active': ''?>">
                    <a href="<?=base_url('hr/profile/'.$this->session->userdata('sessEmpNo'))?>" class="nav-link nav-toggle">
                        <i class="icon-user"></i>
                        <span class="title">201 File</span>
                    </a>
                </li>
                <li class="nav-item <?=($active=='hr' && $activesub=='attendance_summary') || ($active=='employee' && $activesub=='leave_balance')?'active open':''?>">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-settings"></i>
                        <span class="title">Attendance</span>
                        <span class="arrow <?=($active=='hr' && $activesub=='attendance_summary') || ($active=='employee' && $activesub=='leave_balance')?'open':''?>"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item <?=$activesub=='attendance_summary' && $activetab=='dtr'?'active':''?>">
                            <a href="<?=base_url('hr/attendance_summary/dtr/'.$this->session->userdata('sessEmpNo'))?>">
                                <span class="title">Daily Time Record</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$active=='employee' && $activesub=='leave_balance'?'active':''?>">
                            <a href="<?=base_url('employee/leave_balance/'.$this->session->userdata('sessEmpNo'))?>">
                                <span class="title">Leave Balance</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$activesub=='attendance_summary' && $activetab=='qr_code'?'active':''?>">
                            <a href="<?=base_url('hr/attendance_summary/qr_code/'.$this->session->userdata('sessEmpNo'))?>">
                                <span class="title">QR Code</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?=$active=='employee' && (!in_array($activesub,array('notification','leave_balance')))?'active open':''?>">
                    <a href="javascript:;" class="nav-link nav-toggle">
                        <i class="icon-doc"></i>
                        <span class="title">Request</span>
                        <span class="arrow <?=$active=='employee'?'open':''?>"></span>
                    </a>
                    <ul class="sub-menu">
                        <li class="nav-item <?=$active=='employee' && $activesub=='official_business' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/official_business')?>">
                                <span class="title">Official Business</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$active=='employee' && $activesub=='leave' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/leave')?>">
                                <span class="title">Leave</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$active=='employee' && $activesub=='travel_order' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/travel_order')?>">
                                <span class="title">Travel Order</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$active=='employee' && $activesub=='pds_update' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/pds_update')?>">
                                <span class="title">PDS Update</span>
                            </a>
                        </li>
                        <!-- <li class="nav-item <?=$active=='employee' && $activesub=='reports' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/reports')?>">
                                <span class="title">Reports</span>
                            </a>
                        </li> -->
                        <li class="nav-item <?=$active=='employee' && $activesub=='leave_monetization' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/leave_monetization')?>">
                                <span class="title">Leave Monetization</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$active=='employee' && $activesub=='update_dtr' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/update_dtr')?>">
                                <span class="title">DTR Update</span>
                            </a>
                        </li>
                        <li class="nav-item <?=$active=='employee' && $activesub=='compensatory_leave' ? 'active' : ''?>">
                            <a href="<?=base_url('employee/compensatory_leave')?>">
                                <span class="title">Compensatory Time Off</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item <?=$activesub =='compensation' && $activetab =='personnel_profile' ? 'active': ''?>">
                    <a href="<?=base_url('finance/compensation/personnel_profile/employee/'.$this->session->userdata('sessEmpNo'))?>" class="nav-link nav-toggle">
                        <i class="icon-wallet"></i>
                        <span class="title">Compensation</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="heading">
                <h3 class="uppercase">Quicklinks</h3>
            </li>
            <li class="nav-item <?=$active=='onlinehelp' ? 'active open':''?>">
                <?php if($this->session->userdata('sessUserLevel') == 1):?>
                    <a href="<?=site_url('Online%20Help/HR/index.html')?>" target="_blank" class="nav-link nav-toggle">
                        <i class="icon-layers"></i>
                        <span class="title">Online Help</span>
                        <!-- <span class="arrow <?=$active=='onlinehelp' ? 'open':''?>"></span> -->
                    </a>
                <?php endif; ?>
                <?php if($this->session->userdata('sessUserLevel') == 2):?>
                    <a href="<?=site_url('Online%20Help/Finance/index.html')?>" target="_blank" class="nav-link nav-toggle">
                        <i class="icon-layers"></i>
                        <span class="title">Online Help</span>
                        <!-- <span class="arrow <?=$active=='onlinehelp' ? 'open':''?>"></span> -->
                    </a>
                <?php endif; ?>
                <?php if($this->session->userdata('sessUserLevel') == 3):?>
                    <a href="<?=site_url('Online%20Help/Officer/index.html')?>" target="_blank" class="nav-link nav-toggle">
                        <i class="icon-layers"></i>
                        <span class="title">Online Help</span>
                        <!-- <span class="arrow <?=$active=='onlinehelp' ? 'open':''?>"></span> -->
                    </a>
                <?php endif; ?>
                <?php if($this->session->userdata('sessUserLevel') == 4):?>
                    <a href="<?=site_url('Online%20Help/Executive/index.html')?>" target="_blank" class="nav-link nav-toggle">
                        <i class="icon-layers"></i>
                        <span class="title">Online Help</span>
                        <!-- <span class="arrow <?=$active=='onlinehelp' ? 'open':''?>"></span> -->
                    </a>
                <?php endif; ?>
                <?php if($this->session->userdata('sessUserLevel') == 5):?>
                    <a href="<?=site_url('Online%20Help/Employee/index.html')?>" target="_blank" class="nav-link nav-toggle">
                        <i class="icon-layers"></i>
                        <span class="title">Online Help</span>
                        <!-- <span class="arrow <?=$active=='onlinehelp' ? 'open':''?>"></span> -->
                    </a>
                <?php endif; ?>
                
                <!-- <ul class="sub-menu" style="<?=$active=='onlinehelp' && $activesub=='employee' && $activetab=='login'? 'display: block;' : ''?>">
                    <li class="nav-item <?=$active=='onlinehelp' && $activesub=='employee' && $activetab=='login' ? 'active open' : ''?>">
                        <a href="<?=base_url('onlinehelp/employee/login')?>" class="nav-link">
                            <span class="title">Login</span>
                            <span class="arrow nav-toggle <?=$active=='onlinehelp' && $activesub=='employee' && in_array($activetab, array('login','howtologin'))?'open':''?>"></span>
                        </a>
                        <ul class="sub-menu" style="<?=$active=='onlinehelp' && $activesub=='employee' && in_array($activetab, array('login','howtologin')) ? 'display: block;' : 'display: none;'?>">
                            <li class="nav-item <?=$active=='onlinehelp' && $activesub=='employee' && $activetab=='howtologin' ? 'active open' : ''?>">
                                <a href="<?=base_url('onlinehelp/employee/howtologin')?>">
                                    <span class="title">How to Login</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <ul class="sub-menu" style="<?=$active=='onlinehelp' && $activesub=='employee' && $activetab=='defaultscreen'? 'display: block;' : ''?>">
                    <li class="nav-item <?=$active=='onlinehelp' && $activesub=='employee' && $activetab=='defaultscreen' ? 'active open' : ''?>">
                        <a href="<?=base_url('onlinehelp/employee/defaultscreen')?>" class="nav-link">
                            <span class="title">Default Screen</span>
                        </a>
                    </li>
                </ul>
                <ul class="sub-menu" style="<?=$active=='onlinehelp' && $activesub=='employee' && $activetab=='employeemodule'? 'display: block;' : ''?>">
                    <li class="nav-item <?=$active=='onlinehelp' && $activesub=='employee' && $activetab=='employeemodule' ? 'active open' : ''?>">
                        <a href="<?=base_url('onlinehelp/employee/employeemodule')?>" class="nav-link">
                            <span class="title">Employee Module</span>
                        </a>
                    </li>
                </ul> -->
            </li>
            <li class="nav-item  ">
                <?php if($this->session->userdata('sessUserLevel') == 1):?>
                    <a href="<?=site_url('FAQ/HR/index.html')?>" target="_blank" class="nav-link nav-toggle">
                        <i class="icon-layers"></i>
                        <span class="title">FAQs</span>
                    </a>
                <?php endif; ?>
                <?php if($this->session->userdata('sessUserLevel') == 2):?>
                    <a href="<?=site_url('FAQ/Finance/index.html')?>" target="_blank" class="nav-link nav-toggle">
                        <i class="icon-layers"></i>
                        <span class="title">FAQs</span>
                    </a>
                <?php endif; ?>
                <?php if($this->session->userdata('sessUserLevel') == 3):?>
                    <a href="<?=site_url('FAQ/Officer/index.html')?>" target="_blank" class="nav-link nav-toggle">
                        <i class="icon-layers"></i>
                        <span class="title">FAQs</span>
                    </a>
                <?php endif; ?>
                <?php if($this->session->userdata('sessUserLevel') == 4):?>
                    <a href="<?=site_url('FAQ/Executive/index.html')?>" target="_blank" class="nav-link nav-toggle">
                        <i class="icon-layers"></i>
                        <span class="title">FAQs</span>
                    </a>
                <?php endif; ?>
                <?php if($this->session->userdata('sessUserLevel') == 5):?>
                    <a href="<?=site_url('FAQ/Employee/index.html')?>" target="_blank" class="nav-link nav-toggle">
                        <i class="icon-layers"></i>
                        <span class="title">FAQs</span>
                    </a>
                <?php endif; ?>
            </li>
        </ul>
        <!-- END SIDEBAR MENU -->
        <!-- END SIDEBAR MENU -->
    </div>
    </div>
    <!-- END SIDEBAR -->