$(function(){
	
	 var startNum;
	 var id;
	 
	 $("#cmbSec").prop("selectedIndex", 1);
	 
	 function anim(n){ 
		 startNum = n;
		 
			if(n == 0){
				$("#countdown").fadeIn("fast", function(){
						$(this).html(n);
				});
				if(!($(".rn-names").text() == "")){
					$(".title").text("Winner!").blink({delay:500});
					$(".n-container").addClass("addconfetti");
					$(".rc, .lc").removeClass("hide");
				}
			}else{ 
				$(".title").text("").unblink();
					 $("#countdown").fadeIn("fast", function(){
							if($(this).html() == ""){
								$(this).html(n);
								//
							} 
						
								$("#countdown").delay(400).hide("puff", 400, function(){
									 if(n == 0) n = 0; else n--;
									/*$(this).html(n);
									anim(n); */ 
									$(this).html(n);
								
									if(!(n == 0)){
										
									}
									anim(n);
								});	
					 });	
					$(".n-container").removeClass("addconfetti");
					$(".rc, .lc").addClass("hide");
			}
	 }
 
  $("#btnStart").click(function(){
		$("#countdown").text("");
		var count = $("#cmbSec").val();
		anim(count);
		RandomStart();
		$(".control").hide();
  });
  
  function RandomStart(){
	  
	  var intervals = setInterval(function(){
		  
		  if(startNum == 0){
			  clearInterval(intervals);   
			  upd();
		  }
		  
			$.ajax({
					type:"POST",
					url: BaseURL + "/raffle/picker",
					async: true,
					success: function(html){
						$(".rn-names").html(html);
						
					}
			});
	  }, 65);
  }
  
  function upd(){
	  var ins = setInterval(function(){
			clearInterval(ins);
	  var di = $(".picker").attr("id");
	
		updatePicked(di);
			//alert($(".picker").attr("id"));
		$(".control").fadeIn(500, function(){
				
		});
	  }, 1800);
  }
  
  function updatePicked(di){
	  $.ajax({
		  type:"POST",
		  url: BaseURL + "/raffle/updatepicked",
		  data:{di:di},
		  async: true,
		  success: function(html){
			  
		  }
	  });
  }
  
  $("#btnReset").click(function(){
		 $.ajax({
			 type:"POST",
			 url: BaseURL + "/raffle/reset",
			 async: true,
			 beforeSend: function(){
				 
			 },
			 success: function(html){
				 switch(parseInt(html)){
					 case 0:
						alert("Reset Successfull");
						$(".n-container").removeClass("addconfetti");
						$(".rc, .lc").addClass("hide");
						break;
					 default:
						alert(html);
				 }
				 $("#countdown, .rn-names, .title").text("");
			 },
			 complete: function(){
				 
			 }
		 })
  });
 
});

(function($) {
	var t;
    $.fn.blink = function(options) {
        var defaults = {
            delay: 500
        };
        var options = $.extend(defaults, options);

        return this.each(function() {
            var obj = $(this);
           t = setInterval(function() {
               /**/ if ($(obj).css("visibility") == "visible") {
                    $(obj).css('visibility', 'hidden');
                }
                else {
                    $(obj).css('visibility', 'visible');
                }
            }, options.delay);
        });
    }
	
	$.fn.unblink = function() 
        {
            clearInterval(t);
			var obj = $(this);
			obj.css("visibility", "visible");
        }
}(jQuery)) 