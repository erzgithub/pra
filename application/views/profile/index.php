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
				
				if($VType == "Delegate" || $VType == "SVIP" || $VType == null ){
					$res = "res";
					$details = "details";
				}else{ 
					$res = "res1";
					$details = "details1";
				}
				
			?>
			<!--<div class="<?php echo $res ?>">
					<span>
							<?php
								if($VType == "Delegate" || $VType == "SVIP" || $VType == null ){
									echo "" .$FirstName ." " .$LastName;
								}else{ 
									echo $CompanyName;
								}
							?> 
						</span>
				</div> -->
			
				<div class="<?php echo $details ?>">
					<span>
							<?php 
									if($VType == "Delegate" || $VType == "sVIP" || $VType == null){
										echo "" .$FirstName ." " .$LastName;
									}else {
										echo $VType;
									}
								?>
						</span>
				</div>
				
				<?php if($VType == "Delegate" || $VType == "SVIP" || $VType == null){ ?>
					<div class="barcode">
						<img src="data:image/png;base64, <?php echo $Barcode  ?>" width="70" height="20"/>
					</div>
					<div class="code">
						<span><?php
								 echo $Code;
							?>
							</span>
					</div>
				<?php } ?>
				
			</div>
		 
			<script type="text/javascript" src="<?php echo includeJs("id") ?>"></script>
		</body>
</html>