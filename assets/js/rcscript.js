$(function(){
	 var currPage = 1;
	 var cpages = [];
	 var data = [];
	 var total_page = 0;
	 var total_records = 0;
	 var keyword = null;
	 var wC = 0;
	 var pageSize = 10;
	 var category;
	 
	 var Categories = {0:"First Name", 1:"Last Name", 2:"Company Name"};
	 
	 loadDefaults();
	 
	 function loadDefaults(){
		 LoadPersons(data);
		 updatePageInfo();
		 LoadPages();
		 LoadCategories();
	 }
	 
	 function LoadCategories(){
		 if(Categories){
			 $.each(Categories, function(val, text){
				$("#cmbCategory").append(new Option(text));
			 });
		 }
	 }
	 
	 function LoadPersons(data){
		 $.ajax({
				type:"POST",
				url: BaseURL + "/records/showrecords",
				data:data,
				async: true,
				beforeSend: function(){
					$(".records").show();
				},
				success: function(html){
					$(".main-content").html(html);
					$(".click").webuiPopover({
							type:"html",
							title: "Configuration",
							cache: false,
							content: function(data){
								$(".c-content").html(Config(this.id));
								return $(this).parent().find(".content").html();
							},
							placement: "right",
							animation: "fade",
							closeable: true,
							width: "160"
					});
					TableSorter();
					LoadAB();
					updatePresent();
				},
				complete: function(){
					$(".records").hide();
				}
				
		 });
		  
	 }
	 
	 
	 function Config(id){
		 var s = $.ajax({
				type:"POST",
				url: BaseURL + "/records/config",
				data:{id:id},
				async: false,
				beforeSend: function(){
					$(".conf").show();
				},
				complete: function(){
					$(".conf").hide();
				}
		 }).responseText;
		 return s;
	 }
	 
	 function LoadPages(){
		 cpages = [];
		 $(".cmbpager").empty();
		 for(var i = 1; i <= total_page.replace(",", ""); i++){
			cpages.push(i);
		 }
		 
		  $.each(cpages, function(i, v){
				$(".cmbpager").append(new Option(v));
		  });
	 }
	 
	 function setNavigation(total_page){
		if(total_page > 1){
			if(currPage == total_page){
				 $(".btnNext").attr("disabled", true);
				 $(".btnPrev").attr("disabled", false);
			 }else if(currPage > 1){
				 $(".btnPrev").attr("disabled", false);
				 $(".btnNext").attr("disabled", false);
			 }else if(currPage <= 1){
				 $(".btnPrev").attr("disabled", true);
				 $(".btnNext").attr("disabled", false);
			 }
		 }else{ 
			$(".btnNext").attr("disabled", true);
			$(".btnPrev").attr("disabled", true);
		 }
	 }
	 
	 function Pager(i){ 
		$(".cmbpager").each(function(){
			$(this).find("option").eq(i - 1).prop("selected", true); 
		});
		  
	 }
	 
	 function getTotal(val, data){
		 var s = $.ajax({
					 type:"POST",
					 url: BaseURL + "/records/total/" + val,
					 data:data,
					 async: false
				  }).responseText;
		return s;
	 }
	 
	 function updatePageInfo(){
		 total_page = getTotal("page", data);
		 total_records = getTotal("records", data);
		 $(".tpages").text(total_page);
		 $(".trecords").text(total_records);
		 setNavigation(total_page.replace(",", ""));
		 LoadPages();
	 }
	 
	 $("#txtSearch").keypress(function(e){
		  if(e.keyCode == 13){
			  Search($(this).val());
		  }
	 });
	 
	 $(".btnSearch").click(function(){
		 if($("#txtSearch").val()){
			 Search($("#txtSearch").val());
		 }
	 });
	 
	 $(".btnRefresh").click(function(){
		$("#txtSearch") .val("");
		wC = 0;
		data = [];
		currPage = 1;
		pageSize = $("#cmbPS").val();
		data = {pageSize:pageSize};
		LoadPersons(data);
		updatePageInfo();
		LoadPages();
		// $("#cmbPS").prop("selectedIndex", 0);
	 });
	 
	 function Search(key){
		 wC = 1;
		 currPage = 1;
		 keyword = key;
		 category = $("#cmbCategory").val();
		 data = {wC:wC, keyword:keyword, category:category, pageSize:pageSize};
		 LoadPersons(data);
		 updatePageInfo();
	 }
	 
	 $(".btnNext").click(function(){
		 if(currPage < total_page.replace(",", "")) {
			 currPage++;
			 pageOnclick(currPage);
		 }
	 });
	 
	 function pageOnclick(page){		
			 data = {page:page, wC:wC, category:category, keyword:keyword, pageSize:pageSize};
			 LoadPersons(data);
			 updatePageInfo();
			 Pager(currPage);
	 }
	 
	 $(".btnPrev").click(function(){
		  if(currPage > 1){
			  currPage--;
			pageOnclick(currPage);
		 }
	 });
	 
	 $(".cmbpager").change(function(){
		 currPage = $(this).val();
		 pageOnclick(currPage);
	 });
	 
	 $("#cmbPS").change(function(){
		 currPage = 1;
		 pageSize = $(this).val();
		 pageOnclick(currPage);
	 });
	 
	 function TableSorter(){
		 $("table").tablesorter({
				headers:{
					0:{
						sorter:false
					},
					1:{
						sorter:false
					}
				}
		 });
	 }
	 
	 $(document).on("click", ".btn-edit", function(){
			var id = this.id;
		
			
			$.ajax({
				type:"POST",
				url: BaseURL + "/config/edit",
				data:{id:id},
				async: true,
				beforeSend: function(){
					$(".modal-loader").show();
				},
				success: function(html){
					$(".modal-title").text("Edit");
					$("#myModal").modal("show");
					$(".modal-container").html(html);
					
					if($("#rExhibitor").is(":checked")){
						$("#cbKIT").attr("disabled", true);
						$("#cbVIP").attr("disabled", true);
						
					}
					
					$(".click").webuiPopover("hide");
					
					
					
				},
				complete: function(){
					$(".modal-loader").hide();
				}
			});
	 });
	 
	 $(document).on("click", "#rDelegate", function(e){
			if($(this).is(":checked")){
				 $("#cbKIT").attr("disabled", false);
			  $("#cbVIP").attr("disabled", false);
			}
	 });
	 
	 $(document).on("click", "#rExhibitor", function(e){
			 if($(this).is(":checked")){
			  $("#cbKIT").attr("disabled", true).attr("checked", false);
			  $("#cbVIP").attr("disabled", true).attr("checked", false);
		  }
	 });
	 
	 $(document).on("click", ".btn-update", function(){
		 var id = this.id;
		var SAL = $("#txtSal").val();
		  var FN = $("#txtFN").val();
		  var LN = $("#txtLN").val();
		  var Designation = $("#txtDesignation").val();
		  var Email = $("#txtEmail").val();
		  var BusinessPhone = $("#txtBP").val();
		  var MobileNo = $("#txtMobile").val();
		  var Province = $("#txtProvince").val();
		  var City = $("#txtCity").val();
		  var Company = $("#txtCompany").val();
		  
		  var td = $("#" + this.id.replace("btnU-", "cf-")).closest("td");
		  var row = $(td).parent().parent().children().index(td.parent());
		 var col = $(td).parent().children().index(td);
		 
		 var VIP;
		  var VType;
		  var KIT;
		 
		  if($("#cbVIP").is(":checked")){
			  VIP = "#rDelegate";
		  }else {
			  VIP = null;
		  }
		  
		  if($("#cbKIT").is(":checked")){
			  KIT = true;
		  }else{ 
				KIT = false;
		  }
		  
		  if($("#rDelegate").is(":checked")){
			  VType = $("#rDelegate").val();
		  }
		  
		  if($("#rExhibitor").is(":checked")){
			  VType = $("#rDelegate").val();
		  }
		
		  $.ajax({
				type:"POST",
				url: BaseURL + "/config/update",
				data:{id:id, SAL:SAL, FN:FN, LN:LN, Designation:Designation, Email:Email, BusinessPhone:BusinessPhone,
				MobileNo:MobileNo, Province:Province,City:City, Company:Company, VType:VType, KIT:KIT, VIP:VIP},
				async: true,
				beforeSend: function(){
					$(".modal-loader").show();
				},
				success: function(html){
					switch(parseInt(html)){
						case 0:
							alert("Update Success!");
							$("#myModal").modal("hide");
							$(".alert").empty().append("<strong></strong>");
							$(".alert").find("strong").next().remove();
							$(".alert").find("strong").prev().remove();
							$(".alert").removeClass("hide alert-warning alert-danger").addClass("alert-success").find("strong").text("Success : ").after("<i> Registration Completed!</i>");
							$(".alert").find("strong").before("<span class='glyphicon glyphicon-ok'></span>&nbsp;");
							$("input[type=text], input[type=password]").val("");
							/* $("input[type=text], input[type=password]").parent().removeClass("has-error has-warning has-success");
							$("input[type=text], input[type=password]").next().addClass("hide"); */
							
							 $(".tablesorter tbody tr:nth-child(" + (row + 1) + ") td:nth-child(" + (col + 3) + ")").text(FN);
							 $(".tablesorter tbody tr:nth-child(" + (row + 1) + ") td:nth-child(" + (col + 4) + ")").text(LN);
							 $(".tablesorter tbody tr:nth-child(" + (row + 1) + ") td:nth-child(" + (col + 5) + ")").text(Company);
							// $(".tablesorter tbody tr:nth-child(" + (row + 1) + ") td:nth-child(" + (col + 6) + ")").text(Designation);
		 
							
							break;
						case -4:
							InvalidEmail();
							break;
						case -2:
							checkValidation();
							break;
						default:
							alert(html);
					}
				},
				complete: function(){
					$(".modal-loader").hide();
				}
		  });
		  
	 });
	 
	 function InvalidEmail(){
		 $("#txtEmail").parent().addClass("has-warning");
				$("#txtEmail").next().removeClass("hide").addClass("glyphicon-warning-sign");
				$(".alert").empty().append("<strong></strong>");
				 $(".alert").find("strong").next().remove();
				 $(".alert").find("strong").prev().remove();
				$(".alert").removeClass("hide alert-danger").addClass("alert-warning").find("strong").text("Warning : ").after("<i> Invalid Email!</i>");
				$(".alert").find("strong").before("<span class='glyphicon glyphicon-alert'></span>&nbsp;");
		 $("#txtEmail").focus();
	 }
	 
	 function checkValidation(){
	
		 $("#txtSal, #txtFN, #txtLN, #txtMobile").each(function(val, text){
			 if(!$.trim($(this).val())){
				 $("#" + this.id).parent().addClass("has-error");
				$("#" + this.id).next().removeClass("hide").addClass("glyphicon-exclamation-sign");
			 }
		 });
		 $(".alert").empty().append("<strong></strong>");
		 $(".alert").find("strong").next().remove();
		 $(".alert").find("strong").prev().remove();
		$(".alert").removeClass("hide alert-warning").addClass("alert-danger").find("strong").text("Error : ").after("<i> Fields are Empty!</i>");
		$(".alert").find("strong").before("<span class='glyphicon glyphicon-exclamation-sign'></span>&nbsp;");
		 
	 }
	 
	 $("#txtSal, #txtFN, #txtLN, #txtMobile").keyup(function(){
			if($.trim($("#" + this.id).val())){
				$("#" + this.id).parent().removeClass("has-error has-warning has-success");
				$("#" + this.id).next().addClass("hide").removeClass("glyphicon-exclamation-sign glyphicon-warning-sign glyphicon-ok");
			}else{ 
				
				$("#" + this.id).parent().removeClass("has-warning").addClass("has-error");
				$("#" + this.id).next().removeClass("hide glyphicon-warning-sign").addClass("glyphicon-exclamation-sign");
			}
	 });
	 
	 $("#txtSal, #txtFN, #txtLN, #txtMobile").focusout(function(){
			if($.trim($("#" + this.id).val())){
				$("#" + this.id).parent().addClass("has-success");
				$("#" + this.id).next().removeClass("hide").addClass("glyphicon-ok");
			}
	 });
	 
	 $(document).on("click", ".btn-delete", function(){
			var id = this.id;
			var td = $("#" + this.id.replace("btnD-", "cf-")).closest("td");
			var row = $(td).parent().parent().children().index(td.parent());
		  
		     $(".click").webuiPopover("hide");
		  
			if(confirm("Are you sure you want to delete this record?")){
					$.ajax({
						type:"POST",
						url: BaseURL + "/records/delete",
						data:{id:id},
						async: true,
						beforeSend: function(){
							$(".records").show();
						},
						success: function(html){
							switch(parseInt(html)){
								case 0:
									$(".tablesorter tbody tr:nth-child(" + (row + 1) + ")").fadeOut(500, function(){});
									updatePresent();
									updatePageInfo();
									LoadPages();
									break;
								default:
									alert(html);
							}
						},
						complete: function(){
							$(".records").hide();
						}
					});
			}
	 });
	 
	  $(document).on("click", ".btn-a", function(){
			var id = this.id;
			var tload = id.replace("btnA-", "tload-");
			
			var td = $("#" + this.id.replace("btnA-", "cf-")).closest("td");
			var row = $(td).parent().parent().children().index(td.parent());
			var col = $(td).parent().children().index(td);
			
			$(this).hide();
			
			 $.ajax({
				type:"POST",
				url: BaseURL + "/config/attend",
				data:{id:id},
				async: true,
				beforeSend: function(){
					
					$("#" + tload).removeClass("hide");
				},
				success: function(html){
					LoadAB();
					 $(".tablesorter tr:nth-child(" + (row + 1) + ") td:nth-child(" + (col + 12) + ")").text(html);
					updatePresent();
				},
				complete: function(){
					$("#" + tload).addClass("hide");
				}
			 });
	  });
	  
	  
	  $(document).on("click", ".btn-r", function(){
			var id = this.id;
			var tload = id.replace("btnR-", "tload-");
			
			var td = $("#" + this.id.replace("btnR-", "cf-")).closest("td");
			var row = $(td).parent().parent().children().index(td.parent());
			var col = $(td).parent().children().index(td);
			
			$(this).hide();
			
			$.ajax({
				type:"POST",
				url: BaseURL + "/config/reset",
				data:{id:id},
				async: true,
				beforeSend: function(){
					
					$("#" + tload).removeClass("hide");
				},
				success: function(html){
					LoadAB();
					 $(".tablesorter tr:nth-child(" + (row + 1) + ") td:nth-child(" + (col + 12) + ")").text("");
					updatePresent();
				},
				complete: function(){
					$("#" + tload).addClass("hide");
				}
			});
	  });
	 
	 function LoadAB(){
		 $(".ab-container").each(function(){
				var id = this.id;
				 $.ajax({
						type:"POST",
						url: BaseURL + "/config/updatebutton",
						data:{id:id},
						async: true,
						beforeSend: function(){
						//	$(".tloadersposition").removeClass("hide");
						},
						success: function(html){
							$("#" + id).html(html);
						},
						complete: function(){
							//$(".tloadersposition").addClass("hide");
						},
						
				 });
		 });
	 }
	 
	 function updatePresent(){
		
		 $.ajax({
				type:"POST",
				url: BaseURL + "/records/totalpresent",
				data:{category:category, keyword:keyword, wC:wC},
				async: true,
				success: function(html){
					$(".ptext").text(html);
				}
		 });
	 }
	 
	 $(document).on("click", ".btn-view", function(){
			var id = this.id;
			$.ajax({
				type:"POST",
				url: BaseURL + "/config/view",
				data:{id:id},
				async: true,
				beforeSend: function(){
					$(".modal-loader").show();
				},
				success: function(html){
					$(".modal-title").text("View Information");
					$("#myModal").modal("show");
					$(".modal-container").html(html);
					$(".click").webuiPopover("hide");
				},
				complete: function(){
					$(".modal-loader").hide();
				}
			});
	 });
	 
	 
});