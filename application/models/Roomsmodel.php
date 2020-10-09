<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Roomsmodel extends CI_Model {
	
	function execute($sql, $data){
		return $this->db->query($sql, $data);
	}
	
	function getDateTime(){
		return $this->sqlquery->getDateTime($this->db);
	}
	
	function getTime(){
		return $this->sqlquery->getTime($this->db);
	}
	
}