<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['404_override'] = '';

## Attendance Summary
$route['hr/attendance_summary/index/(:any)'] = 'hr/attendance/attendance_summary/$1';

# Leave
$route['hr/attendance_summary/leave_balance/(:any)'] = 'hr/attendance/leave_balance/$1';
	$route['hr/attendance_summary/leave_balance_update/(:any)'] = 'hr/attendance/leave_balance_update/$1';
	$route['hr/attendance_summary/leave_balance_set/(:any)'] = 'hr/attendance/leave_balance_set/$1';
	$route['hr/attendance_summary/leave_monetization/(:any)'] = 'hr/attendance/leave_monetization/$1';
	$route['hr/attendance_summary/leave_balance_override/(:any)'] = 'hr/attendance/leave_balance_override/$1';
	
$route['hr/attendance_summary/filed_request/(:any)'] = 'hr/attendance/filed_request/$1';

$route['hr/attendance_summary/dtr/(:any)'] = 'hr/attendance/dtr/$1';
	# Broken Sched
	$route['hr/attendance_summary/dtr/edit_mode/(:any)'] = 'hr/attendance/dtr_edit_mode/$1';
	$route['hr/attendance_summary/dtr/dtr_edit'] = 'hr/attendance/dtr_edit';

	# Broken Sched
	$route['hr/attendance_summary/dtr/broken_sched/(:any)'] = 'hr/attendance/dtr_broken_sched/$1';
		$route['hr/attendance_summary/dtr/broken_sched_add/(:any)'] = 'hr/attendance/dtr_add_broken_sched/$1';
		$route['hr/attendance_summary/dtr/broken_sched_edit/(:any)'] = 'hr/attendance/dtr_edit_broken_sched/$1';
		$route['hr/attendance_summary/dtr/broken_sched_delete/(:any)'] = 'hr/attendance/dtr_delete_broken_sched/$1';

	# Local Holiday
	$route['hr/attendance_summary/dtr/local_holiday/(:any)'] = 'hr/attendance/dtr_local_holiday/$1';
		$route['hr/attendance_summary/dtr/local_holiday_add/(:any)'] = 'hr/attendance/dtr_add_local_holiday/$1';
		$route['hr/attendance_summary/dtr/local_holiday_edit/(:any)'] = 'hr/attendance/dtr_edit_local_holiday/$1';
		$route['hr/attendance_summary/dtr/local_holiday_delete/(:any)'] = 'hr/attendance/dtr_delete_local_holiday/$1';

	# OB
	$route['hr/attendance_summary/dtr/ob/(:any)'] = 'hr/attendance/dtr_ob/$1';
		$route['hr/attendance_summary/dtr/ob_add/(:any)'] = 'hr/attendance/dtr_add_ob/$1';
		$route['hr/attendance_summary/dtr/ob_edit/(:any)'] = 'hr/attendance/dtr_edit_ob/$1';

	# Leave
	$route['hr/attendance_summary/dtr/leave/(:any)'] = 'hr/attendance/dtr_leave/$1';
		$route['hr/attendance_summary/dtr/leave_add/(:any)'] = 'hr/attendance/dtr_add_leave/$1';
		$route['hr/attendance_summary/dtr/leave_edit/(:any)'] = 'hr/attendance/dtr_edit_leave/$1';

	# Compensatory Leave
	$route['hr/attendance_summary/dtr/compensatory_leave/(:any)'] = 'hr/attendance/dtr_compensatory_leave/$1';
		$route['hr/attendance_summary/dtr/compensatory_leave_add/(:any)'] = 'hr/attendance/dtr_add_compensatory_leave/$1';
		$route['hr/attendance_summary/dtr/compensatory_leave_edit/(:any)'] = 'hr/attendance/dtr_edit_compensatory_leave/$1';
	
	# DTR Time
	$route['hr/attendance_summary/dtr/time/(:any)'] = 'hr/attendance/dtr_time/$1';
		$route['hr/attendance_summary/dtr/time_add/(:any)'] = 'hr/attendance/dtr_add_time/$1';

	# Travel Order
	$route['hr/attendance_summary/dtr/to/(:any)'] = 'hr/attendance/dtr_to/$1';
		$route['hr/attendance_summary/dtr/to_add/(:any)'] = 'hr/attendance/dtr_add_to/$1';
		$route['hr/attendance_summary/dtr/to_edit/(:any)'] = 'hr/attendance/dtr_edit_to/$1';

	# Flag Ceremony
	$route['hr/attendance_summary/dtr/flagcrmy/(:any)'] = 'hr/attendance/dtr_flagcrmy/$1';
		$route['hr/attendance_summary/dtr/flagcrmy_add/(:any)'] = 'hr/attendance/dtr_add_flagcrmy/$1';

	$route['hr/attendance_summary/dtr/certify_offset/(:any)'] = 'hr/attendance/dtr_certify_offset/$1';
	
$route['hr/attendance_summary/qr_code/(:any)'] = 'hr/attendance/qr_code/$1';

# Override
# -OB
$route['hr/attendance/override/ob'] = 'hr/override/override_ob';
	$route['hr/attendance/override/ob_add'] = 'hr/override/override_ob_add';
	$route['hr/attendance/override/ob_edit/(:any)'] = 'hr/override/override_ob_edit/$1';

# -Exclude DTR
$route['hr/attendance/override/exclude_dtr'] = 'hr/override/exclude_dtr';
	$route['hr/attendance/override/exclude_dtr_add'] = 'hr/override/override_exec_dtr_add';
	$route['hr/attendance/override/exclude_dtr_edit/(:any)'] = 'hr/override/override_exec_dtr_edit/$1';

# - generate DTR
$route['hr/attendance/override/generate_dtr'] = 'hr/override/generate_dtr';
	$route['hr/attendance/override/generate_dtr_allemp'] = 'hr/override/generate_dtr_allemp';

// Signatory
$route['hr/libraries/signatory'] = 'finance/libraries/Signatory/index';
$route['hr/libraries/signatory/add'] = 'finance/libraries/Signatory/add';
$route['hr/libraries/signatory/edit/(:any)'] = 'finance/libraries/Signatory/edit/$1';

# Officer dtr link
// hr/attendance_summary/dtr/0015-CO0-2016?month=06&yr=2019
$route['attendance_summary/(:any)'] = 'hr/attendance/dtr/$1';

# Convert dtr time to standard format
$route['hr/attendance_summary/convert_time'] = 'hr/attendance/convert_time';

