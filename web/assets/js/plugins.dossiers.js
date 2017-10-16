$('#input-search').keyup(function(e){
	var val = $(this).val(),
		lien = $('#form-search').attr('action');
		lien += '&s='+val;

	$('#folders').load(lien, function(){
		//alert("Page");
	});
});