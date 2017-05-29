$(function(){

	var advform = $.ajax({ 	
			url: baseUrl+"adventureeditform/"+id_adventure,
			method: "POST",
	});

	advform.done(function( msg ) {
		$("#adventure_edit_form").html(msg);
		$("#adventure_edit_form > form").on("submit", function(e){
			e.preventDefault();
			var advFormData = $.ajax({ 	
				url: baseUrl+"adventureeditform/"+id_adventure,
				method: $(this).attr('method'),
				data: $(this).serialize()
			});
			advFormData.done(function(reg){
				$("#form_msg").html(reg);
			});
		});
	});

	var listpages = $.ajax({
		url: baseUrl+"listepage/"+id_adventure,
		method: "POST",
	});

	listpages.done(function(msg){
		$("#adventure_pages").html(msg);
	});

});