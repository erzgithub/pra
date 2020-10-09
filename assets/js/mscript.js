$(function(){
	 $(".ms").hide();
	 
	 var typingTimer;
		var doneTypingInterval = 700;
	 
	 $("#btnCheck").click(function(){
			check();
	 });
	 
	 
	 
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
	 
	 function check(){
		 var barcode = $("#txtBarcode").val();
		 var mealtype = $("#cmbMeal").val();
		 
		 $.ajax({
			type:"POST",
			url: BaseURL + "/foodstab/check",
			async: true,
			data:{barcode:barcode, mealtype:mealtype},
			beforeSend: function(){
				$(".ms").show();
			},
			success: function(html) {
				$(".result").html(html);
				$("#txtBarcode").val("");
				$("#txtBarcode").focus();
				viewClaims();
			},
			complete: function(){
				$(".ms").hide();
			}
		 });
	 
	 }
	 
	 function viewClaims(){
		 $(".c-claim").text($("#cmbMeal").val() + " Claimed : " + countClaims());
	 }
	 
	 var Meals = $.ajax({
			type:"POST",
			url: BaseURL + "/foodstab/loadmealtypes",
			async: false,
	}).responseText;
	
	var Mls = [];
	
	
	
	 if(Meals){
			  var mls = JSON.parse(Meals.split(","));
			for(var i = 0; i < mls.length; i++){
				Mls.push(mls[i]);
			}  
	  }
	  
	  $(document).on("click", ".btnDelete",function(){
			var tid = this.id;
			if(confirm("Are you sure you want to delete this record?")){
				$.ajax({
					type:"POST",
					url: BaseURL + "/foodstab/delete",
					async: true,
					data: {tid:tid},
					beforeSend: function(){
						$(".ms").show();
					},
					success: function(html){
						switch(parseInt(html)){
							case 0:
								$(".result").empty();
								$("#txtBarcode").focus();
								viewClaims();
								break;
							default:
								alert(html);
						}
					},
					complete: function(){
						$(".ms").hide();
					}
				});
			}
	  });
	  
	  LoadMealTypes();
	  
	  viewClaims();
	  
	function LoadMealTypes(){
		$.each(Mls, function(val, text){
			$("#cmbMeal").append(new Option(text));
		});
	 
	}
	
	function countClaims(){
		
		var mealtype = $("#cmbMeal").val();
		
		var s =	$.ajax({
					type:"POST",
					url: BaseURL + "/foodstab/countclaims",
					async: false,
					data: {mealtype:mealtype}
				}).responseText;
		return s;
	}
	 
});