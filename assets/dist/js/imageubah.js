function previewGambar(){
    const tampilUbah = document.querySelector('.tampilubah');
    const imgPreviewUbah = document.querySelector('.img-previewubah');
    
    const oFReader = new FileReader();
    oFReader.readAsDataURL(tampilUbah.files[0]);
    oFReader.onload = function (oFREvent){
    imgPreviewUbah.src = oFREvent.target.result;
     }; 
}