$(function(){

	var loginInit = $.ajax({ 	
		url: baseUrl+"login/",
		method: "POST",
	});
	loginInit.done(function( msg ) {
		msg = JSON.parse(msg);
		$(".contenu_popup_connexion").html(msg['display']);
	});

	$("a.bouton_connexion").click(function(e){
		var login = $.ajax({ 	
			url: baseUrl+"login/",
			method: "POST",
		});	

		login.done(function( msg ) {
			msg = JSON.parse(msg);
			$(".contenu_popup_connexion").html(msg['display']);
			$("div.contenu_popup_connexion > form").on("submit", function(e){
				e.preventDefault();
				var loginData = $.ajax({ 	
					url: $(this).attr('action'),
					method: $(this).attr('method'),
					data: $(this).serialize()
				});

				loginData.done(function(reg){
					reg = JSON.parse(reg);
					console.log(reg);
					if(reg["redirect"] == "true"){
						window.location.href=baseUrl+'profil';
					}
					else{
						$("#error_connexion").html("Erreur de saisie");
					}
				});
				loginData.fail(function( jqXHR, textStatus ) {
		  			alert( "Request failed: " + textStatus );
		  		});			
			});
		});

		login.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});		
	});


// ---------------------------

	var registerInit = $.ajax({ 	
		url: baseUrl+"register/",
		method: "POST",
	});	
	registerInit.done(function( msg ) {
		$(".contenu_popup_inscription").html(msg);
	});

	$("a.bouton_inscription").click(function(e){
		var register = $.ajax({ 	
			url: baseUrl+"register/",
			method: "POST",
		});	

		register.done(function( msg ) {
			$(".contenu_popup_inscription").html(msg);
			$("div.contenu_popup_inscription > form").on("submit", function(e){
				e.preventDefault();
				var registerData = $.ajax({ 	
					url: $(this).attr('action'),
					method: $(this).attr('method'),
					data: $(this).serialize()
				});

				registerData.done(function(reg){
					console.log(reg);
					var test = "ça marche !!";
					if (reg == test){
						$(".contenu_popup_inscription").empty();
						$("img.image_close_popup_inscription").click();
						$("a.bouton_connexion").click();
						// window.location.href=baseUrl+'profil';
					}
					else{
						$("#error_inscription").html(reg);
					}
				});
				registerData.fail(function( jqXHR, textStatus ) {
		  			alert( "Request failed: " + textStatus );
		  		});	
				
			});
		});

		register.fail(function( jqXHR, textStatus ) {
		  alert( "Request failed: " + textStatus );
		});

	});
});
 