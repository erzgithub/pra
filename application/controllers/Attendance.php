<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Attendance extends CI_Controller{
    
    function __construct(){
        parent::__construct();
        $this->load->model("Attendancemodel");
        $this->load->library("Sqlquery");
    }
    
    function index(){
        $this->load->helper("url");
        $this->load->template("attendance", null, 0);
    }
    function save(){
        $this->Attendancemodel->save();
    }
    function totalentry(){
        $this->Attendancemodel->entry();
    }
}