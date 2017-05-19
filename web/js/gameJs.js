$(function(){
	console.log("test");
	var request = $.ajax({ 	
		url: baseUrl+"testing/",
		method: "POST",
		data : {id_page : 6}
	});	

	request.done(function( msg ) { 
		msg = JSON.parse(msg);
		console.log(msg);
		console.log("test");
	});
 
	request.fail(function( jqXHR, textStatus ) {
	  alert( "Request failed: " + textStatus );
	});
});