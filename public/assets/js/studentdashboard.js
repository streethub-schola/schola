//Grab all the elements to parse
const img = document.getElementById("std_img");
const fullname = document.getElementById("std_name");
const firstname = document.getElementById("firstname");
const lastname = document.getElementById("lastname");
const admin_no = document.getElementById("admin_no");
const pgname = document.getElementById("pgname");
const pgrel = document.getElementById("pgrel");
const registered_at = document.getElementById("registered_at");
const modalX = document.getElementById("view_detail_assignment");
const showModal = document.getElementById("view_details");
const question_container = document.getElementById("questions");

const showAssighments = document.getElementById("showAssighments");

let serialNo = 1;
let newAssignments;

// CHECK IF THERE IS A CONTENT IN THE STORAGE
const student_data = JSON.parse(sessionStorage.getItem("schola-user"));

console.log(student_data);

// if (student_data == null) {
//   alert('Please login');
//   location.href = '../students/student_login.html';
// }

fullname.innerHTML = `${student_data.student.lastname.toUpperCase()} ${
  student_data.student.firstname
}`;
firstname.innerHTML = `${student_data.student.firstname}`;
lastname.innerHTML = `${student_data.student.lastname.toUpperCase()}`;
admin_no.innerHTML = `${student_data.student.admin_no}`;
pgname.innerHTML = `${student_data.student.guardian_name}`;
pgrel.innerHTML = `${student_data.student.guardian_rel}`;
registered_at.innerHTML = `${student_data.student.created_at}`;

console.log(student_data.student.class);

// Show assignment
searchAssignmentByClass();

// Search for assignment by class fuction
function searchAssignmentByClass() {
  const studentConfig = {
    method: "POST",
    mode: "no-cors",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      searchstring: student_data.student.class,
      searchcolumn: "class_id",
    }),
  };

  fetch(API_DOMAIN + "/api/assignmentapi/searchassignment.php", studentConfig)
    .then((res) => res.json())
    .then((student_assignments) => {
      console.log(student_assignments);

      showAssighments.innerHTML = "";

      student_assignments.result.forEach((assignment, index) => {
        showAssighments.innerHTML += `
        <tr
                    class="border-b bg-white dark:border-neutral-500 dark:bg-neutral-600"
                  >
                    <td class="whitespace-nowrap px-6 py-4 font-medium">
                    ${index + 1}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4">${
                      assignment.created_at
                    }</td>
                    <td class="whitespace-nowrap px-6 py-4">
                    ${assignment.subject_id}
                    </td>
                    <td class="whitespace-nowrap px-6 py-4">
                    ${assignment.staff_id}
                    </td>
                    <td class="tbody_td_controller whitespace-nowrap px-6 py-4 font-medium" id="controller">
                      <a href="view_assignment.html?assignment_id=${
                        assignment.assignment_id
                      }" data-te-toggle="tooltip" title="View Record">
                      <i class="fa-regular fa-eye text-lg text-blue-400"></i> View
                      </a>
                      </td>
                  </tr>
        `;
      });
    })
    .catch((err) => console.log(err));
}

