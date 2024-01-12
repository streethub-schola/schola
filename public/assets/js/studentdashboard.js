//Grab all the elements to parse
const img = document.getElementById('std_img');
const fullname = document.getElementById('std_name');
const firstname = document.getElementById('firstname');
const lastname = document.getElementById('lastname');
const admin_no = document.getElementById('admin_no');
const gender = document.getElementById('gender');
const registered_at = document.getElementById('registered_at');


// CHECK IF THERE IS A CONTENT IN THE STORAGE

const verifier = sessionStorage.getItem('schola-user');

// if (verifier) {
//     console.log('user is logged in')
// } else {
//     location.href = '../students/login.html';
// }

// Get the data from the storage

const data = JSON.parse(verifier);

fullname.innerHTML = `${data.student.firstname} ${data.student.lastname}`;
firstname.innerHTML = `${data.student.firstname}`;
lastname.innerHTML = `${data.student.lastname}`;
admin_no.innerHTML = `${data.student.admin_no}`;
gender.innerHTML = `${data.student.gender}`;
registered_at.innerHTML = `${data.student.registered_at}`;





