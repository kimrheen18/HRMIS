<div class="modal fade in" id="edit_empnumber" tabindex="-1" role="full" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h5 class="modal-title uppercase"><b>Edit Employee Number</b></h5>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label">New Employee Number</label>
                    <input type="text" class="form-control" id="txtnew_empnumber" name="txtnew_empnumber" value="">
                    <span class="help-block"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                <a href="javascript:;" class="btn green" id="btnsave_empno">Save</a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        var empnumbers = $.parseJSON('<?=$arrEmpNumbers?>');
        
        $('a#btnsave_empno').click(function() {
            if($.inArray($('#txtnew_empnumber').val(),empnumbers) !== -1){
                $('#txtnew_empnumber').next('.help-block').html('Duplicate data. Employee number is already taken.');
                $('#txtnew_empnumber').closest('div.form-group').addClass('has-error');
            }else{
                $('#txtnew_empnumber').next('.help-block').html('');
                $('#txtnew_empnumber').closest('div.form-group').removeClass('has-error');
                window.location.href = "<?=base_url('pds/edit_empnumber/').$this->uri->segment(3)?>?new_empnumber="+$('#txtnew_empnumber').val();
            }
        });

    });
</script>

