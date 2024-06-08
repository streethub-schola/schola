//Grab all the elements to parse
const img = document.getElementById('std_img');
const fullname = document.getElementById('std_name');
const firstname = document.getElementById('firstname');
const lastname = document.getElementById('lastname');
const admin_no = document.getElementById('admin_no');
const pgname = document.getElementById('pgname');
const pgrel = document.getElementById('pgrel');
const registered_at = document.getElementById('registered_at');
const modalX = document.getElementById('view_detail_assignment');
const showModal = document.getElementById('view_details');
const question_container = document.getElementById('questions');



let serialNo = 1;
let newAssignments;

// LOAD THE RESOURCES FROM THE BACKEND

// ASSIGNMENTS

document.addEventListener('DOMContentLoaded', () => {

   modalX.style.display = 'none';
   // var classes ;
   let staff ;
   let subject;

 Promise.all([
  //  getResource('https://schola.skaetch.com/api/subjectapi/getsubjects.php'),
  //  getResource('https://schola.skaetch.com/api/assignmentapi/getassignments.php'),
  //  getResource('https://schola.skaetch.com/api/classapi/getclasses.php')
   getResource('http://localhost/schola-2/api/subjectapi/getsubjects.php'),
   getResource('http://localhost/schola-2/api/assignmentapi/getassignments.php'),
   getResource('http://localhost/schola-2/api/classapi/getclasses.php')
   // getResource('https://schola-2.myf2.net/api/staffapi/getstaffs.php')
]).then ((assignment_data) => {
  //  console.log(assignment_data);


let subjects = assignment_data[0];
let classes = assignment_data[2];
let assignments = assignment_data[1].result;


const newData = joinOtherResourcesToBase(assignments, subjects, classes);






function joinOtherResourcesToBase(base, ...resources) {
  console.log(resources);

  newAssignments = base.map((item) => {
    const subject = findData(resources[0], 'subject_id', item.subject_id)
    const classItem = findData(resources[1], 'class_id', item.class_id)
    // const term = findData(resources[2], 'term_id', item.term_id)

    return {
      ...item,
      subject_name: subject.subject_name,
      class_name: classItem.class_name,
    };
  });
  console.log(newAssignments);

  // process data

  let source = document.getElementById('showAssighments');

   source.innerHTML = "";
   let tasks;

   newAssignments.forEach(items => {
      let view = `
      <td class="whitespace-nowrap px-6 py-4 font-medium"> ${items.assignment_id}</td>
      <td class="whitespace-nowrap px-6 py-4">${items.updated_at.slice(0, 11)}</td>
      <td class="whitespace-nowrap px-6 py-4">${items.subject_name}</td>
      <td class="whitespace-nowrap px-6 py-4"></td>
      <td class="whitespace-nowrap px-6 py-4">
      <a href="#view_detail_assignment" class="p-1 mx-1 bg-blue-200 rounded-md border border-black" id="view_details">view</a>
      </td>`;
      tasks = items.question
                  
      source.insertAdjacentHTML("beforeend", view)
      
                
   });

   

  return newAssignments;
}



function findData(item, field, id) {
  return item.find((data) => data[field] === id);
}

})
});



// CHECK IF THERE IS A CONTENT IN THE STORAGE

const verifier = sessionStorage.getItem('schola-user');

// if (!verifier) {
//         location.href = '../students/student_login.html';
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


async function getResource(url) {
   let resource;
   let res = await fetch(url)
   let data = await res.json();
    return data;
}



