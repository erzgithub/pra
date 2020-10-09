<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Loader extends CI_Loader {
	
	public function template($template_name, $vars = array(), $allowHeader = 0, $allowDoc = 0, $return = false){
		$curTemplate = $template_name ."/index";
		
		if($allowDoc == 0){
			if(file_exists(APPPATH ."views" .DIRECTORY_SEPARATOR ."templates/header.php")){
					$this->view("templates/header", $vars, $return);
			}
			
				if($allowHeader == 1){
					if(file_exists(APPPATH ."views" .DIRECTORY_SEPARATOR .$template_name .DIRECTORY_SEPARATOR ."navbar.php")){
						$this->view($template_name ."/navbar.php", $vars, $return);
					}	
				}else{ 
					if(file_exists(APPPATH ."views" .DIRECTORY_SEPARATOR ."templates/navbar.php")){
							$this->view("templates/navbar", $vars, $return);
					}
				}
				
				$this->view($curTemplate, $vars, $return);
					
			if(file_exists(APPPATH ."views" .DIRECTORY_SEPARATOR ."templates/footer.php")){
					$this->view("templates/footer", $vars, $return);
			}
		
		}else{ 
			$this->view($curTemplate, $vars, $return);
		}
		
	/* 	if($allowHeader == 0){
			if(file_exists(APPPATH ."views" .DIRECTORY_SEPARATOR ."templates/header.php")){
				$this->view("templates/header", $vars, $return);
			}
			
			if(file_exists(APPPATH ."views" .DIRECTORY_SEPARATOR ."templates/navbar.php")){
				$this->view("templates/navbar", $vars, $return);
			}
			$this->view($curTemplate, $vars, $return);
			if(file_exists(APPPATH ."views" .DIRECTORY_SEPARATOR ."templates/footer.php")){
				$this->view("templates/footer", $vars, $return);
			}
		}else{
			if(file_exists(APPPATH ."views" .DIRECTORY_SEPARATOR .$template_name .DIRECTORY_SEPARATOR ."header.php")){
				$this->view($template_name ."/header.php", $vars, $return);
			}
			
			if(file_exists(APPPATH ."views" .DIRECTORY_SEPARATOR .$template_name .DIRECTORY_SEPARATOR ."navbar.php")){
				$this->view($template_name ."/navbar.php", $vars, $return);
			}
			
			$this->view($curTemplate, $vars, $return);
			
			if(file_exists(APPPATH ."views" .DIRECTORY_SEPARATOR .$template_name .DIRECTORY_SEPARATOR ."footer.php")){
				$this->view($template_name ."/footer.php");
			}
		} */
		
	}
	
}