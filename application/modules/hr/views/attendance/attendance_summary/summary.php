<?php load_plugin('css',array('select','datepicker'));
      if($_SESSION['sessUserLevel'] != 1):?>
        <style> ul.nav.nav-tabs { display: none;} .tab-content { border-top: none !important;} </style>
<?php endif;
    $this_page = $this->uri->segment(3);
    $tab = $this->uri->segment(4);
    $month = isset($_GET['month']) ? $_GET['month'] : date('m');
    $yr = isset($_GET['yr']) ? $_GET['yr'] : date('Y');

    $m_dtr = isset($_GET['month-dtr']) ? $_GET['month-dtr'] : date('m');
    $y_dtr = isset($_GET['year-dtr']) ? $_GET['year-dtr'] : date('Y');

    $datefrom = isset($_GET['datefrom']) ? $_GET['datefrom'] : date('Y-m').'-01';
    $dateto = isset($_GET['dateto']) ? $_GET['dateto'] : date('Y-m').'-'.cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));

    $show_monyr = 0;
    $show_dates = 0;
    switch ($this_page):
        case 'dtr':
            if(in_array($this->uri->segment(4), array($arrData['empNumber'],'certify_offset'))):
                $show_monyr = 0; $show_dates = 1;
            elseif(in_array($this->uri->segment(4), array('leave'))):
                $show_monyr = 1; $show_dates = 0;
            else:
                $show_monyr = 0; $show_dates = 0;
            endif;
            break;
        case 'leave_balance_update':
        case 'leave_balance':
        case 'filed_request': $show_monyr = 1; $show_dates = 0; break;          
    endswitch;
?>

<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
       <?php 
             $page_name = $this_page;
            $breadcrumbs = array();
             if($page_name == 'leave_balance_update'):
                $page_name = 'Leave Balance';
            elseif($page_name == 'leave_monetization'):
                $page_name = 'Leave Monetization';
            elseif($page_name == 'filed_request'):
                $page_name = 'Filed Request';
            elseif($page_name == 'qr_code'):
                $page_name = 'QR Code';
            endif;
            
            switch (check_module()):
                case 'officer':
                case 'executive':
                    $mode = isset($_GET['mode']) ? $_GET['mode'] == 'employee' ? 1 : 0 : 0;
                    if($mode):
                        $breadcrumbs = array('Home','Attendance','DTR',getfullname($arrData['firstname'],$arrData['surname'],$arrData['middlename'],$arrData['middleInitial'],''));
                    else:
                        $breadcrumbs = array('Home','Attendance','DTR');
                    endif;
                    break;
                case 'employee':
                    $breadcrumbs = array('Home','Attendance','DTR');
                    break;
                case 'hr':
                    $breadcrumbs = array('Home','Attendance','Attendance Summary',$this_page=='dtr'?strtoupper($page_name):$page_name,getfullname($arrData['firstname'],$arrData['surname'],$arrData['middlename'],$arrData['middleInitial'],''));
                    break;
            endswitch;

            foreach($breadcrumbs as $key => $bc):
                if($bc != 'index'):
                    echo '<li><span>'.$bc.'</span>';
                    if($key != count($breadcrumbs)-1):
                        echo '<i class="fa fa-circle"></i>';
                    endif;    
                    echo '</li>';
                endif;
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
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject bold uppercase"> <?=$this_page == 'qr_code' ? 'QR Code' : 'Attendance'?></span>
                        </div>
                    </div>
                    <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                    <div style="height: 560px;" id="div_hide"></div>
                    <div class="portlet-body"  id="employee_view" style="display: none">
                        <div class="row">
                            <div class="tabbable-line tabbable-full-width col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="<?=$this_page == 'index' ? 'active' : ''?>">
                                        <a href="<?=base_url('hr/attendance_summary/index/').$arrData['empNumber']?>">
                                            Attendance Summary </a>
                                    </li>
                                    <li <?=$arrData['appointmentCode']!='P' ? 'style="display: none;"' :''?> class="<?=in_array($this_page, array('leave_balance','leave_balance_update','leave_balance_set')) ? 'active' : ''?>">
                                        <?php if(check_module() == 'hr'): ?>
                                            <a href="<?=base_url('hr/attendance_summary/leave_balance_update/').$arrData['empNumber'].'?month='.date('m').'&yr='.date('Y')?>">
                                                Leave Balance </a>
                                        <?php else: ?>
                                            <a href="<?=base_url('hr/attendance_summary/leave_balance/').$arrData['empNumber'].'?datefrom='.$datefrom.'&dateto='.$dateto?>">
                                                Leave Balance </a>
                                        <?php endif; ?>
                                    </li>
                                    <li <?=$arrData['appointmentCode']!='P' ? 'style="display: none;"' :''?> class="<?=$this_page == 'leave_monetization' ? 'active' : ''?>">
                                        <a href="<?=base_url('hr/attendance_summary/leave_monetization/').$arrData['empNumber'].'?month='.$month.'&yr='.$yr?>">
                                            Leave Monetization </a>
                                    </li>
                                    <li class="<?=$this_page == 'filed_request' ? 'active' : ''?>">
                                        <a href="<?=base_url('hr/attendance_summary/filed_request/').$arrData['empNumber'].'?month='.$month.'&yr='.$yr?>">
                                            Filed Request </a>
                                    </li>
                                    <li class="<?=($this_page == 'dtr') ? 'active' : ''?>">
                                      
                                        <a href="<?=base_url('hr/attendance_summary/dtr/').$arrData['empNumber'].'?month-dtr='.$m_dtr.'&year-dtr='.$y_dtr?>">
                                            Daily Time Record </a>
                                    </li>
                                    <li class="<?=$this_page == 'qr_code' ? 'active' : ''?>">
                                        <a href="<?=base_url('hr/attendance_summary/qr_code/').$arrData['empNumber'].'?month='.$month.'&yr='.$yr?>">
                                            QR Code </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="col-md-12" style="margin-bottom: 20px;" <?=$show_monyr?'':'hidden'?>>
                                        <center>
                                            <?=form_open('', array('class' => 'form-inline', 'method' => 'get'))?>
                                                <input type="hidden" name="mode" value="<?=isset($_GET['mode']) ? $_GET['mode'] : check_module()?>">
                                                <input type="hidden" name="tab" id="txttab" value="<?=isset($_GET['tab']) ? $_GET['tab'] : ''?>">
                                                <div class="form-group" style="display: inline-flex;">
                                                    <label style="padding: 6px;">Month</label>
                                                    <select class="bs-select form-control" name="month">
                                                        <?php if($this_page!='dtr' || ($this_page=='dtr' && $this->uri->segment(4) == 'leave')): ?>
                                                            <option value="all">All</option>
                                                        <?php endif; ?>
                                                        <?php foreach (range(1, 12) as $m): ?>
                                                            <option value="<?=sprintf('%02d', $m)?>"
                                                                <?php 
                                                                    if(isset($_GET['month'])):
                                                                        echo $_GET['month'] == $m ? 'selected' : '';
                                                                    else:
                                                                        echo $m == sprintf('%02d', date('n')) ? 'selected' : '';
                                                                    endif;
                                                                 ?> >
                                                                <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group" style="display: inline-flex;margin-left: 10px;">
                                                    <label style="padding: 6px;">Year</label>
                                                    <select class="bs-select form-control" name="yr">
                                                        <?php foreach (getYear() as $yr): ?>
                                                            <option value="<?=$yr?>"
                                                                <?php 
                                                                    if(isset($_GET['yr'])):
                                                                        echo $_GET['yr'] == $yr ? 'selected' : '';
                                                                    else:
                                                                        echo $yr == date('Y') ? 'selected' : '';
                                                                    endif;
                                                                 ?> >  
                                                            <?=$yr?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <button type="submit" class="btn btn-primary" style="margin-top: -3px;">Search</button>
                                            <?=form_close()?>
                                        </center>
                                    </div>
                                    <div class="col-md-12" style="margin-bottom: 20px;" <?=$show_dates?'':'hidden'?>>
                                        <center>
                                            <?=form_open('', array('class' => 'form-inline', 'method' => 'get'))?>
                                                <input type="hidden" name="mode" value="<?=isset($_GET['mode']) ? $_GET['mode'] : check_module()?>">
                                               <!--  <input type="hidden" data-date-format="yyyy-mm-dd" name="datefrom" value="<?=$datefrom?>">
                                                <input type="hidden" data-date-format="yyyy-mm-dd" name="dateto" value="<?=$dateto?>">
                                               -->  <!-- <div class="form-group" style="display: inline-flex;">
                                                    <label style="padding: 6px;">Date From</label>
                                                    <input class="form-control date-picker form-required" data-date-format="yyyy-mm-dd" name="datefrom" type="text" style="width: 140px !important;"
                                                            value="<?=$datefrom?>">
                                                </div>
                                                <div class="form-group" style="display: inline-flex;margin-left: 10px;">
                                                    <label style="padding: 6px;">Date To</label>
                                                    <input class="form-control date-picker form-required" data-date-format="yyyy-mm-dd" name="dateto" type="text" style="width: 140px !important;"
                                                            value="<?=$dateto?>">
                                                </div> -->

                                                <!-- Changes  Here -->

                                                <div class="form-group" style="display: inline-flex;">
                                                    <label style="padding: 6px;">Month</label>
                                                    <select class="bs-select form-control" name="month-dtr">
                                                        <?php foreach (range(1, 12) as $m): ?>
                                                            <option value="<?=sprintf('%02d', $m)?>"
                                                                <?php 
                                                                    if(isset($_GET['month-dtr'])):
                                                                        echo $_GET['month-dtr'] == $m ? 'selected' : '';
                                                                    else:
                                                                        echo $m == sprintf('%02d', date('n')) ? 'selected' : '';
                                                                    endif;
                                                                 ?> >
                                                                <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                <div class="form-group" style="display: inline-flex;margin-left: 10px;">
                                                    <label style="padding: 6px;">Year</label>
                                                    <select class="bs-select form-control" name="year-dtr">
                                                        <?php foreach (getYear() as $yr): ?>
                                                            <option value="<?=$yr?>"
                                                                <?php 
                                                                    if(isset($_GET['year-dtr'])):
                                                                        echo $_GET['year-dtr'] == $yr ? 'selected' : '';
                                                                    else:
                                                                        echo $yr == date('Y') ? 'selected' : '';
                                                                    endif;
                                                                 ?> >  
                                                            <?=$yr?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>

                                                &nbsp;
                                                <button type="submit" class="btn btn-primary" style="margin-top: -3px;">Search</button>
                                            <?=form_close()?>
                                        </center>
                                    </div>

                                    <div class="tab-pane fade active in" id="tab-profile">
                                        <?php
                                            if($this_page == 'index'): $this->load->view('_index.php'); endif;
                                            if($this_page == 'leave_balance'): $this->load->view('_leave_balance.php'); endif;
                                            if($this_page == 'leave_balance_update'): $this->load->view('_leave_balance_update.php'); endif;
                                            if($this_page == 'leave_balance_set'): $this->load->view('_leave_balance_set.php'); endif;
                                            if($this_page == 'leave_monetization'): $this->load->view('_leave_monetization.php'); endif;
                                            if($this_page == 'filed_request'): $this->load->view('_filed_request.php'); endif;
                                            if($this_page == 'dtr'):
                                                switch ($tab):
                                                    case 'edit_mode':
                                                        $this->load->view('_dtr/edit_dtr_form.php');
                                                        break;
                                                    case 'broken_sched':
                                                        $this->load->view('_dtr/broken_sched_view.php');
                                                        break;
                                                    case 'broken_sched_add':
                                                        $this->load->view('_dtr/broken_sched_form.php');
                                                        break;
                                                    case 'broken_sched_edit':
                                                        $this->load->view('_dtr/broken_sched_form.php');
                                                        break;
                                                    case 'local_holiday':
                                                        $this->load->view('_dtr/local_holiday_view.php');
                                                        break;
                                                    case 'local_holiday_add':
                                                        $this->load->view('_dtr/local_holiday_form.php');
                                                        break;
                                                    case 'local_holiday_edit':
                                                        $this->load->view('_dtr/local_holiday_form.php');
                                                        break;
                                                    case 'certify_offset':
                                                        $this->load->view('_dtr/certify_offset_view.php');
                                                        break;
                                                    case 'ob':
                                                        $this->load->view('_dtr/ob_view.php');
                                                        break;
                                                    case 'ob_add':
                                                        $this->load->view('_dtr/ob_form.php');
                                                        break;
                                                    case 'ob_edit':
                                                        $this->load->view('_dtr/ob_form.php');
                                                        break;
                                                    case 'leave':
                                                        $this->load->view('_dtr/leave_view.php');
                                                        break;
                                                    case 'leave_edit':
                                                        $this->load->view('_dtr/leave_form.php');
                                                        break;
                                                    case 'leave_add':
                                                        $this->load->view('_dtr/leave_form.php');
                                                        break;
                                                    case 'compensatory_leave':
                                                        $this->load->view('_dtr/compensatory_leave_view.php');
                                                        break;
                                                    case 'compensatory_leave_add':
                                                        $this->load->view('_dtr/compensatory_leave_form.php');
                                                        break;
                                                    case 'time':
                                                        $this->load->view('_dtr/time_view.php');
                                                        break;
                                                    case 'time_add':
                                                        $this->load->view('_dtr/time_form.php');
                                                        break;
                                                    case 'to':
                                                        $this->load->view('_dtr/to_view.php');
                                                        break;
                                                    case 'to_add':
                                                        $this->load->view('_dtr/to_form.php');
                                                        break;
                                                    case 'to_edit':
                                                        $this->load->view('_dtr/to_form.php');
                                                        break;
                                                    case 'flagcrmy':
                                                        $this->load->view('_dtr/flagcrmy_view.php');
                                                        break;
                                                    case 'flagcrmy_add':
                                                        $this->load->view('_dtr/flagcrmy_form.php');
                                                        break;
                                                    case 'flagcrmy_edit':
                                                        $this->load->view('_dtr/flagcrmy_form.php');
                                                        break;
                                                    default:
                                                        $this->load->view('_dtr.php');
                                                endswitch;

                                            endif;
                                            if($this_page == 'qr_code'): include('_qr_code.php'); endif;
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