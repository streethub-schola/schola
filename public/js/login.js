// https://scholabe.myf2.net/api/studentapi/studentlogin.php
let form = document.querySelector('form');



form.addEventListener('submit', (e) => {
    e.preventDefault()
    
    const userData = {
        admin_no: `${form.username.value}`,
        password: `${form.password.value}`
    };

    const configData = {
        method: 'POST',
        mode: 'no-cors',
        headers: {
            'Content-Type':'application/json'
        },
        body: JSON.stringify(userData)
    };
   

    // console.log (userData)


    fetch('https://schola.myf2.net/api/studentapi/studentlogin.php', configData)
    .then(res => res.json())
    .then(data => console.log(data))
    .catch(err => console.log(err))
    
})