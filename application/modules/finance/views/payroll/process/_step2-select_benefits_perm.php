<?=form_open($form, array('class' => 'form-horizontal', 'method' => 'post', 'id' => 'frmcompute'))?>
<div class="tab-content">
    <div class="loading-fade" style="display: none;width: 80%;height: 100%;top: 150px;">
        <center><img src="<?=base_url('assets/images/spinner-blue.gif')?>"></center>
    </div>
    <div class="tab-pane active" id="tab-payroll">
        <input type="hidden" name="txtprocess" value='<?=$process_details?>'>
        <h3>Select Benefits</h3>
        <div class="block" style="margin-bottom: 10px;">
            <small style="margin-left: 10px;">
                Payroll Date: <b><?=date("F", mktime(0, 0, 0, $_POST['mon'], 10)).' '.$_POST['yr']?></b> |
                Use data from: <b><?=date("F", mktime(0, 0, 0, $_POST['data_fr_mon'], 10)).' '.$_POST['data_fr_yr']?></b> |
                For: <b><?=$_POST['selemployment']?></b>
            </small>
        </div>
        <div class="portlet-body">
            <!-- Monthly Benefits -->
            <div class="row" id="row-benefit">
                <div class="col-md-11" style="margin-left: 40px;">
                    <label class="checkbox"><input type="checkbox" id="chkall-benefit" value="chkall"
                        <?=$chk_all_benefits ? 'checked' : ''?>> Check All </label>
                    <div class="portlet-body" id="div-benefit">
                        <label class="checkbox col-md-3" <?=in_array('SALARY',array_column($process,'processCode'))?'style="display:none"':''?>>
                            <input type="checkbox" class="chkbenefit" name="chksalary" value="psalary" <?=in_array('SALARY',array_column($process,'processCode'))?'':'checked'?>>
                            Monthly Salary
                        </label>
                        <?php foreach($arrBenefit as $benefit):
                                $isselect = 0;
                                if(isset($_GET['data']['chkbenefit'])):
                                    $isselect = in_array($benefit['incomeCode'],$_GET['data']['chkbenefit']) ? 1 : 0;
                                else:
                                    $isselect = isset($_POST['selemployment']) ? strtolower($_POST['selemployment']) == 'p' ? 1 : 0 : 0;
                                endif;?>
                                <label class="checkbox col-md-3">
                                    <input type="checkbox" class="chkbenefit" name="chkbenefit[]" value="<?=$benefit['incomeCode']?>"
                                        <?=$isselect ? 'checked' : '' ?>>
                                        <?=ucwords($benefit['incomeDesc'])?>
                                </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <hr id="row-benefit" />
            <!-- Bonus -->
            <div class="row" id="row-bonus">
                <div class="col-md-11" style="margin-left: 40px;">
                    <label class="checkbox"><input type="checkbox" id="chkall-bonus" value="chkall" <?=$chk_all_bonus ? 'checked' : ''?>> Check All </label>
                    <div class="portlet-body" id="div-bonus">
                        <?php foreach($arrBonus as $bonus):
                                $isselect = 0;
                                if(isset($_GET['data']['chkbonus'])):
                                    $isselect = in_array($bonus['incomeCode'],$_GET['data']['chkbonus']) ? 1 : 0;
                                endif;?>
                                <label class="checkbox col-md-3">
                                    <input type="checkbox" class="chkbonus" name="chkbonus[]" value="<?=$bonus['incomeCode']?>"
                                        <?=$isselect ? 'checked' : '' ?>> <?=ucwords($bonus['incomeDesc'])?>
                                </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <hr id="row-bonus" />

            <!-- Income -->
            <div class="row" id="row-income">
                <div class="col-md-11" style="margin-left: 40px;">
                    <label class="checkbox"><input type="checkbox" id="chkall-income" value="chkall" <?=$chk_all_income ? 'checked' : ''?>> Check All </label>
                    <div class="portlet-body" id="div-income">
                        <?php foreach($arrIncome as $income):
                                $isselect = 0;
                                if(isset($_GET['data']['chkincome'])):
                                    $isselect = in_array($income['incomeCode'],$_GET['data']['chkincome']) ? 1 : 0;
                                endif;?>
                                <label class="checkbox col-md-3">
                                    <input type="checkbox" name="chkincome[]" class="chkincome" value="<?=$income['incomeCode']?>"
                                        <?=$isselect ? 'checked' : '' ?>> <?=ucwords($income['incomeDesc'])?>
                                </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <br><br>

    </div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            <a href='<?=base_url("finance/payroll_update/process?data=".json_encode($_POST))?>' class="btn default btn-previous">
                <i class="fa fa-angle-left"></i> Back </a>
            <button type="submit" class="btn blue btn-submit" id="btncompute"> Compute </button>
        </div>
    </div>
</div>
<?=form_close()?>

<script>
    $(document).ready(function() {
        $('button#btncompute').on('click', function(e) {
            // e.preventDefault();
            $('.loading-fade').show();
        });
        // Benefits
        $('#chkall-benefit').click(function() {
            if($(this).prop('checked')){
                $('div#div-benefit > label.checkbox').find('div.checker > span').addClass('checked');
                $('div#div-benefit').find('input.chkbenefit').prop('checked', true);
            }else{
                $('div#div-benefit > label.checkbox').find('div.checker > span').removeClass('checked');
                $('div#div-benefit').find('input.chkbenefit').prop('checked', false);
            }
        });
        // Bonus
        $('#chkall-bonus').click(function() {
            if($(this).prop('checked')){
                $('div#div-bonus > label.checkbox').find('div.checker > span').addClass('checked');
                $('div#div-bonus').find('input.chkbonus').prop('checked', true);
            }else{
                $('div#div-bonus > label.checkbox').find('div.checker > span').removeClass('checked');
                $('div#div-bonus').find('input.chkbonus').prop('checked', false);
            }
        });
        // income
        $('#chkall-income').click(function() {
            if($(this).prop('checked')){
                $('div#div-income > label.checkbox').find('div.checker > span').addClass('checked');
                $('div#div-income').find('input.chkincome').prop('checked', true);
            }else{
                $('div#div-income > label.checkbox').find('div.checker > span').removeClass('checked');
                $('div#div-income').find('input.chkincome').prop('checked', false);
            }
        });
    });
</script>