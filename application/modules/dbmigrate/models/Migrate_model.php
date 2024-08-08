<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migrate_model extends CI_Model {

	function __construct()
	{
		$this->load->database();
		$this->db->initialize();
		$this->load->dbforge();
		$this->path = 'schema/data/migration/schema/hrmis-schema-upt.sql';
		$this->created_sys_sql = 'schema/hrmisv10/hrmis-schema-upt.sql';
	}
	
	function comparing_tables()
	{
		$this->hrmisv10 = null;
		$tbldb_hrmisv10 = array();
		$tbldb_hrmis = array();

		$this->create_log('<br>Create database hrmisv10_upt..');
		$check_db_exist = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'hrmisv10_upt'";
		$db_new_isexist = $this->db->query($check_db_exist)->result_array();
		if(count($db_new_isexist) > 0):
			$this->hrmisv10 = $this->load->database('hrmisv10_upt', TRUE);
		else:
			$create_db = $this->db->query('CREATE DATABASE IF NOT EXISTS hrmisv10_upt');
			if(!$create_db):
				$this->create_log('<br><b>ERR!!</b> Error in creating database for migration..');
			endif;
			$db_new_isexist = $this->db->query($check_db_exist)->result_array();
		endif;

		if(count($db_new_isexist) > 0):
			$this->create_log('<br>Checking database if not empty...');
			$this->hrmisv10 = $this->load->database('hrmisv10_upt', TRUE);
			if(count($this->hrmisv10->list_tables()) < 1):
				$this->create_log('<br>Importing database...');
				$this->import_database($this->hrmisv10,$this->path,1);
			endif;
			# get the table list from hrmisv10 schema
			$tbldb_hrmisv10 = $this->hrmisv10->list_tables();
		else:
			$this->create_log('<br><b>ERR!!</b> Error in creating database for migration..');
		endif;

		# get the table list from current database
		$tbldb_hrmis = $this->db->list_tables();

		# create file and start writing sql content
		fopen($this->created_sys_sql, "w") or die("Unable to open file!");

		# call check_tables
		$this->check_tables();
	}

	function check_tables()
    {
    	set_sql_mode();
    	$this->hrmisv10 = $this->load->database('hrmisv10_upt', TRUE);
    	$tbldb_hrmisv10 = $this->hrmisv10->list_tables();
    	$tbldb_hrmis = $this->db->list_tables();

    	$table_removed = 0;
    	$table_added = 0;
    	$sql_file = 'schema/hrmisv10/hrmis-schema-upt_001.sql';
    	# remove file contents
    	if(file_exists($sql_file)):
	    	unlink($sql_file);
	    endif;

    	$this->create_log('<br>Start creating sql file...');
        $this->create_log('<br>Checking Tables...');

        # get tables that does not exist in updated schema
        $this->write_sqlstmt('# Remove unused Tables that does not exist in updated schema',$sql_file);
        $this->write_sqlstmt("# Remove unused Tables...",$sql_file);
        $tbl_toremove = array_diff($tbldb_hrmis,$tbldb_hrmisv10);
        foreach($tbl_toremove as $tbldel):
        	$table_removed++;
        	$this->write_sqlstmt("# Remove table ".$tbldel."...",$sql_file);
        	$this->write_sqlstmt('DROP TABLE IF EXISTS `'.$tbldel.'`;',$sql_file);
        endforeach;
        
        # get tables that exist in updated schema and not exist in current database, then create
        $this->write_sqlstmt("# Add necessary Tables...",$sql_file);
        $tbl_toadd = array_diff($tbldb_hrmisv10,$tbldb_hrmis);
        foreach($tbl_toadd as $tbladd):
        	$table_added++;
        	$this->write_sqlstmt("# Add table ".$tbladd."...",$sql_file);
        	$desc_tbl = $this->hrmisv10->query('DESCRIBE '.$tbladd.';')->result_array();
        	# populate fields
        	$arr_fields = array();
        	$arr_primary = array();
        	foreach($desc_tbl as $field):
        		$isnull = $field['Null'] == 'NO' ? 'NOT NULL' : 'NULL';
        		$default = $field['Default'] != '' ? "default '".$field['Default']."'" : '';
        		array_push($arr_fields,"`".$field['Field']."` ".$field['Type']." ".$isnull." ".$default." ".$field['Extra']);
        		# add primary
        		if($field['Key'] == 'PRI'):
        			array_push($arr_primary,"PRIMARY KEY  (`".$field['Field']."`)");
        		endif;
        	endforeach;

        	$new_tbl = "CREATE TABLE IF NOT EXISTS `".$tbladd."` (".implode(",",$arr_fields).(count($arr_primary) > 0 ? ','.implode(",",$arr_primary) : '').");";
        	$this->create_log($new_tbl);
			$this->write_sqlstmt('# Add table '.$tbladd,$sql_file);
			$this->write_sqlstmt($new_tbl,$sql_file);
        endforeach;
        if(($table_removed + $table_added) > 0):
        	$this->sql_initial_statement($sql_file);
        endif;

    }

    /* STEP 2; Fix Date*/
    function fix_datetime_fields()
    {
    	$sql_file = 'schema/hrmisv10/hrmis-schema-upt_002.sql';
    	$sql_file_S3 = 'schema/hrmisv10/hrmis-schema-upt_002-s3.sql';
    	# remove file contents
    	if(file_exists($sql_file)):
	    	unlink($sql_file);
	    endif;
	    if(file_exists($sql_file_S3)):
	    	unlink($sql_file_S3);
	    endif;

	   	# Fix Time for Holiday Year
	    $this->write_sqlstmt("# Fix Time for Holidays ",$sql_file);
        $this->write_sqlstmt("ALTER TABLE `tblHolidayYear` CHANGE  `holidayTime`  `holidayTime_old_data` VARCHAR(20) NULL DEFAULT  '00:00:00';",$sql_file);
        $this->write_sqlstmt("ALTER TABLE `tblHolidayYear` ADD  `holidayTime` TIME NULL AFTER  `holidayTime_old_data`;",$sql_file);
        $this->write_sqlstmt("ALTER TABLE `tblHolidayYear` ADD  `htime` VARCHAR(20) NULL AFTER  `holidayTime`;",$sql_file);
        $this->write_sqlstmt("ALTER TABLE `tblHolidayYear` ADD  `hmed` VARCHAR(20) NULL AFTER  `htime`;",$sql_file);
        $this->write_sqlstmt("UPDATE `tblHolidayYear` SET htime = SUBSTRING_INDEX(holidayTime_old_data,' ',1);",$sql_file);
        $this->write_sqlstmt("UPDATE `tblHolidayYear` SET hmed = SUBSTRING_INDEX(holidayTime_old_data,' ',-1);",$sql_file);
        $this->write_sqlstmt("UPDATE `tblHolidayYear` SET `holidayTime` = CASE WHEN (hmed = 'AM') THEN CONCAT(htime,':00') WHEN (hmed = 'PM') THEN (TIME(STR_TO_DATE(concat(`holidayDate`,' ',`holidayTime_old_data`),'%Y-%m-%d  %h:%i %p'))) ELSE NULL END;",$sql_file);
        $this->write_sqlstmt("ALTER TABLE `tblHolidayYear` DROP `holidayTime_old_data`, DROP `htime`, DROP `hmed`;",$sql_file);

	   	# Fix Time for Holiday Year
	    $this->write_sqlstmt("# Fix Time for Holidays ",$sql_file);
        $this->write_sqlstmt("ALTER TABLE `tblHolidayYear` CHANGE  `holidayTime`  `holidayTime_old_data` VARCHAR(20) NULL DEFAULT  '00:00:00';",$sql_file);
        $this->write_sqlstmt("ALTER TABLE `tblHolidayYear` ADD  `holidayTime` TIME NULL AFTER  `holidayTime_old_data`;",$sql_file);
        $this->write_sqlstmt("ALTER TABLE `tblHolidayYear` ADD  `htime` VARCHAR(20) NULL AFTER  `holidayTime`;",$sql_file);
        $this->write_sqlstmt("ALTER TABLE `tblHolidayYear` ADD  `hmed` VARCHAR(20) NULL AFTER  `htime`;",$sql_file);
        $this->write_sqlstmt("UPDATE `tblHolidayYear` SET htime = SUBSTRING_INDEX(holidayTime_old_data,' ',1);",$sql_file);
        $this->write_sqlstmt("UPDATE `tblHolidayYear` SET hmed = SUBSTRING_INDEX(holidayTime_old_data,' ',-1);",$sql_file);
        $this->write_sqlstmt("UPDATE `tblHolidayYear` SET `holidayTime` = CASE WHEN (hmed = 'AM') THEN CONCAT(htime,':00') WHEN (hmed = 'PM') THEN (TIME(STR_TO_DATE(concat(`holidayDate`,' ',`holidayTime_old_data`),'%Y-%m-%d  %h:%i %p'))) ELSE NULL END;",$sql_file);
        $this->write_sqlstmt("ALTER TABLE `tblHolidayYear` DROP `holidayTime_old_data`, DROP `htime`, DROP `hmed`;",$sql_file);
        $this->write_sqlstmt("INSERT INTO `tblRequestType` (`requestCode`, `requestDesc`) VALUES ('CTO', 'Compensatory Time Off');",$sql_file);

        if(!$this->check_if_column_exist('tblIncome','income_id')):
            $this->write_sqlstmt("ALTER TABLE `tblIncome` ADD `income_id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`income_id`);",$sql_file);
        endif;

        if(!$this->check_if_column_exist('tblDeductionGroup','deduct_id')):
            $this->write_sqlstmt("ALTER TABLE `tblDeductionGroup` ADD `deduct_id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`deduct_id`);",$sql_file);
        endif;

        if(!$this->check_if_column_exist('tblPayrollProcess','process_id')):
            $this->write_sqlstmt("ALTER TABLE `tblPayrollProcess` ADD `process_id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`process_id`);",$sql_file);
        endif;

        if(!$this->check_if_column_exist('tblEmpDeductionRemit','remitt_id')):
            $this->write_sqlstmt("ALTER TABLE `tblEmpDeductionRemit` ADD `remitt_id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`remitt_id`);",$sql_file);
        endif;

    	$tbldb_hrmis = $this->db->list_tables();
    	foreach($tbldb_hrmis as $tbl):
    		$desc_tbl = $this->db->query('DESCRIBE '.$tbl.';')->result_array();
    		$arr_datatype = array_column($desc_tbl,'Type');
    		$fields_ddtime_to_varchar = array();
    		$fields_varchar_to_ddtime = array();
    		$fields_alter = array();

    		if(in_array('datetime',$arr_datatype)):
    			$this->create_log('<br><br>##DATETIME');
    			foreach($arr_datatype as $key => $dttype):
    				if($dttype == 'datetime'):
    					array_push($fields_ddtime_to_varchar, "CHANGE `".$desc_tbl[$key]['Field']."` `".$desc_tbl[$key]['Field']."` VARCHAR(20) DEFAULT NULL");
    					array_push($fields_varchar_to_ddtime, "CHANGE `".$desc_tbl[$key]['Field']."` `".$desc_tbl[$key]['Field']."` DATETIME DEFAULT NULL");
    					array_push($fields_alter,$desc_tbl[$key]['Field']);
    				endif;
    			endforeach;
    		endif;

    		if(in_array('date',$arr_datatype)):
    			$this->write_sqlstmt("# Fix Date Value ",$sql_file);
    			foreach($arr_datatype as $key => $dttype):
    				if($dttype == 'date'):
    					array_push($fields_ddtime_to_varchar, "CHANGE `".$desc_tbl[$key]['Field']."` `".$desc_tbl[$key]['Field']."` VARCHAR(20) DEFAULT NULL");
    					array_push($fields_varchar_to_ddtime, "CHANGE `".$desc_tbl[$key]['Field']."` `".$desc_tbl[$key]['Field']."` DATE DEFAULT NULL");
    					array_push($fields_alter,$desc_tbl[$key]['Field']);
    				endif;
    			endforeach;
    		endif;

    		if(count($fields_alter) > 0):
	    		$this->write_sqlstmt("# Fix DateTime field in table ".$tbl,$sql_file_S3);
	    		# Alter table, change date/datetime to varchar
	    		$this->write_sqlstmt("ALTER TABLE `".$tbl."` ".implode(',',$fields_ddtime_to_varchar).";",$sql_file_S3);
	    		foreach($fields_alter as $field):
	    			# the update table, set null to datetime field with 0000-00-00 value
	    			$this->write_sqlstmt("UPDATE `".$tbl."` SET `".$field."` = NULL WHERE `".$field."` LIKE '0000%' OR `".$field."` LIKE '%-00-%' OR `".$field."` LIKE '%-00';",$sql_file_S3);
	    			# back the field to its field date/datetime
	    		endforeach;
	    		# Alter table, change varchar to date/datetime
	    		$this->write_sqlstmt("ALTER TABLE `".$tbl."` ".implode(',',$fields_varchar_to_ddtime).";",$sql_file_S3);
	    	endif;

    	endforeach;
    }

    /* STEP 3; Fix Time*/
    /* STEP 4; fix DateTime field in table tblEmpDTR*/
    /* STEP 5; Change inPM to Military Time*/
    /* STEP 6; Change outPM to Military Time*/
    /* STEP 7; Change inOT to Military Time*/
    /* STEP 8; Change outOT to Military Time*/
    /* STEP 9; Drop old field with old data */

    function update_fields()
    {
    	$sql_file = 'schema/hrmisv10/hrmis-schema-upt_003.sql';
    	# remove file contents
    	if(file_exists($sql_file)):
	    	unlink($sql_file);
	    endif;

    	$this->hrmisv10 = $this->load->database('hrmisv10_upt', TRUE);
    	$hrmisv10_table_list = $this->hrmisv10->list_tables();
    	$hrmis_table_list = $this->db->list_tables();

    	if(count($hrmisv10_table_list) != count($hrmis_table_list)):
    		# check if table list from both database is equal
    		$this->create_log('There is error in migrating table, please try again.');
    		die();
    	else:
	    	foreach($hrmisv10_table_list as $tbl):
	    		$field_list_hrmisv10 = $this->hrmisv10->query('DESCRIBE '.$tbl.';')->result_array();
	    		$field_list = $this->db->query('DESCRIBE '.$tbl.';')->result_array();
	    		# compare field that does not exists in current db
	    		$field_diff = array_diff(array_column($field_list_hrmisv10,'Field'),array_column($field_list,'Field'));
	    		$arr_new_fields = array();
	    		$arr_new_primary = '';
	    		if(count($field_diff) > 0):
	    			$new_fields = $this->hrmisv10->query("SHOW COLUMNS FROM ".$tbl." WHERE FIELD IN ('".implode("','",$field_diff)."');")->result_array();
		    		foreach($new_fields as $field):
		    			# check if field is primary, then check if primary key exist in currentdb
		    			$isnull = $field['Null'] == 'NO' ? 'NOT NULL' : 'NULL';
		    			$default = $field['Default'] != '' ? "default '".$field['Default']."'" : '';
		    			if(in_array($field['Key'], array('PRI','UNI'))):
		    				$primary = $this->db->query("SHOW KEYS FROM ".$tbl." WHERE Key_name = 'PRIMARY';")->result_array();
		    				if(count($primary)):
		    					$this->write_sqlstmt("# Drop index for ".$tbl."  \nDROP INDEX `PRIMARY` ON ".$tbl.";",$sql_file);
		    				endif;
		    				$arr_new_primary = ", ADD PRIMARY KEY (`".$field['Field']."`)";
		    				$isnull = 'NOT NULL';
		    			endif;
		    			array_push($arr_new_fields,"ADD `".$field['Field']."` ".$field['Type']." ".$isnull." ".$default." ".$field['Extra']);
		    		endforeach;
		    		$this->write_sqlstmt("# Add new field/s for table ".$tbl,$sql_file);
		    		$this->write_sqlstmt("ALTER TABLE `".$tbl."` ".implode(",",$arr_new_fields).$arr_new_primary.";",$sql_file);
		    	endif;
	    	endforeach;
	    endif;

        # Fix Request Applicant
        $this->write_sqlstmt("UPDATE `tblRequestSignatory` SET `group` = '1' WHERE `tblRequestSignatory`.`SignCode` IN ('SECHEAD','UNSEC','EXECUTIVE');",$sql_file);
        $this->write_sqlstmt("UPDATE `tblRequestSignatory` SET `group` = '2' WHERE `tblRequestSignatory`.`SignCode` = 'SERVICE';",$sql_file);
        $this->write_sqlstmt("UPDATE `tblRequestSignatory` SET `group` = '3' WHERE `tblRequestSignatory`.`SignCode` = 'DIVISION';",$sql_file);
        $this->write_sqlstmt("UPDATE `tblRequestSignatory` SET `group` = '4' WHERE `tblRequestSignatory`.`SignCode` = 'SECTION';",$sql_file);

        # fix user account access level
        $this->write_sqlstmt("UPDATE `tblEmpAccount` SET `userPermission` = 'hr' WHERE LOWER(userPermission) like 'hr%officer';",$sql_file);
        $this->write_sqlstmt("UPDATE `tblEmpAccount` SET `userPermission` = 'hr' WHERE LOWER(userPermission) like 'hr%assistant';",$sql_file);
        $this->write_sqlstmt("UPDATE `tblEmpAccount` SET `userPermission` = 'finance' WHERE LOWER(userPermission) like 'cashier%officer';",$sql_file);
        $this->write_sqlstmt("UPDATE `tblEmpAccount` SET `userPermission` = 'finance' WHERE LOWER(userPermission) like 'cashier%assistant';",$sql_file);
        $this->write_sqlstmt("UPDATE `tblEmpAccount` SET `userPermission` = 'officer' WHERE LOWER(userPermission) like 'chief';",$sql_file);
        $this->write_sqlstmt("UPDATE `tblEmpAccount` SET `userPermission` = 'executive' WHERE LOWER(userPermission) like 'director';",$sql_file);
        $this->write_sqlstmt("UPDATE `tblEmpAccount` SET `userPermission` = 'employee' WHERE LOWER(userPermission) like 'employee';",$sql_file);
        
    }

    function update_data_type()
    {
    	$sql_file = 'schema/hrmisv10/hrmis-schema-upt_004.sql';
    	# remove file contents
    	if(file_exists($sql_file)):
	    	unlink($sql_file);
	    endif;

    	$this->hrmisv10 = $this->load->database('hrmisv10_upt', TRUE);
    	$hrmisv10_table_list = $this->hrmisv10->list_tables();
    	$hrmis_table_list = $this->db->list_tables();

    	if(count($hrmisv10_table_list) != count($hrmis_table_list)):
    		# check if table list from both database is equal
            $this->create_log('hrmisv10_table_list = '.count($hrmisv10_table_list).'||hrmis_table_list = '.count($hrmis_table_list));
            $this->create_log('<br>hrmisv10_table_list:');
            $ctrv10 = 0; $ctrcur = 0;
            foreach($hrmisv10_table_list as $tblv10):
                $this->create_log('<br>'.$ctrv10++.' .'.$tblv10);
            endforeach;
            foreach($hrmis_table_list as $tblcur):
                $this->create_log('<br>'.$tblcur++.' .'.$ctrcur);
            endforeach;
    		$this->create_log('There is error in migrating table, please try again.');
    		die();
    	else:
	    	# compare field type
	    	foreach($hrmisv10_table_list as $tbl):
	    		$field_list_hrmisv10 = $this->hrmisv10->query('DESCRIBE '.$tbl.';')->result_array();
	    		$field_list = $this->db->query('DESCRIBE '.$tbl.';')->result_array();
	    		$common_fields = array_intersect(array_column($field_list_hrmisv10,'Field'),array_column($field_list,'Field'));
	    		$newdb_fields = array_column($field_list_hrmisv10,'Type','Field');
	    		$currdb_fields = array_column($field_list,'Type','Field');
	    		$arr_update_type = array();
	    		foreach($newdb_fields as $key => $hrmisv10_type):
	    			if($newdb_fields[$key] != $currdb_fields[$key]):
	    				$field_key = array_search($key, array_column($field_list_hrmisv10, 'Field'));
	    				$desc_field = $field_list_hrmisv10[$field_key];
	    				$isnull = $desc_field['Null'] == 'NO' ? 'NOT NULL' : 'NULL';
	    				$default = $desc_field['Default'] != '' ? "default '".$desc_field['Default']."'" : '';
	    				array_push($arr_update_type,"CHANGE `".$key."` `".$key."` ".$desc_field['Type']." ".$isnull." ".$default);
	    			endif;
	    		endforeach;

	    		if(count($arr_update_type) > 0):
	    			$this->write_sqlstmt("# Update field/s for table ".$tbl,$sql_file);
	    			$this->write_sqlstmt("ALTER TABLE `".$tbl."` ".implode(",",$arr_update_type).";",$sql_file);
	    		endif;
	    	endforeach;

	    	$this->sql_final_statement();
	    endif;

        # fix Agency
        $this->write_sqlstmt("UPDATE `tblAgency` SET `salarySchedule` = 'semimonthly' WHERE LOWER(`tblAgency`.`salarySchedule`) LIKE 'bi%monthly';",$sql_file);
    }

    function update_database($path='')
    {
    	if($path == ''):
    		$path = $this->created_sys_sql;
    	endif;
    	$this->import_database($this->db,$path);
    }

	function import_database($dbconn,$path,$set=0) 
	{
		set_sql_mode();
		if($set == 0):
			if(file_exists($path)):
			    $sql_contents = file_get_contents($path);
			    $file = fopen($path,"r");
			    while(! feof($file)):
			        $query = fgets($file);
			        if($query != ''):
			        	$pos = strpos($query,'ci_sessions');
			        	if($pos == false):
			        		// $result = $dbconn->query($query);
			        		if(str_replace(' ','',$query) != ''):
				        		if ($dbconn->simple_query($query))
								{
								    $this->create_log($query.'<br>');
								}
								else
								{
									$this->create_log("<font color='red'><b>Query failed!</b></font>");
									$this->create_log($dbconn->error()['message'].'<br>');
									$this->create_log($query.'<br></font>');
								}
							endif;
			        	else:
			        		continue;
			        	endif;
			        endif;
			    endwhile;
			    fclose($file);
			endif;
			$this->create_log('<br>Database Modified Successfully!!...');
		else:
			$sql_contents = file_get_contents($path);
			$sql_contents = explode(";", $sql_contents);

			foreach($sql_contents as $query):
				$pos = strpos($query,'ci_sessions');
				if($pos == false):
					// $result = $dbconn->query($query);
					if(str_replace(' ','',$query) != ''):
						if ($dbconn->simple_query($query))
						{
						    $this->create_log($query.'<br>');
						}
						else
						{
							$this->create_log("<font color='red'><b>Query failed!</b></font>");
							$this->create_log($dbconn->error()['message'].'<br>');
							$this->create_log('<br>');
							$this->create_log($query.'<br></font>');
						}
					endif;
				else:
					continue;
				endif;
			endforeach;
			$this->create_log('<br>Database Initialized Successfully!!...');
		endif;
		
	}

	function write_sqlstmt($txt,$path='')
	{
		if($path == ''):
			$path = $this->created_sys_sql;
		endif;
		file_put_contents($path, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
		if($txt[0] == '#'){
			$this->create_log('<br>'.$txt);
		}
        $log_file = 'schema/data/migration/schema/migrate.log';
        file_put_contents($log_file, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
	}

    function create_log($txt)
    {
        echo $txt;
        $log_file = 'schema/data/migration/schema/migrate.log';
        file_put_contents($log_file, $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
    }

	function sql_initial_statement($path='')
	{
		$this->write_sqlstmt("# Set Global Variable",$path);
		$this->write_sqlstmt("set global sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';",$path);
		$this->write_sqlstmt("set session sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';",$path);
	}

	function sql_final_statement()
	{
		$path = 'schema/hrmisv10/hrmis-schema-upt_0000-inipass.sql';
		
		if(file_exists($path)):
			$sql_inipass = file_get_contents($path);
			$sfind = "start#";
			$str_start = strpos($sql_inipass, $sfind) + strlen($sfind);
			$efind = "#end";
			$str_end = strpos($sql_inipass, $efind);
			$inital_password = substr($sql_inipass,$str_start,($str_end-$str_start));

			$this->create_log("<br><br>Initial data for password: <b>".$inital_password.'</b><br>');
			$total_line = 0;
			$ctrcomment = 0;
			if(file_exists($path)):
			    $sql_contents = file_get_contents($path);
			    $file = fopen($path,"r");
			    while(! feof($file)):
			        $line = fgets($file);
			        $total_line++;
			        if($line[0] == '#' || $line == '') { $ctrcomment++; }
			    endwhile;
			    fclose($file);

			    if($total_line != $ctrcomment):
			        $this->update_database($path);
			    endif;
			    # append file in schema update
			    $str=file_get_contents($path);
			    file_put_contents($path, $str.PHP_EOL , FILE_APPEND | LOCK_EX);

			    unlink($path);
			endif;
		endif;
	}

	function drop_dbase()
	{
		$this->dbforge->drop_database('hrmisv10_upt');
	}

	function check_if_column_exist($tablename,$colname)
    {
     	$tbl = $this->db->query("show tables like '".$tablename."'")->result_array();
     	if(count($tbl) > 0){
     		$cols = $this->db->list_fields($tablename);
     		foreach($cols as $col):
     			if($col == $colname){
     				return true;
     			}
     		endforeach;
     	}else{
     		return false;
     	}

    }

}
