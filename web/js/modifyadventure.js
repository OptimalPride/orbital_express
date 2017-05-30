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
				method: "POST",
				data: $(this).serialize()
			});
			advFormData.done(function(reg){
				$("#form_msg").html(reg);
			});
		});
	});
// -----------------------------

	var listpages = $.ajax({
		url: baseUrl+"listepage/"+id_adventure,
		method: "POST",
	});

	listpages.done(function(msg){
		$("#adventure_pages").html(msg);

		$(".pageedit").click(function(e){
			e.preventDefault();
			var id_page = $(this).attr("id");
			var pageform = $.ajax({
				url: baseUrl+"modifypage/"+id_adventure+"/"+id_page,
				method: "POST"
			});

			pageform.done(function(reg){
				$("#page_edit_form").html(reg);

				$("form#page_modif").on("submit", function(f){
					f.preventDefault();
					var pagemodifdata = $.ajax({ 	
						url: baseUrl+"modifypageformprocessing/"+id_page,
						method: "POST",
						data: $(this).serialize()
					});
					pagemodifdata.done(function(meg){
						console.log(meg);
						$("#form_message").text(meg);
					});

				});
			});		
		})
	});
// -----------------------------

});