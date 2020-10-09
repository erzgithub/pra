<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Rooms extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model("Roomsmodel");
		$this->load->library("Sqlquery");
	}
	
	function index(){
		$this->load->helper("url");
		 $this->load->template("rooms", null, 0, 0);
		 
	}
	
	function loadRooms(){
		$sql = $this->sqlquery->select("tbl_session_rooms", "*", false, null);
		$query = $this->Roomsmodel->execute($sql, null);
		$arr = array();
		if($query->num_rows() > 0){
			foreach($query->result_array() as $row){
				array_push($arr, $row["RoomName"]);
			}
			print_r(json_encode($arr));
		}
	}
	
	function checkbCode(){
		if($this->input->post("code")){
			$barcode = filter_var($this->input->post("code"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$room = filter_var($this->input->post("room"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		 	$arr = array();
			 
			$arr = $this->checkPersonExists($barcode);
			 
			if($this->checkBExistence($barcode, $room)){
		 		$this->updateAttend($barcode, $room);
				//echo "<span><h1>Successfully Signed Out</h1></span>";
				echo 2;
			}else {
				if($arr){
					$this->insertBCode($barcode, $room, $arr);
					//echo "<span><h1>Successfully Attended</h1></span>";
					echo 1;
				}else{ 
					echo 4;
				}
			} 
			 
		}
	}
	
	function absentForm(){
		if($this->input->post("c")){
			$barcode = filter_var($this->input->post("c"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			
			echo "<br>";
			
			echo "<form role='form'>";
						
						echo "<span class='text-center'>Please Enter Personal Details</span>";
						
				echo "<div class='form-group has-feedback'>";
					echo "<input type='text' class='form-control' id='txtFN' placeholder='First Name' />";
				echo "</div>";
				
				echo "<div class='form-group has-feedback'>";
					echo "<input type='text' class='form-control' id='txtLN' placeholder='Last Name' />";
				echo "</div>";
				
				echo "<div class='form-group has-feedback'>";
					echo "<input type='text' class='form-control' id='txtChapter' placeholder='Chapter' />";
				echo "</div>";
			
			echo "</form>";
			
			echo "<button class='btn btn-primary btn-block' id='btnSave'>Save</button>";
			
		}
	}
	
	function saveAbsent(){
		if($this->input->post("FN") && $this->input->post("LN") && $this->input->post("code")){
			$FN = filter_var($this->input->post("FN"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$LN = filter_var($this->input->post("LN"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$Chapter = filter_var($this->input->post("Chapter"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$code = filter_var($this->input->post("code"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$room = filter_var($this->input->post("room"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			
			$sql = $this->sqlquery->insert("tbl_session_data", "BarcodeID,FirstName,LastName,CompanyName,RoomName,DateRecorded", "?,?,?,?,?,?");
			
			$data = array("BarcodeID" => $code,
							"FirstName" => $FN,
							"LastName" => $LN,
							"Chapter" => $Chapter,
							"RoomName" => $room,
							"DateRecorded" => $this->Roomsmodel->getDateTime());
			
			$this->Roomsmodel->execute($sql, $data);
			echo 0;
		}else{ 
			echo -2;
		}
	}
	
	function updateAttend($b, $r){
		$barcode = filter_var($b, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$room = filter_var($r, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$data = array("DateSignout" => $this->Roomsmodel->getDateTime(), "BarcodeID" => $barcode, "RoomName" => $room);
		$sql = $this->sqlquery->update("tbl_session_data", "DateSignout = ?", true, "BarcodeID = ? And RoomName = ?");
		$this->Roomsmodel->execute($sql, $data);
	}
	
	function insertBCode($b, $r, $arr){
		$barcode = filter_var($b, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$room = filter_var($r, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$data = array("Barcode" => $barcode, "RoomName" => $room, "DateRecorded" => $this->Roomsmodel->getDateTime(), "TS" => $this->Roomsmodel->getTime(),
			"FirstName" => $arr["FN"], "LastName" => $arr["LN"], "CompanyName" => $arr["CompanyName"]);
		$sql = $this->sqlquery->insert("tbl_session_data", "BarcodeID, RoomName, DateRecorded, TS, FirstName, LastName, CompanyName", "?,?,?,?,?,?,?");
		$this->Roomsmodel->execute($sql, $data);
	}
	
	function checkBExistence($b, $r){
		$barcode = filter_var($b, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$room = filter_var($r, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$data = array("BarcodeID" => $barcode, "RoomName" => $room);
		$sql = $this->sqlquery->select("tbl_session_data", "*", true, "BarcodeID = ? And RoomName = ?");
		$query = $this->Roomsmodel->execute($sql, $data);
		
		if($query->num_rows() == 1){
			return true;
		}else{ 
			return false;
		}
	}
	
	function checkPersonExists($b){
		$barcode = filter_var($b, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$data = array("BarcodeID" => $barcode);
		$s = $this->sqlquery;
		 $sql = $s->select("tbl_persons", "*", true, "BarcodeID = ?");
		$arr = array();
		$query = $this->Roomsmodel->execute($sql, $data);
		if($query->num_rows() >= 1){
			foreach($query->result_array() as $row){
				$arr["FN"] = $s->decodechar($row["FirstName"]);
				$arr["LN"] = $s->decodechar($row["LastName"]);
				$arr["CompanyName"] = $s->decodechar($row["CompanyName"]);
				$arr["ID"] = $row["ID"];
			}	
			return $arr;
		}else{ 
			return false;
		}
	}
	
	function countAttendance(){
		if($this->input->post("room")){
			$RoomName = filter_var($this->input->post("room"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$sql = $this->sqlquery->select("tbl_session_data", "*", true, "RoomName = ?");
			$data = array("RoomName" => $RoomName);
			$query = $this->Roomsmodel->execute($sql, $data);
			echo number_format($query->num_rows());
		}
	}
	
	function checkSession(){
		$sql = $this->sqlquery->select("tbl_session_data", "*", false, null);
		$query = $this->Roomsmodel->execute($sql, null);
		if($query->num_rows() > 0){
			foreach($query->result_array() as $row){
				$this->callPerson($row["BarcodeID"]);
			}
		}
	}
	
	function callPerson($b){
		$barcode = filter_var($b, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$data = array("BarcodeID" => $barcode);
		$sql = $this->sqlquery->select("tbl_persons", "*", true, "BarcodeID = ?");
		$query = $this->Roomsmodel->execute($sql, $data);
		if($query->num_rows() >= 1){
			foreach($query->result_array() as $row){
				
			}
		}else{ 
			$this->updateStat($barcode);
		}
	}
	
	function updateStat($b){
		$barcode = filter_var($b, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$sql = $this->sqlquery->update("tbl_session_data", "Status = ?", true, "BarcodeID = ?");
		$data = array("Status" => "NU", "BarcodeID" => $barcode);
		$this->Roomsmodel->execute($sql, $data);
	}
	
	
}