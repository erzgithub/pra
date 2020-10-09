$(function(){
	 var Rooms = $.ajax({
					type:"POST",
					url: BaseURL + "/rooms/loadrooms",
					async: false
				}).responseText;
	
	var Rms = [];
	var aCode;
	
	$(".rooms").hide();
	
	if(Rooms){
		var rms = JSON.parse(Rooms.split(","));
		for(var i = 0; i < rms.length; i++){
			 Rms.push(rms[i]);
		}
	}
	
	LoadSessionRooms();
	
	function LoadSessionRooms(){
		$.each(Rms, function(val, text){
			$("#cmbSessionRooms").append(new Option(text));
		});
	}
	
	var typingTimer;
	var doneTypingInterval = 700;
	
	$("#txtBarcode").keyup(function(e){
		clearTimeout(typingTimer);
		typingTimer = setTimeout(check, doneTypingInterval);
	});
	
	$("#txtBarcode").keydown(function(){
		clearTimeout(typingTimer);
	});
	
	Count();
	
	function Count(){
		var room = $("#cmbSessionRooms").val();
		var s = $.ajax({
						type:"POST",
						url: BaseURL + "/rooms/countattendance",
						async: false,
						data:{room:room}
				}).responseText;
		$(".c-claim").text("Total Attendees: " + s);
	}
	
	function check(){
		var code = $("#txtBarcode").val();
		var room = $("#cmbSessionRooms").val();
		$.ajax({
			type:"POST",
			url: BaseURL + "/rooms/checkbcode",
			data:{code:code, room:room},
			async: true,
			beforeSend: function(){
				$(".rooms").show();
			},
			success: function(html){
				
				switch(parseInt(html)){
					case 1:
						$(".result").empty().append("<h1><span>Successfully Attended</span></h1>");
						$(".result").hide().fadeIn(500);
						$("#txtBarcode").val("");
						$("#txtBarcode").focus();
						break;
					case 2:
						$(".result").empty().append("<h1><span>Successfully Out</span></h1>");
						$(".result").hide().fadeIn(500);
						$("#txtBarcode").val("");
						$("#txtBarcode").focus();
						break;
					case 4:
						$(".result").html(absentForm(code));
						aCode = code;
						break;
					default:
						alert(html);
				}
				Count();
				/* $(".result").empty().html(html);
				$("#txtBarcode").val("");
				$("#txtBarcode").focus(); */
				
			},
			complete: function(){
				$(".rooms").hide();
			}
		});
	}
	
	$(document).on("click", "#btnSave", function(){
		 
			var FN = $("#txtFN").val();
			var LN = $("#txtLN").val();
			var Chapter = $("#txtChapter").val();
			var code = aCode;
			var room = $("#cmbSessionRooms").val();
			
			$.ajax({
				type:"POST",
				url: BaseURL + "/rooms/saveabsent",
				data:{FN:FN, LN:LN, Chapter:Chapter, code:code, room:room},
				async: true,
				beforeSend: function(){
					
				},
				success: function(html){
					 
					switch(parseInt(html)){
						case 0:
							$(".result").empty().append("<h1><span>Successfully Attended</span></h1>");
							$(".result").hide().fadeIn(500);
							$("#txtBarcode").val("");
							$("#txtBarcode").focus();
							break;
						case -2:
							break;
						default:
							alert(html);
					}
					Count();
				},
				complete: function(){
					
				}
			});
			 
	});
	
	function absentForm(c){
		var s = $.ajax({
					type:"POST",
					url: BaseURL + "/rooms/absentform",
					data:{c:c},
					async: false
		}).responseText;
		return s;
	}
	
});