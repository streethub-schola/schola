const form = document.querySelector('form');
let img_preview, email;
const url =document.URL


function loadPreview(event) {
    img_preview = URL.createObjectURL(event.target.files[0])
    let img_view = document.getElementById('img_upload');
    if(form.studentPassport.files[0].size > 419999) {
        alert ('You have selected a file larger than the threshold');
        form.studentPassport.value = '';
        img_view.src = '';
    } else {
        img_view.src = img_preview;
    }
    
    // return img_preview;
}

form.addEventListener('submit', (e) => {
    e.preventDefault();

   let formData = new FormData(form);


    const configData = {
        method: 'POST',
        mode: 'no-cors',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(formData)
    }
    fetch("https://schola.skaetch.com/api/staffapi/createstaff.php", configData)
    .then(res => res.json())
    .then((data) => {
        console.log(data);
    })
    .catch((err) => {
        console.log('something went wrong with your request');
    })

});