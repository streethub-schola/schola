//Grab all the elements to parse
const img = document.getElementById('std_img');
const fullname = document.getElementById('std_name');
const firstname = document.getElementById('firstname');
const lastname = document.getElementById('lastname');
const admin_no = document.getElementById('admin_no');
const pgname = document.getElementById('pgname');
const pgrel = document.getElementById('pgrel');
const registered_at = document.getElementById('registered_at');


// CHECK IF THERE IS A CONTENT IN THE STORAGE

const verifier = sessionStorage.getItem('schola-user');

if (!verifier) {
        location.href = '../students/login.html';
   //console.log('user is logged in')
}

// Get the data from the storage

const data = JSON.parse(verifier);

fullname.innerHTML = `${data.student.lastname.toUpperCase()} ${data.student.firstname}`;
firstname.innerHTML = `${data.student.firstname}`;
lastname.innerHTML = `${data.student.lastname.toUpperCase()}`;
admin_no.innerHTML = `${data.student.admin_no}`;
pgname.innerHTML = `${data.student.guardian_name}`;
pgrel.innerHTML = `${data.student.guardian_rel}`;
// const crdate = data.student.created_at
// const padate = crdate.split(" ")[0]
registered_at.innerHTML = `${data.student.created_at}`;





