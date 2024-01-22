const form = document.querySelector('form');
const preview = document.querySelector('#preview');

const formdata = new FormData(form)

form.addEventListener('submit', (e)=>{
    e.preventDefault()
    
    
})

preview.addEventListener('click', ()=>{
    const passport= document.querySelector('#studentPassport');
    const img_preview = document.querySelector('#img_upload');

    if(!passport.value){
        alert('You have not selected the file to upload')
    } else {
        // img_preview.src = 'passport.value'
        // Get the source file 
        // let img = passport.e.

    }
})

