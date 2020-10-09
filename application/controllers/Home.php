<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{

	private $items_per_page = 10;

	function __construct(){
		parent::__construct();
		$this->load->model("Homemodel");
		$this->load->library("Sqlquery");
	}
	
	function index(){
		$this->load->helper("url");
		$this->load->template("home", null, 0);
	}
	function total($val){
		 $keyword = isset($_REQUEST["keyword"]) ? filter_var($_REQUEST["keyword"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : null;
		$wC = isset($_REQUEST["wC"]) ? filter_var($_REQUEST["wC"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : 0;
		$b = false;
		$category = isset($_REQUEST["category"]) ? filter_var($_REQUEST["category"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : null;
		
		$pageSize = isset($_REQUEST["pageSize"]) ? filter_var($_REQUEST["pageSize"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : 10;
	    
		$condition = null;
		if($wC == 1){
			$b = true;
			$condition = str_replace(" ", "", $category) ." Like ? '%'";
		}
		
		$data = array("Keyword" => $keyword);
		$sql = $this->sqlquery->select("tbl_persons", "*", $b, $condition);
		 
		//eto yan
		$query = $this->Homemodel->execute($sql, $data);
		
			if($val == "records"){
				print_r(number_format($query->num_rows()));
			}else{ 
				$total_records = $query->num_rows();
				$total_page = ceil($total_records / $pageSize);
				print_r(number_format($total_page));
			}
		
	}
	
	function showRecords(){
		
		$items_per_page = $this->items_per_page;
		$s = $this->sqlquery;
		
		$data = array();
		$condition = null;
		
		$keyword = isset($_POST["keyword"]) ? filter_var($_POST["keyword"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : null;
		$wC = isset($_POST["wC"]) ? filter_var($_POST["wC"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : 0;
		
		$category = isset($_POST["category"]) ? filter_var($_POST["category"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : null;
		
		$pageSize = isset($_REQUEST["pageSize"]) ? filter_var($_REQUEST["pageSize"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : 10;
		
		$b = false;
		
		$page = isset($_POST["page"]) ? filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : 1;
		
		$from = (($page * $pageSize) - $pageSize);
		
		$data["keyword"] = $keyword;
		
		if($wC == 1){
			$b = true;
			$condition = str_replace(" ", "", $category) ." Like ? '%'";
		}
		
		$sql = $s->LoadRecords("tbl_persons", "*", $b, $condition, null, $from, $pageSize);
		
		$query = $this->Homemodel->execute($sql, $data);
		 
		
		if($query->num_rows() > 0){
			 echo "<table class='table-hover tablesorter span5 center-table table table-condensed table-bordered tbl-lessons'>";
					echo "<thead>";
							echo "<tr>"	
									."<th></th>"
									."<th></th>"
									."<th>First Name</th>"
									."<th>Last Name</th>"
									."<th>Company Name</th>"
									."<th>Designation</th>"
									."<th>Address</th>"
									."<th>Telephone/Fax</hd>"
									."<th>Mobile</th>"
									."<th>Email</th>"
									."<th>Date Registered</th>"
									."<th>Date Attended</th>"
								."</tr>";
					echo "</thead>";
					echo "<tbody>";
							foreach($query->result_array() as $row){
								
								echo "<tr>";
								
									echo "<td>";
											echo "<span class='pop-markup'><a class='click' rel='popover' id='cf-" .$row["ID"] ."'>";
													echo "<span class='glyphicon glyphicon-cog'></span></a>";
													
													echo "<div class='content hide'>";
														echo "<div class='c-content'>";
															
														echo "</div>";
														echo "<div class='loadersposition conf'>";
															echo "<img src='" .asset_url("images/ajax-loader.gif") ."'/>";
														echo "</div>";
													echo "</div>";
													
											echo "</span>";
									echo "</td>";
									
									echo "<td>";
									
										echo "<div class='ab-container' id='abc-" .$row["ID"] ."'>";
											
										echo "</div>";
									
									/* 	
									
										if(!($row["DateAttended"] == null)){
											echo "<button class='btn-a btn btn-warning btn-block btn-xs' id='btnR-" .$row["ID"] ."'><i class='fa fa-retweet' aria-hidden='true'></i>&nbsp;&nbsp;Reset</button>";
										}else{ 
										echo "<button class='btn-a btn btn-info btn-block btn-xs' id='btnA-" .$row["ID"] ."'><i class='fa fa-flag-checkered' aria-hidden='true'></i>&nbsp;&nbsp;Attend</button>";
										} */
										
										echo "<div class='tloadersposition hide' id='tload-" .$row["ID"] ."'>";
											echo "<img src='" .asset_url('images/ajax-loader.gif') ."' width='20' height='20'/>";
										echo "</div>";
										
									echo "</td>";
									
									echo "<td>" .$s->decodechar(ucfirst($row["Salutation"])) ." " .$s->decodechar(ucfirst($row["FirstName"])) ."</td>";
									echo "<td>" .$s->decodechar(ucfirst($row["LastName"])) ."</td>";
									echo "<td>" .$s->decodechar(ucfirst($row["CompanyName"])) ."</td>";
									echo "<td>" .$row["Designation"] ."</td>";
									echo "<td>" .$row["Address"] ."</td>";
									echo "<td>" .$row["Telephonefax"] ."</td>";
									echo "<td>" .$row["Mobile"] ."</td>";
									echo "<td>" .$row["Email"] ."</td>";
									echo "<td>" .$row["DateRegistered"] ."</td>";
									echo "<td>" .$row["DateAttended"] ."</td>";
								echo "</tr>";
								
							}
					echo "</tbody>";
			echo "</table>";
		}else{ 
			echo "<div class='text-center'>";
				echo "<span>No Records to Display</span>";
			echo "</div>";
		}
		
	}
	
	function Config(){
		if($this->input->post("id")){
			$cid = substr($this->input->post("id"), strpos($this->input->post("id"), "-") + 1);
			$id = filter_var($cid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			echo "<div>";
					echo "<button class='btn btn-primary btn-xs btn-block btn-edit' id='btnE-" .$id ."'><span class='glyphicon glyphicon-pencil'></span>&nbsp;&nbsp;Edit</button>";
			echo "</div>";
			
			echo "<div class='spacer'>";
					echo "<button class='btn btn-danger btn-xs btn-block btn-delete' id='btnD-" .$id ."'><i class='fa fa-trash-o' aria-hidden='true'></i>&nbsp;Delete</button>";
			echo "</div>";
			
			echo "<div class='spacer'>";
				echo "<button class='btn btn-info btn-xs btn-block btn-view' id='btnV-" .$id ."'><i class='fa fa-eye' aria-hidden='true'></i>&nbsp;&nbsp;View</button>";
			echo "</div>";
			
			/* echo "<div class='spacer'>";
				echo "<button class='btn btn-secondary btn-block' id='btnI-" .$id ."'>";
			echo "</div>"; */
			
			echo "<div class='spacer text-center'>";
				echo "<a href='" .base_url() ."records/profile/" .$id ."'><i class='fa fa-print' aria-hidden='true'></i>&nbsp;&nbsp;Print ID</a>";
			echo "</div>";
			
			
			
		}
	}
	
	function profile($cid){
		$id = filter_var($cid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		if(!is_numeric($id)){
			header("Location:" .base_url());
		}
		$generator = $this->barcode->generator();
		$arr = $this->pQuery($id);
		$arr["Barcode"] = base64_encode($generator->getBarcode($arr["BarcodeID"], $generator::TYPE_CODE_128));
		$arr["Code"] = $arr["BarcodeID"];
		 $arr["VType"] = $arr["VType"];
		if($arr){	
			$this->load->helper("url");
			$this->load->template("profile", $arr, 0, 1);
		}
		
	}
	
	function printid(){
		
		$this->load->library("session");
		
		if( $this->input->post("FN")
				&& $this->input->post("LN")){
			
			$s = $this->sqlquery;
			
			$generator = $this->barcode->generator();
			
			
			$arr = array();
			$arr["SAL"] = ucfirst($s->decodechar($this->input->post("SAL")));
			$arr["FN"] = ucfirst($s->decodechar($this->input->post("FN")));
			$arr["LN"] = ucfirst($s->decodechar($this->input->post("LN")));
			$arr["Company"] = ucfirst($s->decodechar($this->input->post("Company")));
			$arr["Designation"] = ucfirst($s->decodechar($this->input->post("Designation")));
			$arr["BarcodeID"] = base64_encode($generator->getBarcode($this->session->userdata("Barcode_ID"), $generator::TYPE_CODE_128));
			 $arr["Code"] = $this->session->userdata("Barcode_ID");
			 $arr["VType"] = ucwords($this->input->post("VType"));
			 $arr["VIP"] = $this->input->post("VIP");
		 
			$this->load->helper("url");
			$this->load->template("printid", $arr, 0, 1);
		}else{ 
			echo "Some fields are empty please try to re-print your id <a href='" .base_url() ."/records'>Here</a>";
		}
	}
	
	function pQuery($tid){
		$id = filter_var($tid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		
		$s = $this->sqlquery;
		
		$sql = $s->select("tbl_persons", "*", true, "ID = ?");
		$data = array("ID" => $id);
		$query = $this->Homemodel->execute($sql, $data);
		$arr = array();
		if($query->num_rows() == 1){
			foreach($query->result_array() as $row){
				$arr["SAL"] = ucfirst($s->decodechar($row["Salutation"]));
				$arr["FirstName"] = ucfirst($s->decodechar($row["FirstName"]));
				$arr["LastName"] = ucfirst($s->decodechar($row["LastName"]));
				$arr["CompanyName"] = ucfirst($s->decodechar($row["CompanyName"]));
				$arr["Designation"] = ucfirst($s->decodechar($row["Designation"]));
				$arr["Address"] = $row["Address"];
				$arr["Telephonefax"] = $row["Telephonefax"];
				$arr["Mobile"] = $row["Mobile"];
				$arr["Email"] = $row["Email"];
				$arr["BarcodeID"] = $row["BarcodeID"];
				$arr["VType"] = $row["BusinessPhone"];
			}
			return $arr;
		}else{ 
			return false;
		}
	}
	
	function delete(){
		$cid = substr($this->input->post("id"), strpos($this->input->post("id"), "-") + 1);
		$id = filter_var($cid, FILTER_SANITIZE_NUMBER_INT ,FILTER_FLAG_STRIP_HIGH);
		$data = array("ID" => $id);
		$sql = $this->sqlquery->delete("tbl_persons", true, "ID = ?");
		$this->Homemodel->execute($sql, $data);
		echo 0;
	}
	
	function totalPresent(){
		
		$category = filter_var($this->input->post("category"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		 
		$keyword = filter_var($this->input->post("keyword"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		
		$wC = filter_var($this->input->post("wC"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		
		$data = array();
		
		$b = true;
		
		$condition = "DateAttended is not null";
		
		if($wC == 1){
			$condition .= " And " .str_replace(" ", "", $category) ." Like ? '%'";
			$data["keyword"] = $keyword;
		}
		
		$sql = $this->sqlquery->select("tbl_persons", "*", $b, $condition);
		 $query = $this->Homemodel->execute($sql, $data);
		echo number_format($query->num_rows());
	}
	
	
	
}
