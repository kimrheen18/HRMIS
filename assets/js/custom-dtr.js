$(document).ready(function(){
	// $('#tbldtr-employee').dataTable({"scrollY": "200px","scrollCollapse": true,"paging": false} );

	$('[data-toggle="tooltip"]').tooltip();

	$('#btn-present').click(function() {
	    $('.modal-title').html('List of Present Employees');

	    if($.fn.DataTable.isDataTable('#tbldtr-employee')) {
	    	$('#tbldtr-employee').DataTable().destroy();
	    }
	    
	    $('#tbldtr-employee').empty();
	    $('#tbldtr-employee').DataTable({
	    	"ajax": {"type":"GET","url":"dtrkiosk/dtr_kiosk/emp_presents","dataType":"json","dataSrc":""},
	    	"columns": [
	    		{"title":"No",
	    			"render":function(data,type,row,meta) {return meta.row + meta.settings._iDisplayStart + 1;}},
	    		{"title":"Employee Name",
	    			"render":function(data,type,row) {
	    				row.surname = row.surname!='' ? row.surname+', ' : '';
				    	mname = row.middlename == '' ? '' : row.middlename[0];
				    	mid_ini = row.middleInitial!='' ? row.middleInitial.replace('.', '') : mname;
				    	mid_ini = mid_ini!='' ? mid_ini+'.' : '';
				    	mid_ini = mid_ini != '' ? mid_ini.indexOf('.') ? mid_ini : mid_ini+'.' : '';
				    	fullname = row.surname+row.firstname+' '+mid_ini;
	    				return fullname;
	    			}},
	    		{"title":"Time in","data":"inAM"},
	    		{"title":"Time out","data":"outAM"},
	    		{"title":"Time in","data":"inPM"},
	    		{"title":"Time out","data":"outPM"}
	    	],
	    	// "scrollY": "200px","scrollCollapse": true,"paging": false,
	    	"initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#tbldtr-employee').show();},
	    });

	    $('#dtr-modal').modal('show');
	});

	$('#btn-ob').click(function() {
	    $('.modal-title').html('List of On Official Business Employees');

	    if($.fn.DataTable.isDataTable('#tbldtr-employee')) {
	    	$('#tbldtr-employee').DataTable().destroy();
	    }
	    $('#tbldtr-employee').empty();
	    $('#tbldtr-employee').DataTable({
	    	"ajax": {"type":"GET","url":"dtrkiosk/dtr_kiosk/emp_ob","dataType":"json","dataSrc":""},
	    	"columns": [
	    		{"title":"No",
	    			"render":function(data,type,row,meta) {return meta.row + meta.settings._iDisplayStart + 1;}},
	    		{"title":"Employee Name",
	    			"render":function(data,type,row) {
	    				row.surname = row.surname!='' ? row.surname+', ' : '';
				    	mname = row.middlename == '' ? '' : row.middlename[0];
				    	mid_ini = row.middleInitial!='' ? row.middleInitial.replace('.', '') : mname;
				    	mid_ini = mid_ini!='' ? mid_ini+'.' : '';
				    	mid_ini = mid_ini != '' ? mid_ini.indexOf('.') ? mid_ini : mid_ini+'.' : '';
				    	fullname = row.surname+row.firstname+' '+mid_ini;
	    				return fullname;
	    			}}
	    	],
	    	// "scrollY": "200px","scrollCollapse": true,"paging": false,
	    	"initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#tbldtr-employee').show();},
	    });

	    $('#dtr-modal').modal('show');
	});

	$('#btn-leave').click(function() {
	    $('.modal-title').html('List of On Leave Employees');

	    if($.fn.DataTable.isDataTable('#tbldtr-employee')) {
	    	$('#tbldtr-employee').DataTable().destroy();
	    }
	    $('#tbldtr-employee').empty();
	    $('#tbldtr-employee').DataTable({
	    	"ajax": {"type":"GET","url":"dtrkiosk/dtr_kiosk/emp_leave","dataType":"json","dataSrc":""},
	    	"columns": [
	    		{"title":"No",
	    			"render":function(data,type,row,meta) {return meta.row + meta.settings._iDisplayStart + 1;}},
	    		{"title":"Employee Name",
	    			"render":function(data,type,row) {
	    				row.surname = row.surname!='' ? row.surname+', ' : '';
				    	mname = row.middlename == '' ? '' : row.middlename[0];
				    	mid_ini = row.middleInitial!='' ? row.middleInitial.replace('.', '') : mname;
				    	mid_ini = mid_ini!='' ? mid_ini+'.' : '';
				    	mid_ini = mid_ini != '' ? mid_ini.indexOf('.') ? mid_ini : mid_ini+'.' : '';
				    	fullname = row.surname+row.firstname+' '+mid_ini;
	    				return fullname;
	    			}}
	    	],
	    	// "scrollY": "200px","scrollCollapse": true,"paging": false,
	    	"initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#tbldtr-employee').show();},
	    });

	    $('#dtr-modal').modal('show');
	});

	$('#btn-absent').click(function() {
	    $('.modal-title').html('List of Absent Employees');

	    if($.fn.DataTable.isDataTable('#tbldtr-employee')) {
	    	$('#tbldtr-employee').DataTable().destroy();
	    }
	    $('#tbldtr-employee').empty();
	    $('#tbldtr-employee').DataTable({
	    	"ajax": {"type":"GET","url":"dtrkiosk/dtr_kiosk/emp_absents","dataType":"json","dataSrc":""},
	    	"columns": [
	    		{"title":"No",
	    			"render":function(data,type,row,meta) {return meta.row + meta.settings._iDisplayStart + 1;}},
	    		{"title":"Employee Name",
	    			"render":function(data,type,row) {
	    				row.surname = row.surname!='' ? row.surname+', ' : '';
				    	mname = row.middlename == '' ? '' : row.middlename[0];
				    	mid_ini = row.middleInitial!='' ? row.middleInitial.replace('.', '') : mname;
				    	mid_ini = mid_ini!='' ? mid_ini+'.' : '';
				    	mid_ini = mid_ini != '' ? mid_ini.indexOf('.') ? mid_ini : mid_ini+'.' : '';
				    	fullname = row.surname+row.firstname+' '+mid_ini;
	    				return fullname;
	    			}}
	    	],
	    	// "scrollY": "200px","scrollCollapse": true,"paging": false,
	    	"initComplete": function(settings, json) {
                $('.loading-image').hide();
                $('#tbldtr-employee').show();},
	    });

	    $('#dtr-modal').modal('show');
	});
});