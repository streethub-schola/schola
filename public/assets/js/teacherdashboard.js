const firstname = document.getElementById('firstname');
const lastname = document.getElementById('lastname');
const staffID = document.getElementById('staffID');
const guarantorName = document.getElementById('guaName');
const staffemail = document.getElementById('staffEmail');
const verID = document.getElementById('verID');
const registered_at = document.getElementById('registered_at');


//CHECK IF THE TEACHER IS LOGGED IN 

const check = sessionStorage.getItem('scola-staff')

// if(!sessionStorage.getItem('scola-staff')){
//     alert('You do not have permission to view this page.');
//     location.href = '../teachers/teacher_login.html';
// }

const staff_data = JSON.parse(check)
console.log(staff_data);

// FILL IN THE TEMPLATES WITH THE DATA FROM THE SESSION

