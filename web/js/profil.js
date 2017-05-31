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
			$("div.contenu_sauvegardes").html(msg);
<<<<<<< HEAD
			$(".delete_save_button").click(function(a){
				a.preventDefault();
				var deletesave = $.ajax({ 	
					url: $(this).attr("href"),
					method: "POST",
				}); 
				deletesave.done(function(b){
					$("a.sauvegardes").click();
				})
			});
		});	
	})
})
=======
		});
	});
});
>>>>>>> 6d45ee632ac93e019e9e5e9b7cbe9a7b3b6c68b9
