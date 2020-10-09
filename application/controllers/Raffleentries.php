<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Raffleentries extends CI_Controller {
    function __construct(){
        parent::__construct();
        $this->load->library("Sqlquery");
        $this->load->model("Raffleentriesmodel");
    }

    function index(){
        $this->load->helper("url");
        $arr["query"] = $this->Raffleentriesmodel->rafflename();
        $this->load->template("raffleentries", $arr);
    }

    function save(){
        $this->Raffleentriesmodel->save();
    }
    function totalentry(){
        $this->Raffleentriesmodel->entry();
    }

}