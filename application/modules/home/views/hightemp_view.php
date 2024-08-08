<?php 
/** 
Purpose of file:    Default View for 201
Author:             Francis Nikko V. Perez
System Name:        Human Resource Management Information System Version 10
Copyright Notice:   Copyright(C)2018 by the DOST Central Office - Information Technology Division
**/
?>
<?=load_plugin('css',array('datatables'));?>
<!-- BREADCRUMB -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
      <!--   <li>
            <span>HR Module</span>
            <i class="fa fa-circle"></i>
        </li> -->
        <li>
            <span>201 File</span>
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
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN EXAMPLE TABLE PORTLET-->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <i class="icon-user font-dark"></i>
                    <span class="caption-subject bold uppercase"> No. of Personnel w/ temperature above 37.5</span>
                </div>
                
            </div>
            <div class="caption font-dark">
                <div class="row">
                    <label class="col-form-label col-lg-1 col-sm-12">Date filter:</label>
                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                        <input type="text" class="form-control form-control-sm date-picker form-required " id="txtdate" name="txtdate" value="<?=$this->uri->segment(3)?>" data-date-format="yyyy-mm-dd">
                    </div>
                </div>
            </div>
            <div class="portlet-body">
               
                <div class="loading-image"><center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center></div>
                <table class="table table-striped table-bordered table-hover table-checkable order-column" id="tblemployees"  style="display: none">
                    <thead>
                        <tr>
                            <th style="width: 75px;"> No. </th>
                            <th> Name of Employee </th>
                            <th> Office </th>
                            <th style="width: 120px;text-align: center;"> Temperature </th>
                            <th style="text-align: center;"> WFH </th>
                            <th>HCD Form</th>
                           
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i=1; foreach($arrData as $row):?>
                            <tr class="odd gradeX">
                                <td> <?=$i++?> </td>
                                <td> <a href="<?=base_url('hr/profile').'/'.$row['empNumber']?>"><?=$row['fullName']?></a></td>
                                <td> <?=employee_office($row['empNumber'])?> </td>
                                <td align="center"> <?=$row['temperature']?></td>
                                <td align="center"> <input type="checkbox" <?=($row['wfh'] == 1) ? 'checked="checked"' : ''?> name="chkwfh" disabled  /></td>
                                <td align="center"><button type="button" class="btn btn-info" onclick="hcdForm('<?=$row['empNumber']?>')">Details</button></i></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- END EXAMPLE TABLE PORTLET-->
    </div>
</div>
<?php include('_hcd_modal.php'); ?>
<?=load_plugin('js',array('datatables'));?>

<script>
    $(document).ready(function() {
        $('#tblemployees').dataTable( {
            "initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#tblemployees').show();
            }} );

        $('#txtdate').change(function() {
            var _href = "<?=base_url('home/withhightemp')?>";
            _href = _href + '/' + $('#txtdate').val();

            // window.location.href = _href, true;
            setTimeout(function(){document.location.href = _href, true},100);
        });

        var dt = $('.date-picker').datepicker({autoclose: true, });
        $("#hcd_form :input").prop("disabled", true);
    });

    function hcdForm(empNumber){
        var oldURL = window.location.toString();
        var index = 0;
        var newURL = oldURL;
        index = oldURL.indexOf('home');
        if(index == -1){
            index = oldURL.indexOf('?');
        }
        if(index != -1){
            newURL = oldURL.substring(0, index);
        }

        $.ajax({
            type: "GET",
            dataType: "json",
            data: {empNumber: empNumber, dtrDate: $('#txtdate').val()},
            url: newURL+"home/hcdform/",
            success: function (data) {
                $('#hcd-modal').modal('show');

                $("#hcd_form :input[type='text']").val("");

                // $('#tblhcd tr').each(function (index) {
                //     $(this).find('input[type="radio"]').parents('span').removeClass('checked');
                // });
                $("#hcd_form :input[type='radio']").parents('span').removeClass('checked');

                $('#txtempno').val(data.empNumber);
                $('#hcd_form #txtdate').val(data.dtrDate);
                $('#txttemp').val(data.temperature);
                $('#txtname').val(data.fullName);
                $('#txtemail').val(data.email);
                $('input[name=rdosex][value=' + data.sex + ']').prop('checked', true);
                $('input[name=rdosex][value=' + data.sex + ']').parents('span').addClass('checked');
                $('#txtage').val(data.age);
                $('#txtrescon').val(data.residence_contact);

                $('#txtwfh').val(data.wfh);
                if(data.wfh != 1){
                    $('.iswfh').show();
                    $('input[name=rdonvisit][value=' + data.natureVisit + ']').prop('checked', true);
                    $('input[name=rdonvisit][value=' + data.natureVisit + ']').parents('span').addClass('checked');
                    $('input[name=rdonob][value=' + data.natureOb + ']').prop('checked', true);
                    $('input[name=rdonob][value=' + data.natureOb + ']').parents('span').addClass('checked');
                }
                else{
                    $('.iswfh').hide();
                }

                $('input[name=rdoq1_1][value=' + data.q1_1 + ']').prop('checked', true);
                $('input[name=rdoq1_1][value=' + data.q1_1 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_2][value=' + data.q1_2 + ']').prop('checked', true);
                $('input[name=rdoq1_2][value=' + data.q1_2 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_3][value=' + data.q1_3 + ']').prop('checked', true);
                $('input[name=rdoq1_3][value=' + data.q1_3 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_4][value=' + data.q1_4 + ']').prop('checked', true);
                $('input[name=rdoq1_4][value=' + data.q1_4 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_5][value=' + data.q1_5 + ']').prop('checked', true);
                $('input[name=rdoq1_5][value=' + data.q1_5 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_6][value=' + data.q1_6 + ']').prop('checked', true);
                $('input[name=rdoq1_6][value=' + data.q1_6 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_7][value=' + data.q1_7 + ']').prop('checked', true);
                $('input[name=rdoq1_7][value=' + data.q1_7 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_8][value=' + data.q1_8 + ']').prop('checked', true);
                $('input[name=rdoq1_8][value=' + data.q1_8 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_9][value=' + data.q1_9 + ']').prop('checked', true);
                $('input[name=rdoq1_9][value=' + data.q1_9 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_10][value=' + data.q1_10 + ']').prop('checked', true);
                $('input[name=rdoq1_10][value=' + data.q1_10 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_11][value=' + data.q1_11 + ']').prop('checked', true);
                $('input[name=rdoq1_11][value=' + data.q1_11 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_12][value=' + data.q1_12 + ']').prop('checked', true);
                $('input[name=rdoq1_12][value=' + data.q1_12 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_13][value=' + data.q1_13 + ']').prop('checked', true);
                $('input[name=rdoq1_13][value=' + data.q1_13 + ']').parents('span').addClass('checked');
                $('input[name=rdoq1_14][value=' + data.q1_14 + ']').prop('checked', true);
                $('input[name=rdoq1_14][value=' + data.q1_14 + ']').parents('span').addClass('checked');
                $('input[name=rdoq2][value=' + data.q2 + ']').prop('checked', true);
                $('input[name=rdoq2][value=' + data.q2 + ']').parents('span').addClass('checked');
                $('input[name=rdoq3][value=' + data.q3 + ']').prop('checked', true);
                $('input[name=rdoq3][value=' + data.q3 + ']').parents('span').addClass('checked');
                $('input[name=rdoq4][value=' + data.q4 + ']').prop('checked', true);
                $('input[name=rdoq4][value=' + data.q4 + ']').parents('span').addClass('checked');
                $('input[name=rdoq5][value=' + data.q5 + ']').prop('checked', true);
                $('input[name=rdoq5][value=' + data.q5 + ']').parents('span').addClass('checked');
                $('input[name=rdoq6][value=' + data.q6 + ']').prop('checked', true);
                $('input[name=rdoq6][value=' + data.q6 + ']').parents('span').addClass('checked');
                
                $('#txtq1_1').val(data.q1_1_txt);
                $('#txtq5').val(data.q5_txt);
                $('#txtq6').val(data.q6_txt);
            }
        }).fail(function () {
            toastr.error("An error has occurred. Please try again later.");
        });
    }

    function savePDF(){
        var doc = new jsPDF();

        doc.setFontSize(10);
        doc.setFontType('bold');
        doc.text(170, 15, 'Annex A');
        doc.text(80, 20, 'Health Check Declaration Form');

        // doc.line(30, 25, 180, 25);

        doc.setFontType('normal');
        doc.setFontSize(10);
        doc.text(20, 35, 'Date:');
        doc.text(55, 35, $('#txtdate').val());
        doc.line(55, 36, 110, 36);

        doc.text(120, 35, 'Temperature:');
        doc.text(150, 35, $('#txttemp').val());
        doc.line(150, 36, 180, 36);

        doc.text(20, 45, 'Name:');
        doc.text(55, 45, $('#txtname').val());
        doc.line(55, 46, 110, 46);

        doc.text(120, 45, 'Sex:');
        doc.text(145, 45, 'Male');
        doc.text(145, 55, 'Female');
        doc.line(139, 46, 144, 46);
        doc.line(139, 56, 144, 56);
        $("input[name='rdosex']:checked").val() == 'M' ?  doc.text(141, 45, '/') :  doc.text(141, 55, '/');

        doc.text(160, 45, 'Age:');
        doc.text(175, 45, $('#txtage').val());
        doc.line(174, 46, 180, 46);

        doc.text(20, 55, 'Email:');
        doc.text(55, 55, $('#txtemail').val());
        doc.line(55, 56, 110, 56);

        doc.text(20, 65, 'Residence &');
        doc.text(20, 70, 'Contact No.:');
        doc.text($('#txtrescon').val(), 55, 65, {maxWidth: 120, align: "justify"});
        // doc.line(55, 66, 180, 66);
        doc.line(55, 71, 180, 71);
        // doc.text(55, 55, cutString($('#txtrescon').val(),1));
        // doc.text(55, 60, cutString($('#txtrescon').val(),2));

        if($("input[name='wfh-toggle']:checked").val() != "on"){
            doc.text(20, 80, 'Nature of Visit:');
            doc.text(20, 85, '(Please check one)');
            doc.text(65, 80, 'Official');
            doc.text(65, 85, 'Personal');
            doc.line(59, 81, 64, 81);
            doc.line(59, 86, 64, 86);
            $("input[name='rdonvisit']:checked").val() == 'Official' ? doc.text(62, 80, '/') :  doc.text(62, 85, '/');

            doc.text(100, 80, 'Nature of Official Business:');
            doc.text(100, 85, '(Please check one)');
            doc.text(155, 80, 'Employee');
            doc.text(155, 85, 'Client');
            doc.line(149, 81, 154, 81);
            doc.line(149, 86, 154, 86);
            $("input[name='rdonob']:checked").val() == 'Employee' ? doc.text(151, 80, '/') :  doc.text(151, 85, '/');
        }

        // doc.text(20, 95, 'Company Name:');
        // doc.text(55, 95, $('#txtcompname').val());
        // doc.line(55, 96, 180, 96);

        // doc.text(20, 105, 'Company');
        // doc.text(20, 110, 'Address:');
        // doc.text($('#txtcompadd').val(), 55, 105, {maxWidth: 120, align: "justify"});
        // // doc.line(55, 101, 180, 101);
        // doc.line(55, 111, 180, 111);
        // // doc.text(55, 95, cutString($('#txtcompadd').val(),1));
        // // doc.text(55, 100, cutString($('#txtcompadd').val(),2));

        // doc.autoTable({
        //     html:"#tblhcd", 
        //     theme: 'grid', 
        //     startY: 150, 
        //     styles: { 
        //         textColor: [0, 0, 0] 
        //     },
        //     didDrawCell: data => {
        //         // tdtr = data.row.raw[1]._element; // Instance of <tr> element
        //         // console.log(tdtr.getElementsByTagName('span')[0]);
        //         // data.cell.text = 'qqq';
        //         if(data.column.index == 1)
        //         {
        //             // console.log(data.row.raw[1]);
        //             data.cell.text = 'qqq';
        //         }
                
        //     }
        // });


        var table = document.getElementById('tblhcd');
        var columns = [" ", "Yes", "No"];
        var rows = [];
        var chckr = 0;

        $('#tblhcd tr').each(function (index) {
            yes = "";
            no = "";
            qsn = (table.rows[index].cells[0].textContent.trim());

            if(!$(this).find('input[type="radio"]').is(":checked")){
                yes = "";
                no = "";
                chckr++;
            } else {
                if($(this).find('input[type="radio"]:checked').val() == 1)
                    yes = '  /';
                else
                    no = ' /';

                chckr = 0;
            }

            qsn_str = qsn.split(' ');

            if(qsn.charAt(0) == "*")
                qsn = '\t'+qsn;

            if(qsn_str[1] == "Fever")
                    qsn = qsn + ' ' + $('#txtq1_1').val();

            if(qsn.charAt(0) == "5")
                    qsn = qsn + '                                   ' + $('#txtq5').val();

            if(qsn.charAt(0) == "6")
                    qsn = qsn + ' ' + $('#txtq6').val();

            rows.push([qsn,yes,no]);
        });

        // if(chckr > 0){
        //     toastr.warning("Please answer all questions.");
        //     return;
        // }

        // if($("input[name='rdoq5']:checked").val() == "1"){
        //     if($('#txtq5').val() == ""){
        //         $('#txtq5').parent().addClass('has-error');
        //         $('#txtq5').attr("placeholder", "This field is required.");
        //         return;
        //     }else{
        //         $('#txtq5').parent().removeClass('has-error');
        //         $('#txtq5').removeAttr('placeholder');
        //     }
        // }

        rows = rows.slice(0);
        rows.splice(1 - 1, 1);

        doc.autoTable(
            columns, 
            rows,
            {
                theme: 'grid', 
                // margin: { left: 10 },
                startY: 115-25, 
                // tableWidth: 180,    
                styles: { textColor: [0, 0, 0], fontSize: 10, fillColor: [255, 255, 255], halign: 'justify' },
                columnStyles: {
                  0: {
                    cellWidth: 'auto',halign:'left'
                  }
                }
            });           

        let finalY = doc.lastAutoTable.finalY; // The y position on the page
        doc.text($('#lblconsent').text(), 20, finalY+10, {maxWidth: 170, align: "justify"})
        // doc.text(20, 235, $('#lblconsent').text(), "center");

        // doc.text(20, 270, 'Signture:');
        // doc.text(55, 270, $('#txtsign').val());
        // Save the PDF
        doc.save('hcdform_'+$('#txtempno').val()+'_'+$('#txtdate').val()+'.pdf');
    }

    function saveExcel(){
        var table = document.getElementById('tblhcd');
        var columns = [" ", "Yes", "No"];
        var rows = [];
        var chckr = 0;
        $('#tblhcd tr').each(function (index) {
            yes = "";
            no = "";
            qsn = (table.rows[index].cells[0].textContent.trim());

            if(!$(this).find('input[type="radio"]').is(":checked")){
                yes = "";
                no = "";
                chckr++;
            } else {
                if($(this).find('input[type="radio"]:checked').val() == 1)
                    yes = '  /';
                else
                    no = ' /';

                chckr = 0;
            }

            qsn_str = qsn.split(' ');

            if(qsn.charAt(0) == "*")
                qsn = '\t'+qsn;

            // if(qsn_str[1] == "Fever")
            //         qsn = qsn + ' ' + $('#txtq1_1').val();

            // if(qsn.charAt(0) == "5")
            //         qsn = qsn + '                                   ' + $('#txtq5').val();

            // if(qsn.charAt(0) == "6")
            //         qsn = qsn + ' ' + $('#txtq6').val();

            rows.push([qsn,yes,no]);
        });
        
        var workbook = {
        SheetNames : ["Sheet1"],
        Sheets: {
            "Sheet1": {
                "K2": {  
                    v: "Annex A", 
                    s: { font: {bold: true}, alignment: {wrapText: true, horizontal: "center"} }
                },
                "B3": {
                    v: "Health Check Declaration Form", 
                    s: { font: {bold: true}, alignment: {wrapText: true, horizontal: "center"} }
                },
                "B6": {
                    v: "Date:",
                    s: { alignment: {wrapText: true} }
                },
                "D6": {
                    v: $('#txtdate').val(),
                    s: { alignment: {wrapText: true} }
                },
                "H6": {
                    v: "Temperature:",
                    s: { alignment: {wrapText: true} }
                },
                "J6": {
                    v: $('#txttemp').val(),
                    s: { alignment: {wrapText: true} }
                },
                "K6": {
                    v: "Age:",
                    s: { alignment: {wrapText: true} }
                },
                "L6": {
                    v: $('#txtage').val(),
                    s: { alignment: {wrapText: true} }
                },
                "B7": {
                    v: "Name:",
                    s: { alignment: {wrapText: true} }
                },
                "D7": {
                    v: $('#txtname').val(),
                    s: { alignment: {wrapText: true} }
                },
                "H7": {
                    v: "Sex:",
                    s: { alignment: {wrapText: true} }
                },
                "J7": {
                    v: $("input[name='rdosex']:checked").val() == 'M' ? "_/_ Male\n___ Female" : "___ Male\n_/_ Female",
                    s: { alignment: {wrapText: true} }
                },
                "B8": {
                    v: "Email:",
                    s: { alignment: {wrapText: true} }
                },
                "D8": {
                    v: $('#txtemail').val(),
                    s: { alignment: {wrapText: true} }
                },
                "B9": {
                    v: "Residence & Contact No.:",
                    s: { alignment: {wrapText: true} }
                },
                "D9": {
                    v: $('#txtrescon').val(),
                    s: { alignment: {wrapText: true} }
                },
                "B11": {
                    v: "Nature of Visit:\n(Please check one)",
                    s: { alignment: {wrapText: true} }
                },
                "D11": {
                    v: $("input[name='rdonvisit']:checked").val() == 'Official' ? "_/_ Official\n___ Personal" : "___ Official\n_/_ Personal",
                    s: { alignment: {wrapText: true} }
                },
                "G11": {
                    v: "Nature of Official Business:\n(Please check one)",
                    s: { alignment: {wrapText: true} }
                },
                "J11": {
                    v: $("input[name='rdonob']:checked").val() == 'Employee' ? "_/_ Employee\n___ Client" : "___ Employee\n_/_ Client",
                    s: { alignment: {wrapText: true} }
                },
                "J15": {
                    v: "Yes", 
                    s: { font: {bold: true}, alignment: {wrapText: true, horizontal: "center"} }
                },
                "K15": {
                    v: "No", 
                    s: { font: {bold: true}, alignment: {wrapText: true, horizontal: "center"} }
                },
                "B16": {
                    v: rows[1][0], 
                    s: { alignment: {wrapText: true} }
                },
                "B18": {
                    v: "     "+rows[2][0].replace("                       ","")+"\n"+"     "+$('#txtq1_1').val(), 
                    s: { alignment: {wrapText: true} }
                },
                "J18": {
                    v: rows[2][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K18": {
                    v: rows[2][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B21": {
                    v: "     "+rows[3][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J21": {
                    v: rows[3][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K21": {
                    v: rows[3][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B22": {
                    v: "     "+rows[4][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J22": {
                    v: rows[4][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K22": {
                    v: rows[4][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B23": {
                    v: "     "+rows[5][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J23": {
                    v: rows[5][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K23": {
                    v: rows[5][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B24": {
                    v: "     "+rows[6][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J24": {
                    v: rows[6][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K24": {
                    v: rows[6][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B25": {
                    v: "     "+rows[7][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J25": {
                    v: rows[7][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K25": {
                    v: rows[7][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B26": {
                    v: "     "+rows[8][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J26": {
                    v: rows[8][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K26": {
                    v: rows[8][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B27": {
                    v: "     "+rows[9][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J27": {
                    v: rows[9][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K27": {
                    v: rows[9][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B28": {
                    v: "     "+rows[10][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J28": {
                    v: rows[10][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K28": {
                    v: rows[10][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B29": {
                    v: "     "+rows[11][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J29": {
                    v: rows[11][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K29": {
                    v: rows[11][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B30": {
                    v: "     "+rows[12][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J30": {
                    v: rows[12][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K30": {
                    v: rows[12][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B31": {
                    v: "     "+rows[13][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J31": {
                    v: rows[13][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K31": {
                    v: rows[13][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B32": {
                    v: "     "+rows[14][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J32": {
                    v: rows[14][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K32": {
                    v: rows[14][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B33": {
                    v: "     "+rows[15][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J33": {
                    v: rows[15][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K33": {
                    v: rows[15][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B35": {
                    v: rows[16][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J35": {
                    v: rows[16][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K35": {
                    v: rows[16][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B38": {
                    v: rows[17][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J38": {
                    v: rows[17][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K38": {
                    v: rows[17][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B41": {
                    v: rows[18][0], 
                    s: { alignment: {wrapText: true} }
                },
                "J41": {
                    v: rows[18][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K41": {
                    v: rows[18][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B43": {
                    v: rows[19][0]+"\n"+"     "+$('#txtq5').val(), 
                    s: { alignment: {wrapText: true} }
                },
                "J43": {
                    v: rows[19][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K43": {
                    v: rows[19][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B47": {
                    v: rows[20][0]+"\n"+"     "+$('#txtq6').val(), 
                    s: { alignment: {wrapText: true} }
                },
                "J47": {
                    v: rows[20][1], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "K47": {
                    v: rows[20][2], 
                    s: { alignment: {wrapText: true, horizontal: "center", vertical: "center"} }
                },
                "B54": {
                    v: $('#lblconsent').text(), 
                    s: { alignment: {wrapText: true} }
                },
                "!ref":"A1:Z100"
            }
        }
    };

        var ws = workbook.Sheets["Sheet1"];
        const merge = [
            { s: { r: 1, c: 10 }, e: { r: 1, c: 11 } }, //annex
            { s: { r: 2, c: 1 }, e: { r: 2, c: 11 } }, //hcd
            { s: { r: 5, c: 1 }, e: { r: 5, c: 2 } }, //date
            { s: { r: 5, c: 3 }, e: { r: 5, c: 5 } }, //date val
            { s: { r: 5, c: 7 }, e: { r: 5, c: 8 } }, //temp
            { s: { r: 6, c: 1 }, e: { r: 6, c: 2 } }, //name
            { s: { r: 6, c: 3 }, e: { r: 6, c: 5 } }, //name val
            { s: { r: 6, c: 7 }, e: { r: 6, c: 8 } }, //sex
            { s: { r: 6, c: 9 }, e: { r: 7, c: 10 } }, //sex val
            { s: { r: 7, c: 1 }, e: { r: 7, c: 2 } }, //email
            { s: { r: 7, c: 3 }, e: { r: 7, c: 6 } }, //email val
            { s: { r: 8, c: 1 }, e: { r: 9, c: 2 } }, //rescon
            { s: { r: 8, c: 3 }, e: { r: 9, c: 8 } }, //rescon val
            { s: { r: 10, c: 1 }, e: { r: 11, c: 2 } }, //visit
            { s: { r: 10, c: 3 }, e: { r: 11, c: 4 } }, //visit val
            { s: { r: 10, c: 6 }, e: { r: 11, c: 8 } }, //business
            { s: { r: 10, c: 9 }, e: { r: 11, c: 10 } }, //business val

            { s: { r: 14, c: 1 }, e: { r: 14, c: 8 } },

            { s: { r: 15, c: 1 }, e: { r: 16, c: 8 } },
            { s: { r: 15, c: 9 }, e: { r: 16, c: 9 } },
            { s: { r: 15, c: 10 }, e: { r: 16, c: 10 } },

            { s: { r: 17, c: 1 }, e: { r: 18+1, c: 8 } },
            { s: { r: 17, c: 9 }, e: { r: 18+1, c: 9 } },
            { s: { r: 17, c: 10 }, e: { r: 18+1, c: 10 } },

            { s: { r: 19+1, c: 1 }, e: { r: 19+1, c: 8 } },
            { s: { r: 20+1, c: 1 }, e: { r: 20+1, c: 8 } },
            { s: { r: 21+1, c: 1 }, e: { r: 21+1, c: 8 } },
            { s: { r: 22+1, c: 1 }, e: { r: 22+1, c: 8 } },
            { s: { r: 23+1, c: 1 }, e: { r: 23+1, c: 8 } },
            { s: { r: 24+1, c: 1 }, e: { r: 24+1, c: 8 } },
            { s: { r: 25+1, c: 1 }, e: { r: 25+1, c: 8 } },
            { s: { r: 26+1, c: 1 }, e: { r: 26+1, c: 8 } },
            { s: { r: 27+1, c: 1 }, e: { r: 27+1, c: 8 } },
            { s: { r: 28+1, c: 1 }, e: { r: 28+1, c: 8 } },
            { s: { r: 29+1, c: 1 }, e: { r: 29+1, c: 8 } },
            { s: { r: 30+1, c: 1 }, e: { r: 30+1, c: 8 } },

            { s: { r: 31+1, c: 1 }, e: { r: 32+1, c: 8 } },
            { s: { r: 31+1, c: 9 }, e: { r: 32+1, c: 9 } },
            { s: { r: 31+1, c: 10 }, e: { r: 32+1, c: 10 } },

            { s: { r: 33+1, c: 1 }, e: { r: 35+1, c: 8 } },
            { s: { r: 33+1, c: 9 }, e: { r: 35+1, c: 9 } },
            { s: { r: 33+1, c: 10 }, e: { r: 35+1, c: 10 } },

            { s: { r: 36+1, c: 1 }, e: { r: 38+1, c: 8 } },
            { s: { r: 36+1, c: 9 }, e: { r: 38+1, c: 9 } },
            { s: { r: 36+1, c: 10 }, e: { r: 38+1, c: 10 } },

            { s: { r: 39+1, c: 1 }, e: { r: 40+1, c: 8 } },
            { s: { r: 39+1, c: 9 }, e: { r: 40+1, c: 9 } },
            { s: { r: 39+1, c: 10 }, e: { r: 40+1, c: 10 } },

            { s: { r: 41+1, c: 1 }, e: { r: 43+1+1, c: 8 } },
            { s: { r: 41+1, c: 9 }, e: { r: 43+1+1, c: 9 } },
            { s: { r: 41+1, c: 10 }, e: { r: 43+1+1, c: 10 } },

            { s: { r: 44+1+1, c: 1 }, e: { r: 47+1+1+1, c: 8 } },
            { s: { r: 44+1+1, c: 9 }, e: { r: 47+1+1+1, c: 9 } },
            { s: { r: 44+1+1, c: 10 }, e: { r: 47+1+1+1, c: 10 } },

            { s: { r: 53, c: 1 }, e: { r: 56, c: 10 } },
        ];

        if($("input[name='wfh-toggle']:checked").val() == "on"){ 
            delete ws['B11'];
            delete ws['D11'];
            delete ws['G11'];
            delete ws['J11'];
            merge.splice(13, 4);
        }
        ws["!merges"] = merge;
        // wscols = [
        //     {wpx:59},
        //     {wpx:620},
        // ];
        // ws['!cols'] = wscols;
        

        var wopts = { bookType:'xlsx', bookSST:false, type:'binary' };

        var wbout = XLSX.write(workbook,wopts);
        saveAs(new Blob([s2ab(wbout)],{type:""}), "hcd_"+$('#txtdate').val()+".xlsx");
    }

    function s2ab(s) {
        var buf = new ArrayBuffer(s.length);
        var view = new Uint8Array(buf);
        for (var i=0; i<s.length; i++) view[i] = s.charCodeAt(i) & 0xFF;
        return buf;       
    }
</script>
<link href="<?=base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')?>" rel="stylesheet" type="text/css" />
<script src="<?=base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')?>" type="text/javascript"></script>
<script src="<?=base_url('assets/plugins/jspdf/jspdf.min.js')?>"></script>
<script src="<?=base_url('assets/plugins/jspdf/jspdf-autotable.js')?>"></script>

