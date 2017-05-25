$(function(){
	
	var login = $.ajax({ 	
		url: baseUrl+"login/",
		method: "POST",
	});	

	login.done(function( msg ) {
		$(".contenu_popup_connexion").html(msg);
		$("div.contenu_popup_connexion > form").on("submit", function(e){
			e.preventDefault();
			var loginData = $.ajax({ 	
				url: $(this).attr('action'),
				method: $(this).attr('method'),
				data: $(this).serialize()
			});

			loginData.done(function(reg){
				$(".contenu_popup_connexion").html(reg);
			});
			loginData.fail(function( jqXHR, textStatus ) {
	  			alert( "Request failed: " + textStatus );
	  		});			
		});
	});

	login.fail(function( jqXHR, textStatus ) {
	  alert( "Request failed: " + textStatus );
	});

// ---------------------------

	var register = $.ajax({ 	
		url: baseUrl+"register/",
		method: "POST",
	});	

	register.done(function( msg ) {
		$(".contenu_popup_inscription").html(msg);
		$("div.contenu_popup_inscription > form").on("submit", function(e){
			e.preventDefault();
			if (msg = "ça marche !!"){
				window.location.href=baseUrl+'profil';
			}
			else{
				$(".contenu_popup_inscription").html(msg);
			}			
		});
	});

	register.fail(function( jqXHR, textStatus ) {
	  alert( "Request failed: " + textStatus );
	});
});
 