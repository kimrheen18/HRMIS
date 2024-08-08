<?php load_plugin('css',array('select'));?>
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Attendance</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Attendance Summary</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Override</span>
        </li>
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
                            <span class="caption-subject bold uppercase"> Override</span>
                        </div>
                    </div>
                    <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                    <div style="height: 560px;" id="div_hide"></div>
                    <div class="portlet-body"  id="employee_view" style="display: none">
                        <div class="row">
                            <div class="tabbable-line tabbable-full-width col-md-12">
                                <ul class="nav nav-tabs">
                                    <?php $this_page = $this->uri->segment(4); $tab = $this->uri->segment(4); ?>
                                    <li class="<?=$this_page == 'ob' || $this_page == 'ob_add' || $this_page == 'ob_edit' ? 'active' : ''?>">
                                        <a href="<?=base_url('hr/attendance/override/ob')?>"> Official Business </a>
                                    </li>
                                    <li class="<?=$this_page == 'exclude_dtr' || $this_page == 'exclude_dtr_add' || $this_page == 'exclude_dtr_edit' ? 'active' : ''?>">
                                        <a href="<?=base_url('hr/attendance/override/exclude_dtr')?>"> Exclude in DTR </a>
                                    </li>
                                    <li class="<?=$this_page == 'generate_dtr' || $this_page == 'generate_dtr_allemp' ? 'active' : ''?>">
                                        <a href="<?=base_url('hr/attendance/override/generate_dtr')?>"> Generate DTR </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active in" id="tab-profile">
                                        <?php
                                            switch ($this_page):
                                                case 'ob_add':
                                                case 'ob_edit':
                                                    $this->load->view('_ob_form.php');
                                                    break;
                                                case 'exclude_dtr':
                                                    $this->load->view('_execdtr.php');
                                                    break;
                                                case 'exclude_dtr_add':
                                                case 'exclude_dtr_edit':
                                                    $this->load->view('_execdtr_form.php');
                                                    break;
                                                case 'generate_dtr':
                                                    $this->load->view('_gendtr.php');
                                                    break;
                                                case 'generate_dtr_allemp':
                                                    $this->load->view('_gendtr_form.php');
                                                    break;
                                                default:
                                                    $this->load->view('_ob.php');
                                                    break;
                                            endswitch;
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

<?php load_plugin('js',array('select'));?>
<script>
    $(document).ready(function() {
        $('.loading-image, #div_hide').hide();
        $('#employee_view').show();
    });
</script>