var bar = document.querySelector('#progress-bar-upload'),
	progress = document.querySelector('#progress-upload'),
	taille = 0,
	nbre = 0;

$(progress).fadeOut('fast');

function cleanUploadForm(){
	$('#formUpload .form-control').each(function(i){
		$(this).val('');
	});
	$('#fileDetails').html('');
	$('#tailleDescription').text('200');
	$('#progress-bar-upload').width(0);
	$('#progress-bar-upload').text('');
	$('#progress-upload').fadeOut();
	toggleSubmit($('#formUpload #submit'),false);
}

function resultUpload(message,type){
	var result = $('#resultUpload');
	if( typeof type === 'undefined'){
		type = 'success';
	}
	
	switch(type){
		case 'success':
			result.removeClass('alert-danger');
			result.addClass('alert-success');
		break;
		case 'danger':
			result.removeClass('alert-success');
			result.addClass('alert-danger');
		break;
	}
	 result.html(message);
}
function toggleSubmit(submit,display){
	if (typeof display === 'undefined') { 
		display = true;
	}
	if(display){
		$(submit).attr('type','submit');
		$(submit).removeClass('disabled');
	}else{
		$(submit).attr('type','button');
		$(submit).addClass('disabled');
	}
}

function verifFormUpload(){
		if(taille > 50000000){
			resultUpload('<h4>Impossible!</h4>Taille des fichiers supérieur à 50 Mo','danger');
			return false;
		}

		if(nbre > 8){
			resultUpload('<h4>Impossible!</h4>Nombre des fichiers supérieur à 8.','danger');
			return false;
		}
		return true;
}
toggleSubmit($('#formUpload #submit'),false);

var allowedDocumentTypes = ['png', 'jpg', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'rtf', 'zip', 'rar'];
	fileDetails = document.querySelector('#fileDetails');

$('#input-docs').change(function() {
	var files = this.files,
		filesLen = files.length,
		fileType,
		fileName,
		fileTaille,
		fileDate;
		fileDetails.innerHTML = '';
		taille = 0;
		span = document.createElement('span');
		span.setAttribute('class','list-group-item');
		span.innerHTML = '<b>Liste des Fichiers</b>';
		fileDetails.appendChild(span);
		
	//prev.style.display = 'block';
	for (var i = 0 ; i < filesLen ; i++) {
		
		fileType = files[i].name.split('.');
		fileName = files[i].name.substring(0,files[i].name.lastIndexOf('.'));
		fileTaille = files[i].size;
		fileDate = files[i].lastModifiedDate;
		fileType = fileType[fileType.length - 1];
		a = document.createElement('a');
		a.setAttribute('class','list-group-item');
		a.setAttribute('data-html','true');
		a.setAttribute('data-toggle','pop-over');
		heure = fileDate.getDate()+'/'+(fileDate.getMonth() + 1)+'/'+fileDate.getFullYear()+' à '+fileDate.getHours()+'h'+fileDate.getMinutes()+'min'+fileDate.getSeconds()+'s';
		a.setAttribute('data-original-title','Details Fichier');
		a.setAttribute('data-content','<b>Taille:</b> '+fileTaille/1000000+' Mo <br/><b>Dernière Modification:</b> '+heure+'<br/><b>Type:</b> '+fileType.toUpperCase());
		$(a).text('['+fileType.toUpperCase()+'] '+fileName);
		taille += fileTaille;
		fileDetails.appendChild(a);
		/*
		if(allowedTypes.indexOf(fileType) != -1) {
			createThumbnail(files[i],prev);
		}
		*/
	}

	nbre = filesLen;
	taille = taille;

		span = document.createElement('span');
		span.setAttribute('class','list-group-item');
		span.innerHTML = '<b>Nombres de Fichiers:</b><span class="pull-right">'+filesLen+'</span>';
		fileDetails.appendChild(span);
		span = document.createElement('span');
		span.setAttribute('class','list-group-item');
		span.innerHTML = '<b>Taille Totale:</b><span class="pull-right">'+taille/1000000+' Mo</span>';
		fileDetails.appendChild(span);
	
	$('#fileDetails .list-group-item').popover({trigger: 'hover'});
	$('#fileDetails .list-group-item').each(function(i){
		//alert();
		$(this).popover();
	});
	toggleSubmit($('#formUpload #submit'),true);
});

$('#formUpload').on('submit',function(e){
	e.preventDefault();
	if(verifFormUpload())
	{
		$(this).ajaxSubmit({ 
				dataType: 'json',
				forceSync: true,
				beforeSend: function(){
						toggleSubmit($('#formUpload #submit'),false);
						$(progress).fadeIn();
						resultUpload('<h4>Transfert en cours...</h4>');
				},
				uploadProgress: function(event,position,total,percent){
							$(bar).width(percent+'%');
							$(bar).text(percent+'%');
							if(percent == 100){
							$(bar).text('100% Traitement en cours...');
							}
				},
				success: function(){
							$(bar).width('100%');
							$(bar).text('100% Traitement en cours...');
				},
				complete: function(xhr){
								//var text = xhr.responseText,
								code = 2;
								message = 'Erreur survenue lors du traitement. Vérifiez que votre document réponde aux consignes.';
								//showModal('ReponseText',text,false);
								try{
									var rep = xhr.responseText;
									rep = JSON.parse(rep);
									status = rep.status;
									$(bar).text(rep.message);
									code = parseInt(rep.code);
									message = rep.message;
									
								}catch(err){
								}

								toggleSubmit($('#formUpload #submit'),true);
								switch(code)
								{
									case 0:
										$(bar).text('Transert Terminé.');
										setTimeout(cleanUploadForm(),2000);
										resultUpload('Transert Terminé.');
									break;
									case 1:
										$(bar).text('Erreur survenue');
										resultUpload(message,'danger');
									break;
									case 2:
										$(bar).text('Erreur survenue');
										resultUpload(message,'danger');
									break;
									case 3:
										$(bar).text('Erreur survenue');
										resultUpload(message,'danger');
									break;
								}
				}
		});
	}
});