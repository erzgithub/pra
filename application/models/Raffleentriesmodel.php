<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Raffleentriesmodel extends CI_Model{
        
        function save(){
            if($this->input->post("code")){
                $BarcodeID = filter_var($this->input->post("code"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
                $this->myQuery($BarcodeID);
                  $row = ($this->myQuery($BarcodeID)) ? ($this->myQuery($BarcodeID)) : false;

                if($row !== false){
                   
                 $sql = $this->sqlquery->insert("tbl_raffleentries", "FirstName,LastName,CompanyName,BarcodeID,isPicked"  , "?,?,?,?,?");

                    $data = array("FN" => $row["FN"],
                                  "LN" => $row["LN"],
                                  "CompanyName" => $row["CompanyName"],
                                  "Barcode" => $BarcodeID,
                                  "isPicked" => 0);

                  $this->db->query($sql, $data);
                    echo "Success";
                }else{
                    echo "Failed";
                }
            }
        }

        function myQuery($BarcodeID){
            $sql = $this->sqlquery->select("tbl_persons", "*", true, "BarcodeID = ?");
            $data = array("BarcodeID" => $BarcodeID);
            $query = $this->db->query($sql, $data);

          $arr = array();

            if($query->num_rows() == 1){
                foreach($query->result_array() as $row){
                    $arr["FN"] = $this->sqlquery->decodechar($row["FirstName"]);
                    $arr["LN"] = $this->sqlquery->decodechar($row["LastName"]);
                    $arr["CompanyName"] = $this->sqlquery->decodechar($row["CompanyName"]);
                }
                return $arr;
            }else{
                return false;
            }

        }
        function entry(){
             $sql = $this->sqlquery->select("tbl_raffleentries", "*", false, "BarcodeID = ?");
            $query = $this->db->query($sql, null);
             echo number_format($query->num_rows()); 
        } 
        function rafflename(){
            $sql = $this->sqlquery->select("tbl_raffleentries", "*", false, "BarcodeID = ?");
            $query = $this->db->query($sql, null);
            if ($query->num_rows()>1){
                return $query;            
            }else {
                return false;
            }
        }  

}