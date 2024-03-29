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

let classes ;
let staff ;
let subject;





// LOAD THE RESOURCES FROM THE BACKEND

// ASSIGNMENTS

document.addEventListener('DOMContentLoaded', () => {
    //ASSIGNMENTS
//     fetch('https://schola-2.myf2.net/api/assignmentapi/getassignments.php')
//  .then((response) => response.json())
//  .then((assignment_data) => {

//    // console.log(assignment_data);
//     callAssignments(assignment_data.result);
//  })

 Promise.all([
   fetch('https://schola-2.myf2.net/api/subjectapi/getsubjects.php'),
   fetch('https://schola-2.myf2.net/api/assignmentapi/getassignments.php'),
   fetch('https://schola-2.myf2.net/api/classapi/getclasses.php')
]).then((responses) => {
   return Promise.all(responses.map(function (response){
      return response.json();
   }))
})
.then ((assignment_data) => {
   console.log(assignment_data);
   console.log(assignment_data[1]);
   console.log(assignment_data[0]);
   callAssignments(assignment_data)
})
.catch((err) => {
   console.log(err);
})

//  .catch(err => console.log(err));

 //RESULTS
//  fetch('https://schola.skaetch.com/api/resultapi/getresults.php')
//  .then((response) => response.json())
//  .then((result_data) => {
//     console.log(result_data);
//    //  callResults(data);

//  })

})

// console.log(classes);
// console.log(subject);
// console.log(staff);



function callAssignments(assignments){
   let source = document.getElementById('showAssighments');

   source.innerHTML = "";

   assignments.forEach(items => {
      let view = `
      <td class="whitespace-nowrap px-6 py-4 font-medium"> ${items[1].assignment_id}</td>
      <td class="whitespace-nowrap px-6 py-4">${items[1].created_at.slice(0, 11)}</td>
      <td class="whitespace-nowrap px-6 py-4">${items[1].subject_id}</td>
      <td class="whitespace-nowrap px-6 py-4">10th Dec, 2023</td>
      <td class="whitespace-nowrap px-6 py-4">False</td>`;
                  
      source.insertAdjacentHTML("beforeend", view)
                
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