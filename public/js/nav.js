const navLinks = document.querySelector('#navbar');
const navSwitch = document.querySelector('#nav_toggle');
const mobileView = document.querySelector('#mobile-menu');


navSwitch.addEventListener('click', ()=>{
    mobileView.classList.toggle('flex');
    mobileView.classList.toggle('hidden')

   

    
})

mobileView.addEventListener('click', ()=> {
    mobileView.classList.toggle('hidden')
})