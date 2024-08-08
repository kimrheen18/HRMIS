<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['404_override'] = '';

## Employee leave balance
$route['employee/leave_balance/(:any)'] = 'employee/leave/leave_balance/$1';