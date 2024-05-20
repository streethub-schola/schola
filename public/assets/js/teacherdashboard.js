const firstname = document.getElementById('firstname');
const lastname = document.getElementById('lastname');
const staffID = document.getElementById('staffID');
const guarantorName = document.getElementById('guaName');
const staffemail = document.getElementById('staffEmail');
const verID = document.getElementById('verID');
const registered_at = document.getElementById('registered_at');


//CHECK IF THE TEACHER IS LOGGED IN 

const check = sessionStorage.getItem('schola-staff')

if(!check){
    alert('You do not have permission to view this page.');
    location.href = '../teachers/teacher_login.html';
}

const staff_data = JSON.parse(check)
console.log(staff_data);

// FILL IN THE TEMPLATES WITH THE DATA FROM THE SESSION

firstname.innerHTML = staff_data.firstname;
lastname.innerHTML = staff_data.lastname;
staffID.innerHTML = staff_data.staff_no;
guarantorName.innerHTML = staff_data.guarantor_name;
staffemail.innerHTML = staff_data.email;
// verID = document.getElementById('verID');
// registered_a


function fetchStudent(){
    fetch('http://localhost/schola-2/api/student/getstudents.php')
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
    })
    .catch((err) => {
        console.log(err.message);
    });
    
}
fetchStudent()