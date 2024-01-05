// password type change 
const showpass = document.querySelectorAll('.showpass');
const passtext = document.querySelectorAll(".passtext");
showpass.forEach((element) => {
    element.onclick = () => {
        passtext.forEach((e) => {
            if (e.type === "password") {
                e.type = "text";
            } else {
                e.type = "password";
            }
        })
    }
})

// image preview on account.php
const uploadimage = document.querySelectorAll('.imageupload');
const previewImage = document.querySelectorAll('.preview-image');
uploadimage.forEach((upload) => {
    upload.onchange = () => {
        previewImage.forEach((image) => {
            image.src = URL.createObjectURL(upload.files[0]);
        });
    }
})
