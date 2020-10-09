<script type="text/javascript" src="<?php echo includeJs("jquery-ui.min")  ?>"></script>
<link rel="stylesheet" href="<?php echo includeCss("jquery-ui.min") ?>"/>
<link rel="stylesheet" href="<?php echo includeCss("jquery-ui.theme.min") ?>"/>

<link rel="stylesheet" href="<?php echo includeCss("hstyle") ?>"/>
<link rel="stylesheet" href="<?php echo includeCss("rfstyle")?>"/>


	<div class="container">
			<div class="row">
				<div class="n-container">
					<div class="row">
						
						<div class="logo">
							<img src="<?php echo asset_url("images/atilogos.png") ?>" width="65" height="50"/>&nbsp;E-RAFFLE
						</div>
						
						<div class="cd">
							<div id="countdown"></div>
						</div>
					</div>
					
					<div class="row rbg">
							
							<div class="row mcon">
								 
								 <div class="t-container">
									<div class="lc hide">
										<img src="<?php echo asset_url("images/lconf.png") ?>" width="120" height="95"/>
									</div>
										 <div class="mt">
												<div class="title"></div>
										</div>
									<div class="rc hide">
										<img src="<?php echo asset_url("images/rconf.png") ?>" width="120" height="95"/>
									</div>
									
								</div>
							 
							</div>
							
							
								<div class="text-center rn-names white">
									 
								</div>
						
					</div>
					
				</div>
			</div>
	</div>
 


			<div class="control">
				<ul>
					<li> <button class="btn btn-success btn-lg" id="btnStart"><i class="fa fa-flag-checkered" aria-hidden="true"></i>&nbsp;Start</button> </li>
					 <li><button class="btn btn-primary btn-lg" id="btnReset"><i class="fa fa-retweet" aria-hidden="true"></i>&nbsp;Reset</button></li>
					 <li>
						<select id="cmbSec" class="form-controls">
							<option>3</option>
							<option>5</option>
							<option>10</option>
						</select>
					 </li>
				 </ul>
			</div>

<script type="text/javascript" src="<?php echo includeJs("rfscript") ?>"></script>