<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Config extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->library("Sqlquery");
		$this->load->model("Configmodel");
	}
	
	function edit(){
		if($this->input->post("id")){
			$cid = substr($this->input->post("id"), strpos($this->input->post("id"), "-") + 1);
			$id = filter_var($cid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			if($this->qEditing($id)){
				
				$row = $this->qEditing($id);
				
				$kit = null;
				$vip = null;
				$delegate = null;
				$exhibitor = null;
				
				echo "<form role='form'>";
				
				/* 	echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='Salutation' id='txtSal' value='" .$row["Sal"] ."' required autofocus />";
						echo "<span class='glyphicon form-control-feedback hide'></span>";
					echo "</div>"; */
					
					echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='First Name' id='txtFN' value='" .$row["FN"] ."' />";
						echo "<span class='glyphicon form-control-feedback hide'></span>";
					echo "</div>";
					
					echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='Last Name' id='txtLN' value='" .$row["LN"] ."' />";
						echo "<span class='glyphicon form-control-feedback hide'></span>";
					echo "</div>";
					
				 	echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='Chapter' id='txtDesignation' value='".$row["Designation"] ."'/>";
						echo "<span class='glyphicon form-control-feedback hide'></span>";
					echo "</div>";
					
					
					
					echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='Company' id='txtCompany' value='" .$row["CompanyName"] ."' />";
						echo "<span class='glyphicon form-control-feedback hide'></span>";
					echo "</div>";
					
					echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='Address' id='txtAddress' value='" .$row["Address"] ."' />";
						echo "<span class='glyphicon form-control-feedback hide'></span>";
					echo "</div>";
					
					echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='Telephone/Fax' id='txtTelephonefax'" .$row["Telephonefax"] ."' />";
						echo "<span class='glyphicon' form-control-feedback hide'></span>";
					echo "</div>";
					
					echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='Mobile No. ' id='txtMobile' value='" .$row["Mobile"] ."' />";
						echo "<span class='glyphicon' form-control-feedback hide'></span>";
					echo "</div>";
					
					echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='Email Address' id='txtEmail' value='" .$row["Email"] ."' />";
						echo "<span class='glyphicon' form-control-feedback hide'></span>";
					echo "</div>";
					
				/* 	echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='Business Phone' id='txtBP' value='" .$row["BusinessPhone"] ."' />";
						echo "<span class='glyphicon form-control-feedback hide'></span>";
					echo "</div>";
					
					echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='Mobile No.' id='txtMobile' value='" .$row["MobileNo"] ."' />";
						echo "<span class='glyphicon form-control-feedback hide'></span>";
					echo "</div>"; */
					
					echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='Province' id='txtProvince' value='" .$row["Province"] ."' />";
						echo "<span class='glyphicon form-control-feedback hide'></span>";
					echo "</div>";
					
					echo "<div class='form-group has-feedback'>";
						echo "<input type='text' class='form-control' placeholder='City/Municipality' id='txtCity' value='" .$row["CityMunicipality"] ."' />";
						echo "<span class='glyphicon form-control-feedback hide'></span>";
					echo "</div>";
					
					if($row["Sal"] == "VIP"){
						$vip = "checked";
					}
					
					if($row["MobileNo"] == "Claimed"){
						$kit = "checked";
					}
					
					if($row["BusinessPhone"] == "Delegate"){
						$delegate = "checked";
					}
					
					if($row["BusinessPhone"] == "Exhibitor"){
						$exhibitor = "checked";
					}
					
					echo "<div>";
						echo "(<label>VIP</label>&nbsp;&nbsp;<input type='checkbox' id='cbVIP' " .$vip ." />)";
						echo "&nbsp;(<label>KIT</label>&nbsp;&nbsp;<input type='checkbox' id='cbKIT' " .$kit ." />)";
						echo "&nbsp;&nbsp;";
						echo "<input type='radio' id='rDelegate' value='Delegate' name='rad' " .$delegate ." />Delegate";
						echo "&nbsp;&nbsp;";
						echo "<input type='radio' id='rExhibitor' value='Exhibitor' name='rad' " .$exhibitor ." />Exhibitor";
					echo "</div>";
					
				echo "</form>";
				 
				echo "<button class='btn btn-primary btn-block btn-update' id='btnU-" .$id ."'>Update</button>";
			}
		}
	}
	
	function view(){
		if($this->input->post("id")){
			$cid = substr($this->input->post("id"), strpos($this->input->post("id"), "-") + 1);
			$id = filter_var($cid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			
			if($this->qEditing($id)){	
				$row = $this->qEditing($id);
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>First Name: </span>" .$row["FN"]  ."</h4>";
				echo "</div>";
				
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>Last Name: </span>" .$row["LN"]  ."</h4>";
				echo "</div>";
				
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>Company Name: </span>" .$row["CompanyName"]  ."</h4>";
				echo "</div>";
				
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>Designation: </span>" .$row["Designation"]  ."</h4>";
				echo "</div>";
				
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>Address: </span>" .$row["Address"] ."</h4>";
				echo "</div>";
				
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>Telephone/Fax: </span>" .$row["Telephonefax"] ."</h4>";
				echo "</div>";
				
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>Mobile No.</span>" .$row["Mobile"] ."</h4>";
				echo "</div>";
				
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>Email Address</span>" .$row["Email"] ."</h4>";
				echo "</div>";
				
			/* 	echo "<div class='spacer'>";
					echo "<h4><span class='gray'>Email: </span>" .$row["Email"]  ."</h4>";
				echo "</div>";
				
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>Mobile No: </span>" .$row["MobileNo"]  ."</h4>";
				echo "</div>";
				
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>Business Phone: </span>" .$row["BusinessPhone"]  ."</h4>";
				echo "</div>";
				
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>Designation: </span>" .$row["Designation"]  ."</h4>";
				echo "</div>";*/
				
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>PRC: </span>" .$row["Province"]  ."</h4>";
				echo "</div>";
				
				echo "<div class='spacer'>";
					echo "<h4><span class='gray'>OR: </span>" .$row["CityMunicipality"]  ."</h4>";
				echo "</div>"; 
				
			}
			
		}
	}
	
	function qEditing($tid){
		$id = filter_var($tid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		$data = array("ID" => $id);
		$s = $this->sqlquery;
		$sql = $s->select("tbl_persons", "*", true, "ID = ?");
		$arr = array();
		$query = $this->Configmodel->execute($sql, $data);
		if($query->num_rows() == 1){
			foreach($query->result_array() as $row){
				$arr["Sal"] = ucfirst($s->decodechar($row["Salutation"]));
				$arr["FN"] = ucfirst($s->decodechar($row["FirstName"]));
				$arr["LN"] = ucfirst($s->decodechar($row["LastName"]));
				$arr["CompanyName"] = ucfirst($s->decodechar($row["CompanyName"]));
				$arr["Designation"] = ucfirst($s->decodechar($row["Designation"]));
				$arr["Address"] = $s->decodechar($row["Address"]);
				$arr["Telephonefax"] = $s->decodechar($row["Telephonefax"]);
				$arr["Mobile"] = $s->decodechar($row["Mobile"]);
				$arr["Email"] = $s->decodechar($row["Email"]);
				$arr["MobileNo"] = $s->decodechar($row["MobileNo"]);
				$arr["BusinessPhone"] = $s->decodechar($row["BusinessPhone"]);
				
				$arr["Province"] = ucfirst($s->decodechar($row["Province"]));
				$arr["CityMunicipality"] = ucfirst($s->decodechar($row["CityMunicipality"]));
			}
			return $arr;
		}else{ 
			return false;
		}
	}
	
	function update(){
		if($this->input->post("id") && $this->input->post("FN") && $this->input->post("LN")){
			
			$cid = substr($this->input->post("id"), strpos($this->input->post("id"), "-") + 1);
			$id = filter_var($cid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			
			$email = $this->input->post("Email");
			
			
		/* 	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				echo -4;
			}else{  */
			
					$sal = filter_var($this->input->post("SAL"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$fn = filter_var($this->input->post("FN"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$ln = filter_var($this->input->post("LN"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$businessPhone = filter_var($this->input->post("BusinessPhone"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$mobileNo = filter_var($this->input->post("MobileNo"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$province = filter_var($this->input->post("Province"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$city = filter_var($this->input->post("City"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$designation = filter_var($this->input->post("Designation"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$company = filter_var($this->input->post("Company"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						//edit here
						$address = filter_var($this->input->post("Address"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$Telephonefax = filter_var($this->input->post("Telephonefax"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$mobile = filter_var($this->input->post("Mobile"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$email = filter_var($this->input->post("Email"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						
						$VIP = filter_var($this->input->post("VIP"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$kt = filter_var($this->input->post("KIT"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						$VType = filter_var($this->input->post("VType"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						
						$VIP = filter_var($this->input->post("VIP"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
						
						$KIT = null;
						
						if($kt == "true"){
							$KIT = "Claimed";
						}
						
					$data = array("SAL" => $VIP,//$sal,
									"FN" => $fn,
									"LN" => $ln,
								//	"BusinessPhone" => $VType,//$businessPhone,
								//	"MobileNo" => $KIT,
//									"Province" => $province,
//									"City" => $city,
									"Company" => $company,
									"Designation" => $designation,
									"Address" => $address,
									"Telephonefax" => $Telephonefax,
									"Mobile" => $mobile,
									"Email" => $email,
									"ID" => $id);
									
					$sql = $this->sqlquery->update("tbl_persons", "Salutation = ?, FirstName = ?, LastName = ?, BusinessPhone =?, MobileNo = ?, Address=? , Mobile=?, Telephonefax=?, "
														."Province = ?, CityMunicipality = ?, Designation = ?, CompanyName = ?, Email = ?", true, "ID = ?");
					
					$this->Configmodel->execute($sql, $data);
					
					echo 0;
			//}
		}else{ 
			echo -2;
		}
	}
	
	function updateButton(){
		if($this->input->post("id")){
			$cid = substr($this->input->post("id"), strpos($this->input->post("id"), "-") + 1);
			$id = filter_var($cid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			
			$data = array("ID" => $id);
			
			$sql = $this->sqlquery->select("tbl_persons", "ID,DateAttended", true, "ID = ?");
			$query = $this->Configmodel->execute($sql, $data);
			if($query->num_rows() == 1){
					foreach($query->result_array() as $row){
						if(!($row["DateAttended"] == null)){
								echo "<button class='btn-r btn btn-warning btn-block btn-xs' id='btnR-" .$row["ID"] ."'><i class='fa fa-retweet' aria-hidden='true'></i>&nbsp;&nbsp;Reset</button>";
						}else{ 
								echo "<button class='btn-a btn btn-info btn-block btn-xs' id='btnA-" .$row["ID"] ."'><i class='fa fa-flag-checkered' aria-hidden='true'></i>&nbsp;&nbsp;Attend</button>";
						}
					}
			}
		}
	}
	
	function attend(){
		if($this->input->post("id")){
			$cid = substr($this->input->post("id"), strpos($this->input->post("id"), "-") + 1);
			$id = filter_var($cid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			$da = $this->Configmodel->getDateTime();
			$data = array("DateAttended" => $da, "ID" => $id);
			$sql = $this->sqlquery->update("tbl_persons", "DateAttended = ?", true, "ID = ?");
			$this->Configmodel->execute($sql, $data);
			echo $da;
		}
	}
	
	function reset(){
		if($this->input->post("id")){
			$cid = substr($this->input->post("id"), strpos($this->input->post("id"), "-") + 1);
			$id = filter_var($cid, FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			$data = array("ID" => $id);
			$sql = $this->sqlquery->update("tbl_persons", "DateAttended = null", true, "ID = ?");
			$this->Configmodel->execute($sql, $data);
		}
	}
	
}