<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Kits extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model("Kitsmodel");
		$this->load->library("Sqlquery");
	}
	
	function index(){
		
		$this->load->helper("url");
		$this->load->template("kits", null);
	}
	
	function verifyKit(){
		if($this->input->post("code")){
			$BarcodeID = filter_var($this->input->post("code"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
			$data = array("BarcodeID" => $BarcodeID);
			$sql = $this->sqlquery->select("tbl_kits", "*", true, "BarcodeID = ? And DATE(DateRecorded) = DATE(NOW())");
			$query = $this->Kitsmodel->execute($sql, $data);
			if($query->num_rows() >= 1){
				
				foreach($query->result_array() as $rows){
					
					$row = $this->pQuery($BarcodeID);
				 
					echo "<div class='col-md-12'>";
							echo "<div class='panel panel-danger'>";
								echo "<div class='panel-heading'>";
										echo "<div class='panel-title'>Kit already Claimed</div>";
								echo "</div>";
								
								echo "<div class='panel-body'>";
								
									 echo "<div class='col-md-6 info text-center'>";
										echo "<div>";
											echo "<span>" .$row["FirstName"] ." " .$row["LastName"] ."</span>";
										echo "</div>";
											 
										echo "<div>";
											echo "<span>" .$row["CompanyName"] ."</span>";
										echo "</div>";
										
									echo "</div>";
									
									echo "<div class='col-md-6 info text-center'>";
										echo "<div><span>Date and time claimed</span></div>";
									 
										echo "<div>";
											echo $rows["DateRecorded"];
										echo "</div>";
									echo "</div>";
									
								echo "</div>";
							 
							echo "</div>";
							
							echo "<div>";
									echo "<button class='btnDelete btn btn-danger btn-lg' id='btnD-" .$rows["ID"] ."'><i class='fa fa-trash' aria-hidden='true'></i>&nbsp;Delete</button>";
								echo "</div>";
							
					echo "</div>";
					
				}
				
			}else{ 
				//if($this->checkPersonExists($BarcodeID)){
					$this->SaveKit($BarcodeID);
					echo "<div class='panel panel-success'>";
							echo "<div class='panel-heading'>";
								echo "<div class='panel-title'>Successfull</div>";
							echo "</div>";
							
							echo "<div class='panel-body text-center s'>";
								echo "<h1><i class='fa fa-check-circle fa-6' aria-hidden='true'></i>&nbsp;KIT Successfully Claimed</h1>";
							echo "</div>";
							
					echo "</div>";
				/* }else{ 
					echo "<div class='text-center'>";
						echo "<h1>Barcode does not Exists!</h1>";
					echo "</div>";
				} */
			}
		}
	}
	
	function checkPersonExists($barcode){
		$BarcodeID = filter_var($barcode, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
		$data = array("BarcodeID" => $BarcodeID);
		$sql = $this->sqlquery->select("tbl_persons", "*", true, "BarcodeID = ?");
		$query = $this->Kitsmodel->execute($sql, $data);
		if($query->num_rows() == 1){
			return true;
		}else{ 
			return false;
		}
	}
	
	function pQuery($barcode){
		$BarcodeID = filter_var($barcode, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
		$s = $this->sqlquery;
		$data = array("BarcodeID" => $BarcodeID);
		$sql = $s->select("tbl_persons", "*", true, "BarcodeID = ?");
		$query = $this->Kitsmodel->execute($sql, $data);
		$arr = array();
		if($query->num_rows() == 1){
			foreach($query->result_array() as $row){
				$arr["FirstName"] = $s->decodechar($row["FirstName"]);
				$arr["LastName"] = $s->decodechar($row["LastName"]);
				$arr["CompanyName"] = $s->decodechar($row["CompanyName"]);
			}
			return $arr;
		}else{ 
			return false;
		}
	}
	
	function delete(){
		if($this->input->post("tid")){
			$tid = substr($this->input->post("tid"), strpos($this->input->post("tid"), "-") + 1);
			$id = filter_var($tid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			$data = array("ID" => $id);
			$sql = $this->sqlquery->delete("tbl_kits", true, "ID = ?");
			$this->Kitsmodel->execute($sql, $data);
			echo 0;
		}
	}
	
	function SaveKit($barcode){
		$sql = $this->sqlquery->insert("tbl_kits", "BarcodeID,DateRecorded", "?,?");
		$data = array("BarcodeID" => $barcode,
						"DateRecorded" => $this->Kitsmodel->getDateTime());
		$this->Kitsmodel->execute($sql, $data);
	}
	
	function TotalKits(){
		$sql = $this->sqlquery->select("tbl_kits", "*", false, null);
		$query = $this->Kitsmodel->execute($sql, null);
		echo number_format($query->num_rows());
	}
	
}