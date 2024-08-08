<?=load_plugin('css', array('datepicker','timepicker'))?>

<div id="tab_position" class="tab-pane">
    <form action="#">
        <b>POSITION DETAILS :</b><br><br>                        
            <table class="table table-bordered table-striped" class="table-responsive">
                <?php foreach($arrPosition as $row):?>
                <tr>
                <td colspan="4"><b>Position Details</b></td>
                </tr>
                <tr>
                    <td width="25%">Service Code :</td>
                    <td width="25%"><?=$row['service']?></td>
                    <td width="25%"></td>
                    <td width="25%"></td>
                </tr>
                <tr>
                    <td>First Day Government :</td>
                    <td><?=$row['firstDayGov']?></td>
                    <td>Salary Effectivity Date :</td>
                    <td><?=$row['effectiveDate']?></td>
                </tr>
                <tr>
                    <td>First Day Agency :</td>
                    <td><?=$row['firstDayAgency']?></td>
                    <td>Employment Basis :</td>
                    <td><?=$row['employmentBasis']?></td>
                </tr>
                <tr>
                    <td>Employment Status :</td>
                    <td><?=$row['statusOfAppointment']?></td>
                    <td>Category Service :</td>
                    <td><?=$row['categoryService']?></td>
                </tr>
                <tr>
                    <td>Separation Date :</td>
                    <td><?=$row['contractEndDate']?></td>
                    <td>Tax Status :</td>
                    <td><?=$row['taxStatCode']?></td>
                </tr>
                <tr>
                    <td>Appointment Desc. :</td>
                    <td><?=$row['appointmentCode']?></td>
                    <td>No. Of Dependents :</td>
                    <td><?=$row['dependents']?></td>
                </tr>
                <td colspan="4"><b>Payroll</b></td>
                </tr>
                <tr>
                    <td>Payroll Group :</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Include in DTR ? :</td>
                    <td><?=$row['dtrSwitch']?></td>
                    <td>Include in Payroll? :</td>
                    <td><?=$row['payrollSwitch']?></td>
                </tr>
                <tr>
                    <td>Attendance Scheme :</td>
                    <td><?=$row['schemeCode']?></td>
                    <td>Hazard Pay Factor :</td>
                    <td><?=$row['hpFactor']?></td>
                </tr>
                <tr>
                    <td>Include in PhilHealth ? :</td>
                    <td><?=$row['philhealthSwitch']?></td>
                    <td>Include in PAGIBIG? :</td>
                    <td><?=$row['pagibigSwitch']?></td>
                </tr>
                 <tr>
                    <td>Include in Life & Retirement ? :</td>
                    <td><?=$row['lifeRetSwitch']?></td>
                    <td>Include Secondment? :</td>
                    <td><?=$row['includeSecondment']?></td>
                </tr>
                <td colspan="4"><b>Plantilla Position</b></td>
                <tr>
                    <td>ItemNumber :</td>
                    <td><?=$row['uniqueItemNumber']?></td>
                    <td>Head of the Agency :</td>
                    <td><?=$row['firstDayAgency']?></td>
                </tr>
                <tr>
                    <td>Actual Salary :</td>
                    <td><?=$row['actualSalary']?></td>
                    <td>Salary Grade :</td>
                    <td><?=$row['firstDayAgency']?></td>
                </tr>
                <tr>
                    <td>Authorize Salary :</td>
                    <td><?=$row['authorizeSalary']?></td>
                    <td>Step Number :</td>
                    <td><?=$row['stepNumber']?></td>
                </tr>
                <tr>
                    <td>Position :</td>
                    <td><?=$row['positionCode']?></td>
                    <td>Date Increment :</td>
                    <td><?=$row['dateIncremented']?></td>
                </tr>
                <tr>
                    <td>Position Date :</td>
                    <td><?=$row['positionDate']?></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <td>  <a class="btn green" data-toggle="modal" href="#editPosition_modal"> Save </a></td>
                <?php endif;?>
                </tr>
               <?php endforeach; ?>
            </tr>
        </table>
        </form>
        <?=form_open(base_url('pds/edit_position/'.$this->uri->segment(4)), array('method' => 'post', 'name' => 'frmPosition'))?>
               <div class="modal fade in" id="editPosition_modal" tabindex="-1" role="full" aria-hidden="true">
                    <div class="modal-dialog modal-full">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title"><b>POSITION DETAILS</b></h4>
                            </div>
                            <div class="modal-body"> </div>
                             <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <div class="form-group" >
                                        <label class="control-label" ><b>Position Details </b></label>
                                        <div class="input-icon right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <div class="form-group">
                                        <label class="control-label"><b>Payroll </b></label>
                                        <div class="input-icon right">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3 text-center">
                                    <div class="form-group">
                                        <label class="control-label"><b>Plantilla Position : </b></label>
                                        <div class="input-icon right">
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Service Code :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strServiceCode" value="<?=isset($arrPosition[0]['serviceCode'])?$arrPosition[0]['serviceCode']:''?>">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Payroll Group :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strPayroll" value="<?=isset($arrPosition[0]['payrollGroupCode'])?$arrPosition[0]['payrollGroupCode']:''?>">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Item Number :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strItemNum" value="<?=isset($arrPosition[0]['uniqueItemNumber'])?$arrPosition[0]['uniqueItemNumber']:''?>">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">First Day Gov't :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input class="form-control form-control-inline input-medium date-picker" name="dtmGovnDay" id="dtmGovnDay" size="16" type="text" value="<?=isset($arrPosition[0]['firstDayGov'])?$arrPosition[0]['firstDayGov']:''?>" data-date-format="yyyy-mm-dd">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Include in DTR? : <span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strIncludeDTR" value="<?=isset($arrPosition[0]['dtrSwitch'])?$arrPosition[0]['dtrSwitch']:''?>">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Head of the Agency :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strHead" value="<?=isset($arrPosition[0][''])?$arrPosition[0]['']:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">First Day Agency :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input class="form-control form-control-inline input-medium date-picker" name="dtmAgencyDay" id="dtmAgencyDay" size="16" type="text" value="<?=isset($arrPosition[0]['firstDayAgency'])?$arrPosition[0]['firstDayAgency']:''?>" data-date-format="yyyy-mm-dd">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Include in Payroll? : <span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strIncludePayroll" value="<?=isset($arrPosition[0]['payrollSwitch'])?$arrPosition[0]['payrollSwitch']:''?>">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Actual Salary :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strActual" value="<?=isset($arrPosition[0]['actualSalary'])?$arrPosition[0]['actualSalary']:''?>">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Salary Effectivity Date :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input class="form-control form-control-inline input-medium date-picker" name="intSalaryDate" id="intSalaryDate" size="16" type="text" value="<?=isset($arrPosition[0]['effectiveDate'])?$arrPosition[0]['effectiveDate']:''?>" data-date-format="yyyy-mm-dd">
                                    </div>
                                </div>
                                 <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Attendance Scheme : <span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strAttendance" value="<?=isset($arrPosition[0]['schemeCode'])?$arrPosition[0]['schemeCode']:''?>">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Salary Grade :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strSG" value="<?=isset($arrPosition[0]['salaryGradeNumber'])?$arrPosition[0]['salaryGradeNumber']:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Employment Basis :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strEmpBasis" value="<?=isset($arrPosition[0]['employmentBasis'])?$arrPosition[0]['employmentBasis']:''?>">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Hazard Pay Factor :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strHP" value="<?=isset($arrPosition[0]['hpFactor'])?$arrPosition[0]['hpFactor']:''?>">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Authorize Salary :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strAuthorize" value="<?=isset($arrPosition[0]['authorizeSalary'])?$arrPosition[0]['authorizeSalary']:''?>">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Employment Status :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strModeofSep" value="<?=isset($arrPosition[0]['statusOfAppointment'])?$arrPosition[0]['statusOfAppointment']:''?>">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Include in PhilHealth? :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strIncPHealth" value="<?=isset($arrPosition[0]['philhealthSwitch'])?$arrPosition[0]['philhealthSwitch']:''?>">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Step Number :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strStepNum" value="<?=isset($arrPosition[0]['stepNumber'])?$arrPosition[0]['stepNumber']:''?>">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Separation Date :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                       <input class="form-control form-control-inline input-medium date-picker" name="dtmSepDate" id="dtmSepDate" size="16" type="text" value="<?=isset($arrPosition[0]['contractEndDate'])?$arrPosition[0]['contractEndDate']:''?>" data-date-format="yyyy-mm-dd">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Include in PAGIBIG ? :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strIncPagibig" value="<?=isset($arrPosition[0]['pagibigSwitch'])?$arrPosition[0]['pagibigSwitch']:''?>">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Position :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strPosition" value="<?=isset($arrPosition[0]['positionCode'])?$arrPosition[0]['positionCode']:''?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Category Service :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strCatService" value="<?=isset($arrPosition[0]['categoryService'])?$arrPosition[0]['categoryService']:''?>">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Include in Life & Retirement? :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strIncLife" value="<?=isset($arrPosition[0]['lifeRetSwitch'])?$arrPosition[0]['lifeRetSwitch']:''?>">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Date Increment :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input class="form-control form-control-inline input-medium date-picker" name="dtmDateInc" id="dtmDateInc" size="16" type="text" value="<?=isset($arrPosition[0]['dateIncremented'])?$arrPosition[0]['dateIncremented']:''?>" data-date-format="yyyy-mm-dd">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Tax Status :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strTaxStatus" value="<?=isset($arrPosition[0]['taxStatCode'])?$arrPosition[0]['taxStatCode']:''?>">
                                    </div>
                                </div>
                                 <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Include Secondment? :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strSecondment" value="<?=isset($arrPosition[0]['includeSecondment'])?$arrPosition[0]['includeSecondment']:''?>">
                                    </div>
                                </div>
                              
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Position Date :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input class="form-control form-control-inline input-medium date-picker" name="dtmPosDate" id="dtmPosDate" size="16" type="text" value="<?=isset($arrPosition[0]['positionDate'])?$arrPosition[0]['positionDate']:''?>" data-date-format="yyyy-mm-dd">
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Appointment Desc. :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strAppointmentDesc" value="<?=isset($arrPosition[0]['appointmentCode'])?$arrPosition[0]['appointmentCode']:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">No. of Dependents :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="intDependents" value="<?=isset($arrPosition[0]['dependents'])?$arrPosition[0]['dependents']:''?>">
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Executive Office :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strExecOffice" value="<?=isset($arrPosition[0]['officeCode'])?$arrPosition[0]['officeCode']:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Personnel Action : <span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strPersonnel" value="<?=isset($arrPosition[0]['personnelAction'])?$arrPosition[0]['personnelAction']:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Service : <span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strService" value="<?=isset($arrPosition[0]['service'])?$arrPosition[0]['service']:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Division : <span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                       <input type="text" class="form-control" name="strDivision" value="<?=isset($arrPosition[0]['divisionCode'])?$arrPosition[0]['divisionCode']:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Section : <span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strSection" value="<?=isset($arrPosition[0]['sectionCode'])?$arrPosition[0]['sectionCode']:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-1">
                                    <div class="form-group">
                                    </div>
                                </div>
                                <div class="col-sm-1 text-left">
                                    <div class="form-group">
                                        <label class="control-label">Place of Assignment :<span class="required"> * </span></label>
                                    </div>
                                </div>
                                <div class="col-sm-2" text-left>
                                    <div class="form-group">
                                        <input type="text" class="form-control" name="strAssignment" value="<?=isset($arrPosition[0]['assignPlace'])?$arrPosition[0]['assignPlace']:''?>">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <input type="hidden" name="strEmpNumber" id="strEmpNumber" value="<?=isset($arrPosition['empNumber'])?$arrPosition['empNumber']:''?>">
                                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn green">Save</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
        <?=form_close()?>
</div>

<?=load_plugin('js',array('validation','datepicker'));?>
<script>
    $(document).ready(function() 
    {
        $('.date-picker').datepicker();
    });
 
</script>

<?=load_plugin('js',array('timepicker'));?>
<script>
    $(document).ready(function() {
        $('.timepicker').timepicker({
                timeFormat: 'HH:mm:ss A',
                disableFocus: true,
                showInputs: false,
                showSeconds: true,
                showMeridian: true,
                // defaultValue: '12:00:00 a'
            });
    });
</script>