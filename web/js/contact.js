$(function(){
	$("#email-form").on("submit", function(e){
		e.preventDefault();
		var contactsend = $.ajax({ 	
			url: baseUrl+"mailsending/",
			method: "POST",
			data: $(this).serialize()
		});
		contactsend.done(function(msg){
			$("#message_mail").html(msg);
		});

	});
});
