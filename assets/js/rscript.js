$(function(){
 
	$(".save").hide();
	
	 $(".btn-Save").click(function(){
	 	 $('#txtId').val('');
		 Save(0);
	 });

	 $('.btn-Continue').on('click', function() {
	 	var con = confirm('Are you sure to Continue');

	 	if (con) {
	 		var id = $('#txtId').val();
	 		if (id == '') {
	 			return Save(9999999);
	 		}
	 		return Save(id);
	 	}
	 });

	 $('#select__type').on('change', function() {
	 	var value = $(this).val();

	 	$('.select__radio').each( function(index) {
	 		if($(this).val() == value) {
	 			$(this).attr('checked', true);
	 		}
	 	});
	 });
	 
	 $("input[type=text]").keyup(function(e){
			if(e.keyCode == 13){
				Save(0);
			}
	 });
	 
	 function Save(id){
			var SAL = $("#txtSal").val();
			var FN = $("#txtFN").val();
			var LN = $("#txtLN").val();
			var Designation = $("#txtDesignation").val();
			var Email = $("#txtEmail").val();
			var Address = $("#txtAddress").val();
			var Telephonefax = $("#txtTelephonefax").val();
			var Mobile = $("#txtMobile").val();
			var Email = $("#txtEmail").val();

			var BusinessPhone = $("#txtBP").val();
			var MobileNo = $("#txtMobile").val();
			var Province = $("#txtProvince").val();
			var City = $("#txtCity").val();
			var Company = $("#txtCompany").val();
			var Present = false;
			var PRC = $("#txtPRC").val();
			var OR = $("#txtOR").val();
			var VIP;
			var VType;
			var KIT;

			var genId = $('#txtGenId').val();

		  if($("#cbPresent").is(":checked")){
			  Present = true;
		  }else{ 
			Present = false;
		  }
		  
		  if($("#cbVIP").is(":checked")){
			  VIP = "VIP";
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
			  VType = $("#rExhibitor").val();
		  }
		  
			if($("#rSponsor").is(":checked")){
			  VType = $("#rSponsor").val();
		  }
		  
		  if($("#rCon").is(":checked")){
			  VType = $("#rCon").val();
		  }
		  
		   if($("#rsVIP").is(":checked")){
			  VType = $("#rsVIP").val();
		  }

		  var remarks = $('#select__type').val();

		  $.ajax({

			  type:"POST",
			  url: BaseURL + "/registration/save",
			  data: {
			  	SAL:SAL, FN:FN, LN:LN, Designation:Designation, Email:Email, BusinessPhone:BusinessPhone,
				  MobileNo:MobileNo, Province:Province,City:City,
				  Address:Address, Telephonefax:Telephonefax, Mobile:Mobile,
				  Company:Company, Present:Present, PRC:PRC, OR:OR,
				  VIP:VIP, VType:VType, KIT:KIT, id : id, genId:genId, remarks: remarks
			},
			  async: true,
			  beforeSend: function(){
				  $(".save").show();
			  },
			  success: function(html){
			  	 
					html = JSON.parse(html);

				   switch(parseInt(html.status)){
				// switch(parseInt(html)){
					  case 0:
							$(".alert").empty().append("<strong></strong>");
							$(".alert").find("strong").next().remove();
							$(".alert").find("strong").prev().remove();
							$(".alert").removeClass("hide alert-warning alert-danger").addClass("alert-success").find("strong").text("Success : ").after("<i> Registration Complete!</i>");
							$(".alert").find("strong").before("<span class='glyphicon glyphicon-ok'></span>&nbsp;");
							$("input[type=text], input[type=password]").val("");
							$("input[type=text], input[type=password]").parent().removeClass("has-error has-warning has-success");
							$("input[type=text], input[type=password]").next().addClass("hide");
							$("#txtFN").focus();

							if(id == false || id == 9999999){
								$().redirect(BaseURL + "/records/printid", {
									SAL:SAL, FN:FN, LN:LN,
									Company:Company, Designation:Designation,
									VType:VType, VIP:VIP
								});
							}
							break;
					  case -4:
							InvalidWarning();
							break;
					  case -2:
							checkValidation();
							break;
					  case -8:
					  		InvalidMessage('Last Name already Exists', html.data);
					  		break;
					  case -9:
					  		InvalidMessage('First Name already Exists', html.data);
					  		break;
					  case -10:
					  		InvalidMessage("Company Already Exists", html.data);
					  		break;
					  default:
							alert(html);
				  }
			  },
			  complete: function(){
				  $(".save").hide();
			  }
		  });
	 }
	 
	 function InvalidWarning(content){
	 	if (typeof content == 'undefined') {
	 		cotent = 'Invalid Email!';
	 	};
		 $("#txtEmail").parent().addClass("has-warning");
				$("#txtEmail").next().removeClass("hide").addClass("glyphicon-warning-sign");
				$(".alert").empty().append("<strong></strong>");
				 $(".alert").find("strong").next().remove();
				 $(".alert").find("strong").prev().remove();
				$(".alert").removeClass("hide alert-danger").addClass("alert-warning").find("strong").text("Warning : ").after("<i> "+ content +"</i>");
				$(".alert").find("strong").before("<span class='glyphicon glyphicon-alert'></span>&nbsp;");
		 $("#txtEmail").focus();
	 }

	 function InvalidMessage(message, data)
	 {
	 	var div = $('#Invalid__Message');
	 	var tableDiv = $('#Invalid__Table');
	 	var tableContainer = $('#Invalid__Table--Container');
	 	var btnContinue = $('.btn-Continue');
	 	newMessage = '<strong>' + message + '</strong>';
	 	tableHtml = '';
	 	tableDiv.html('');
	 	for (var i = data.length - 1; i >= 0; i--) {
	 		addTable(data[i]);
	 	}

	 	div.html( newMessage );
	 	div.removeClass('hide');
	 	tableContainer.removeClass('hide');
	 	btnContinue.removeClass('hide');

	 	setTimeout( function() {
	 		tableContainer.addClass('hide');
	 		div.addClass('hide');
	 		btnContinue.addClass('hide');
	 		$('#txtId').val('');
	 		$('#txtGenId').val('');
	 	}, 40000);
	 }
	 
	 $("#rExhibitor").click(function(){
		  if($(this).is(":checked")){
			 $("#cbKIT").attr("disabled", false);//.attr("checked", false);
			  $("#cbVIP").attr("disabled", false);//.attr("checked", false);
		  }
	 });
	 
	 $("#rDelegate").click(function(){
		  if($(this).is(":checked")){
			   $("#cbKIT").attr("disabled", false);
			  $("#cbVIP").attr("disabled", false);
		  }
	 });
	 
	 function addTable(data)
	 {
	 	var tableDiv = $('#Invalid__Table');
	 	var remarks = typeof data.Remarks == 'null' ? '' : data.Remarks;

	 	tableHtml = '<table class="table table-striped table-bordered">';
	 	tableHtml += "<tr>";
	 	tableHtml += '<td> Last Name: ' + data.LastName + '</td>';
	 	tableHtml += '<td> First Name: ' + data.FirstName + '</td>';
	 	tableHtml += "</tr>";
	 	tableHtml += "<tr>";
	 	tableHtml += '<td> Email: ' + data.Email + '</td>';
	 	tableHtml += '<td> Company: ' + data.CompanyName + '</td>';
	 	tableHtml += "</tr>";
	 	tableHtml += '<td> Designation: ' + data.Designation + '</td>';
	 	tableHtml += '<td> Address: ' + data.Address + '</td>';
	 	tableHtml += "</tr>";
	 	tableHtml += '<td> Telephonefax: ' + data.Telephonefax + '</td>';
	 	tableHtml += '<td> Mobile: ' + data.Mobile + '</td>';
	 	tableHtml += "</tr>";
	 	tableHtml += "<tr>";
	 	tableHtml += '<td colspan="2" class="text-center"> <strong> <i>' + remarks + '</i> </strong></td>';
	 	tableHtml += "</tr>";
	 	tableHtml += "<tr>";
	 	tableHtml += '<td colspan="2"> <button type="button" class="btn btn-default btn-block btn-info" id="btnGetDetails__'+data.ID+'" data-id="'+ data.ID +'">Get Details</button></td>';
	 	tableHtml += "</tr>";

	 	tableHtml += "</table>";
	 	tableDiv.append(tableHtml);

	 	$('#btnGetDetails__' + data.ID).on('click', function() {
	 		$('#txtFN').val(data.FirstName);
	 		$('#txtLN').val(data.LastName);
	 		$('#txtCompany').val(data.CompanyName);
	 		$('#txtDesignation').val(data.Designation);
	 		$('#txtAddress').val(data.Address);
	 		$('#txtTelephonefax').val(data.Telephonefax);
	 		$('#txtMobile').val(data.Mobile);
	 		$('#txtEmail').val(data.Email);
	 		$('#txtId').val(data.ID);
	 		$('#txtGenId').val(data.BarcodeID);
	 	});
	 }

	function checkValidation(){
	
		 $("input[type=text], input[type=password]").each(function(val, text){
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
	 
	 $("input[type=text], input[type=password]").keyup(function(){
			if($.trim($("#" + this.id).val())){
				$("#" + this.id).parent().removeClass("has-error has-warning has-success");
				$("#" + this.id).next().addClass("hide").removeClass("glyphicon-exclamation-sign glyphicon-warning-sign glyphicon-ok");
			}else{ 
				
				$("#" + this.id).parent().removeClass("has-warning").addClass("has-error");
				$("#" + this.id).next().removeClass("hide glyphicon-warning-sign").addClass("glyphicon-exclamation-sign");
			}
	 });
	 
	 $("input[type=text], input[type=password]").focusout(function(){
			if($.trim($("#" + this.id).val())){
				$("#" + this.id).parent().addClass("has-success");
				$("#" + this.id).next().removeClass("hide").addClass("glyphicon-ok");
			}
	 });

});