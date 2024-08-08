<div class="col-md-12">
    <table class="table table-bordered">
        <tr>
            <th style="line-height: 2;width: 10%;" class="active" nowrap>Employee Number :</th>
            <td style="line-height: 2;" colspan="4">
                <b></b> <?=$arrData[0]['empNumber']?>
                <?php if($this->session->userdata('sessUserLevel') == '1'): ?>
                    <a class="btn green btn-sm pull-right" id="btnedit_empnumber"> <i class="icon-pencil"></i> Edit Employee Number </a>
                <?php endif; ?>
            </td>
        </tr>
    </table>
</div>

<?php require 'modal/_empnumber_info.php'; ?>

<script>
    $(document).ready(function() {

        $('#btnedit_empnumber').click(function() {
            $('#edit_empnumber').modal('show');
        });

    });
</script>

