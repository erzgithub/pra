<link rel="stylesheet" href="<?php echo includeCss("hstyle") ?>">
<link rel="stylesheet" href="<?php echo includeCss("rcstyle") ?>">

<div class="upper-controller">
		<div class="inner-controller">
			<div class="row">
				<div class="container">
							<div class="row">
									<div class="col-md-2">
											<div class="input-group">
												<div class="category" >
															<select class="form-control" id="cmbCategory">
																 
															</select>
												</div>
											</div>  
									</div> 
									
									<div class=" col-md-4" >
													<div class="input-group">
															<input type="text" class="search-query form-control" placeholder="Search" id="txtSearch" />
															<span class="input-group-btn">
																<button class="btn btn-success btnSearch" title="Search">
																	<span class="glyphicon glyphicon-search"></span>
																</button>
																<button class="btn btn-info btnRefresh" title="Reload">
																	<span class="glyphicon glyphicon-refresh"></span>
																</button>
															</span>	
													</div>
									</div> 
									
									<div class="col-md-4">
										 
										&nbsp;&nbsp;Total Present:&nbsp;<b><span class="ptext"></span></b>
									</div>
							</div>
							 
								<div class="pagecontainer pgc">
								
										<nav>
										   <span>
											<ul class="pager">
												<li>
													<i>Page Size:&nbsp;
													<select id="cmbPS">
														<option>10</option>
														<option>20</option>
														<option>30</option>
														<option>40</option>
														<option>50</option>
													</select>
													&nbsp;&nbsp;</i>
												</li>
												<li><input type="button" class="btnPrev btn btn-danger btn-xs" value="<" title="Previous"/></li>
												<li>Page:&nbsp;<select class="form-controls cmbpager"><option>1</option></select> - &nbsp; <b class="tpages"></b> &nbsp; of &nbsp; <b class="trecords"></b>&nbsp;</li>
												<li><input type="button" class="btnNext  btn btn-danger btn-xs" value=">" title="Next"/></li>
											 
											</ul>
										   </span>
										</nav>
										
								</div>
					 
								
				</div>
			</div>
	  </div>
</div>
 <br>
<div class="m-container">
	<div class="main-content">
		
	</div>
</div>

<div id="myModal" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title"></h4>
						</div>
						<div class="modal-body">
							 <div class="modal-container">
							 
							 </div>
							 <div class="loadersposition modal-loader">
								<img src="<?php echo asset_url("images/ajax-loader.gif") ?>"/>
							 </div>
						</div>
					 <!--	<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="button" class="btn btn-primary btnSave">Save changes</button>
						</div>     -->
					</div>
				</div>
</div>


<div class="loadersposition records">
	<img src="<?php echo asset_url("images/ajax-loader.gif") ?>"/>
</div>

<script type="text/javascript" src="<?php echo includeJs("jquery.tablesorter.min") ?>"></script>

<script type="text/javascript" src="<?php echo includeJs("jquery.webui-popover") ?>"></script>
<link rel="stylesheet" href="<?php echo includeCss("jquery.webui-popover") ?>">

<script type="text/javascript" src="<?php echo includeJs("rcscript") ?>"></script>