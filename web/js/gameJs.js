$(function(){
	console.log("Js marche");
	var id_landing_page = 1;

	function gameFunction(page){
		var request = $.ajax({ 	
			url: baseUrl+"gamefunction/",
			method: "POST",
			data : {id_page : page}
		});	

		request.done(function( msg ) {
			msg = JSON.parse(msg);
			console.log(msg);
			console.log("request done");

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
		});

		request.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});		
	}

	var page = 1;
	gameFunction(page);

	$("div.linkchoice").click(function(e) {

		page = $(this).attr('data_id');
		console.log(page);
		gameFunction(page);
		
	});
	

});
 