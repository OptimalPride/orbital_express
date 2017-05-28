$(function(){
	$("a.nouvelle-aventure").click(function(e){
		var getAdventures = $.ajax({ 	
			url: baseUrl+"getavailableadventures/",
			method: "POST",
		}); 
		getAdventures.done(function( msg ) {
			console.log(msg);
			$("div.contenu_nouvelle_aventure").html(msg);
		});	
	})
})