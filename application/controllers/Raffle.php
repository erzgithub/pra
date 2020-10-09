<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Raffle extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model("Rafflemodel");
		$this->load->library("Sqlquery");
	}
	
	function index(){
		$this->load->helper("url");
		$this->load->template("raffle", null, 0);
	}
	
	function picker(){
		$s = $this->sqlquery;
		$data = array("isPicked" => 0,);

	//	$sql = $s->select("tbl_raffleentries", "*", true, "isPicked = ? Order by rand() Limit 1;");
		//$query = $this->Rafflemodel->execute($sql, $data);

		$sql = "SELECT * From tbl_raffleentries Order by rand() Limit 1"; //$s->select("tbl_raffleentries", "*", true, " Order by rand() Limit 1;");
		$query = $this->Rafflemodel->execute($sql, null);

		if($query->num_rows() > 0){
			foreach($query->result_array() as $row){
				echo "<div class='picker' id='cd-" .$row["ID"] ."'>";
					echo "<h1><span class='name'>" .ucfirst($s->decodechar($row["FirstName"])) ." " .ucfirst($s->decodechar($row["LastName"])) ."</span><h1>";
				echo "</div>";
					 
				echo "<div class='white'>";
					echo "<h4><span class='companyname'>" .ucfirst($s->decodechar($row["CompanyName"])) ."</span></h4>";
				echo "</div>";
				
			}
		} 
	}
	
	function reset(){
		$sql = $this->sqlquery->update("tbl_raffleentries", "isPicked = 0", false, null);
		$this->Rafflemodel->execute($sql, null);
		echo 0;
	}
	
	function updatePicked(){
		if($this->input->post("di")){
			$cid = substr($this->input->post("di"), strpos($this->input->post("di"), "-") + 1);
			$id = filter_var($cid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			
			$data = array("ID" => $id);
			
			$sql = $this->sqlquery->update("tbl_raffleentries", "isPicked = -1", true, "ID = ?");
			
			$this->Rafflemodel->execute($sql, $data);
			
			echo 0;
			
		}else{ 
			echo -2;
		}
	}
	
}