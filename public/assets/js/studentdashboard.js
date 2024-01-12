//Grab all the elements to parse
const img = document.getElementById('std_img');
const fullname = document.getElementById('std_name');
const firstname = document.getElementById('firstname');
const lastname = document.getElementById('lastname');
const email = document.getElementById('email');
const gender = document.getElementById('gender');
const registered_at = document.getElementById('registered_at');


// CHECK IF THERE IS A CONTENT IN THE STORAGE

const verifier = sessionStorage.getItem('schola-user');

if (verifier) {
    console.log('user is logged in')
}

// Get the data from the storage

const data = JSON.parse(verifier);

fullname.innerHTML = `${data.firstname} ${data.lastname}`;
firstname.innerHTML = `${data.firstname}`;
lastname.innerHTML = `${data.lastname}`;
email.innerHTML = `${data.email}`;
gender.innerHTML = `${data.gender}`;
registered_at.innerHTML = `${data.registered_at}`;





