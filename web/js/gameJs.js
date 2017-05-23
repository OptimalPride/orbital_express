$(function(){
	console.log("js marche");
	var request = $.ajax({
		url: baseUrl+"gamefunction/",
		method: "POST",
		data : {id_page : 1}
	});

	request.done(function( msg ) {
		msg = JSON.parse(msg);
		console.log(msg);
		console.log("request done");
		$("#story").html(msg.page.story);
		var choices = msg.choices;
		var ul = $('<ul>');

		choices.forEach(function(choice){
			ul.append('<li>'+choice.response+'</li>');
		});

		$('#choices').html(ul);
	});

	request.fail(function( jqXHR, textStatus ) {
	  alert( "Request failed: " + textStatus );
	});
});
