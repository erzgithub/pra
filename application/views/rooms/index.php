<link rel="stylesheet" href="<?php echo includeCss("hstyle") ?>"/>
<link rel="stylesheet" href="<?php echo includeCss("rstyle") ?>"/>
<div class="container">
	<div class="row">
		
		<div class="col-md-12">
						
					 
			<div>
				<h1><i class="fa fa-map-marker" aria-hidden="true"></i></h1>
				<hr>
				<div class="row">
				 	<div class="col-md-5">
							<label class="col-xs-3 control-label"></label>
							<div class="col-xs-9">
								<select class="form-control" name="SessionRooms" id="cmbSessionRooms">
									 
								</select>
							</div>
					</div>
					
					<div class="col-md-2">
						<button class="btn btn-success btn-block btn-sm" id="btnRC">Refresh Count</button>
					</div>
					
					<div class="col-md-3">
						<span class="c-claim"></span>
					</div>
					
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<div class="input-group">
							<div class="input-group-addon"><i class="fa fa-barcode" aria-hidden="true"></i></div>
							<input type="text" class="form-control" id="txtBarcode" autofocus/>
						</div>
					</div>
				</div>
				
				<br>
				<button id="btnCheck" class="btn btn-primary btn-block btn-md"><i class="fa fa-check" aria-hidden="true"></i>&nbsp;Check</button>
			</div>
			
			<div class="result">
			
			</div>
			
		</div>
		
	</div>
</div>

					<div class="col-md-2 loadersposition rooms">
						<img src="<?php echo asset_url("images/ajax-loader.gif") ?>"/>
					</div>
					
<script type="text/javascript" src="<?php echo includeJs("rmscript") ?>"></script>