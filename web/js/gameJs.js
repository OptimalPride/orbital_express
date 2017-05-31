$(function(){
	console.log("WTF 2");
	function gameFunction(id_landing_page, id_current_page){
		var request = $.ajax({ 	
			url: baseUrl+"gamefunction/",
			method: "POST",
			data : {id_landing_page : id_landing_page,
			 id_current_page : id_current_page}
		});	

		request.done(function( msg ) {
			msg = JSON.parse(msg);
			if(msg.cheat == "true"){
				$("#story").html(msg.message);
			}
			else{
				if(msg.ending != ""){
					if(msg.ending == "success"){						
						var win = $.ajax({ 	
							url: baseUrl+"successdisplay/",
							method: "POST"
						});	

						win.done(function( reg ) {
							console.log(reg);
							$("main").load(reg);
							$(".text_victoire").html(msg.page.story);							
						});
					}
					if(msg.ending == "fail"){
						var fail = $.ajax({ 	
							url: baseUrl+"successdisplay/",
							method: "POST"
						});	

						fail.done(function( reg ) {
							$("main").html(msg);
							$(".text_fail").html(msg.page.story);							
						});	
					}
				}
				else{
					$("#story").html(msg.page.story);
					var choice1 = msg.choices[0];
					var choice2 = msg.choices[1];
					var choice3 = msg.choices[2];
					$("#response1").html(choice1.response);
					$("#response2").html(choice2.response);
					$("#response3").html(choice3.response);
					$( "#link1" ).attr( "data_id", choice1.id_landing_page );
					$( "#link2" ).attr( "data_id", choice2.id_landing_page );
					$( "#link3" ).attr( "data_id", choice3.id_landing_page );	
				}
			}
		});

		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});		
	}

	var id_landing_page = id_current_page;
	gameFunction(id_landing_page, id_current_page);

	$("div.linkchoice").click(function(e) {
		id_current_page = id_landing_page;
		id_landing_page = $(this).attr('data_id');
		gameFunction(id_landing_page, id_current_page);
	});
	

});
 