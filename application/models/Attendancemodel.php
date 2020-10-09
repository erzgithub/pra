<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Attendancemodel extends CI_Model{
            function save(){
            if($this->input->post("code")){
                $BarcodeID = filter_var($this->input->post("code"), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

                  $row = ($this->myQuery($BarcodeID)) ? ($this->myQuery($BarcodeID)) : false;
                if($row !== false){
                   
                 $sql = $this->sqlquery->insert("tbl_attendance", "first,last,company,barcode"  , "?,?,?,?");

                    $data = array("first" => $row["first"],
                                  "last" => $row["last"],
                                  "company" => $row["company"],
                                  "barcode" => $BarcodeID);

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
                    $arr["first"] = $this->sqlquery->decodechar($row["FirstName"]);
                    $arr["last"] = $this->sqlquery->decodechar($row["LastName"]);
                    $arr["company"] = $this->sqlquery->decodechar($row["CompanyName"]);
                }
                return $arr;
            }else{
                return false;
            }

        }
        function entry(){
             $sql = $this->sqlquery->select("tbl_attendance", "*", false, "BarcodeID = ?");
            $query = $this->db->query($sql, null);
             echo number_format($query->num_rows()); 
        } 
        function attendancename(){
            $sql = $this->sqlquery->select("tbl_attendance", "*", false, "BarcodeID = ?");
            $query = $this->db->query($sql, null);
            if ($query->num_rows()>0){
                return $query;            
            }else {
                return false;
            }
        }  


}