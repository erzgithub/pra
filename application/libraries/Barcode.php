<?php 
include('src/BarcodeGenerator.php');
include('src/BarcodeGeneratorPNG.php');
include('src/BarcodeGeneratorSVG.php');
include('src/BarcodeGeneratorJPG.php');
include('src/BarcodeGeneratorHTML.php');
//https://github.com/picqer/php-barcode-generator
class Barcode {
	
	private $generator;
	
	function generator(){
		$generator  = new Picqer\Barcode\BarcodeGeneratorPNG();
		return $generator;
	}
	
}