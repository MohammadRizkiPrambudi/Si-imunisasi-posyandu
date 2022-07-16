function previewImage(){
const tampil = document.querySelector('.tampil');
const imgPreview = document.querySelector('.img-preview');

const oFReader = new FileReader();
oFReader.readAsDataURL(tampil.files[0]);
oFReader.onload = function (oFREvent){
imgPreview.src = oFREvent.target.result;
	};
}

