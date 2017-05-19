$(function(){
	console.log("Js marche");
	var id_landing_page = 1;

	var request = $.ajax({ 	
		url: baseUrl+"gamefunction/",
		method: "POST",
		data : {id_page : 1}
	});	

	request.done(function( msg ) { 
		msg = JSON.parse(msg);
		console.log(msg);
		console.log("request done");
		$("#story").html(msg.page["story"]);
	});
 
	request.fail(function( jqXHR, textStatus ) {
	  alert( "Request failed: " + textStatus );
	});
});