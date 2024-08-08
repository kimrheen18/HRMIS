function check_icon(ext) {
    ext = ext.toLowerCase();
    if(ext.includes(['doc','docx','dotx'])){
        return 'file-word-o';
    }else if(ext.includes(['xlsx','xlsm','xlsx'])){
        return 'file-excel-o';
    }else if(ext.includes(['ppt','pptx'])){
        return 'file-powerpoint-o';
    }else if(ext.includes(['pdf'])){
        return 'file-pdf-o';
    }else if(ext.includes(['jpg','jpeg','png'])){
        return 'file-photo-o';
    }else if(ext.includes(['zip','rar'])){
        return 'file-zip-o';
    }else{
        return 'file';
    }
}

function ellipsisChar(text, size) {
    var len = text.length;
    if (len >= size) {
        // if text length is equal to or more than given size then add ...
        text = text.substring(0, size) + "...";
    }
    return text;
};

function getsegment(num) {
    num += 1;
    var loc = window.location.href.replace('//','');
    var segments = (loc).toString();
    segments = segments.split('/');
    if (segments[num] != undefined) {
        return segments[num];
    }
    return '';
}

function getdata(idname) {
    var loc = window.location.href.replace('//','');
    var ids = (loc).toString();
    ids = ids.split('?');
    ids = ids[1].split('&');

    var id_value = '';
    $.each(ids, function(i,value) {
        arrids = value.split('=');
        if(arrids[0] == idname){
            id_value = arrids[1];
        }
    });

    return id_value;
}

function has_set(idname) {
    var isset = 0;

    var loc = window.location.href.replace('//','');
    var ids = (loc).toString();
    
    if(ids.indexOf("?") >= 0){
        ids = ids.split('?');
        if(ids.indexOf("&") >= 0){
            ids = ids[1].split('&');
        }
        $.each(ids, function(i,value) {
            arrids = value.split('=');
            if(arrids[0] == idname){
                isset = 1;
            }
        });
    }
    return isset;
}

function check_date(el,msg='')
{
    var value = $(el).val();
    var message = msg == '' ? "Invalid input." : msg;
    message = value == '' ? message : 'Invalid input.';

    if(value == '')
    {
        $(el).closest('div.form-group').addClass('has-error');
        $(el).closest('div.form-group').removeClass('has-success');
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $('<i class="fa fa-warning tooltips font-red" data-original-title="'+message+'"></i>').tooltip().insertBefore($(el));
        return 1;
    }else{
        if(/^\d{4}-\d{2}-\d{2}$/.test(value))
        {
            $(el).closest('div.form-group').removeClass('has-error');
            $(el).closest('div.form-group').addClass('has-success');
            $(el).closest('div.form-group').find('i.fa-warning').remove();
            $(el).closest('div.form-group').find('i.fa-check').remove();
            $('<i class="fa fa-check tooltips"></i>').insertBefore($(el));
            return 0;
        }else
        {
            $(el).closest('div.form-group').addClass('has-error');
            $(el).closest('div.form-group').removeClass('has-success');
            $(el).closest('div.form-group').find('i.fa-check').remove();
            $(el).closest('div.form-group').find('i.fa-warning').remove();
            $('<i class="fa fa-warning tooltips font-red" data-original-title="'+message+'"></i>').tooltip().insertBefore($(el));
            return 1;
        }
    }
}

function check_null(el,msg)
{
    $(el).closest('div.form-group').find('i.fa-calendar').remove();
    if($(el).val() == null){
        $(el).val('');
    }
    if($(el).val() != '' && $(el).val().replace(/\s/g, '').length > 0){
        $(el).closest('div.form-group').removeClass('has-error');
        $(el).closest('div.form-group').addClass('has-success');
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $('<i class="fa fa-check tooltips"></i>').insertBefore($(el));
        return 0;
    }else{
        $(el).closest('div.form-group').addClass('has-error');
        $(el).closest('div.form-group').removeClass('has-success');
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $('<i class="fa fa-warning tooltips font-red" data-original-title="'+msg+'"></i>').tooltip().insertBefore($(el));
        return 1;
    }
}

function check_null_select2(el,msg)
{
    $(el).closest('div.form-group').find('i.fa-calendar').remove();
    if($(el).val() == null){
        $(el).val('');
    }
    if($(el).val() != '' && $(el).val() != '0' && $(el).val().replace(/\s/g, '').length > 0){
        $(el).closest('div.form-group').removeClass('has-error');
        $(el).closest('div.form-group').addClass('has-success');
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $('<i class="fa fa-check tooltips"></i>').insertBefore($(el));
        return 0;
    }else{
        $(el).closest('div.form-group').addClass('has-error');
        $(el).closest('div.form-group').removeClass('has-success');
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $('<i class="fa fa-warning tooltips font-red" data-original-title="'+msg+'"></i>').tooltip().insertBefore($(el));
        return 1;
    }
}

function check_number(el,msg='')
{
    var value = $(el).val();
    if(value.substr(value.length - 1) == ',')
    {
        $(el).closest('div.form-group').addClass('has-error');
        $(el).closest('div.form-group').removeClass('has-success');
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $('<i class="fa fa-warning tooltips font-red" data-original-title="Invalid input."></i>').tooltip().insertBefore($(el));
        return 1;
    }else{
        var el_val = value.replace(',', '');
        var message = msg == '' ? "Invalid input." : msg;
        message = el_val == '' ? message : 'Invalid input.';

        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $(el).closest('div.form-group').find('i.fa-check').remove();
        if(isNaN(el_val) == false && $(el).val() != '' && el_val.replace(/\s/g, '').length > 0){
            $(el).closest('div.form-group').removeClass('has-error');
            $(el).closest('div.form-group').addClass('has-success');
            $(el).closest('div.form-group').find('i.fa-warning').remove();
            $(el).closest('div.form-group').find('i.fa-check').remove();
            $('<i class="fa fa-check tooltips"></i>').insertBefore($(el));
            return 0;
        }else{
            $(el).closest('div.form-group').addClass('has-error');
            $(el).closest('div.form-group').removeClass('has-success');
            $(el).closest('div.form-group').find('i.fa-check').remove();
            $(el).closest('div.form-group').find('i.fa-warning').remove();
            $('<i class="fa fa-warning tooltips font-red" data-original-title="'+message+'."></i>').tooltip().insertBefore($(el));
            return 1;
        }
    }
}

function check_str(el)
{
    var el_val = $(el).val().replace(',', '');
    $(el).closest('div.form-group').find('i.fa-warning').remove();
    $(el).closest('div.form-group').find('i.fa-check').remove();
    if(isNaN(el_val) == false && el_val != ''){
        $(el).closest('div.form-group').removeClass('has-error');
        $(el).closest('div.form-group').addClass('has-success');
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $('<i class="fa fa-check tooltips"></i>').insertBefore($(el));
        return 0;
    }else{
        $(el).closest('div.form-group').addClass('has-error');
        $(el).closest('div.form-group').removeClass('has-success');
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $('<i class="fa fa-warning tooltips font-red" data-original-title="Invalid input."></i>').tooltip().insertBefore($(el));
        return 1;
    }
}

function check_time(el)
{
    value = $(el).val();
    if (!/^\d{2}:\d{2}$/.test(value)){
        $(el).closest('div.form-group').addClass('has-error');
        $(el).closest('div.form-group').removeClass('has-success');
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $('<i class="fa fa-warning tooltips font-red" data-original-title="Invalid input."></i>').tooltip().insertBefore($(el));
        return 1;
    }
    var parts = value.split(':');
    if (parts[0] > 23 || parts[1] > 59){
        $(el).closest('div.form-group').addClass('has-error');
        $(el).closest('div.form-group').removeClass('has-success');
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $('<i class="fa fa-warning tooltips font-red" data-original-title="Invalid input."></i>').tooltip().insertBefore($(el));
        return 1;
    }

    $(el).closest('div.form-group').find('i.fa-calendar').remove();
    if($(el).val() != ''){
        $(el).closest('div.form-group').removeClass('has-error');
        $(el).closest('div.form-group').addClass('has-success');
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $('<i class="fa fa-check tooltips"></i>').insertBefore($(el));
        return 0;
    }else{
        $(el).closest('div.form-group').addClass('has-error');
        $(el).closest('div.form-group').removeClass('has-success');
        $(el).closest('div.form-group').find('i.fa-check').remove();
        $(el).closest('div.form-group').find('i.fa-warning').remove();
        $('<i class="fa fa-warning tooltips font-red" data-original-title="Invalid input."></i>').tooltip().insertBefore($(el));
        return 1;
    }
}

function check_year(month,yr)
{
    var month = parseInt(month);
    var yr = parseInt(yr);
    var mon_yr = [1,2];

    if(month == 12){
        mon_yr = [1,yr+1];
    }else{
        mon_yr = [month+1,yr];
    }
    return mon_yr;
}

function mins_to_time(mins)
{
    var hours = Math.floor(mins / 60);          
    var minutes = mins % 60;

    return pad(hours,2)+':'+pad(minutes,2);
}

function numberformat(num)
{
    num = parseFloat(Math.round(num * 100) / 100).toFixed(2);
    var parts = num.toString().split(".");
    parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    if(parts.length == 1){
        parts[1] = "00";
    }
    return parts.join(".");
}

function number_to_month(num,word=0) 
{
    num = Number(num);
    var array_month = ['','Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    var array_month_word = ['','January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    if(word==0){
        return array_month[num];    
    }else{
        return array_month_word[num];
    }   
}

function pad (str, max)
{
  str = str.toString();
  return str.length < max ? pad("0" + str, max) : str;
}

function validate_bsselect(e)
{
	if(e.val() == ''){
		e.prev("i").show().attr('data-original-title', "This field is required.");
		e.closest('div.form-group').addClass('has-error');
		return 1;
	}else{
		e.prev("i").hide();
		e.closest('div.form-group').removeClass('has-error');
		return 0;
	}
}

function validate_text(e)
{
	if(e.val() == ''){
		e.prev("i").show().attr('data-original-title', "This field is required.");
		e.closest('div.form-group').addClass('has-error');
		return 1;
	}else{
		e.prev("i").hide();
		e.closest('div.form-group').removeClass('has-error');
		return 0;
	}	
}

