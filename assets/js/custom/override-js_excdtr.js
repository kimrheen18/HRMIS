$(document).ready(function() {
    $('#selemps').multiSelect({ selectableOptgroup: true });
    $('.selper').select2({
        placeholder: "",
        allowClear: true
    });

    all_employees = $.parseJSON($('#json_employee').val());
    // hide all the group
    if($('#spnaction').text().toLowerCase() == 'add'){
        $(".div-group,.div-group1,.div-group2,.div-group3,.div-group4,.div-group5").hide();
    }else{
        var arrgrp_emp = [];
        var arrappt_emp = [];

        var selgroup1 = $('#selgroup1').val();
        if(selgroup1!=0){
            $.each(all_employees, $.proxy(function(i, emp) {
                if(emp.group1 == selgroup1){
                    arrgrp_emp.push(emp);
                }
            }, this));
        }

        var selgroup2 = $('#selgroup2').val();
        if(selgroup2!=0){
            $.each(all_employees, $.proxy(function(i, emp) {
                if(emp.group2 == selgroup2){
                    arrgrp_emp.push(emp);
                }
            }, this));
        }

        var selgroup3 = $('#selgroup3').val();
        if(selgroup3!=0){
            $.each(all_employees, $.proxy(function(i, emp) {
                if(emp.group3 == selgroup3){
                    arrgrp_emp.push(emp);
                }
            }, this));
        }

        var selgroup4 = $('#selgroup4').val();
        if(selgroup4!=0){
            $.each(all_employees, $.proxy(function(i, emp) {
                if(emp.group4 == selgroup4){
                    arrgrp_emp.push(emp);
                }
            }, this));
        }

        var selgroup5 = $('#selgroup5').val();
        if(selgroup5!=0){
            $.each(all_employees, $.proxy(function(i, emp) {
                if(emp.group5 == selgroup5){
                    arrgrp_emp.push(emp);
                }
            }, this));
        }

        if(selgroup1 == 0 && selgroup2 == 0 && selgroup3 == 0 && selgroup4 == 0 && selgroup5 == 0){
            arrgrp_emp = all_employees;
        }

        var apptcode = $('#selappt').val();
        
        if(apptcode!=0){
            $.each(arrgrp_emp, $.proxy(function(i, emp) {
                // console.log(emp.appointmentCode);
                if(emp.appointmentCode == apptcode){
                    arrappt_emp.push(emp);
                }
            }, this));
        }else{ arrappt_emp = arrgrp_emp; }
        
        // console.log(arrappt_emp);
        edit_emp = $.parseJSON($('#txtemp_ob').val());
        console.log(edit_emp);
        $('#selemps').multiSelect('destroy').empty();
        var selemps_data_b = '<optgroup label="SELECT ALL">';
        $.each(arrappt_emp, $.proxy(function(i, emp) {
            e_name = emp.surname + ', ' + emp.firstname + ' ' + emp.middleInitial + '.';
            selected = '';
            if($.inArray(emp.empNumber, edit_emp) !== -1){
                selected = 'selected';
                console.log(emp);
            }
            // $('#selemps').append('<option value="'+ emp.empNumber +'" '+selected+'>'+ e_name +'</option>');
            selemps_data_b = selemps_data_b + '<option value="'+ emp.empNumber +'" '+selected+'>'+ e_name +'</option>';
        }, this));
        $('#selemps').append(selemps_data_b + '</optgroup>');
        $('#selemps').multiSelect({ selectableOptgroup: true });
        console.log(selemps_data_b);
    }

    $('#seltype').change(function() {
        strgrp = $(this).val();
        $(".div-group,.div-group1,.div-group2,.div-group3,.div-group4,.div-group5").hide();

        // begin if select type is not empty
        if(strgrp != ''){
            // begin checking group
            if(strgrp != 'AllEmployees' && strgrp != ''){
                $('.div-type,.div-apptstatus').removeClass('col-md-5').addClass('col-md-4');

                $(".div-group").show();
                $(".div-group"+strgrp).show();
            }else{
                $('.div-type,.div-apptstatus').removeClass('col-md-4').addClass('col-md-5');
            }
            // end checking group
        }
        // end if select type is not empty
    });

    
    $('#selappt,#selgroup1,#selgroup2,#selgroup3,#selgroup4,#selgroup5').on("select2:select", function(e) {
        var arrgrp_emp = [];
        var officename = '';

        /*check if group 1 is visible*/
        if($('div.div-group1').is(":visible")){
            if($('#selgroup1').val() == '0'){
                arrgrp_emp = all_employees;
            }else{
                $.each(all_employees, $.proxy(function(i, emp) {
                    if(emp.group1 == $('#selgroup1').val()){
                        arrgrp_emp.push(emp);
                    }
                }, this));
            }
            officename = $('#selgroup1').val();
        }

        /*check if group 2 is visible*/
        else if($('div.div-group2').is(":visible")){
            if($('#selgroup2').val() == '0'){
                arrgrp_emp = all_employees;
            }else{
                $.each(all_employees, $.proxy(function(i, emp) {
                    if(emp.group2 == $('#selgroup2').val()){
                        arrgrp_emp.push(emp);
                    }
                }, this));
            }
            officename = $('#selgroup2').val();
        }

        /*check if group 3 is visible*/
        else if($('div.div-group3').is(":visible")){
            if($('#selgroup3').val() == '0'){
                arrgrp_emp = all_employees;
            }else{
                $.each(all_employees, $.proxy(function(i, emp) {
                    if(emp.group3 == $('#selgroup3').val()){
                        arrgrp_emp.push(emp);
                    }
                }, this));
            }
            officename = $('#selgroup3').val();
        }

        /*check if group 4 is visible*/
        else if($('div.div-group4').is(":visible")){
            if($('#selgroup4').val() == '0'){
                arrgrp_emp = all_employees;
            }else{
                $.each(all_employees, $.proxy(function(i, emp) {
                    if(emp.group4 == $('#selgroup4').val()){
                        arrgrp_emp.push(emp);
                    }
                }, this));
            }
            officename = $('#selgroup4').val();
        }

        /*check if group 5 is visible*/
        else if($('div.div-group5').is(":visible")){
            if($('#selgroup5').val() == '0'){
                arrgrp_emp = all_employees;
            }else{
                $.each(all_employees, $.proxy(function(i, emp) {
                    if(emp.group5 == $('#selgroup5').val()){
                        arrgrp_emp.push(emp);
                    }
                }, this));
            }
            officename = $('#selgroup5').val();
        }

        else {
            arrgrp_emp = all_employees;
            officename = '';
        }

        /* Appointment Code */
        arrappt_emp = [];
        var apptcode = $('#selappt').val();
        if(apptcode!=0){
            $.each(arrgrp_emp, $.proxy(function(i, emp) {
                if(emp.appointmentCode == apptcode){
                    arrappt_emp.push(emp);
                }
            }, this));
        } else {
            arrappt_emp = arrgrp_emp;
        }

        $('#selemps').multiSelect('destroy').empty();
        if($('#spnaction').text().toLowerCase() == 'edit'){ edit_emp = $.parseJSON($('#txtemp_ob').val()); }
        var selemps_data = '<optgroup label="SELECT ALL">';
        $.each(arrappt_emp, $.proxy(function(i, emp) {
            e_name = emp.surname + ', ' + emp.firstname + ' ' + emp.middleInitial + '.';
            selected = '';
            if($('#spnaction').text().toLowerCase() == 'edit'){
                if($.inArray(emp.empNumber, edit_emp) != -1){
                    selected = 'selected';
                }
            }
            // $('#selemps').append('<option value="'+ emp.empNumber +'" '+selected+'>'+ e_name +'</option>');
            selemps_data = selemps_data + '<option value="'+ emp.empNumber +'" '+selected+'>'+ e_name +'</option>';
        }, this));
        $('#selemps').append(selemps_data + '</optgroup>');
        $('#selemps').multiSelect({ selectableOptgroup: true });

        $('#txtoffice').val(officename);
    });

});