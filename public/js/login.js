// https://scholabe.myf2.net/api/studentapi/studentlogin.php
let form = document.querySelector('form');

// function geterror() {
//     fetch('https://scholabe.myf2.net/api/studentapi/studentlogin.php')
//     .then(res => res.json())
//     .then(data => {
//         console.log(data)
//         document.getElementById('errorMsg').innerHTML = data.message;
//         document.getElementById('errorMsg').style.display = 'block'
//     })
// }

form.addEventListener('submit', (e) => {
    e.preventDefault();

    let admin_no = form.username.value;
    let password = form.password.value;

    const data = {
        admin_no,
        password
    }

    console.log(data);

    const config = {
        method: 'POST',
        headers: {
            'Content-Type':'application/json',
        },
        body: JSON.stringify(data),
    }

    fetch('https://scholabe.myf2.net/api/studentapi/studentlogin.php', config)
    .then(res => res.json())
    .then(data => console.log(data))
    .catch(err => console.log(err))
    
})

// function fetchuser() {
//     fetch('https://scholabe.myf2.net/api/studentapi/getstudents.php')
//     .then(response => response.json())
//     .then(data => {
//         let username = form.username.value;
//         let password = form.password.value;

//         data.records.forEach(user => {
//             if (username == user.admin_no && password == user.password) {
//                 sessionStorage.setItem('loggedInUser', JSON.parse(user));
//                 // location.href = './admin/index.html'
//                 console.log(user)
//             } else {
//                 // geterror()
//                 console.log('Data not found in the db')
//             }
            
//         });
//     })

// }

