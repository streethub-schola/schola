const firstname = document.getElementById('firstname');
const lastname = document.getElementById('lastname');
const staffID = document.getElementById('staffID');
const guarantorName = document.getElementById('guaName');
const staffemail = document.getElementById('staffEmail');
const verID = document.getElementById('verID');
const registered_at = document.getElementById('registered_at');


//CHECK IF THE TEACHER IS LOGGED IN 

const staff_data = JSON.parse(sessionStorage.getItem('schola-user'));
if (!staff_data) {
    alert('You do not have permission to view this page.');
    location.href = '../teachers/teacher_login.html';
}


const isStaff = staff_data.hasOwnProperty('staff_no') && staff_data.hasOwnProperty('staff_id');

console.log(isStaff);

if(!isStaff){
    alert('You do not have permission to view this page.');
    location.href = '../teachers/teacher_login.html';
}




// FILL IN THE TEMPLATES WITH THE DATA FROM THE SESSION

firstname.innerHTML = staff_data.firstname;
lastname.innerHTML = staff_data.lastname;
staffID.innerHTML = staff_data.staff_no;
guarantorName.innerHTML = staff_data.guarantor_name;
staffemail.innerHTML = staff_data.email;
// verID = document.getElementById('verID');
// registered_a


// function fetchStudent(){
//     fetch('http://localhost/schola-2/api/student/getstudents.php')
//     .then((response) => response.json())
//     .then((data) => {
//         console.log(data);
//     })
//     .catch((err) => {
//         console.log(err.message);
//     });
    
// }

// fetchStudent()





function displayStudentsClass(){

    const userData = {
        searchstring: staff_data.class_id,
        searchcolumn: "class",
    }

    const configData = {
        method: "POST",
        mode: "no-cors",
        headers: {
          "Content-Type": "application/json",
          "Accept": "application/json"
        },
        body: JSON.stringify(userData)
      };

    fetch(API_DOMAIN+"/api/studentapi/searchstudent.php", configData)
    .then(res => res.json())
    .then(data => {

        let data_target = document.getElementById("my_students");
        data_target.innerHTML = "";
        let counter = 0;

        data.array.forEach((item) => {
            let data_field = `<tr
            class="border-b bg-neutral-100 dark:border-neutral-500 dark:bg-neutral-700"
          >
            <td class="whitespace-nowrap px-6 py-4 font-medium">
              ${++counter}
            </td>
            <td class="whitespace-nowrap px-6 py-4" id="std_name">${item.admin_no}</td>
            <td class="whitespace-nowrap px-6 py-4" id="std_class">${item.firstname} ${item.lastname}</td>
            <td class="whitespace-nowrap px-6 py-4" id="teacher_action">
              Delete
            </td>
          </tr>`

            data_target.insertAdjacentHTML("beforeend", data_field)
        });
        

    })
    
}