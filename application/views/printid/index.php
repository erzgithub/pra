<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="utf-8">
		<script type="text/javascript" src="<?php echo includeJs("jquery-2.2.3.min") ?>"></script>
		<script type="text/javascript" src="<?php echo includeJs("local") ?>"></script>
	</head>
		<body>
			<script type="text/javascript" src="<?php echo includeJs("jquery.textfill.min") ?>"></script>
			<link rel="stylesheet" href="<?php echo includeCss("id") ?>">
				<div class="idcontainer">
				<?php 
				$res;
				$details;
				
				if($VType == "Delegate"){
					$res = "res";
					$details = "details";
				}else{ 
					$res = "res1";
					$details = "details1";
				}
				
			?>
				<!--	<div class="<?php echo $res ?>">
						<span>
							<?php
								if($VType == "Delegate" || $VType == "SVIP"){
									echo "";
								}else{ 
									echo "";
								}
							?> 
						</span>
					</div>-->
					<div class="<?php echo $details ?>">
						<span>
							<?php 
									if($VType == "Delegate" || $VType == "SVIP"){
										echo " " .$FN ." " .$LN;
										echo "<br>";
										echo $Company;
									}else {
										echo $VType;
									}
								?>
						</span>
					</div>
					
					<?php  if($VType == "Delegate" || $VType == "SVIP"){ ?>
						  <div class="barcode">
							<img src="data:image/png;base64, <?php echo $BarcodeID  ?>" width="240" height="20"/>
						</div> 
						<div class="code">
							<span>
								<?php 
									 
										echo $Code;
								 ?>
							</span>
						</div>
					<?php } ?>
				</div>
			 
			<script type="text/javascript" src="<?php echo includeJs("id") ?>"></script>
		</body>
</html>