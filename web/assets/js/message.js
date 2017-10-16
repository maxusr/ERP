var isScrolling = false;
function Message(sender, receiver, content, id, status, date) {

	if(typeof status === "undefined"){
		status = 0;
	}

	if(typeof date === "undefined"){
		date = new Date();
	}

	if(typeof id === "undefined"){
		id = 0;
	}

	this.identifiant = id;
	this.envoyeur = sender;
	this.receveur = receiver;
	this.contenu = content;
	this.statut = status;
	this.date = date;

}

function Utilisateur(name, surname, email, civility, id) {

	this.identifiant = id;
	this.nom = name;
	this.prenom = surname;
	this.email = email;
	this.civilite = civility;
}

// Fonction qui trie et rafraichit la discussion.
function refreshDiscussion(messages) {
	var elt = '',
		prev = $('#messages').html();
	if(typeof messages === "undefined") {
		messages = new Message(0,0,'');
	}
	if(typeof messages.messages !== "undefined")
	{
		for (var i = 0; i <= messages.messages.length - 1; i++) {
			elt += displayMessage(messages.messages[i]);
		};
		$('#messages').html($(elt));
		if(prev != elt){
			isScrolling = false;
			scrolling();
		}
	}
	

}

// Fonction qui affiche le message à l'écran.
function displayMessage(message) {
	
	var elt = "";
	if(!message.isSender) {
		elt = '<div class="media thumbnail pull-left"><div class="media-body"><h4 class="media-heading text-left">'+message.receiver_civ+' '+message.sender+'</h4><p class="text-left">'+message.contenu+'</p><small class="pull-right">'+message.date+'</small></div></div><div class="clearfix"></div>';
	}else{
		elt = '<div class="media thumbnail pull-right"><div class="media-body"><h4 class="media-heading text-right">'+message.sender_civ+' '+message.sender+'</h4><p class="text-right">'+message.contenu+'</p><small class="pull-left">'+message.date+'</small></div></div><div class="clearfix"></div>';
	}

	return elt;
}
function scrolling() {
	if(!isScrolling)
		$('#messages').get()[0].scrollTop = $('#messages').get()[0].scrollHeight;
}
scrolling();

$('#messages').on('scroll',function(e){
	isScrolling = true;
	//alert(isScrolling);
});
$('#messages').off('scroll',function(e){
	isScrolling = false;
});

//Fonction qui retourne les messages de la base de données. Retourne un tableau de message
function loadMessages() {
	var msgs,
		form = $('.form-message').get()[0],
		lien = $(form).attr('data-message-load-url'),
		receveur = $(form).attr('data-receiver');


	var xhr = new XMLHttpRequest();

	xhr.open('GET',lien+"&id_receiver="+receveur);
	xhr.withCredentials = true;
	//xhr.setRequestHeader("Content-Type","application/x-www-formurlencoded");
	xhr.onreadystatechange = function(){
		if(xhr.readyState == 4 && xhr.status == 200) {

			refreshDiscussion(JSON.parse(xhr.responseText));
		}
	};
	xhr.send();

	setTimeout(function(){
		loadMessages();
	},2000);
}

$('.form-message').each(function(index){
	var form = this,
		lien = $(form).attr('data-message-load-url'),
		messages = [];

	$(this).on('submit',function(e){

		var receiver = $('#receiver').val(),
			content = $('.content').get()[index],
			message = new Message(1,0,$(content).val());
				
		e.preventDefault();
		$(this).ajaxSubmit({ 
				dataType: 'json',
				forceSync: false,
				beforeSend: function(){
				},
				uploadProgress: function(event,position,total,percent){
				},
				success: function(){
				},
				complete: function(xhr){
								var result = xhr.responseText;
								//alert(result);
								result = JSON.parse(result);
								if(xhr.status == 200 && parseInt(result.status) == 1){
									form.reset();
									loadMessages();
								}else{
									if(xhr.readyState == 4){	
									}else{
									}

								}
				}
		});
	});
});