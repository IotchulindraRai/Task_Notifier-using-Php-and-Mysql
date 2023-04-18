<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_reminder(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				if(!is_numeric($v) && !empty($v))
					$v = htmlspecialchars($this->conn->real_escape_string($v));
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `reminder_list` set {$data} ";
		}else{
			$sql = "UPDATE `reminder_list` set {$data} where id = '{$id}' ";
		}
		try{
			$save = $this->conn->query($sql);
		}catch(Exeption $e){
			$save= false;
			$resp['err'] = $e->getMessage();
		}
		if($save){
			$resp['id'] = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "New Task Reminder has been added successfully.";
			else
				$resp['msg'] = " Task Reminder has been updated successfully.";
			$this->settings->set_flashdata('success', $resp['msg']);
		}else{
			$resp['status'] = 'failed';
		}
			return json_encode($resp);
	}
	function delete_reminder(){
		extract($_POST);
		try{
			$del = $this->conn->query("DELETE FROM `reminder_list` where id = '{$id}'");
		}catch(Exeption $e){
			$del= false;
			$resp['err'] = $e->getMessage();
		}
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Task Reminder has been deleted successfully.");
		}else{
			$resp['status'] = 'failed';
		}
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'save_reminder':
		echo $Master->save_reminder();
	break;
	case 'delete_reminder':
		echo $Master->delete_reminder();
	break;
	default:
		// echo $sysset->index();
		break;
}