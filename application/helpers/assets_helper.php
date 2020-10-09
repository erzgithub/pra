<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

	

if(!function_exists('asset_url')){
	function asset_url($uri = '', $group = false){
		$CI = & get_instance();
		if(!$dir = $CI->config->item("asset_path")){
			$dir = 'assets/';
		}
		
		if($group){
			return $CI->config->base_url($dir .$group ."/" .$uri);
		}else{ 
			return $CI->config->base_url($dir .$uri);
		}
		
	}
}
 if(!function_exists("includeJs")){
	
	function includeJs($filename = ''){
		$CI = & get_instance();
		if(!$dir = $CI->config->item("asset_path")){
			$dir = "assets/";
		}
		
		return $CI->config->base_url($dir ."js/" .$filename) .".js";
	}
}

if(!function_exists("includeCss")){
	function includeCss($filename = ''){
		$CI = & get_instance();
		if(!$dir = $CI->config->item("asset_path")){
			$dir = "assets/";
		}
		return $CI->config->base_url($dir ."css/" .$filename) .".css";
	}
}

if(!function_exists("Items_per_Page")){
	function Items_per_Page(){
		return 20;
	}
}