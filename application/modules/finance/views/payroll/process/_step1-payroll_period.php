<div class="form-horizontal">
    <div class="loading-fade" style="display: none;width: 80%;height: 100%;top: 150px;">
        <center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center>
    </div>
    <?=form_open('finance/payroll_update/select_benefits_perm', array('class' => 'form-horizontal', 'method' => 'post', 'id' => 'frmprocess'))?>
    <div class="tab-content">
        <div class="tab-pane active" id="tab-payroll">
            <h3 class="block">Process Payroll</h3>
            <div class="form-group">
                <label class="control-label col-md-3">Employee <span class="required"> * </span></label>
                <div class="col-md-4">
                    <div class="input-icon right">
                        <i class="fa fa-warning tooltips i-required"></i>
                        <textarea id="txtdefault" hidden><?=json_encode($arrProcesses)?></textarea>
                        <input type="hidden" id="txtform_data" value='<?=$_GET["data"]?>'>
                        <select class="bs-select form-control form-required" name="selemployment" id="selemployment" onchange="validate_bsselect($(this))">
                            <option value="">-- SELECT EMPLOYEE --</option>
                            <?php
                                foreach ($arrAppointments as $appointment):
                                    if($appointment['appointmentDesc'] != ''):
                                        if(isset($_SESSION['strUserPermission'])):
                                            if($_SESSION['strUserPermission'] == "Cashier Assistant"):
                                                if($appointment['appointmentCode']=='GIA'): ?>
                                                    <option value="<?=$appointment['appointmentCode']?>" data-comp="<?=$appointment['computation']?>"
                                                        <?=count($arr_form_data) > 0 ? $arr_form_data['selemployment'] == $appointment['appointmentCode'] ? 'selected' : '' : ''?>>
                                                        <?=$appointment['appointmentDesc']?></option><?php
                                                endif;
                                            endif;
                                        else: ?>
                                            <option value="<?=$appointment['appointmentCode']?>" data-comp="<?=$appointment['computation']?>"
                                                <?=count($arr_form_data) > 0 ? $arr_form_data['selemployment'] == $appointment['appointmentCode'] ? 'selected' : '' : ''?>>
                                                <?=$appointment['appointmentDesc']?></option><?php
                                        endif;
                                    endif;
                                endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Process <span class="required"> * </span></label>
                <div class="col-md-4">
                    <div class="input-icon right">
                        <i class="fa fa-warning tooltips i-required"></i>
                        <select class="bs-select form-control form-required" name="selcode" id="selcode" onchange="validate_bsselect($(this))">
                            <option value="">-- SELECT PROCESS --</option>
                            <?php foreach (get_process_code() as $process_code):?>
                                    <option value="<?=$process_code['code']?>" <?=count($arr_form_data) > 0 ? $arr_form_data['selcode'] == $process_code['code'] ? 'selected' : '' : $process_code['code'] == 'SALARY' ? 'selected' : ''?>>
                                        <?=$process_code['desc']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Month <span class="required"> * </span></label>
                <div class="col-md-4">
                    <div class="input-icon right">
                        <i class="fa fa-warning tooltips i-required"></i>
                        <select class="bs-select form-control form-required" name="mon" id="selmon" onchange="validate_bsselect($(this))">
                            <option value="">-- SELECT MONTH --</option>
                            <?php foreach (range(1, 12) as $m): ?>
                                <option value="<?=$m?>" <?=count($arr_form_data) > 0 ? $arr_form_data['mon'] == $m ? 'selected' : '' : $m == currmo() ? 'selected' : ''?>>
                                    <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3">Year <span class="required"> * </span></label>
                <div class="col-md-4">
                    <div class="input-icon right">
                        <i class="fa fa-warning tooltips i-required"></i>
                        <select class="bs-select form-control form-required" name="yr" id="selyr" onchange="validate_bsselect($(this))">
                            <option value="">-- SELECT YEAR --</option>
                            <?php foreach (getYear() as $yr): ?>
                                <option value="<?=$yr?>" <?=count($arr_form_data) > 0 ? $arr_form_data['yr'] == $yr ? 'selected' : '' : $yr == curryr() ? 'selected' : ''?>>
                                    <?=$yr?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group div-period" <?=count($arr_form_data) > 0 ? strtolower($arr_form_data['selemployment']) == 'p' ? 'hidden' : '' : ''?>>
                <label class="control-label col-md-3">Period <span class="required"> * </span></label>
                <div class="col-md-4">
                    <div class="input-icon right">
                        <i class="fa fa-warning tooltips i-required"></i>
                        <select class="bs-select form-control form-required" name="period" id="selperiod" onchange="validate_bsselect($(this))">
                            <option value="">-- SELECT PERIOD --</option>
                            <?php foreach (periods() as $per): ?>
                                <option value="<?=$per['id']?>" <?=isset($_GET['period']) ? $_GET['period'] == $per['val'] ? 'selected' : '' : ''?>>
                                    <?=$per['val']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group div-date" <?=count($arr_form_data) > 0 ? $arr_form_data['selemployment'] != 'P' ? '' : 'style="display: none;"' : 'style="display: none;"' ?>>
                <label class="control-label col-md-3">Process Date
                    <span class="required"> * </span>
                </label>
                <div class="col-md-4">
                    <div class="input-group date-picker input-daterange" data-date="2003" data-date-format="yyyy-mm-dd" data-date-viewmode="years" id="dateRange">
                        <div class="input-icon right">
                            <i class="fa fa-warning tooltips i-required"></i>
                            <input type="text" class="form-control form-required" id="txt_dtfrom" name="txt_dtfrom"
                                value="<?=count($arr_form_data) > 0 ? $arr_form_data['txt_dtfrom'] : '' ?>" onchange="validate_text($(this))">
                        </div>
                        <span class="input-group-addon"> to </span>
                        <div class="input-icon right">
                            <i class="fa fa-warning tooltips i-required"></i>
                            <input type="text" class="form-control form-required" id="txt_dtto" name="txt_dtto"
                                value="<?=count($arr_form_data) > 0 ? $arr_form_data['txt_dtto'] : '' ?>" onchange="validate_text($(this))">
                        </div>
                    </div>
                </div>
            </div>
            <div class="div-datause" <?=count($arr_form_data) > 0 ? strtoupper($arr_form_data['selemployment'])=='P' ? '' : 'style="display: none;"' : 'style="display: none;"'?>>
                <div class="row">
                    <label class="control-label col-md-3"></label>
                    <label class="control-label col-md-4">
                        <div class="caption">
                            <span class="caption-subject font-black bold uppercase pull-left" style="padding-bottom: 5px;">Data Use</span>
                        </div>
                    </label>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Month <span class="required"> * </span></label>
                    <div class="col-md-4">
                        <div class="input-icon right">
                            <i class="fa fa-warning tooltips i-required"></i>
                            <select class="bs-select form-control form-required" name="data_fr_mon" id="data_fr_mon" onchange="validate_bsselect($(this))">
                                <option value="">-- SELECT MONTH --</option>
                                <?php foreach (range(1, 12) as $m): ?>
                                    <option value="<?=$m?>" <?=count($arr_form_data) > 0 ? $arr_form_data['data_fr_mon'] == $m ? 'selected' : '' : $m == currmo() - 1 ? 'selected' : ''?>>
                                        <?=date('F', mktime(0, 0, 0, $m, 10))?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-3">Year <span class="required"> * </span></label>
                    <div class="col-md-4">
                        <div class="input-icon right">
                            <i class="fa fa-warning tooltips i-required"></i>
                            <select class="bs-select form-control form-required" name="data_fr_yr" id="data_fr_yr" onchange="validate_bsselect($(this))">
                                <option value="">-- SELECT YEAR --</option>
                                <?php foreach (getYear() as $yr): ?>
                                    <option value="<?=$yr?>" <?=count($arr_form_data) > 0 ? $arr_form_data['data_fr_yr'] == $yr ? 'selected' : '' : $yr == curryr() ? 'selected' : ''?>>
                                        <?=$yr?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-3 col-md-9">
                <input type="hidden" name="txtcomputation" id="txtcomputation" value="<?=count($arr_form_data) > 0 ? $arr_form_data['txtcomputation'] : '' ?>">
                <button type="submit" id="btn_step1" class="btn blue btn-submit"> Save and Continue
                    <i class="fa fa-angle-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
<?=form_close()?>

<script src="<?=base_url('assets/js/custom/payroll-step_1.js')?>"></script>