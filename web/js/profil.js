$(function(){
	$("a.nouvelle-aventure").click(function(e){
		var getAdventures = $.ajax({
			url: baseUrl+"getavailableadventures/",
			method: "POST",
		});
		getAdventures.done(function(msg) {
			$("div.contenu_nouvelle_aventure").html(msg);
		});
	});

	$("a.continuer-aventure").click(function(e){
		$("div.contenu_nouvelle_aventure").empty();
		var continueAdventure = $.ajax({
			url: baseUrl+"continue/",
			method: "POST",
		});
		continueAdventure.done(function(msg) {
			$("div.contenu_continuer_aventure").html(msg);
		});
	});

	$("a.sauvegardes").click(function(e){
		$("div.contenu_nouvelle_aventure").empty();
		var gestionSauvegardes = $.ajax({
			url: baseUrl+"gestionusersaves/",
			method: "POST",
		});
		gestionSauvegardes.done(function(msg) {
			console.log(msg);
			$("div.contenu_sauvegardes").html(msg);
		});
	});
});
