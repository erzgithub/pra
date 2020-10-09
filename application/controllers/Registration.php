<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Registration extends CI_Controller{
    
    private $genID;
    
    function __construct(){
        parent::__construct();
        $this->load->model("Registrationmodel");
		$this->load->model("Configmodel");
		$this->load->library("Sqlquery");
    }
    
    function index(){
        $this->load->helper("url");
        $this->load->template("registration", null, 0);
    
    }
    
    function checkgenID($cid){
        $id = filter_var($cid, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $sql = $this->sqlquery->select("tbl_persons", "BarcodeID", true, "BarcodeID = ?");
        $data = array("BarcodeID" => $id);
        $query = $this->Registrationmodel->execute($sql, $data);
        if($query->num_rows() > 0){
            $this->checkgenID($this->genID());
        }else{ 
            $this->genID = $id;
            return false;
        }
    }
    
    function genID(){
        return base_convert(uniqid(rand()), 10, 36);
    }

    function checkName()
    {
        $sql = $this->sqlquery->select("tbl_persons", "*", true, "FirstName LIKE ? ");
        $data = array(
            "FirstName" => '%'. $this->input->post("FN") . '%'  
        );

        $query = $this->Registrationmodel->execute($sql, $data);

        if ($query->num_rows() > 0) {
            echo json_encode(['status' => -9, 'data' => $query->result_array()]);
            return false;
        }

        return true;
    }
    function checkLname() 
    {
        $sql = $this->sqlquery->select("tbl_persons", "*", true, "LastName LIKE ?");
        $data = array(
            "LastName"  => '%'. $this->input->post("LN") . '%'
        );
        $query = $this->Registrationmodel->execute($sql, $data);
        if ($query->num_rows() > 0) {
            echo json_encode(['status' => -8, 'data' => $query->result_array()]);
            return false;
        }

        return true;
    }

    function checkCompany()
    {
        $sql = $this->sqlquery->select("tbl_persons", "*", true, "CompanyName LIKE ?");
        $data = array(
            "CompanyName" => '%'. $this->input->post("Company") . '%'
        );
        $query = $this->Registrationmodel->execute($sql, $data);
        if ($query->num_rows() > 0) {
            echo json_encode(['status' => -10, 'data' => $query->result_array()]);
            return false;
        }

        return true;
    }

    function update()
    {
			$id = filter_var($this->input->post("id"), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
			
			$email = $this->input->post("Email");
	        $present = $this->input->post("Present");
	        $sal = filter_var($this->input->post("SAL"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	        $fn = filter_var($this->input->post("FN"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	        $ln = filter_var($_POST["LN"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	        $businessPhone = filter_var($this->input->post("BusinessPhone"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	        $mobileNo = filter_var($this->input->post("MobileNo"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	        $province = filter_var($this->input->post("Province"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	        $city = filter_var($this->input->post("City"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	        $designation = filter_var($this->input->post("Designation"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	        $company = filter_var($this->input->post("Company"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	        $address = filter_var($this->input->post("Address"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	        $Telephonefax = filter_var($this->input->post("Telephonefax"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	        $mobile = filter_var($this->input->post("Mobile"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	        $email = filter_var($this->input->post("Email"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
	        
	        $dateRegistered = $this->Registrationmodel->getDateTime();
	        
	        $PRC = filter_var($this->input->post("PRC"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	        $OR = filter_var($this->input->post("OR"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	        $Vtype = filter_var($this->input->post("VType"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	        $kt = filter_var($this->input->post("KIT"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	        
	        $VIP = filter_var($this->input->post("VIP"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	        
	        $KIT = null;
	        
	        if($kt == "true"){
	            $KIT = "Claimed";
	            $this->saveKit($BarcodeID);
	        }

	        $dateAttended = ($present == "true") ? $this->Registrationmodel->getDateTime() : null;
			
			$data = array(
              "Salutation" => $VIP,//$sal,
	          "FN" => $fn,
	          "LN" => $ln,
	          "CompanyName" => $company,
	          "BusinessPhone" => $Vtype,//$businessPhone,
	          "Designation" => $designation,
	          "Province" => $PRC,
	          "CityMunicipality" => $OR,
	          "DateRegistered" => $dateRegistered,
	          "DateAttended" => $dateAttended,
	          "isAllowed" => 0,
	          "Address" => $address,
	          "Telephonefax" => $Telephonefax,
	          "Mobile" => $mobile,
	          "Email" => $email,
	          "Remarks" => $this->input->post('remarks'),
			  "ID" => $id
		);

		$sql = $this->sqlquery->update("tbl_persons", 
                "Salutation = ?, FirstName = ?, LastName = ?, CompanyName = ?".
                ", BusinessPhone = ?, Designation = ?, Province = ?, CityMunicipality = ?, DateRegistered = ?, DateAttended = ?, isAllowed = ?" . 
                ",Address =?,Telephonefax  = ?, Mobile = ?, Email = ?, Remarks = ?"
                , true
                , "ID = ?");
			
		$this->Configmodel->execute($sql, $data);

        $this->session->set_userdata("Barcode_ID", $this->input->post('genId'));
        echo json_encode(['status' => 0]);
    }


    function save() {
        
        $this->load->library("session");
        $id = $this->input->post('id');
        if ($id > 0) {
            // if(!($this->checkgenID($this->genID()))){
            //     $this->persists();
            // }
            // return false;

            if ($id == 9999999) {
                if(!($this->checkgenID($this->genID()))){
                    $this->persists();
                    return true;
                }
            }

            $this->update();

            return false;
        }

        if($this->input->post("FN") || $this->input->post("LN")){
                    /* if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        echo -4;
                    }else{  */
            
                if ( !$this->checkName() || !$this->checkLname()) {
                    return false;
                }
                if(!($this->checkgenID($this->genID()))){
                    $this->persists();
                }
                    //}
        }else{ 
            echo json_encode(['status' => -2]);
        }
    }

    function persists()
    {
        $BarcodeID = $this->genID;
        $email = $this->input->post("Email");
        $present = $this->input->post("Present");
        $sal = filter_var($this->input->post("SAL"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $fn = filter_var($this->input->post("FN"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $ln = filter_var($_POST["LN"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $businessPhone = filter_var($this->input->post("BusinessPhone"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $mobileNo = filter_var($this->input->post("MobileNo"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $province = filter_var($this->input->post("Province"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $city = filter_var($this->input->post("City"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $designation = filter_var($this->input->post("Designation"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $company = filter_var($this->input->post("Company"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $address = filter_var($this->input->post("Address"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $Telephonefax = filter_var($this->input->post("Telephonefax"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $mobile = filter_var($this->input->post("Mobile"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        $email = filter_var($this->input->post("Email"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
        
        $dateRegistered = $this->Registrationmodel->getDateTime();
        
        $PRC = filter_var($this->input->post("PRC"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $OR = filter_var($this->input->post("OR"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $Vtype = filter_var($this->input->post("VType"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $kt = filter_var($this->input->post("KIT"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        
        $VIP = filter_var($this->input->post("VIP"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        
        $KIT = null;
        
        if($kt == "true"){
            $KIT = "Claimed";
            $this->saveKit($BarcodeID);
        }
        
        
        $dateAttended = ($present == "true") ? $this->Registrationmodel->getDateTime() : null;
        
        $questionMark = [];
        for ($i=0; $i < 17; $i++) { 
            $questionMark[] = '?';
        }
        $questionMark = implode(',', $questionMark);

        $sql = $this->sqlquery->insert(
                "tbl_persons",
                "Salutation,FirstName,LastName,CompanyName".
                ",BusinessPhone,Designation,Province,CityMunicipality,DateRegistered,DateAttended,isAllowed,BarcodeID" .
                ",Address,Telephonefax,Mobile,Email, Remarks",
                $questionMark);
         
        
        $data = array(
              "Salutation" => $VIP,//$sal,
	          "FN" => $fn,
	          "LN" => $ln,
	          "CompanyName" => $company,
	          "BusinessPhone" => $Vtype,//$businessPhone,
	          "Designation" => $designation,
	          "Province" => $PRC,
	          "CityMunicipality" => $OR,
	          "DateRegistered" => $dateRegistered,
	          "DateAttended" => $dateAttended,
	          "isAllowed" => 0,
	          "BarcodeID" => $BarcodeID,
	          "Address" => $address,
	          "Telephonefax" => $Telephonefax,
	          "Mobile" => $mobile,
	          "Email" => $email,
	          'Remarks' => $this->input->post('remarks')
        );

        $this->Registrationmodel->execute($sql, $data);
        $this->session->set_userdata("Barcode_ID", $BarcodeID);
        echo json_encode(['status' => 0]);
    }
    
    function saveKit($b){
        $barcode = filter_var($b, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
        $data = array("BarcodeID" => $barcode, "DateRecorded" => $this->Registrationmodel->getDateTime());
        $sql = $this->sqlquery->insert("tbl_kits", "BarcodeID, DateRecorded", "?,?");
        $this->Registrationmodel->execute($sql, $data);
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
        $query = $this->Registrationmodel->execute($sql, $data);
        
        if($val == "records"){
            print_r(number_format($query->num_rows()));
        }else{ 
            $total_records = $query->num_rows();
            $total_page = ceil($total_records / $pageSize);
            print_r(number_format($total_page));
        }
        
    //}
    
   
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
        $query = $this->Registrationmodel->execute($sql, $data);
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
        $this->Registrationmodel->execute($sql, $data);
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
         $query = $this->Registrationmodel->execute($sql, $data);
        echo number_format($query->num_rows());
    }
    function select_validate() //dagdag ko for validating the select option and proceed with barcode printing kaso hindi gumagana
{
    $choice = $this->input->post("#myselect");
    if(is_null($choice))
    {
        $choice = array();
    }
    $myselect = implode(',', $choice);

    if($myselect != '') {
        return true;
    } else {
        $this->form_validation->set_message('select_validate', 'You need to select a least one element');
        return false;
    }
}

    
}