$('#carousel-file').carousel();
$('.file-image').each(function(i){
	$(this).click(function(e){
		$('#image-modal').attr('src', $(this).attr('src'));
		$('#portfolioModal').modal('show');
	});
});

$('a.close').each(function(i){
	var parent = $('.note').get()[i],
		lien = $(this).attr('href');

	$(this).click(function(e){
		e.preventDefault();
		$.get(lien,function(data){
			var data = JSON.parse(data);
			if(data.code == 1){
				$(parent).fadeOut('slow');
				//$(parent).remove();
			}else{
				alert(data);
			}
		});
		return false;
	});
});