<?php /* $Id */
//Copyright (C) 2006 Lenux Inc. (info@lenux.eu)
//
//This program is free software; you can redistribute it and/or
//modify it under the terms of the GNU General Public License
//as published by the Free Software Foundation; either version 2
//of the License, or (at your option) any later version.
//
//This program is distributed in the hope that it will be useful,
//but WITHOUT ANY WARRANTY; without even the implied warranty of
//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//GNU General Public License for more details.


function configpageinit($mydisplay, $mytype) {
	global $currentcomponent;
	if ( $currentcomponent->isequal($mydisplay, $mytype) ) {
		$currentcomponent->addguifunc('cdrcost_'.$mydisplay.'_configpageload');
		$currentcomponent->addprocessfunc('cdrcost_'.$mydisplay.'_configprocess');
		return true;
	}
	return false;
}

function configpageload($menu) {
	global $currentcomponent;
	extract($_REQUEST);
	//error_log(date("H:i:s").": configpageload menu: ".$menu." action: ".$action." extdisplay: ".$extdisplay."\n",3,"/tmp/php.log");
	if ( $action == 'del' ) { // Deleted
		$currentcomponent->addguielem('_top', new gui_subheading('del', $extdisplay.' '._("deleted"), false));
		return false;
	} else {
		if ( $extdisplay == '' ) { // Adding
			$currentcomponent->addguielem('_top', new gui_pageheading('title', 'Add '.$menu, false), 0);
			$currentcomponent->addguielem('_top', new gui_hidden('action', 'add'));
		} elseif ( is_string($extdisplay) ) { // Editing
			$currentcomponent->addguielem('_top', new gui_pageheading('title', "$menu: $extdisplay", false), 0);
			$currentcomponent->addguielem('_top', new gui_hidden('action', 'edit'));
			$delURL = $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'&action=del';
			$currentcomponent->addguielem('_top', new gui_link('del', _("Delete ")." $menu $extdisplay", $delURL, true, false), 0);
		}
		$currentcomponent->addguielem('_top', new gui_hidden('extdisplay', $extdisplay));
		return true;
	}
}

function cdrcost_configprocess($addfun, $delfun, $editfun) {
	extract($_REQUEST);
	switch ($action) {
		case "add":
			$addfun($_REQUEST);
			//needreload();
			break;
		case "del":
			$delfun($extdisplay);
			//needreload();
			break;
		case "edit":
			$editfun($extdisplay,$_REQUEST);
			//needreload();
			break;
	}
}

// returns a associative arrays with keys 'destination' and 'description'
function cdrcost_destinations() {
	return null;
}

/* 	Generates dialplan for conferences
We call this with retrieve_conf
*/
function cdrcost_get_config($engine) {
	global $ext;  // is this the best way to pass this?
	switch($engine) {
		case "asterisk":
		break;
	}
	sql("SET CHARACTER SET utf8","query");
}

/* begin page.zonegroup.php functions */

function cdrcost_zonegroup_add($vars) {
	extract($vars);
	$sql = "INSERT INTO call_zone_group (name) VALUES ('".$name."');";
	sql($sql,"query");
}

function cdrcost_zonegroup_del($id) {
error_log(date("H:i:s").": torol id: ".$id."\n",3,"/tmp/php.log");
	$sql = "DELETE FROM call_zone_group WHERE id = '".$id."'";
	sql($sql,"query");
}

function cdrcost_zonegroup_edit($id,$vars) {
	extract($vars);
	$sql = "UPDATE call_zone_group SET name = '".$name."' WHERE id = '".$id."'";
	sql($sql,"query");
}

function cdrcost_zonegroup_get($id) {
	$sql = "SELECT * FROM call_zone_group WHERE id = '".$id."'";
	return sql($sql,"getAll",DB_FETCHMODE_ASSOC);
}

function cdrcost_zonegroup_list() {
	$sql = "SELECT id, name FROM call_zone_group ORDER BY name";
	return sql($sql,"getAll");
}

function cdrcost_zonegroup_configpageinit($dispnum) {
	configpageinit('zonegroup', 'tool');
}

function cdrcost_zonegroup_configpageload() {
	global $currentcomponent;
	extract($_REQUEST);
	$disppart = 'Zone Group';
	if ( configpageload($disppart) ) {
		$zonegroup = cdrcost_zonegroup_get($extdisplay);
		if ( is_array($zonegroup) && count($zonegroup) == 1 )
			extract($zonegroup[0], EXTR_PREFIX_ALL, 'zonegroup');
		$section = $disppart.' Options';
		$currentcomponent->addguielem($section, new gui_textbox('name', $zonegroup_name, 'Name', 'The name of this Zone Group.', 'isEmpty()', 'Please enter a valid Name'));
	}
}

function cdrcost_zonegroup_configprocess() {
	cdrcost_configprocess(cdrcost_zonegroup_add, cdrcost_zonegroup_del, cdrcost_zonegroup_edit);
}

/* end page.zonegroup.php functions */

/* begin page.zone.php functions */

function cdrcost_zone_add($vars) {
	extract($vars);
	$sql = "INSERT INTO call_zone (group_id, name, pattern) VALUES (";
	$sql .= "'".$group_id."',";
	$sql .= "'".$name."',";
	$sql .= "'".$pattern."');";
	sql($sql,"query");
}

function cdrcost_zone_del($id) {
	$sql = "DELETE FROM call_zone WHERE id = '".$id."'";
	sql($sql,"query");
}

function cdrcost_zone_edit($id,$vars) {
	extract($vars);
	$sql = "UPDATE call_zone SET group_id = '".$group_id."', name = '".$name."', pattern = '".$pattern."' WHERE id = '".$id."'";
	sql($sql,"query");
}

function cdrcost_zone_get($id) {
	$sql = "SELECT * FROM call_zone WHERE id = '".$id."'";
	return sql($sql,"getAll",DB_FETCHMODE_ASSOC);
}

function cdrcost_zone_list() {
	$sql = "SELECT id, name FROM call_zone ORDER BY name";
	return sql($sql,"getAll");
}

function cdrcost_zone_configpageinit($dispnum) {
	global $currentcomponent;
	if ( configpageinit('zone', 'tool') ) {
		$item = 'grouplist';
		$currentcomponent->addoptlist($item, false);
		$list = cdrcost_zonegroup_list();
		if (is_array($list) && count($list) > 0) {
			foreach ($list as $temp) {
				$currentcomponent->addoptlistitem($item, $temp[0], $temp[1]);
			}
		}
	}
}

function cdrcost_zone_configpageload() {
	global $currentcomponent;
	extract($_REQUEST);
	$disppart = 'Zone';
	if ( configpageload($disppart) ) {
		$zone = cdrcost_zone_get($extdisplay);
		if ( is_array($zone) && count($zone) == 1 )
			extract($zone[0], EXTR_PREFIX_ALL, 'zone');
		$section = $disppart.' Options';
		$currentcomponent->addguielem($section, new gui_textbox('name', $zone_name, 'Name', 'The name of this Zone.', 'isEmpty()', 'Please enter a valid Name'));
		$currentcomponent->addguielem($section, new gui_selectbox('group_id', $currentcomponent->getoptlist('grouplist'), $zone_group_id, 'Group', 'The group of this zone', false));
		$currentcomponent->addguielem($section, new gui_textbox('pattern', $zone_pattern, 'Pattern', 'The regex pattern of this Zone.', 'isEmpty()', 'Please enter a valid Pattern'));
	}
}

function cdrcost_zone_configprocess() {
	cdrcost_configprocess(cdrcost_zone_add, cdrcost_zone_del, cdrcost_zone_edit);
}

/* end page.zone.php functions */

/* begin page.schedule.php functions */

function cdrcost_schedule_add($vars) {
	extract($vars);
	$sql = "INSERT INTO call_schedule (name) VALUES ('".$name."');";
	sql($sql,"query");
}

function cdrcost_schedule_del($id) {
	$sql = "DELETE FROM call_schedule WHERE id = '".$id."'";
	sql($sql,"query");
}

function cdrcost_schedule_edit($id,$vars) {
	extract($vars);
	$sql = "UPDATE call_schedule SET name = '".$name."' WHERE id = '".$id."'";
	sql($sql,"query");
}

function cdrcost_schedule_get($id) {
	$sql = "SELECT * FROM call_schedule WHERE id = '".$id."'";
	return sql($sql,"getAll",DB_FETCHMODE_ASSOC);
}

function cdrcost_schedule_list() {
	$sql = "SELECT id, name FROM call_schedule ORDER BY name";
	return sql($sql,"getAll");
}

function cdrcost_schedule_configpageinit($dispnum) {
	configpageinit('schedule', 'tool');
}

function cdrcost_schedule_configpageload() {
	global $currentcomponent;
	extract($_REQUEST);
	$disppart = 'Schedule';
	if ( configpageload($disppart) ) {
		$schedule = cdrcost_schedule_get($extdisplay);
		if ( is_array($schedule) && count($schedule) == 1 )
			extract($schedule[0], EXTR_PREFIX_ALL, 'schedule');
		$section = $disppart.' Options';
		$currentcomponent->addguielem($section, new gui_textbox('name', $schedule_name, 'Name', 'The name of this Schedule.', 'isEmpty()', 'Please enter a valid Name'));
	}
}

function cdrcost_schedule_configprocess() {
	cdrcost_configprocess(cdrcost_schedule_add, cdrcost_schedule_del, cdrcost_schedule_edit);
}

/* end page.schedule.php functions */

/* begin page.schedulepart.php functions */

function cdrcost_schedulepart_add($vars) {
	extract($vars);
	$sql = "INSERT INTO call_schedule_part (name, schedule_id, weekday, begin, end) VALUES (";
	$sql .= "'".$name."',";
	$sql .= "'".$schedule_id."',";
	$sql .= "'".$weekday."',";
	$sql .= "'".$begin."',";
	$sql .= "'".$end."');";
	sql($sql,"query");
}

function cdrcost_schedulepart_del($id) {
	$sql = "DELETE FROM call_schedule_part WHERE id = '".$id."'";
	sql($sql,"query");
}

function cdrcost_schedulepart_edit($id,$vars) {
	extract($vars);
	$sql = "UPDATE call_schedule_part SET ";
	$sql .= "name = '".$name;
	$sql .= "', schedule_id = '".$schedule_id;
	$sql .= "', weekday = '".$weekday;
	$sql .= "', begin = '".$begin;
	$sql .= "', end = '".$end."' WHERE id = '".$id."'";
	sql($sql,"query");
}

function cdrcost_schedulepart_get($id) {
	$sql = "SELECT * FROM call_schedule_part WHERE id = '".$id."'";
	return sql($sql,"getAll",DB_FETCHMODE_ASSOC);
}

function cdrcost_schedulepart_list() {
	$sql = "SELECT id, name FROM call_schedule_part ORDER BY name";
	return sql($sql,"getAll");
}

function cdrcost_schedulepart_configpageinit($dispnum) {
	global $currentcomponent;
	if ( configpageinit('schedulepart', 'tool') ) {
		$item = 'schedulelist';
		$currentcomponent->addoptlist($item, false);
		$list = cdrcost_schedule_list();
		if (is_array($list) && count($list) > 0) {
			foreach ($list as $temp) {
				$currentcomponent->addoptlistitem($item, $temp[0], $temp[1]);
			}
		}
	}
}

function cdrcost_schedulepart_configpageload() {
	global $currentcomponent;
	extract($_REQUEST);
	$disppart = 'Schedule Part';
	if ( configpageload($disppart) ) {
		$schedulepart_weekday = -1;
		$schedulepart_begin = '00:00:00';
		$schedulepart_end   = '23:59:59';
		$schedulepart = cdrcost_schedulepart_get($extdisplay);
		if ( is_array($schedulepart) && count($schedulepart) == 1 )
			extract($schedulepart[0], EXTR_PREFIX_ALL, 'schedulepart');
		$section = $disppart.' Options';
		$currentcomponent->addguielem($section, new gui_textbox('name', $schedulepart_name, 'Name', 'The name of this Schedule part.', 'isEmpty()', 'Please enter a valid Name'));
		$currentcomponent->addguielem($section, new gui_selectbox('schedule_id', $currentcomponent->getoptlist('schedulelist'), $schedulepart_schedule_id, 'Schedule', 'The schedule for this part belong to.', false));
		$currentcomponent->addguielem($section, new gui_textbox('weekday', $schedulepart_weekday, 'Weekday', 'On which weekday this part valid (0 and 7 is sunday, negativ value means always.', '!checkNumber()', 'Please enter a valid value'));
		$currentcomponent->addguielem($section, new gui_textbox('begin', $schedulepart_begin, 'From', 'From which time this part valid (format is: hh:mm:ss.', 'isEmpty()', 'Please enter a valid from'));
		$currentcomponent->addguielem($section, new gui_textbox('end', $schedulepart_end, 'To', 'Until which time this part valid (format is: hh:mm:ss.', 'isEmpty()', 'Please enter a valid to'));
	}
}

function cdrcost_schedulepart_configprocess() {
	cdrcost_configprocess(cdrcost_schedulepart_add, cdrcost_schedulepart_del, cdrcost_schedulepart_edit);
}

/* end page.schedule_part.php functions */

/* begin page.rate.php functions */

function cdrcost_rate_add($vars) {
	extract($vars);
	$sql = "INSERT INTO call_rate (";
	$sql .= "accountcode, name, begin, end, trunk, zone_id, rate, min_duration, block_size, connect, disconnect, schedule_id";
	$sql .= ") VALUES (";
	$sql .= "'".$accountcode."',";
	$sql .= "'".$name."',";
	$sql .= "'".$begin."',";
	$sql .= "'".$end."',";
	$sql .= "'".$trunk."',";
	$sql .= "'".$zone_id."',";
	$sql .= "'".$rate."',";
	$sql .= "'".$min_duration."',";
	$sql .= "'".$block_size."',";
	$sql .= "'".$connect."',";
	$sql .= "'".$disconnect."',";
	$sql .= "'".$schedule_id."');";
	sql($sql,"query");
}

function cdrcost_rate_del($id) {
	$sql = "DELETE FROM call_rate WHERE id = '".$id."'";
	sql($sql,"query");
}

function cdrcost_rate_edit($id,$vars) {
	extract($vars);
	$sql = "UPDATE call_rate SET ";
	$sql .= "accountcode = '".$accountcode."', ";
	$sql .= "name = '".$name."', ";
	$sql .= "begin = '".$begin."', ";
	$sql .= "end = '".$end."', ";
	$sql .= "trunk = '".$trunk."', ";
	$sql .= "zone_id = '".$zone_id."', ";
	$sql .= "rate = '".$rate."', ";
	$sql .= "min_duration = '".$min_duration."', ";
	$sql .= "block_size = '".$block_size."', ";
	$sql .= "connect = '".$connect."', ";
	$sql .= "disconnect = '".$disconnect."', ";
	$sql .= "schedule_id = '".$schedule_id."';";
	sql($sql,"query");
}

function cdrcost_rate_get($id) {
	$sql = "SELECT * FROM call_rate WHERE id = '".$id."'";
	return sql($sql,"getAll",DB_FETCHMODE_ASSOC);
}

function cdrcost_rate_list() {
	$sql = "SELECT id, name FROM call_rate ORDER BY name";
	return sql($sql,"getAll");
}

function cdrcost_rate_configpageinit($dispnum) {
	global $currentcomponent;
	if ( configpageinit('rate', 'tool') ) {
		$item = 'zonelist';
		$currentcomponent->addoptlist($item, false);
		$list = cdrcost_zone_list();
		if (is_array($list) && count($list) > 0) {
			foreach ($list as $temp) {
				$currentcomponent->addoptlistitem($item, $temp[0], $temp[1]);
			}
		}
		$item = 'schedulelist';
		$currentcomponent->addoptlist($item, false);
		$list = cdrcost_schedule_list();
		if (is_array($list) && count($list) > 0) {
			foreach ($list as $temp) {
				$currentcomponent->addoptlistitem($item, $temp[0], $temp[1]);
			}
		}
	}
}

function cdrcost_rate_configpageload() {
	global $currentcomponent;
	extract($_REQUEST);
	$disppart = 'Rate';
	if ( configpageload($disppart) ) {
		$rate_begin = '1900-01-01 00:00:00';
		$rate_end   = '2100-01-01 00:00:00';
		$rate_rate  = 0;
		$rate_min_duration = 0;
		$rate_block_size = 1;
		$rate_connect = 0;
		$rate_disconnect = 0;
		$rate = cdrcost_rate_get($extdisplay);
		if ( is_array($rate) && count($rate) == 1 )
			extract($rate[0], EXTR_PREFIX_ALL, 'rate');
		$section = $disppart.' Options';
		$currentcomponent->addguielem($section, new gui_textbox('name', $rate_name, 'Name', 'The name of this Rate.', 'isEmpty()', 'Please enter a valid Name'));
		$currentcomponent->addguielem($section, new gui_textbox('accountcode', $rate_accountcode, 'Account Code', 'The accountcode used in the extension config. If empty then this rate is for all accountcode.', '!isAlphanumeric()', 'Please enter a valid account code'));
		$currentcomponent->addguielem($section, new gui_textbox('begin', $rate_begin, 'Valid from', "This rate is valid from this time. The format is '1979-10-30 01:02:03'.", '', 'Please enter a valid date'));
		$currentcomponent->addguielem($section, new gui_textbox('end', $rate_end, 'Valid till', "This rate is valid untill this time. The format is '1979-10-30 01:02:03'.", '', 'Please enter a valid date'));
		$currentcomponent->addguielem($section, new gui_textbox('trunk', $rate_trunk, 'Trunk', 'The name of the Trunk for this rate is applicable.', '!isAlphanumeric()', 'Please enter a valid trunk'));
		$currentcomponent->addguielem($section, new gui_selectbox('zone_id', $currentcomponent->getoptlist('zonelist'), $rate_zone_id, 'Zone', 'The zone of this rate', false));
		$currentcomponent->addguielem($section, new gui_textbox('rate', $rate_rate, 'Rate', 'The cost of this rate per seconds.', '!isFloat()', 'Please enter a valid number'));
		$currentcomponent->addguielem($section, new gui_textbox('min_duration', $rate_min_duration, 'Minimum duration', 'The minimum duration will be applied in second.', '!isInteger()', 'Please enter a valid duration'));
		$currentcomponent->addguielem($section, new gui_textbox('block_size', $rate_block_size, 'Block size', 'The increment size which will be applied in second.', '!isInteger()', 'Please enter a valid block size'));
		$currentcomponent->addguielem($section, new gui_textbox('connect', $rate_connect, 'Connection cost', 'The cost of the estabilished connections.', '!isFloat()', 'Please enter a valid cost'));
		$currentcomponent->addguielem($section, new gui_textbox('disconnect', $rate_disconnect, 'Disconnection cost', 'The cost of the disconnections.', '!isFloat()', 'Please enter a valid cost'));
		$currentcomponent->addguielem($section, new gui_selectbox('schedule_id', $currentcomponent->getoptlist('schedulelist'), $rate_schedule_id, 'Schedule', 'In which schedule this rate valid.', false));
	}
}

function cdrcost_rate_configprocess() {
	cdrcost_configprocess(cdrcost_rate_add, cdrcost_rate_del, cdrcost_rate_edit);
}

/* end page.rate.php functions */

/* begin page.maint.php functions */

function get_cost($uniqueid) {
	$sql = "SELECT * FROM asteriskcdrdb.cdr WHERE uniqueid = '".$uniqueid."'";
	$result = sql($sql,"getAll",DB_FETCHMODE_ASSOC);
	if (is_array($result) && count($result) == 1) {
		extract($result[0]);
	} else {
		die("There can't be two uniqueid cdr!");
	}

	$result = getdate(strtotime($calldate));
	$wday = $result["wday"];
	$time = $result["hours"].":".$result["minutes"].":".$result["seconds"];

	$sql_sch = "SELECT id FROM call_schedule_part WHERE (weekday = -1 OR weekday = ".$wday.") AND begin <= '".$time."' AND '".$time."' <= end";
	$sql_zone = "SELECT id FROM call_zone WHERE '".$dst."' REGEXP pattern";
	
	$sql = "SELECT id FROM call_rate WHERE ";
	$sql .= "accountcode = '".$accountcode."'";
	$sql .= " AND begin <= '".$calldate."' AND '".$calldate."' <= end";
	$sql .= " AND LOCATE(trunk,'".$dstchannel."') = 1";
	$sql .= " AND schedule_id IN (".$sql_sch.")";
	$sql .= " AND zone_id IN (".$sql_zone.")";
	$result = sql($sql,"getAll");
	$costs = array();
	if (is_array($result) && count($result) > 0) {
		foreach ($result as $rid) {
			$sql = "SELECT * FROM call_rate WHERE id = ".$rid[0];
			$tmp = sql($sql,"getAll",DB_FETCHMODE_ASSOC);
			extract($tmp[0]);
			$costs[$rid[0]] = max(ceil($billsec / $block_size) * $block_size, $min_duration) * $rate / 60.0 + $connect + $disconnect;
		}
	}
	return $costs;
}

function last_uniqueid() {
	$sql = "SELECT MAX(uniqueid) FROM asteriskcdrdb.cdr WHERE disposition = 'ANSWERED'";
	$result = sql($sql,"getAll");
	return $result[0][0];
}

function getnext_uniqueid($last) {
	if ($last == '') {
		$sql = "SELECT value FROM globals WHERE variable = 'CDRCOST_MAX'";
		$result = sql($sql,"getAll");
		if (is_array($result) && count($result) == 1) {
			$last = $result[0][0];
		}
	}
	$sql = "SELECT MIN(uniqueid) FROM asteriskcdrdb.cdr WHERE disposition = 'ANSWERED'";
	if ($last <> '') {
		$sql .= " AND uniqueid > '".$last."'";
	}
	$result = sql($sql,"getAll");
	if (is_array($result) && count($result) == 1) {
		return $result[0][0];
	} else {
		return '';
	}
}

function fill_cdrcost() {
	$next = getnext_uniqueid('');
	while ($next <> '') {
		//print($next."\n");
		$costs = get_cost($next);
		if (count($costs) > 0) {
			arsort($costs,SORT_NUMERIC);
			$rid = key($costs);
			$cost = current($costs);
			$sql = "INSERT INTO asteriskcdrdb.cdrcost (uniqueid, rate_id, cost) VALUES ('".$next."', ".$rid.", ".$cost.")";
			sql($sql,"query");
		}
		$last = $next;
		$next = getnext_uniqueid($last);
	}
	if ($last <> '') {
		$sql = "INSERT INTO globals (variable, value) VALUES ('CDRCOST_MAX', '".$last."')";
		sql($sql,"query");
	}
}

function cdrcost_maint_add($name) {
	//$sql = "INSERT INTO call_zone_group (name) VALUES ('".$name."');";
	//sql($sql,"query");
}

function cdrcost_maint_del($name) {
	//$sql = "DELETE FROM call_zone_group WHERE name = '".$name."'";
	//sql($sql,"query");
}

function cdrcost_maint_list() {
	//$sql = "SELECT name FROM call_zone_group ORDER BY name";
	//return sql($sql,"getAll");
}

function cdrcost_maint_configpageinit($dispnum) {
}

function cdrcost_maint_configpageload() {
}

function cdrcost_maint_configprocess() {
}


/* end page.maint.php functions */

?>
