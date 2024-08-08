<?php 
/** 
Purpose of file:    Add Report View for 201
Author:             Rose Anne L. Grefaldeo
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?=load_plugin('css',array('select','select2', 'datatables'))?>
<!-- BREADCRUMB -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Reports</a>
            <i class="fa fa-circle"></i>
        </li>
       
    </ul>
</div>
<!-- END BREADCRUMB -->
<?=form_open(base_url('hr/reports/reports'), array('method' => 'post', 'id' => 'reportform' , 'onsubmit' => 'return checkForBlank()'))?>
 <!-- <?php print_r($arrData) ?>  -->
 <br><br><br><br>
         <div class="row">
             <div class="col-sm-3 text-right">
                <div class="form-group">
                    <label class="control-label">Type of Reports :  <span class="required"> * </span></label>
                </div>
            </div>
             <div class="col-sm-6">
                <div class="form-group">
                   <select type="text" class="form-control select2" name="strReports" value="<?=!empty($this->session->userdata('strReports'))?$this->session->userdata('strReports'):''?>" required>
                         <option value="">Select</option>
                        <?php foreach($arrReports as $report)
                        {
                          echo '<option value="'.$report['reportCode'].'">'.$report['reportDesc'].'</option>';
                        }?>
                  </select>
                </div>
            </div>
             <div class="col-sm-3">
                <div class="form-group">
                     <font color='red'> <span id="idnum"></span></font>
                </div>
            </div>
         </div>
         <br>
         <div class="row per-block">
             <div class="col-sm-3 text-right">
                <div class="form-group">
                    <label class="control-label">Select Name Per : </label>
                </div>
            </div>
             <div class="col-sm-3">
                <div class="form-group">
                    <select name="strSelectPer" id="strSelectPer" type="text" class="form-control bs-select" value="<?=!empty($this->session->userdata('strSelectPer'))?$this->session->userdata('strSelectPer'):''?>">
                    <option value="">Select</option>
                    <option value="0">All Employees</option>
                    <option value="1">Per Employee</option>
                    <option value="2">Per Office</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                     <font color='red'> <span id="salutation"></span></font>
                </div>
            </div>
         </div>   
         <br>
         <div class="row employee-block">
            <div class="col-sm-3 text-right">
                <div class="form-group">
                    <label class="control-label">Employees :</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                     <select type="text" class="form-control select2" name="strEmpName" value="<?=!empty($this->session->userdata('strEmpName'))?$this->session->userdata('strEmpName'):''?>">
                        <option value="">Select</option>
                        <?php foreach($arrEmployees as $i=>$data): ?>
                        <option value="<?=$data['empNumber']?>"><?=(strtoupper($data['surname'].', '.$data['firstname'].' '.$data['middleInitial'].' '.$data['nameExtension']))?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                     <font color='red'> <span id="salutation"></span></font>
                </div>
            </div>
         </div>   

         <div class="row office-block">
            <div class="col-sm-3 text-right">
                <div class="form-group">
                    <label class="control-label">Offices :</label>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                     <select type="text" class="form-control select2" name="strOffice" >
                      <!-- value="<?=!empty($this->session->userdata('strEmpName'))?$this->session->userdata('strEmpName'):''?>" -->
                        <option value="">Select</option>
                        <?php foreach($arrOffice as $i=>$data): ?>
                        <option value="<?=$data['group3Code']?>"><?=$data['group3Name']?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="form-group">
                     <font color='red'> <span id="salutation"></span></font>
                </div>
            </div>
         </div>   
         <!-- fields -->
         <div class="row rpt-fields">
             
        </div>

         <br><br>
           <div class="row">
             <div class="col-sm-3 text-right">
                <div class="form-group">
                    
                </div>
            </div>
             <div class="col-sm-3">
                <div class="form-group">
                    <input type="checkbox" checked="checked" value="Letterhead" name="ch1"/><label for="latest-events">Letterhead</label>
                </div>
            </div>
             <div class="col-sm-3">
                <div class="form-group">
                     <font color='red'> <span id="salutation"></span></font>
                </div>
            </div>
         </div>
         
        <br><br>
        <div class="row">
          <div class="col-sm-12 text-center">
              <button type="button" class="btn btn-primary" name="btnPrint">Print/Preview</button>
          </div>
        </div>

        <div class="modal fade" id="monthly_attendance" style="display:none;">
          <div class="modal-dialog" role="document" style="width:80%">
              <div class="modal-content">
                  <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x
                      </button>
                      <h4 class="modal-title" id="mdlMA">Monthly Attendance Report</h4>
                  </div>
                  <div class="modal-body" style="padding-right: 30px;padding-left: 30px;">
                      <table id="example" class="display"  cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2"></th>
                                <th rowspan="2">Last Name</th>
                                <th rowspan="2">First Name</th>
                                <th rowspan="2">M.I.</th>
                                <th rowspan="2">Poisition</th>
                                <th rowspan="2">Salary</th>
                                <th colspan="2">Attendance</th>
                                <th rowspan="2">Number of days in Office</th>
                                <th rowspan="2">%</th>
                                <th rowspan="2">Laundry</th>
                                <th rowspan="2">Subsistence</th>
                                <th rowspan="2">Hazard</th>
                                <th rowspan="2"></th>
                                <th rowspan="2"></th>
                                <th rowspan="2"></th>
                                <th rowspan="2"></th>
                                <th rowspan="2"></th>
                            </tr>
                            <tr>
                                <th>Office</th>
                                <th>WFH</th>
                            </tr>
                        </thead>
                        <tfoot>
                          <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><b>TOTAL</b></td>
                            <td id="totSal"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td id="totLaun"></td>
                            <td id="totSubs"></td>
                            <td id="totHaz"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                        </tfoot>
                    </table>
                  </div>
                  <!-- <div class="modal-footer">
                      <button type="button" class="btn btn-primary" onclick="saveTask()">Save</button>
                  </div> -->
              </div>
          </div>
        </div>
    <br><br>
<?=form_close()?>
<?=load_plugin('js',array('select','select2', 'datatables'))?>
<script src="<?=base_url('assets/plugins/datatables/buttons.html5.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/plugins/datatables/datatables.buttons.min.js')?>" type="text/javascript"></script>
</head>
<script>

    var table;
    $(document).ready(function() {
      var year = "";
      var date = new Date();
      var month = date.toLocaleString('default', { month: 'long' });
      // console.log(month);
    });

    $(function(){
        $('.per-block, .employee-block, .office-block').hide();

        $('select[name="strReports"]').change(function(){
            $rpt = $(this).val();
            
            if($rpt=='' || $rpt=='LEEA' || $rpt=='LEAGE' || $rpt=='LEDH' || $rpt=='LEDB' || $rpt=='LEG' || $rpt=='LELS' || $rpt=='LESG' || $rpt=='LESGA' || $rpt=='LEDBA' || $rpt=='LR' || $rpt=='LVP' || $rpt=='LEA' || $rpt=='LVP' || $rpt=='PP' || $rpt=='EFDS' || $rpt=='LOYR' || $rpt=='AAR' || $rpt=='MA')
                $('.per-block, .employee-block, .office-block').hide();
            else
                $('.per-block').show();

            $.ajax({
              url: "<?=base_url('hr/reports/getfields')?>/"+$rpt,
              async: false
            }).done(function(data) {
                // console.log(data);
              $( '.rpt-fields' ).html(data);
              setMonthYear();
            });

        });

        $('select[name="strSelectPer"]').change(function(){
            $per = $(this).val();

            if($per==0){
              $('.office-block').hide();
              $('.employee-block').hide();
              $('select[name="strOffice"]').val('').change();
            }
            else if($per==1){
              $('.employee-block').show();
              $('.office-block').hide();
              $('select[name="strOffice"]').val('').change();
            }
            else
            {
              $('.office-block').show();
              $('.employee-block').hide();
            }
        });

        

        $('button[name="btnPrint"]').click(function(){
            $rpt = $('select[name="strReports"]').val();
            $empno = $('select[name="strEmpName"]').val();
            $ofc = $('select[name="strOffice"]').val();
            $per = $('select[name="strSelectPer"]').val();
            $form = $('#reportform').serializeArray();
            $.each($form, function(index,item){
                //if(item.name == 'csrf_dostitd') item.value='<?=time()?>';
                if(item.name == 'csrf_dostitd') delete $form[index];
                //console.log(index+'/'+item.name);
            });
            $form = $.param($form);
            // console.log($ofc);
            //$form['']
            //$form += '&csrf_dostitd=<?=time()?>';
            //console.log($form);
            //console.log($rpt+$empno);
            if($rpt=='DTR')
            {
                $year=$('select[name="dtrYear"]').val();
                $month=$('select[name="dtrMonth"]').val();
                window.open('<?=base_url('employee/dtr/print_preview')?>/'+$empno+'?yr='+$year+'&month='+$month+'&ofc='+$ofc,'toolbar=0');
                return false;
            }
            if($rpt=='PDS')
            {
                if($per==0)
                    window.open('<?=base_url('employee/reports/generate?rpt=reportPDSupdate')?>','toolbar=0');
                else if($per==1)
                    window.open('<?=base_url('employee/reports/generate?rpt=reportPDSupdate')?>&empNumber='+$empno,'toolbar=0');
                else
                    window.open('<?=base_url('employee/reports/generate?rpt=reportPDSupdate')?>&empNumber='+$empno+'&ofc='+$ofc,'toolbar=0');
                return false;
            }
            if($rpt=='MA')
            {
              year = $('select[name="intYear"]').val();
              date = new Date(year, parseInt($('select[name="intMonth"]').val())-1, 1);
              month = date.toLocaleString('default', { month: 'long' });
              $('#monthly_attendance').modal('show');
              $('#mdlMA').text('Monthly Attendance Report ('+month+' '+year+')');

              var createdCell = function(cell) {
                let original;
                cell.setAttribute('contenteditable', true)
                cell.setAttribute('spellcheck', false)
                cell.addEventListener("focus", function(e) {
                  original = e.target.textContent
                })
                cell.addEventListener("blur", function(e) {
                  if (original !== e.target.textContent) {
                    const row = table.row(e.target.parentElement)
                    // row.invalidate()
                    table.cell( this ).data(e.target.textContent) ;
                    var idx = table.cell(this).index();
                    var data = table.row( idx.row ).data();
                    var percent = 0.00;
                    var ofc = 0;
                    var col = "";

                    if(idx.column == 6 || idx.column == 8){
                      ofc = parseInt(e.target.textContent);
                      col = "Office";

                      if(ofc >= 15 && data[17] == 30)
                        percent = 0.30;
                      else if(ofc >= 15 && data[17] == 23)
                        percent = 0.23;
                      else if(ofc >= 15 && data[17] == 15)
                        percent = 0.15;
                      else if(ofc >= 15 && data[17] == 12)
                        percent = 0.12;
                      else if((ofc >= 8 && ofc <= 14) && data[17] == 30)
                        percent = 0.23;
                      else if((ofc >= 8 && ofc <= 14) && data[17] == 23)
                        percent = 0.15;
                      else if((ofc >= 8 && ofc <= 14) && data[17] == 15)
                        percent = 0.12;
                      else if((ofc < 8 && ofc > 0) && data[17] == 30)
                        percent = 0.15;
                      else if((ofc < 8 && ofc > 0) && data[17] == 15)
                        percent = 0.10;
                      else 
                        percent = 0.00;

                      // console.log(percent*100);

                      var oldHaz = parseFloat(data[12].replace(",",""));
                      var newHaz = parseFloat(data[5].replace(",","")) * percent;
                      table.cell({row:idx.row, column:6}).data(e.target.textContent);
                      table.cell({row:idx.row, column:8}).data(e.target.textContent);
                      // table.cell({row:idx.row, column:9}).data(percent*100);
                      table.cell({row:idx.row, column:12}).data(newHaz.toLocaleString('en-US', {minimumFractionDigits:2}));
                      var newTotHaz = 0.00;
                      if(oldHaz > newHaz)
                        newTotHaz = parseFloat($("#totHaz").text().replace(",","")) - (oldHaz - newHaz);
                      else
                        newTotHaz = parseFloat($("#totHaz").text().replace(",","")) + (newHaz - oldHaz);
                      $("#totHaz").text(newTotHaz.toLocaleString('en-US', {minimumFractionDigits:2}));
                    }
                    else if(idx.column == 7){
                      col = "WFH";
                    }

                    var oldLaun = parseFloat(data[10].replace(",",""));
                    var newLaun = (parseInt(data[6])) * parseFloat(data[16]);
                    var newTotLaun = 0.00;
                    table.cell({row:idx.row, column:10}).data(newLaun.toLocaleString('en-US', {minimumFractionDigits:2}));
                    if(oldLaun > newLaun)
                      newTotLaun = parseFloat($("#totLaun").text().replace(",","")) - (oldLaun - newLaun);
                    else
                      newTotLaun = parseFloat($("#totLaun").text().replace(",","")) + (newLaun - oldLaun);
                    $("#totLaun").text(newTotLaun.toLocaleString('en-US', {minimumFractionDigits:2}));

                    var oldSubs = parseFloat(data[11].replace(",",""));
                    var newSubs = (parseInt(data[6])) * parseFloat(data[15]);
                    var newTotSubs = 0.00;
                    table.cell({row:idx.row, column:11}).data(newSubs.toLocaleString('en-US', {minimumFractionDigits:2}));
                    if(oldSubs > newSubs)
                      newTotSubs = parseFloat($("#totSubs").text().replace(",","")) - (oldSubs - newSubs);
                    else
                      newTotSubs = parseFloat($("#totSubs").text().replace(",","")) + (newSubs - oldSubs);
                    $("#totSubs").text(newTotSubs.toLocaleString('en-US', {minimumFractionDigits:2}));

                    // console.log(col);
                    // console.log('Office: '+data[6]);
                    // console.log('WFH: '+data[7]);
                    // console.log('Days Office: '+data[8]);
                    // console.log('Percent: '+data[9]);
                    // console.log('Laundry: '+data[10]);
                    // console.log('Subs: '+data[11]);
                    // console.log('Hazard: '+data[12]);

                    // console.log('attendance: '+data[13]);
                    // console.log('workdays: '+data[14]);
                    // console.log('subsday: '+data[15]);
                    // console.log('laundryday: '+data[16]);
                    // console.log('hpfactor: '+data[17]);
                    // console.log('------------------------------------------------');
                    
                  }
                })
              }

              table = $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                  {
                    extend: 'pdf',
                    text: 'PDF',
                    title: 'Monthly Attendance Report ('+month+' '+year+')',
                    // messageTop: 'for the month of',
                    // messageBottom: 'Administrative Officer IV',
                    filename: 'MonthlyAttendanceReport('+month+''+year+')',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    footer: true,
                    exportOptions:{
                     columns: ':visible'
                    }
                  },
                  {
                    extend: 'excel',
                    text: 'Excel',
                    title: 'Monthly Attendance Report ('+month+' '+year+')',
                    messageTop: ' ',
                    // messageBottom: 'Administrative Officer IV',
                    filename: 'MonthlyAttendanceReport('+month+''+year+')',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    footer: true,
                    exportOptions:{
                     columns: ':visible'
                    }
                  }
                ],
                columnDefs: [
                { 
                  targets: [6,7,8],
                  createdCell: createdCell
                },
                {
                  targets: [0,13,14,15,16,17],
                  visible: false
                }]
              }) 

              var buttonCommon = {
                exportOptions: {
                    format: {
                      body: function (data, row, column, node) {
                        //check if type is input using jquery
                        console.log(data);
                        return $(data).is("form") ?
                        $(data).find('input:submit').val():
                        data;
                        }
                    }
                }
              };

              table = $("#example").DataTable();
              var rows = table
              .rows()
              .remove()
              .draw();

              $.ajax({
                url : '<?php echo site_url('reports/generate/report') ?>/?rpt='+$rpt+'&empno='+$empno+'&'+$form,
                type: "GET",
                dataType: "json",
                // data: {filterStatus: filterStatus},
                success: function(data) {
                  // console.log(data['data']);
                  for(var x = 0; x < data.data.length; x++){
                    if((x+1) != data.data.length){
                      $("#example").dataTable().fnAddData([
                        data.data[x].no,
                        data.data[x].lname,
                        data.data[x].fname,
                        data.data[x].mi,
                        data.data[x].position,
                        data.data[x].salary,
                        data.data[x].ofc,
                        data.data[x].wfh,
                        data.data[x].ofcdays,
                        data.data[x].percent,
                        data.data[x].laundry,
                        data.data[x].subsistence,
                        data.data[x].hazard,
                        data.data[x].attendance,
                        data.data[x].workdays,
                        data.data[x].subsday,
                        data.data[x].laundryday,
                        data.data[x].hpfactor
                      ]);
                    }
                    else{
                      $("#totSal").text(data.data[x].salary);
                      $("#totLaun").text(data.data[x].laundry);
                      $("#totSubs").text(data.data[x].subsistence);
                      $("#totHaz").text(data.data[x].hazard);
                    }
                  }
                }     
              });
              return false;
            }
            if($rpt!='')
                window.open('<?=base_url('reports/generate/report')?>/?rpt='+$rpt+'&empno='+$empno+'&ofc='+$ofc+'&'+$form,'toolbar=0');
        });

        $('#monthly_attendance').on('hidden.bs.modal', function () {
            $('#example').DataTable().clear();
            $('#example').DataTable().destroy();
        });

    });

    function setMonthYear(){
      $('select[name="intYear"]').on('change', function() {
          // console.log(this.value);
          year = this.value;
      });

      $('select[name="intMonth"]').on('change', function() {
          // console.log(this.value);
          month = this.value;
      });
    }

    // $('.editOfc').bind('dblclick',
    //   function(){
    //     $(this).attr('contentEditable',true);
    // });
</script>
