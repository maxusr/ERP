$('#btn-upload').click(function(e){
	$('#input-docs').trigger('click');
});

$('.dialer').each(function(i){
	$(this).click(function(e){
		var id = $(this).attr('data-user-id');

		$('#message').attr('data-receiver',id);
		$('#receiver').attr('value',id);
		$('#formUpload #to').attr('value',id);
		$('#discussions-empty').fadeOut('fast');
		$('#discussions-list').fadeIn('fast');
		$('#discussions-list #messages').html('<p class="text-center text-navy">Envoyez un message pour commencer la discussion</p>');
		scrolling();
		loadMessages();
	});
});

setInterval(function(){
	online();
},5000);

function numberMessage() {
	$('.dialer').each(function(i){
		var lien = $('#membres').attr('data-number-url');
		$(this).click(function(e){
			var id = $(this).attr('data-user-id');
		});
	});
}

function online(){
	$('.dialer').each(function(i){
		var id = $(this).attr('data-user-id'),
			lien = $('#membres').attr('data-online-url'),
			numberLink = $('#membres').attr('data-number-url');

			$.ajax(lien,{
				type: 'POST',
				dataType: 'json',
				data: {user: id},
				timeout: 1000,
				success: function(data){
					var online = $('.online').get()[i];
					//alert(data.online);
					if(data.online){
						$(online).removeClass('text-white').addClass('text-yellow');
						//alert($(online).html());
					}else{
						$(online).removeClass('text-yellow').addClass('text-white');
					}
				},
				error: function(){
					//alert("Timeout");
				}
			});
			$.ajax(numberLink,{
				type: 'POST',
				dataType: 'json',
				data: {sender: id},
				timeout: 1000,
				success: function(data){
					var online = $('.dialer .badge').get()[i];
					//alert(data.online);
					if(data.status == 0){
						if(data.message > 0){
							$(online).html(data.message);
						}else{
							$(online).html('');
						}
						//alert($(online).html());
					}else{
						if(data.status == 999)
							alert(data.message);
					}
				},
				error: function(){
					//alert("Timeout");
				}
			});

	});
	
	setTimeout(online,10000);
}
online();