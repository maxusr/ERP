$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();
	$('[rel="tooltip"]').tooltip();
	$('#modal-loading').modal({
	    keyboard: false,
	    show: false,
	    backdrop: 'static'
	});
	$('#modal-info').modal({
	    keyboard: false,
	    show: false
	});

	function updateProgressBar(percent) {
	    $('#modal-loading #bar').css('width', percent + '%');
	}

	function displayInfo(title, message) {
	    $('#modal-info #modal-info-title').text(title);
	    $('#modal-info #modal-info-message').html(message);
	    $('#modal-info').modal('show');
	}

	function rotateCard(btn) {
	    var $card = $(btn).closest('.card-container');
	    console.log($card);
	    if ($card.hasClass('hover')) {
	        $card.removeClass('hover');
	    } else {
	        $card.addClass('hover');
	    }
	}

	$('.confirm').each(function(i) {
	    $(this).click(function(e) {
	        var message = $(this).attr('data-confirm-message');
	        if (confirm(message)) {
	            return true;
	        } else {
	            e.preventDefault();
	            return false;
	        }
	    });
	});


	$('.datepicker').datepicker({
	    format: 'dd-mm-yyyy',
	    autoclose: true,
	    language: 'fr'
	});

	setInterval(function() {
	    var numberLink = $('#launch-discussion').attr('data-number-url');
	    if (numberLink > 0 && numberLink != '#') {
	        $.ajax(numberLink, {
	            type: 'GET',
	            dataType: 'json',
	            timeout: 1000,
	            success: function(data) {
	                var online = $('#launch-discussion .notifier');
	                //alert(data.online);
	                if (data.status == 0) {
	                    if (data.message > 0) {
	                        $(online).html(data.message);
	                    } else {
	                        $(online).html('');
	                    }
	                    //alert($(online).html());
	                } else {
	                    if (data.status == 999)
	                        alert(data.message);
	                }
	            },
	            error: function() {
	                //alert("Timeout");
	            }
	        });
	    }
	}, 2000);

	$('.time-mask').each(function(i) {
	    $(this).inputmask("hh:mm:ss");
	});

	$('.printer').each(function(i) {
	    $(this).click(function() {
	        var sheet = $(this).attr('data-print');
	        var restorepage = document.body.innerHTML;
	        var printcontent = $(sheet).html();
	        document.body.innerHTML = printcontent;
	        window.print();
	        document.body.innerHTML = restorepage;
	    });
	});
});