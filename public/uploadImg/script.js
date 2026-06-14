document.addEventListener('DOMContentLoaded', function () {
    const inputGambar = document.getElementById('inputGambar');
    const imgContainer = document.getElementById('imgContainer');
    const imgName = document.querySelector('.imgName');
    
    inputGambar.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (event) {
                imgContainer.src = event.target.result;
                const fileSize = (file.size / 1024).toFixed(2);
                imgName.textContent = `${file.name} - ${fileSize} KB`;
            };
            reader.readAsDataURL(file);
        } else {
            imgName.textContent = '';
        }
    });
});
