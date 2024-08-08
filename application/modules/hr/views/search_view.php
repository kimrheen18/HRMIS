<link href="<?=base_url('assets/css/search.css')?>" rel="stylesheet" type="text/css" />
<!-- BEGIN PAGE BAR -->
<div class="page-bar">
    <ul class="page-breadcrumb">
        <li>
            <a href="index.html">Home</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <a href="#">Employees</a>
            <i class="fa fa-circle"></i>
        </li>
        <li>
            <span>Search</span>
        </li>
    </ul>
    
</div>
<!-- END PAGE BAR -->
<!-- BEGIN PAGE TITLE-->
<h3 class="page-title"> Search Results
    <i><small><?=isset($_POST['strSearch'])?$_POST['strSearch']:''?></small></i>
</h3>
<!-- END PAGE TITLE-->
<!-- END PAGE HEADER-->
<div class="search-page search-content-4">
    <form class="sidebar-search  " action="<?=base_url('hr/search')?>" method="POST">
    <div class="search-bar bordered">
        <div class="row">
            <div class="col-lg-8">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for..." name="strSearch" autocomplete="off">
                    <span class="input-group-btn">
                        <button class="btn green-soft uppercase bold" type="button">Search</button>
                    </span>
                </div>
            </div>
            <div class="col-lg-4 extra-buttons">
                <button class="btn grey-steel uppercase bold" type="reset">Reset Search</button>
                <button class="btn grey-cararra font-blue" type="button">Advanced Search</button>
            </div>
        </div>
    </div>
    </form>
    <?php if(!empty($arrData)): ?>
    <div class="search-table table-responsive">
        <table class="table table-bordered table-striped table-condensed">
            <thead class="bg-blue">
                <tr>
                    <th>
                        <a href="javascript:;">Status</a>
                    </th>
                    <th>
                        <a href="javascript:;">Employee No.</a>
                    </th>
                    <th>
                        <a href="javascript:;">Name</a>
                    </th>
                    <th>
                        <a href="javascript:;">Office</a>
                    </th>
                    <th>
                        <a href="javascript:;">PDS</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($arrData as $row):?>
                <tr>
                    <td class="table-status">
                        <a href="javascript:;">
                            <i class="icon-arrow-right font-blue"></i>
                        </a>
                    </td>
                    <td class="table-date font-blue">
                        <a href="javascript:;"><?=$row['empNumber']?></a>
                    </td>
                    <td class="table-title">
                        <h3>
                            <a href="javascript:;"><?=$row['firstname']." ".$row['middlename']." ".$row['surname']?></a>
                        </h3>
                        <p>
                            <a href="javascript:;"><?=$row['positionCode']?></a>
                        </p>
                    </td>
                    <td class="table-desc"><?=''?></td>
                    <td class="table-download">
                        <a href="javascript:;">
                            <i class="icon-doc font-green-soft"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach;?>
                
            </tbody>
        </table>
    </div>
<?php else:?>

<?php endif;?>
    <div class="search-pagination pagination-rounded">
        <ul class="pagination">
            <li class="page-active">
                <a href="javascript:;"> 1 </a>
            </li>
            <li>
                <a href="javascript:;"> 2 </a>
            </li>
            <li>
                <a href="javascript:;"> 3 </a>
            </li>
            <li>
                <a href="javascript:;"> 4 </a>
            </li>
        </ul>
    </div>
</div>
<!--script src="<?=base_url('assets/js/search.js')?>" type="text/javascript"></script-->