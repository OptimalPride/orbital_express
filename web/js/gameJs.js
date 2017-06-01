$(function(){
	console.log("WTF 3");
	function gameFunction(id_landing_page, id_current_page){
		$("#story, .div-block-11").fadeTo("slow", 0);
		var request = $.ajax({ 	
			url: baseUrl+"gamefunction/",
			method: "POST",
			data : {id_landing_page : id_landing_page,
			 id_current_page : id_current_page}
		});	

		request.done(function( msg ) {
			msg = JSON.parse(msg);
			if(msg.cheat == "true"){
				window.location.href=baseUrl+'cheat/';
			}
			else{
				if(msg.ending != ""){
					if(msg.ending == "success"){						
						window.location.href=baseUrl+'successdisplay/'+msg.page.id_page;
					}
					if(msg.ending == "fail"){
						window.location.href=baseUrl+'faildisplay/'+msg.page.id_page;
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
					$("#crew_img_1").attr("src", baseAsset+choice1.crew+".jpg");	
					$("#crew_img_2").attr("src", baseAsset+choice2.crew+".jpg");	
					$("#crew_img_3").attr("src", baseAsset+choice3.crew+".jpg");
					$("#story, .div-block-11").fadeTo("slow", 1);	
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
