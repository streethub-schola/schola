// https://scholabe.myf2.net/api/studentapi/studentlogin.php
let form = document.querySelector('form');

function geterror() {
    fetch('https://scholabe.myf2.net/api/studentapi/studentlogin.php')
    .then(res => res.json())
    .then(data => {
        console.log(data)
        document.getElementById('errorMsg').innerHTML = data.message;
        document.getElementById('errorMsg').style.display = 'block'
    })
}

form.addEventListener('submit', (e) => {
    e.preventDefault();

    let username = form.username.value;
    let password = form.password.value;
    fetchuser()
})

function fetchuser() {
    fetch('https://scholabe.myf2.net/api/studentapi/getstudents.php')
    .then(response => response.json())
    .then(data => {
        let username = form.username.value;
        let password = form.password.value;

        data.records.forEach(user => {
            if (username == user.admin_no && password == user.password) {
                sessionStorage.setItem('loggedInUser', JSON.parse(user));
                // location.href = './admin/index.html'
                console.log(user)
            } else {
                // geterror()
                console.log('Data not found in the db')
            }
            
        });
    })

}

