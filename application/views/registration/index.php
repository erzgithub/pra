
<link rel="stylesheet" href="<?php echo includeCss("hstyle") ?>"/>
<link rel="stylesheet" href="<?php echo includeCss("rstyle") ?>"/>
	<div class="rows">
			
		<!--	<div class="col-md-5 text-center">
				<div class="logo">
					 <img src="<?php echo base_url() ."assets/images/PRA3 final.png" ?>"/> 
				</div>
					<br>
				<div>
					<span>Technology Partner:</span><span class='blue'><img src="<?php echo asset_url("images/atilogos.png") ?>" width="55" height="40"/><b>American Technologies Inc.</b></span>
				</div>
				
			</div> -->
			

			<div class="col-md-7">
					<div class="">
						<div class="panel panel-warning">
							<div class="panel-heading">
								<div class="panel-title">Registration</div>
							</div>
							
							<div class="panel-body">
								<div class="spacer">
								
									<div class="alert text-center hide">
										<strong></strong>
									</div>
									<div class="alert alert-danger hide" id="Invalid__Message">

									</div>
									
									<form role="form">
										<input type="hidden" value="" id="txtId" />
										<input type="hidden" value="" id="txtGenId" />
										
									<!--	
										<div class="form-group has-feedback">
											<input type="text" class="form-control" placeholder="Salutation" id="txtSal"  required autofocus />
											<span class="glyphicon form-control-feedback hide"></span>
										</div>  
									-->
										
										<div class="row">
													<div class="col-xs-6 col-md-6">
														<div class="form-group has-feedback">
															<input class="form-control" placeholder="First Name" type="text" id="txtFN" required autofocus />
															<span class="glyphicon form-control-feedback hide"></span>
														</div>
													</div>
													 
													<div class="col-xs-6 col-md-6">
														<div  class="form-group has-feedback">
															<input class="form-control" placeholder="Last Name" type="text" id="txtLN" required />
															<span class="glyphicon form-control-feedback hide"></span>
														</div>
													</div>
										</div>	
										
									<!--	<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="PRC" id="txtPRC"  required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>
										
										<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="OR" id="txtOR"  required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>-->
										
										<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="Company" id="txtCompany"  required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>
										
										<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="Designation" id="txtDesignation" required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>
										<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="Address" id="txtAddress" required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>
										
										<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="Telephone/Fax" id="txtTelephonefax" required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>
										
										<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="Mobile No." id="txtMobile" required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>
										
										<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="Email Address" id="txtEmail" required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>
										
										<!-- <div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="Chapter" id="txtDesignation"  required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>  
										 
										<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="Email" id="txtEmail"  required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>
					
										<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="Business Phone" id="txtBP"  required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>
										
										<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="Mobile No." id="txtMobile"  required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>
										
										<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="Province" id="txtProvince"  required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>
										
										<div class="form-group has-feedback">
												<input type="text" class="form-control" placeholder="City/Municipality" id="txtCity"  required/>
												<span class="glyphicon form-control-feedback hide"></span>
										</div>-->
										
										<div class="hide">
											(<label>Present</label>&nbsp;&nbsp;<input type="checkbox" id="cbPresent" checked/>)
											&nbsp;(<label>VIP</label>&nbsp;&nbsp;<input type="checkbox" id="cbVIP"/>)
											&nbsp;(<label>KIT</label>&nbsp;&nbsp;<input type="checkbox" id="cbKIT"/>) 
											<div class="hide">
												&nbsp;
												&nbsp;
												&nbsp;<input type="radio" class="select__radio" id="rDelegate" value="Delegate" name="rad" checked/>Delegate
												&nbsp;
												&nbsp;<input type="radio" class="select__radio" id="rExhibitor" value="Exhibitor" name="rad"/>Pre-Paid
												&nbsp; 
												&nbsp;<input type="radio" class="select__radio" id="rSponsor" value="Sponsor" name="rad"/>Pre-Registered
												&nbsp;
												&nbsp;<input type="radio" class="select__radio" id="rCon" value="Concessionaires" name="rad"/>Sponsor/Board/Speaker/Guest
												&nbsp;<input type="radio" class="select__radio" id="rsVIP" value="sVIP" name="rad"/>Opening(1 day only)
												&nbsp; 
											</div>
										</div> 
										<div class="form-group">
											<select name="type" id="select__type" class="form-control">
												<!-- <option value="Delegate" selected>
													Delegate
												</option> -->
												<option value="Paid">
													PP-Paid
												</option>
												<option value="Unpaid">
													PR-Unpaid
												</option>
												 <option value="SBC">
													SBC-Sponsor/Board/Speaker/Guest
												</option> 
												<option value="One day">
													One day
												</option>
											</select>
										</div>
										
									</form>
									
									<button class="btn btn-lg btn-success btn-block btn-Save">
										<i class="fa fa-floppy-o" aria-hidden="true"></i>
										&nbsp;Save
									</button>
									<button class="btn btn-lg btn-info btn-block btn-Continue hide">
										<i class="fa fa-chevron-right" aria-hidden="true"></i>
										&nbsp;Continue and Save
									</button>
								</div>
							</div>
							
						</div>
					</div>

				<!--	<div class="col-md-2 loadersposition save">
						<img src="<?php echo asset_url("images/ajax-loader.gif") ?>"/>
					</div> -->
					
			</div>
			<div class="col-md-5 bg">
				<div id="Invalid__Table--Container" class="hide">
					<div class="panel panel-danger">
					    <div class="panel-heading">
					        <h3 class="panel-title">User Info</h3>
					    </div>
					    <div class="panel-body">
					        <div id="Invalid__Table" style="max-height: 600px; overflow-y: scroll;"></div>
					    </div>
					</div>
					
				</div>
				 
			</div>
	</div>
<!--<div class="col-sm-6">
<div class="m-container">
    <div class="main-content">
        
    </div>
</div>

<div class="loadersposition records">
    <img src="<?php echo asset_url("images/ajax-loader.gif") ?>"/>
</div> -->
 

<script type="text/javascript" src="<?php echo includeJs("rscript") ?>"></script>
<script type="text/javascript" src="<?php echo includeJs("jquery.redirect.min") ?>"></script>
<script type="text/javascript" src="<?php echo includeJs("rcscript") ?>"></script>
<script type="text/javascript" src="<?php echo includeJs("jquery.tablesorter.min") ?>"></script>
<link rel="stylesheet" href="<?php echo includeCss("jquery.webui-popover") ?>">
<script type="text/javascript" src="<?php echo includeJs("jquery.webui-popover") ?>"></script>