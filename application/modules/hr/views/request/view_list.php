<?php
    load_plugin('css',array('datatables'));
    $request = isset($_GET['request']) ? $_GET['request'] : 'ob'; ?>
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
            <span>Requests</span>
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
                            <i class="icon-doc font-dark"></i>
                            <span class="caption-subject bold uppercase"> Request</span>
                        </div>
                    </div>
                    <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                    <div class="portlet-body"  id="request_view" style="display: none">
                        <div class="row">
                            <div class="tab-pane" id="tab_1_1">
                                <div class="col-md-12">
                                    <div class="col-md-12">
                                        <!-- begin tab -->
                                        <div class="tabbable-line tabbable-custom-profile">
                                            <ul class="nav nav-tabs">
                                                <li class="<?=$request=='ob'?'active':''?>">
                                                    <a href="<?=base_url('hr/request?request=ob')?>"> Official Business </a>
                                                </li>
                                                <li class="<?=$request=='leave'?'active':''?>">
                                                    <a href="<?=base_url('hr/request?request=leave')?>"> Leave </a>
                                                </li>
                                                <li class="<?=$request=='to'?'active':''?>">
                                                    <a href="<?=base_url('hr/request?request=to')?>"> Travel Order</a>
                                                </li>
                                                <li class="<?=$request=='pds'?'active':''?>">
                                                    <a href="<?=base_url('hr/request?request=pds')?>"> PDS Update </a>
                                                </li>
                                                <li class="<?=$request=='mone'?'active':''?>">
                                                    <a href="<?=base_url('hr/request?request=mone')?>"> Leave Monetization </a>
                                                </li>
                                                <li class="<?=$request=='dtr'?'active':''?>">
                                                    <a href="<?=base_url('hr/request?request=dtr')?>">  DTR Update </a>
                                                </li>
                                                <li class="<?=$request=='cto'?'active':''?>">
                                                    <a href="<?=base_url('hr/request?request=cto')?>"> Compensatory Time Off </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content">
                                                
                                                <div class="tab-pane <?=$request=='ob'?'active':''?>" id="tab-ob">
                                                    <?php $this->load->view('_ob_request.php'); ?>
                                                </div>

                                                <div class="tab-pane <?=$request=='leave'?'active':''?>" id="tab-leave">
                                                    <?php $this->load->view('_leave_request.php'); ?>
                                                </div>

                                                <div class="tab-pane <?=$request=='to'?'active':''?>" id="tab-to">
                                                    <?php $this->load->view('_to_request.php'); ?>
                                                </div>

                                                <div class="tab-pane <?=$request=='pds'?'active':''?>" id="tab-pds">
                                                    <?php $this->load->view('_pds_request.php'); ?>
                                                </div>

                                                <div class="tab-pane <?=$request=='mone'?'active':''?>" id="tab-mone">
                                                    <?php $this->load->view('_mone_request.php'); ?>
                                                </div>

                                                <div class="tab-pane <?=$request=='dtr'?'active':''?>" id="tab-dtr">
                                                    <?php $this->load->view('_dtr_request'); ?>
                                                </div>

                                                <div class="tab-pane <?=$request=='cto'?'active':''?>" id="tab-cto">
                                                    <?php $this->load->view('_cto_request'); ?>
                                                </div>

                                            </div>
                                        </div>
                                        <!-- end tab -->
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

<?php load_plugin('js',array('form_validation','datatables'));?>

<?php $this->load->view('_modal_js.php'); ?>