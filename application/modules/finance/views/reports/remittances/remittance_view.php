<?=load_plugin('css', array('select2','select','datepicker'))?>
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
            <span>Employee Remittances</span>
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
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-settings font-dark"></i>
                    <span class="caption-subject bold uppercase"> Employee Remittances</span>
                </div>
            </div>
            <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
            <div class="portlet-body" id="div-body" style="display: none">
                <div class="portlet light bordered">
                    <div class="portlet-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Remittances</label>
                                    <div class="col-md-6">
                                        <select class="form-control select2 form-required" name="remitType" id="remitType">
                                            <option value="0">-- SELECT REMITTANCE --</option>
                                            <?php foreach($arrRemittances as $deduct): ?>
                                                <option value="<?=$deduct['deductionCode']?>" <?=count($_GET) > 0 ? $_GET['selpayrollGrp'] == $deduct['deductionCode'] ? 'selected' : '' : '' ?>>
                                                    <?=$deduct['deductionDesc']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Show</label>
                                    <div class="col-md-6">
                                        <select class="form-control bs-select" name="selshow" id="selshow">
                                            <option value="0">-- SELECT SHOW --</option>
                                            <option value="1"> All Employees</option>
                                            <option value="2">Per Employee</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- All employees -->
                            <div class="form-body" id="div-all_emp">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Appointment</label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" name="selAppoint" id="selAppoint">
                                            <option value="0">-- SELECT APPOINTMENT --</option>
                                            <?php foreach ($arrAppointments as $appt): ?>
                                                <option value="<?=$appt['appointmentCode']?>"> <?=$appt['appointmentDesc']?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- per employee -->
                            <div class="form-body" id="div-per_emp">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Name</label>
                                    <div class="col-md-6">
                                        <select class="form-control select2" name="selname" id="selname">
                                            <option value="0">-- SELECT EMPLOYEE --</option>
                                            <?php foreach ($arrEmployees as $emp): ?>
                                                <option value="<?=$emp['empNumber']?>">
                                                    <?=getfullname($emp['surname'], $emp['firstname'], $emp['middlename'], $emp['middleInitial'])?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group div-yrrange">
                                <label class="col-md-3 control-label">Year</label>
                                <div class="col-md-9">
                                    <div class="input-group input-large date-picker input-daterange" data-date="2003" data-date-format="yyyy" data-date-viewmode="years" id="dateRange">
                                        <input type="text" class="form-control" name="remityrfrom" id="remityrfrom" value="<?=date('Y')?>">
                                        <span class="input-group-addon"> to </span>
                                        <input type="text" class="form-control" name="remityrto" id="remityrto" value="<?=date('Y')?>">
                                    </div>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Generate</label>
                                    <div class="col-md-6">
                                        <select class="form-control bs-select" name="selgen" id="selgen">
                                            <option value="0">-- SELECT FORMAT --</option>
                                            <option value='1'>PDF</option>
                                            <!-- <option value='2'>Excel</option> -->
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">&nbsp;</label>
                                    <div class="col-md-9">
                                    <a id="btnprint-reports" href="javascript:;" class="btn btn-primary">Print Preview</a>
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- begin print-preview modal -->
<div id="print-preview-modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog" style="width: 75%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title bold"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" value="<?=base_url()?>" id="txtbaseurl">
                <div class="row form-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <embed id="embed-pdf" frameborder="0" width="100%" height="500px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a id="link-fullsize" class="btn blue btn-sm" target="_blank"> <i class="glyphicon glyphicon-resize-full"> </i> Open in New Tab</a>
                <button type="button" class="btn dark btn-sm" data-dismiss="modal"> <i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>
<!-- end print-preview modal -->


<?=load_plugin('js', array('datepicker','datatables','select2','select'))?>
<script src="<?=base_url('assets/js/custom/compensation-reports.js')?>"></script>

<script>
    $('select.select2').select2({
        minimumResultsForSearch: -1,
        placeholder: function(){
            $(this).data('placeholder');
        }
    });
    $(document).ready(function() {
        $('.loading-image, #div-all_emp, #div-per_emp').hide();
        $('#div-body').show();
        $('#selshow').change(function() {
            if($(this).val() == 1){
                $('#div-all_emp').show();
                $('#div-per_emp').hide();
            }else if($(this).val() == 2){
                $('#div-all_emp').hide();
                $('#div-per_emp').show();
            }else{
                $('#div-per_emp').hide();
                $('#div-all_emp').hide();
            }
        });
    });
</script>
