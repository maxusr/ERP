function createThumbnail($file, $img) {
    var reader = new FileReader();

    reader.onload = function() {
        $img.src = this.result;
    }

    reader.readAsDataURL($file);
}

$('.input-file').change(function() {
    //	alert(this);
    var files = this.files,
        $img = $('#image-uploaded').get();
    createThumbnail(files[0], $img[0]);
});