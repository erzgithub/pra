<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Foodstab extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model("Foodstabmodel");
		$this->load->library("Sqlquery");
	}
	
	function index(){
		$this->load->helper("url");
		$this->load->template("foodstab", null);
	}
	
	function check(){
		if($this->input->post("barcode") && $this->input->post("mealtype")){
			$barcode = filter_var($this->input->post("barcode"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$mealtype = filter_var($this->input->post("mealtype"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			if($this->foodExists($barcode, $mealtype)){
					$query = $this->pick($barcode, $mealtype);
					foreach($query->result_array() as $row){
						echo "<div class='col-md-12'>";
							
								echo "<br>";
							
								echo "<div class='panel panel-danger'>";
								
									echo "<div class='panel-heading'>";
										echo "<div class='panel-title'>Meal already Claimed</div>";
									echo "</div>";
									
									echo "<div class='panel-body'>";
										
									/* 	echo "<div class='col-md-6 text-center info'>";
										
											echo "<div>";
												echo "<span>" .$rows["FirstName"] ." " .$rows["LastName"] ."</span>";
											echo "</div>";
											
											echo "<div>";
												echo "<span>" .$rows["CompanyName"] ."</span>";
											echo "</div>";
											
										echo "</div>"; */
										
										echo "<div class='col-md-6 text-center info'>";
											echo "<div><span>Date and Time claimed</span></div>";
											
											echo "<div>";
												echo $row["DateRecorded"];
											echo "</div>";
											
										echo "</div>";
										
									echo "</div>";
								 
								echo "</div>";
								
								echo "<div>";
											echo "<button class='btnDelete btn btn-danger btn-lg' id='btnD-" .$row["ID"] ."'><i class='fa fa-trash' aria-hidden='true'></i>&nbsp;Delete</button>";
										echo "</div>";
							
							echo "</div>";
					}
			}else{ 
				$this->insertBarcode($barcode, $mealtype);
				echo "<br>";
					
					echo "<div class='panel panel-success'>";
						echo "<div class='panel-heading'>";
							echo "<div class='panel-title'>Successfull</div>";
						echo "</div>";
						
						echo "<div class='panel-body text-center s'>";
								echo "<h1><i class='fa fa-check-circle fa-6' aria-hidden='true'></i>&nbsp;Meal Successfully Claimed</h1>";
							echo "</div>";
						
					echo "</div>";
			}
		}
	}
	
	function pick($b, $m) {
		$barcode = filter_var($b, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$mealtype = filter_var($m, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$data = array("BarcodeID" => $barcode, "MealType" => $mealtype);
		$sql = $this->sqlquery->select("tbl_foodstabs", "*", true, "BarcodeID = ? And MealType = ?");
		$query = $this->Foodstabmodel->execute($sql, $data);
		return $query;
	}
	
	function insertBarcode($b, $m){
		$barcode = filter_var($b, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$mealtype = filter_var($m, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$sql = $this->sqlquery->insert("tbl_foodstabs", "BarcodeID,MealType,DateRecorded", "?,?,?");
		$data = array("BarcodeID" => $barcode, "MealType" => $mealtype, "DateRecorded" => $this->Foodstabmodel->getDateTime());
		$query = $this->Foodstabmodel->execute($sql, $data);
	}
	
	function foodExists($b, $m){
		$barcode = filter_var($b, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$mealtype = filter_var($m, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$data = array("barcode" => $barcode, "mealtype" => $mealtype);
		$sql = $this->sqlquery->select("tbl_foodstabs", "*", true, "BarcodeID = ? And MealType = ?");
		$query = $this->Foodstabmodel->execute($sql, $data);
		if($query->num_rows() >= 1){
			return true;
		}else{ 
			return false;
		}
	}
	
	function checked(){
	 
		if($this->input->post("barcode") && $this->input->post("mealtype")){
			
			$barcode = filter_var($this->input->post("barcode"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
			$mealtype = filter_var($this->input->post("mealtype"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			
			 $data = array("Barcode" => $barcode, "MealType" => $mealtype);
			$sql = $this->sqlquery->select("tbl_foodstabs", "*", true, "BarcodeID = ? And MealType = ?");
			$query = $this->Foodstabmodel->execute($sql, $data);
			 
		 
			if($query->num_rows() >= 1){
			 
				$rows = $this->pQuery($barcode);
				
				foreach($query->result_array() as $row){
					
					echo "<div class='col-md-12'>";
					
						echo "<br>";
					
						echo "<div class='panel panel-danger'>";
						
							echo "<div class='panel-heading'>";
								echo "<div class='panel-title'>Meal already Claimed</div>";
							echo "</div>";
							
							echo "<div class='panel-body'>";
								
								echo "<div class='col-md-6 text-center info'>";
								
									echo "<div>";
										echo "<span>" .$rows["FirstName"] ." " .$rows["LastName"] ."</span>";
									echo "</div>";
									
									echo "<div>";
										echo "<span>" .$rows["CompanyName"] ."</span>";
									echo "</div>";
									
								echo "</div>";
								
								echo "<div class='col-md-6 text-center info'>";
									echo "<div><span>Date and Time claimed</span></div>";
									
									echo "<div>";
										echo $row["DateRecorded"];
									echo "</div>";
									
								echo "</div>";
								
							echo "</div>";
						 
						echo "</div>";
						
						echo "<div>";
									echo "<button class='btnDelete btn btn-danger btn-lg' id='btnD-" .$row["ID"] ."'><i class='fa fa-trash' aria-hidden='true'></i>&nbsp;Delete</button>";
								echo "</div>";
					
					echo "</div>";
					
				}
			}else{ 
			 
				if($this->isPersonExists($barcode)){
					$data = array("BarcodeID" => $barcode,
									"MealType" => $mealtype,
									"DateRecorded" => $this->Foodstabmodel->getDateTime());
					$sql = $this->sqlquery->insert("tbl_foodstabs", "BarcodeID, MealType, DateRecorded", "?,?,?");
					$this->Foodstabmodel->execute($sql, $data);
					
					echo "<br>";
					
					echo "<div class='panel panel-success'>";
						echo "<div class='panel-heading'>";
							echo "<div class='panel-title'>Successfull</div>";
						echo "</div>";
						
						echo "<div class='panel-body text-center s'>";
								echo "<h1><i class='fa fa-check-circle fa-6' aria-hidden='true'></i>&nbsp;Meal Successfully Claimed</h1>";
							echo "</div>";
						
					echo "</div>";
				}
			}  
		} 
	}
	
	
	function isPersonExists($bc){
		$barcode = filter_var($bc, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
		
		$sql = $this->sqlquery->select("tbl_persons", "*", true, "BarcodeID = ?");
		$data = array("BarcodeID" => $barcode);
		$query = $this->Foodstabmodel->execute($sql, $data);
		if($query->num_rows() == 1){
			return true;
		}else{ 
			return false;
		}
	}
	
	function pQuery($bc){
		$barcode = filter_var($bc, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
		$s = $this->sqlquery;
		$sql = $s->select("tbl_persons", "*", true, "BarcodeID = ?");
		$data = array("BarcodeID" => $barcode);
		$query = $this->Foodstabmodel->execute($sql, $data);
		$arr = array();
		if($query->num_rows() == 1){
			foreach($query->result_array() as $row){
				$arr["FirstName"] = $s->decodechar($row["FirstName"]);
				$arr["LastName"] = $s->decodechar($row["LastName"]);
				$arr["CompanyName"] = $s->decodechar($row["CompanyName"]);
			}
			return $arr;
		}
	}
	
	function delete(){
		if($this->input->post("tid")){
			$tid = substr($this->input->post("tid"), strpos($this->input->post("tid"), "-") + 1);
			$id = filter_var($tid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			$data = array("ID" => $id);
			$sql = $this->sqlquery->delete("tbl_foodstabs", true, "ID = ?");
			$query = $this->Foodstabmodel->execute($sql, $data);
			
			echo 0;
			
		}
	}
	
	function loadMealTypes(){
		$sql = $this->sqlquery->select("tbl_mealtypes", "*", false, null);
		$query = $this->Foodstabmodel->execute($sql, null);
		$arr = array();
		if($query->num_rows() > 0){
			foreach($query->result_array() as $row){
				array_push($arr, $row["MealType"]);
			}
			print_r(json_encode($arr));
		}
	}
	
	function CountClaims(){
		if($this->input->post("mealtype")){
			$mealtype = filter_var($this->input->post("mealtype"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			$data = array("mealtype" => $mealtype);
			$sql = $this->sqlquery->select("tbl_foodstabs", "*", true, "MealType = ?");
			$query = $this->Foodstabmodel->execute($sql, $data);
			echo number_format($query->num_rows());
		}
	}
	
}