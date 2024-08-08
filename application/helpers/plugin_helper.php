<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('load_plugin'))
{
    function load_plugin($type,$arrData)
    {
		$CI =& get_instance();
		$str='';
		if($type=="css")
		{
			foreach($arrData as $row):
				switch($row){
					case 'global': $str.='
							<link href="'.base_url('assets/css/fonts.css').'" rel="stylesheet" type="text/css" />
							<link href="'.base_url('assets/plugins/font-awesome/css/font-awesome.min.css').'" rel="stylesheet" type="text/css" />
							<link href="'.base_url('assets/plugins/simple-line-icons/simple-line-icons.min.css').'" rel="stylesheet" type="text/css" />
							<link href="'.base_url('assets/plugins/bootstrap/css/bootstrap.min.css').'" rel="stylesheet" type="text/css" />
							<link href="'.base_url('assets/plugins/uniform/css/uniform.default.css').'" rel="stylesheet" type="text/css" />
							<link href="'.base_url('assets/css/components.css').'" rel="stylesheet" id="style_components" type="text/css" />
							<link href="'.base_url('assets/css/plugins.min.css').'" rel="stylesheet" type="text/css" />
							<!-- END THEME GLOBAL STYLES -->
							<!-- BEGIN PAGE LEVEL STYLES -->
							<link href="'.base_url('assets/css/profile.min.css').'" rel="stylesheet" type="text/css" />
							<!-- END PAGE LEVEL STYLES -->
							<!-- BEGIN THEME LAYOUT STYLES -->
							<link href="'.base_url('assets/css/layout.min.css').'" rel="stylesheet" type="text/css" />
							<link href="'.base_url('assets/css/themes/darkblue.min.css').'" rel="stylesheet" type="text/css" id="style_color" />
							<link href="'.base_url('assets/plugins/bootstrap-toastr/toastr.min.css').'" rel="stylesheet" type="text/css" />
							<link href="'.base_url('assets/css/custom.css').'" rel="stylesheet" type="text/css" />';
					break;
					case 'datatables': $str.='
							<link href="'.base_url('assets/global/plugins/datatables/datatables.min.css').'" rel="stylesheet" type="text/css" />
        					<link href="'.base_url('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css').'" rel="stylesheet" type="text/css" />';
						break;
					case 'select2':
                        $str.=  '<link href="'.base_url('assets/global/plugins/select2/css/select2.min.css').'" rel="stylesheet" type="text/css" />'.
                        		'<link href="'.base_url('assets/global/plugins/select2/css/select2-bootstrap.min.css').'" rel="stylesheet" type="text/css" />'.
                                '<link href="'.base_url('assets/css/components.min.css').'" rel="stylesheet" type="text/css" />'.
                                '<link href="'.base_url('assets/css/plugins.min.css').'" rel="stylesheet" type="text/css" />';
                        break;
                    case 'select':
                        $str.=  '<link href="'.base_url('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css').'" rel="stylesheet" type="text/css" />';
                        break;
					case 'datepicker':
						$str.= '
							<link href="'.base_url('assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css').'" rel="stylesheet" type="text/css" />';
						break;
					case 'timepicker':
						$str.= '
							<link href="'.base_url('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css').'" rel="stylesheet" type="text/css" />';
						break;
					case 'datetimepicker':
						$str.= '
							<link href="'.base_url('assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css').'" rel="stylesheet" type="text/css" />';
						break;
					case 'profile-2': 
						$str.= '<link href="'.base_url('assets/css/profile-2.min.css').'" rel="stylesheet" type="text/css" />';
						break;
					case 'attendance-css': 
						$str.= '<link href="'.base_url('assets/css/attendance-custom.css').'" rel="stylesheet" type="text/css" />';
						break;
					case 'multi-select': 
						$str.= '<link href="'.base_url('assets/global/plugins/jquery-multi-select/css/multi-select.css').'" rel="stylesheet" type="text/css" />';
						break;
				}
			endforeach;
			echo $str;
		}
		if($type=="js")
		{
			foreach($arrData as $row):
				switch($row){
					case 'global': $str.= '
							<script src="'.base_url('assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js').'" type="text/javascript"></script>
					        <script src="'.base_url('assets/plugins/jquery.blockui.min.js').'" type="text/javascript"></script>
					        <script src="'.base_url('assets/plugins/uniform/jquery.uniform.min.js').'" type="text/javascript"></script>
					        <script src="'.base_url('assets/plugins/bootstrap-sessiontimeout/bootstrap-session-timeout.min.js').'" type="text/javascript"></script>
					        <!--script src="'.base_url('assets/js/ui-session-timeout.js').'" type="text/javascript"></script-->
					        <!--script src="../assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script-->
					        <!-- END CORE PLUGINS -->
					        <!-- BEGIN PAGE LEVEL PLUGINS -->
					        <!--script src="../assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script-->
					        <!--script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script-->
					        <!--script src="../assets/global/plugins/gmaps/gmaps.min.js" type="text/javascript"></script-->
					        <!-- END PAGE LEVEL PLUGINS -->
					        <!-- BEGIN THEME GLOBAL SCRIPTS -->
					       <script src="'.base_url('assets/plugins/bootstrap-toastr/toastr.min.js').'" type="text/javascript"></script>
							<script src="'.base_url('assets/js/ui-toastr.js').'" type="text/javascript"></script>
					        <!-- END THEME GLOBAL SCRIPTS -->
					        <!-- BEGIN THEME LAYOUT SCRIPTS -->
					        <script src="'.base_url('assets/js/layout.min.js').'" type="text/javascript"></script>
					        <!--script src="'.base_url('assets/layouts/layout/scripts/demo.js').'" type="text/javascript"></script-->
					        <script src="'.base_url('assets/js/quick-sidebar.min.js').'" type="text/javascript"></script>';
						break;
					case 'datatables': $str.='
							<script src="'.base_url('assets/js/datatable.js').'" type="text/javascript"></script>
							<script src="'.base_url('assets/plugins/datatables/datatables.min.js').'" type="text/javascript"></script>
							<script src="'.base_url('assets/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js').'" type="text/javascript"></script>
							<script src="'.base_url('assets/js/table-datatables-libraries.js').'" type="text/javascript"></script>';
						break;
					case 'datatables-scroller': $str.='
							<script src="'.base_url('assets/pages/scripts/table-datatables-scroller.min.js').'" type="text/javascript"></script>';
						break;
					case 'validation': $str.='
							<script src="'.base_url('assets/plugins/jquery-validation/js/jquery.validate.min.js').'" type="text/javascript"></script>
							<script src="'.base_url('assets/plugins/jquery-validation/js/additional-methods.min.js').'" type="text/javascript"></script>
							<script src="'.base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js').'" type="text/javascript"></script>
							';
						break;
					case 'form_validation': $str.='
							<script src="'.base_url('assets/js/js-validation/custom-form-validation.js').'" type="text/javascript"></script>
							';
						break;
					case 'personnel-profile-val': $str.='
							<script src="'.base_url('assets/js/js-validation/personnel_profile-validation.js').'" type="text/javascript"></script>
							';
						break;
					case 'val_libraries':
                        $str.= '<script src="'.base_url('assets/js/js-validation/libraries-validation.js').'" type="text/javascript"></script>';
                    	break;
					case 'datepicker': $str.= '<script src="'.base_url('assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js').'" type="text/javascript"></script>';
						break;
					case 'timepicker': $str.= '<script src="'.base_url('assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js').'" type="text/javascript"></script>';
						break;
					case 'datetimepicker': $str.= '<script src="'.base_url('assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js').'" type="text/javascript"></script>';
						break;
					case 'highcharts': $str.= '<script src="'.base_url('assets/plugins/highcharts/js/highcharts.js').'" type="text/javascript"></script>';
						break;
					case 'select2':
                    	$str.=  '<script src="'.base_url('assets/global/plugins/select2/js/select2.full.min.js').'" type="text/javascript"></script>'.
                                    '<script src="'.base_url('assets/global/scripts/app.min.js').'" type="text/javascript"></script>'.
                                    '<script src="'.base_url('assets/pages/scripts/components-select2.min.js').'" type="text/javascript"></script>';
                    	break;
                   	case 'select':
                   	    $str.=  '<script src="'.base_url('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js').'" type="text/javascript"></script>'.
                   	                    '<script src="'.base_url('assets/global/scripts/app.min.js').'" type="text/javascript"></script>'.
                   	                    '<script src="'.base_url('assets/pages/scripts/components-bootstrap-select.min.js').'" type="text/javascript"></script>';
                   	    break;
                   	case 'multi-select':
                   	    $str.=  '<script src="'.base_url('assets/global/plugins/jquery-multi-select/js/jquery.multi-select.js').'" type="text/javascript"></script>'.
                   	                    '<script src="'.base_url('assets/global/scripts/app.min.js').'" type="text/javascript"></script>'.
                   	                    '<script src="'.base_url('assets/pages/scripts/components-multi-select.min.js').'" type="text/javascript"></script>';
                   	    break;
                   	case 'form-wizard':
                   	    $str.=  '<script src="'.base_url('assets/global/plugins/jquery-validation/js/jquery.validate.min.js').'" type="text/javascript"></script>'.
                   	    				'<script src="'.base_url('assets/global/plugins/bootstrap-wizard/jquery.bootstrap.wizard.min.js').'" type="text/javascript"></script>'.
                   	                    '<script src="'.base_url('assets/global/scripts/app.min.js').'" type="text/javascript"></script>'.
                   	                    '<script src="'.base_url('assets/pages/scripts/form-wizard.min.js').'" type="text/javascript"></script>';
                   	    break;

				}
			endforeach;
			echo $str;
		}
	}
}

# Icon
if ( ! function_exists('check_icon'))
{
    function check_icon($ext)
    {
        $ext = strtolower($ext);

        if(in_array($ext,array('doc','docx','dotx'))):
	        return 'file-word-o';
	    elseif(in_array($ext,array('xlsx','xlsm','xlsx'))):
	        return 'fa fa-file-excel-o';
	    elseif(in_array($ext,array('ppt','pptx'))):
	        return 'fa fa-file-powerpoint-o';
	    elseif(in_array($ext,array('pdf'))):
	        return 'fa fa-file-pdf-o';
	    elseif(in_array($ext,array('jpg','jpeg','png'))):
	        return 'fa fa-file-photo-o';
	    elseif(in_array($ext,array('zip','rar'))):
	        return 'fa fa-file-zip-o';
	    else:
	        return 'fa fa-file';
	   	endif;
	}
}


# set sql mode
if ( ! function_exists('set_sql_mode'))
{
    function set_sql_mode()
    {
        $CI =& get_instance();
       	$CI->db->query("set global sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';");
       	$CI->db->query("set session sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';");
    }
}