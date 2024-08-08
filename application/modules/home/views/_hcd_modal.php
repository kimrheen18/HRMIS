<!-- begin hcd modal -->
<div id="hcd-modal" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"  style="width: 75%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="bold" style="text-align: right; padding-right: 5%">Annex A</h4>
                <h4 class="modal-title bold" style="text-align: center;">Health Check Declaration Form</h4>
            </div>

            <div class="modal-body" style="width: 100%;">
                <form id="hcd_form">
                    <div style="margin-left: 5%">
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2 col-sm-12">Date:</label>
                            <div class="col-lg-3 col-md-9 col-sm-12">
                                <input type="text" class="form-control form-control-sm date-picker form-required" id="txtdate" name="txtdate" data-date-format="yyyy-mm-dd">
                            </div>
                            <label class="col-form-label col-lg-2 col-sm-12"><b>Temperature:</b></label>
                            <div class="col-lg-4 col-md-9 col-sm-12">
                                <input type="text" class="form-control form-control-sm form-required" id="txttemp" name="txttemp">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2 col-sm-12">Name:</label>
                            <div class="col-lg-3 col-md-9 col-sm-12">
                                <input type="text" class="form-control form-control-sm form-required" id="txtname" name="txtname">
                            </div>
                            <label class="col-form-label col-lg-1 col-sm-12">Sex:</label>
                            <div class="col-lg-3 col-md-9 col-sm-12" style="text-align:left; ">
                                <label class="radio-inline"><input type="radio" name="rdosex" value="M" checked>Male</label>
                                <label class="radio-inline"><input type="radio" name="rdosex" value="F">Female</label>
                            </div>
                            <label class="col-form-label col-lg-1 col-sm-12">Age:</label>
                            <div class="col-lg-1 col-md-9 col-sm-12" >
                                <input type="text" class="form-control form-control-sm form-required" id="txtage" name="txtage">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-form-label col-lg-2 col-sm-12 tl">Residence &<br>Contact No.:</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" class="form-control form-control-sm form-required" id="txtrescon" name="txtrescon">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-form-label col-lg-2 col-sm-12 tl">Email:</label>
                            <div class="col-lg-9 col-md-9 col-sm-12">
                                <input type="text" class="form-control form-control-sm form-required" id="txtemail" name="txtemail">
                            </div>
                        </div>

                        <div class="form-group row iswfh" hidden>
                            <label class="col-form-label col-lg-2 col-sm-12 tl">Nature of Visit:<br>(Please check one):</label>
                            <div class="col-lg-3 col-md-9 col-sm-12" style="text-align:left">
                                <label class="radio-inline"><input type="radio" name="rdonvisit" value="Official" checked>Official</label>
                                <label class="radio-inline"><input type="radio" name="rdonvisit" value="Personal">Personal</label>
                            </div>
                            <label class="col-form-label col-lg-2 col-sm-12 tl">Nature of Official Business:<br>(Please check one)</label>
                            <div class="col-lg-3 col-md-9 col-sm-12" style="text-align:left">
                                <label class="radio-inline"><input type="radio" name="rdonob" value="Employee" checked>Employee</label>
                                <label class="radio-inline"><input type="radio" name="rdonob" value="Client">Client</label>
                            </div>
                        </div>
                    </div>
                    <div id="hcd_div">
                        <table class="table table-bordered tblhcd" id="tblhcd" >
                            <colgroup>
                                <col width="80%">
                                <col width="10%">
                                <col width="10%">
                            </colgroup>
                            <thead>
                                <tr>
                                    <th scope="col"></th>
                                    <th scope="col">Yes<label><input type="radio" name="rdochkall" value="1"></label></th>
                                    <th scope="col">No<label><input type="radio" name="rdochkall" value="0"></label></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1. Are you experiencing any of the following? (Nakararanas ka ba ng alinman sa sumusunod?) </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Fever for the past 3 days (Lagnat ano mang oras sa nakalipas 3 araw) Fever = 37.5'c above. <br>                       If yes please specify date when fever was experienced: <input type="text" class="form-control form-control-sm form-required" id="txtq1_1" name="txtq1_1" readonly></td>
                                    <td><label><input type="radio" name="rdoq1_1" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_1" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Dry cough / Cough with phlegm (Tuyong ubo / Ubo na may plema) </td>
                                    <td><label><input type="radio" name="rdoq1_2" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_2" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Fatigue (Pagkapagod) </td>
                                    <td><label><input type="radio" name="rdoq1_3" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_3" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Body pains or Muscle pains (Pananakit ng katawan o kalamnan) </td>
                                    <td><label><input type="radio" name="rdoq1_4" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_4" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Runny nose / Colds (Sipon) </td>
                                    <td><label><input type="radio" name="rdoq1_5" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_5" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Shortness of breath (Hirap sa paghinga) </td>
                                    <td><label><input type="radio" name="rdoq1_6" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_6" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Diarrhea (Pagtatae) </td>
                                    <td><label><input type="radio" name="rdoq1_7" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_7" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Headache (Pananakit ng ulo) </td>
                                    <td><label><input type="radio" name="rdoq1_8" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_8" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Loss of smell (Pagkawala ng pang amoy) </td>
                                    <td><label><input type="radio" name="rdoq1_9" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_9" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Loss of taste (Pagkawala ng panlasa) </td>
                                    <td><label><input type="radio" name="rdoq1_10" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_10" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Loss of appetite (Pagkawala ng ganang kumain) </td>
                                    <td><label><input type="radio" name="rdoq1_11" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_11" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Sore throat (Pananakit ng lalamunan) </td>
                                    <td><label><input type="radio" name="rdoq1_12" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_12" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Difficulty of breathing (Hirap sa paghinga) </td>
                                    <td><label><input type="radio" name="rdoq1_13" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_13" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>&emsp;&emsp;* Body malaise or feeling discomfort due to flu like symptoms (panghihina ng katawan dahil sa trankaso) </td>
                                    <td><label><input type="radio" name="rdoq1_14" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq1_14" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>2. Have you worked together or stayed in the same close environment of a confirmed COVID-19 case? (May nakasama ka ba o nakatrabahong tao na kumpirmadong may COVID-19/may impeksyon ng corona virus?) </td>
                                    <td><label><input type="radio" name="rdoq2" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq2" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>3. Have you had any contact with anyone with fever, cough, colds and sore throat in the past 2 weeks? (Mayroon ka bang nakasama na may lagnat, ubo, sipon o sakit ng lalamunan sa nakalipas na dalawang linggo?) </td>
                                    <td><label><input type="radio" name="rdoq3" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq3" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>4. Have you travelled outside the Philippines in the last 14 days? (Ikaw ba ay nagbyahe sa labas ng Pilipinas sa nakalipas na 14 na araw?) </td>
                                    <td><label><input type="radio" name="rdoq4" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq4" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>5. Have you travelled to any area in NCR aside from your home? (Ikaw ba ay nagpunta sa iba pang parte ng NCR or Metro Manila bukod sa iyong bahay?) Specify (Sabihin kung saan): <br><input type="text" class="form-control form-control-sm form-required" id="txtq5" name="txtq5" readonly></td>
                                    <td><label><input type="radio" name="rdoq5" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq5" value="0"></label></td>
                                </tr>
                                <tr>
                                    <td>6. Have you been asked to self-isolate or quarantine by a doctor or local public health official? (Napagpayuhan o napakiusapan ka na ba ng isang doctor o isang local na opisyal pangkalusugan na ihiwalay ang sarili of self quarantine?) If yes, specify dates covered. (Kung ang sagot ay oo, para sa anong petsa?): <br><input type="text" class="form-control form-control-sm form-required" id="txtq6" name="txtq6" readonly></td>
                                    <td><label><input type="radio" name="rdoq6" value="1"></label></td>
                                    <td><label><input type="radio" name="rdoq6" value="0"></label></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group row" style="margin-left: 5%; width: 90%;">
                        <label class="col-form-label" style="text-align: justify;" id="lblconsent">I hereby authorize the Department of Science and Technology to collect and process the data indicated herein for the purpose of effecting control of the COVID-19 infection. I understand that my personal information is protected by RA 10173, Data Privacy Act of 2012, and I am required by RA 11469, Bayanihan to Heal as One Act, to provide truthful information.</label>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <input type="hidden" name="txtempno" id="txtempno">
                <input type="hidden" name="txtwfh" id="txtwfh">
                <!-- <button type="button" class="btn blue" onclick="submitHCD()"><i class="icon-check"> </i> Submit</button> -->
                <button type="button" class="btn green" onclick="savePDF()"><i class="icon-check"> </i> Download PDF</button>
                <button type="button" class="btn green" onclick="saveExcel()"><i class="icon-check"> </i> Download Excel</button>
                <button type="button" class="btn yellow" data-dismiss="modal"><i class="icon-ban"> </i> Close</button>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
  .tl {
    padding-top: 0%;
  }

  
  .tblhcd input[type="radio"] {
    margin-left: 12px;
    bottom: 1%;
  }
</style>
<!-- end hcd modal -->