var allowedDocumentTypes = ['png', 'jpg', 'jpeg', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'txt', 'rtf', 'zip', 'rar'];
fileDetails = document.querySelector('#fileDetails'),
    taille = 0,
    nbre = 0;

$('.input-docs').each(function(i) {
    $(this).change(function() {
        var files = this.files,
            filesLen = files.length,
            fileType,
            fileName,
            fileTaille,
            fileDate;
        fileDetails.innerHTML = '';
        taille = 0;
        span = document.createElement('span');
        span.setAttribute('class', 'list-group-item');
        span.innerHTML = '<b>Liste des Fichiers</b>';
        fileDetails.appendChild(span);

        //prev.style.display = 'block';
        for (var i = 0; i < filesLen; i++) {

            fileType = files[i].name.split('.');
            fileName = files[i].name.substring(0, files[i].name.lastIndexOf('.'));
            fileTaille = files[i].size;
            fileDate = files[i].lastModifiedDate;
            fileType = fileType[fileType.length - 1];
            a = document.createElement('a');
            a.setAttribute('class', 'list-group-item');
            a.setAttribute('data-html', 'true');
            a.setAttribute('data-toggle', 'pop-over');
            heure = fileDate.getDate() + '/' + (fileDate.getMonth() + 1) + '/' + fileDate.getFullYear() + ' à ' + fileDate.getHours() + 'h' + fileDate.getMinutes() + 'min' + fileDate.getSeconds() + 's';
            a.setAttribute('data-original-title', 'Details Fichier');
            a.setAttribute('data-content', '<b>Taille:</b> ' + fileTaille / 1000000 + ' Mo <br/><b>Dernière Modification:</b> ' + heure + '<br/><b>Type:</b> ' + fileType.toUpperCase());
            $(a).text('[' + fileType.toUpperCase() + '] ' + fileName);
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
        span.setAttribute('class', 'list-group-item');
        span.innerHTML = '<b>Nombres de Fichiers:</b><span class="pull-right">' + filesLen + '</span>';
        fileDetails.appendChild(span);
        span = document.createElement('span');
        span.setAttribute('class', 'list-group-item');
        span.innerHTML = '<b>Taille Totale:</b><span class="pull-right">' + taille / 1000000 + ' Mo</span>';
        fileDetails.appendChild(span);

        $('#fileDetails .list-group-item').popover({ trigger: 'hover' });
        $('#fileDetails .list-group-item').each(function(i) {
            //alert();
            $(this).popover();
        });
        if (verifFormUpload())
            toggleSubmit($('#formDossier #submit'), true);
    });
});

function toggleSubmit(submit, display) {
    if (typeof display === 'undefined') {
        display = true;
    }
    if (display) {
        $(submit).attr('type', 'submit');
        $(submit).removeClass('disabled');
    } else {
        $(submit).attr('type', 'button');
        $(submit).addClass('disabled');
    }
}
toggleSubmit($('#formDossier #submit'), false);

function resultUpload(message, type) {
    var result = $('#resultUpload');
    if (typeof type === 'undefined') {
        type = 'success';
    }

    switch (type) {
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

function verifFormUpload() {
    if (taille > 50000000) {
        resultUpload('<h4>Impossible!</h4>Taille des fichiers supérieur à 50 Mo', 'danger');
        return false;
    }

    if (nbre > 8) {
        resultUpload('<h4>Impossible!</h4>Nombre des fichiers supérieur à 8.', 'danger');
        return false;
    }
    return true;
}