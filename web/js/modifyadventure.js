$(function(){

	$("#adventure_edit").on("submit", function(e){
		e.preventDefault();
		var modifadv = $.ajax({
			url: baseUrl+"modifyadventureformprocessing/"+id_adventure+"/",
			method: "POST",
			data: $(this).serialize()
		});

		modifadv.done(function(reg){
			alert(reg);
		});
		modifadv.fail(function( jqXHR, textStatus ) {
  			alert( "Request failed: " + textStatus );
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
						url: baseUrl+"modifypageformprocessing/"+id_adventure+"/"+id_page,
						method: "POST",
						data: $(this).serialize()
					});
					pagemodifdata.done(function(meg){
						alert(meg);
					});

				});
			});		
		})
	});
// -----------------------------

});