<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Homemodel extends CI_Model{
	
	function execute($sql, $data){
		return $this->db->query($sql, $data);
	}
	
}