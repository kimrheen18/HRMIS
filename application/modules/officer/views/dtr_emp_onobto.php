<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="<?=base_url('home')?>">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Attendance</span>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Employees Absent</span>
        </li>
    </ul>
</div>
<!-- END PAGE BAR -->
<br>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-dark">
                    <span class="caption-subject bold uppercase"> Employees on OB/TO for the Day</span>
                </div>
            </div>
            
            <div class="portlet-body">
                <div class="row">
                    <div class="tabbable-line tabbable-full-width col-md-8">
                        <ul class="list-group">
                            <?php 
                                if(count($arremployees) > 0):
                                    $no=1;
                                    foreach($arremployees as $employee):
                                        echo '<li class="list-group-item">'.getfullname($employee['empdetails']['firstname'], $employee['empdetails']['surname'], $employee['empdetails']['middlename'], $employee['empdetails']['middleInitial']).'</li>';
                                    endforeach;
                                else:
                                    echo '<li class="list-group-item"><i>No Employee On OB/TO for the Day</i></li>';
                                endif;
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>