//Grab all the elements to parse
const img = document.getElementById('std_img');
const fullname = document.getElementById('std_name');
const firstname = document.getElementById('firstname');
const lastname = document.getElementById('lastname');
const admin_no = document.getElementById('admin_no');
const pgname = document.getElementById('pgname');
const pgrel = document.getElementById('pgrel');
const registered_at = document.getElementById('registered_at');
let serialNo = 1;

// LOAD THE RESOURCES FROM THE BACKEND

// ASSIGNMENTS

document.addEventListener('DOMContentLoaded', () => {
    //ASSIGNMENTS
    fetch('https://schola.skaetch.com/api/assignmentapi/getassignments.php')
 .then((response) => response.json())
 .then((data) => {
    console.log(data);
    callAssignments(data);

 })

 //RESULTS
 fetch('https://schola.skaetch.com/api/resultapi/getresults.php')
 .then((response) => response.json())
 .then((data) => {
    console.log(data);
 })
 
})

function callAssignments(assignments){
   let source = document.getElementById('showAssignments');

   source.innerHTML = "";

   assignments.forEach(items => {
      let view = `
      <tr class="border-b bg-neutral-100 dark:border-neutral-500 dark:bg-neutral-700>
                  <td class="whitespace-nowrap px-6 py-4 font-medium">
                    ${items.subject_id}
                  </td>
                  <td class="whitespace-nowrap px-6 py-4">${items.staff_id}</td>
                  <td class="whitespace-nowrap px-6 py-4">True</td>
                  <td class="whitespace-nowrap px-6 py-4">
                    10th Dec, 2023
                  </td>
                  <td class="whitespace-nowrap px-6 py-4">False</td>
                </tr>`
   });
}


// CHECK IF THERE IS A CONTENT IN THE STORAGE

const verifier = sessionStorage.getItem('schola-user');

// if (!verifier) {
//         location.href = '../students/login.html';
//    //console.log('user is logged in')
// }

// Get the data from the storage

const data = JSON.parse(verifier);

fullname.innerHTML = `${data.student.lastname.toUpperCase()} ${data.student.firstname}`;
firstname.innerHTML = `${data.student.firstname}`;
lastname.innerHTML = `${data.student.lastname.toUpperCase()}`;
admin_no.innerHTML = `${data.student.admin_no}`;
pgname.innerHTML = `${data.student.guardian_name}`;
pgrel.innerHTML = `${data.student.guardian_rel}`;
registered_at.innerHTML = `${data.student.created_at}`;