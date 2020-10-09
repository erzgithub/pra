<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Sqlquery{
	
	private $output = false;
	private $key = "RanLorch";
		
	// initialization vector 
	private $iv;
	
	function insert($tablename, $fields, $values) {
		$sql = "Insert into " .$tablename ."(" .$fields .") Values (" .$values .")";
		return $sql;
	}
	
	function update($tablename, $fields, $wC, $condition){
		$sql = "";
		if($wC){
			$sql = "Update " .$tablename ." Set " .$fields ." Where " .$condition;
		}else{ 
			$sql = "Update " .$tablename ." Set " .$fields;
		}
		return $sql;
	}
	
	function delete($tablename, $wC, $condition){
		$sql = "";
		if($wC){
			$sql = "Delete From " .$tablename ." Where " .$condition;
		}else{ 
			$sql = "Delete From " .$tablename;
		}
		return $sql;
	}
	
	function getDate(){
		$sql = "Select DATE(NOW()) as cDate";
		return $sql;
	}
	
	function Select($tablename, $fields, $wCondition = false, $condition = null, $orderby = null){
		$sql = "";
		if($wCondition){
			$sql = "Select " .$fields ." From " .$tablename ." Where " .$condition ." " .$orderby;
		}else {
			$sql = "Select " .$fields ." From " .$tablename ." " .$orderby;
		}
		return $sql;
	}
	
	function LoadRecords($tablename, $fields, $wCondition = false, $condition = null, $orderby = null, $page = 0, $limit = 0){
		$sql = "";
		if($wCondition == true){
			$sql = "Select " .$fields ." From " .$tablename ." Where " .$condition ." " .$orderby ." Limit " .$page ."," .$limit;
		}else{
			$sql = "Select " .$fields ." From " .$tablename ." " .$orderby ." Limit " .$page ."," .$limit;
		}
		
		return $sql;
		
	}
	
	function decodechar($val){
		$encoding = mb_detect_encoding($val, 'utf-8', true);
		return iconv($encoding, 'utf-8', $val);
	}
	
	
	function VerifyUser($db, $v_users){
		$sql = $this->select("tbl_ausers", "id,password", true, "id = ? And Password = ?", null);
		$q = $db->query($sql, $v_users);
		$count = $q->num_rows();
		if($count == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function VerifyCurrUser($db, $tablename, $v_users){
		$sql = $this->select($tablename, "ID,Password", true, "ID = ? And Password = ?", null);
		$q = $db->query($sql, $v_users);
		$count = $q->num_rows();
		if($count == 1){
			return true;
		}else{
			return false;
		}
	}
	
	
	function IdentifyUser($db, $id){
		$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$sql = $this->select("tbl_ausers", "FirstName,LastName", true, "id = ?", null);
		$data = array("id" => $id);
		$q = $db->query($sql, $data);
		$count = $q->num_rows();
		
		$arr = array();
		
		if($count == 1){
			foreach($q->result_array() as $row){
				$arr = array("FN" => $row["FirstName"],
								"LN" => $row["LastName"]);
			}
			return $arr;
		}
		
	}
	
	function IdentifyCurrUser($db, $id, $tablename){
		$id = filter_var($id, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$sql = $this->select($tablename, "*", true, "ID = ?", null);
		$data = array("ID" => $id);
		$q = $db->query($sql, $data);
		$count = $q->num_rows();
		
		$arr = array();
		
		if($count == 1){
			foreach($q->result_array() as $row){
				$arr = array("FN" => $row["FirstName"],
								"LN" => $row["LastName"]);
			}
			return $arr;
		}
		
	}
	
	function getDateTime($db){
		$sql = "SELECT DATE_FORMAT(now(), '%Y-%m-%d %H:%i:%s') As formated_date";
		$q = $db->query($sql, null);
		foreach($q->result_array() as $row){
			return date("Y-m-d H:i:s", strtotime($row["formated_date"]));
		}
	}
	
	function encrypt($string){
		 
		$this->iv= md5(md5($this->key));
	   
	    $this->output = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($this->key), $string, MCRYPT_MODE_CBC, $this->iv);
		$this->output = base64_encode($this->output);
		   
		  return $this->output;
	}
	
	function getTime($db){
		$sql = "Select TIME(NOW()) as my_time;";
		$q = $db->query($sql, null);
		foreach($q->result_array() as $row){
			return $row["my_time"];
		}
	}
	
	function decrypt($string){
		$this->iv= md5(md5($this->key));
		
		$this->output = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($this->key), base64_decode($string), MCRYPT_MODE_CBC, $this->iv);
		$this->output = rtrim($this->output);
		
		return $this->output;
	}
	
	
	
}