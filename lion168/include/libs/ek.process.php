<?php
if(!defined('EK_INC'))
{
	exit("Request Error!");
}
class ek_process
{
	function islocked($process, $ttl = 0) {
		$ttl = $ttl < 1 ? 600 : intval($ttl);
		if(ek_process::_status('get', $process)) {
			return true;
		} else {
			return ek_process::_find($process, $ttl);
		}
	}

	function unlock($process) {
		ek_process::_status('rm', $process);
		ek_process::_cmd('rm', $process);
	}

	function _status($action, $process) {
		static $plist = array();
		switch ($action) {
			case 'set' : $plist[$process] = true; break;
			case 'get' : return !empty($plist[$process]); break;
			case 'rm' : $plist[$process] = null; break;
			case 'clear' : $plist = array(); break;
		}
		return true;
	}

	function _find($name, $ttl) {

		if(!ek_process::_cmd('get', $name)) {
			ek_process::_cmd('set', $name, $ttl);
			$ret = false;
		} else {
			$ret = true;
		}
		ek_process::_status('set', $name);
		return $ret;
	}

	function _cmd($cmd, $name, $ttl = 0) {
		return ek_process::_process_cmd_db($cmd, $name, $ttl);
	}

	function _process_cmd_db($cmd, $name, $ttl = 0) {
		global $dsql;
		$ret = '';
		switch ($cmd) {
			case 'set':
				$insql="REPLACE INTO ek_process(processid,expiry) VALUES ('$name','".(time() + $ttl)."')";
				if($dsql->ExecuteNoneQuery($insql)){
					$ret = true;
				}else{
					$ret = false;
				}
				break;
			case 'get':
				$ret = $dsql->GetOne("Select * From `ek_process` where processid='$name'");
				if(empty($ret) || $ret['expiry'] < time()) {
					$ret = false;
				} else {
					$ret = true;
				}
				break;
			case 'rm':
				if($dsql->ExecuteNoneQuery("DELETE FROM ek_process where processid='$name' OR expiry<".time())){
					$ret = true;
				}else{
					$ret = false;
				}
				break;
		}
		return $ret;
	}
}