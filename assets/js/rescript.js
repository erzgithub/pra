$(function(){
    $(".kit").hide();
        
         $("#btnCheck").click(function(){
                check();
         });

         function check(){
       
                     var code = $("#txtBarcode").val();
                        $.ajax({
                            type:"POST",
                            url: BaseURL + "/raffleentries/save",
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

        displayTotalKits();
    
        function displayTotalKits(){
            $(".k-count").text(countClaims());
        }
        
        function countClaims(){
            var s = $.ajax({
                        type:"POST",
                        url:BaseURL + "/raffleentries/totalentry",
                        async: false
                    }).responseText;
            return s;
        }
        
        $("#btnCount").click(function(){
            displayTotalKits();
        });
});