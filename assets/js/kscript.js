$(function(){
		$(".kit").hide();
		
		 $("#btnCheck").click(function(){
				check();
		 });
		 
		 function check(){

					 var code = $("#txtBarcode").val();
						$.ajax({
							type:"POST",
							url: BaseURL + "/kits/verifykit",
							async: true,
							data:{code:code},
							beforeSend: function(){
								$(".kit").show();
							},
							success: function(html){
								$(".result").html(html);
								$("#txtBarcode").val("");
								$("#txtBarcode").focus();
								displayTotalKits();
							},
							complete: function(){
								$(".kit").hide();
							}
						});
		 }
		 
		 
		var typingTimer;
		var doneTypingInterval = 700;
			 
		$("#txtBarcode").keyup(function(e){
				clearTimeout(typingTimer);
				typingTimer = setTimeout(check, doneTypingInterval);
				/* if(e.keyCode == 13){
					check();
				} */
		});
		
		$("#txtBarcode").keydown(function(){
			 clearTimeout(typingTimer);
		});
	
	
	$("#txtBarcode").on("input", function(){
		// setTimeout(check, 2000);
	});
	
	$(document).on("click", ".btnDelete", function(){
		if(confirm("Are you sure you want to delete this record?")){
			var tid = this.id;
			 $.ajax({
				type:"POST",
				url: BaseURL + "/kits/delete",
				data:{tid:tid},
				async: true,
				beforeSend: function(){
					$(".kit").show();
				},
				success: function(html){
					switch(parseInt(html)){
						case 0:
							$(".result").empty();
							$("#txtBarcode").focus();
							break;
						default:
							alert(html);
					}
				},
				complete: function(){
					$(".kit").hide();
				}
			 });
		}
	});
	
	displayTotalKits();
	
	function displayTotalKits(){
		$(".k-count").text(countClaims());
	}
	
	function countClaims(){
		var s = $.ajax({
					type:"POST",
					url:BaseURL + "/kits/totalkits",
					async: false
				}).responseText;
		return s;
	}
	
	$("#btnCount").click(function(){
		displayTotalKits();
	});
		 
});