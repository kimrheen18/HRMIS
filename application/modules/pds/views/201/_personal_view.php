<?php $arrData = $arrData[0]; ?>
<table class="table table-bordered table-striped" class="table-responsive">
    <tr>
        <th style="text-align:right;width: 10% !important;">Date of Birth </th>
        <td style="width: 25%;"><?php echo date("m-d-Y", strtotime($arrData['birthday'])); ?></td>

        
        <td colspan="2" class="active" align="center"><b>RESIDENTIAL ADDRESS</b></td>  
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>Place of Birth </th>
        <td><?=$arrData['birthPlace']?></td>
        <th style="text-align:right;" nowrap style="width: 15%;">House/Block/Lot No., Street:</th>
        <td style="width: 35%;"><?=$arrData['lot1'].' '.$arrData['street1']?></td>
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>Sex </th>
        <td><?=$arrData['sex']?></td>
        <th style="text-align:right;" nowrap>Subdivision/Village, Barangay </th>
        <td><?=$arrData['subdivision1'].' '.$arrData['barangay1']?></td>
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>Civil Status </th>
        <td><?=$arrData['civilStatus']?></td>
        <th style="text-align:right;" nowrap>City/Municipality, Province </th>
        <td><?=$arrData['city1'].' '.$arrData['province1']?></td>
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>Citizenship </th>
        <td><?=$arrData['citizenship']?></td>
        <th style="text-align:right;" nowrap>Zip Code </th>
        <?php if($arrData['zipCode1']==0)
        {
            echo '<td></td>';
        } else { ?>
            <td><?=$arrData['zipCode1']?></td>
        <?php } ?>
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>Height (m) </th>
        <td><?=$arrData['height']?></td>
        <th style="text-align:right;" nowrap>Telephone No. </th>
        <td><?=$arrData['telephone1']?></td>
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>Weight (kg) </th>
        <td><?=$arrData['weight']?></td>
        <td colspan="2" class="active" align="center"><b>PERMANENT ADDRESS</b></td>
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>Blood Type </th>
        <td><?=$arrData['bloodType']?></td>
        <th style="text-align:right;" nowrap>House/Block/Lot No., Street:</th>
        <td><?=$arrData['lot2'].' '.$arrData['street2']?></td>
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>GSIS Policy No. </th>
        <td><?=$arrData['gsisNumber']?></td>
        <th style="text-align:right;" nowrap>Subdivision/Village, Barangay </th>
        <td><?=$arrData['subdivision2'].' '.$arrData['barangay2']?></td>
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>GSIS Business Partner No.</th>
        <td><?=$arrData['businessPartnerNumber']?></td>
        <th style="text-align:right;" nowrap>City/Municipality, Province </th>
        <td><?=$arrData['city2'].' '.$arrData['province2']?></td>
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>PHILHEALTH ID No. </th>
        <td><?=$arrData['philHealthNumber']?></td>
        <th style="text-align:right;" nowrap>Zip Code </th>
        <?php if($arrData['zipCode2']==0)
        {
            echo '<td></td>';
        } else { ?>
            <td><?=$arrData['zipCode2']?></td>
        <?php } ?>
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>Pag-ibig ID No. </th>
        <td><?=$arrData['pagibigNumber']?></td>
         <th style="text-align:right;" nowrap>Telephone No. </th>
        <td><?=$arrData['telephone2']?></td>
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>TIN </th>
        <td><?=$arrData['tin']?></td>
        <th style="text-align:right;" nowrap>Payroll Account Number</th>
        <td><?=$arrData['AccountNum']?></td>
    </tr>
     <tr>
        <th style="text-align:right;" nowrap>Email Address </th>
        <td><?=$arrData['email']?></td>
        <th style="text-align:right;" nowrap></th>
        <td></td>
    </tr>
    <tr>
        <th style="text-align:right;" nowrap>Mobile Number </th>
        <td><?=$arrData['mobile']?></td>
        <th style="text-align:right;" nowrap></th>
        <td></td>
    </tr>
</table>

<?php require 'modal/_personal_info.php';?>