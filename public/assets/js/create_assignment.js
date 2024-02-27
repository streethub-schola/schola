
var textBox = document.querySelector(".textBox");
var messageContainer = document.querySelector(".message");
var add_Question = document.getElementById("AddAss");
var textMessage = document.getElementById("assignmentText");
var remove_Question = document.getElementById("remove");
var btn_Submit = document.getElementById("postBtn");
var sname = document.getElementById("staff-name");
 
const delete_Assignment = document.getElementById("deleteAssignment");

document.addEventListener("DOMContentLoaded", () => {
  const staffName = document.getElementById("staff-name");
  const subject = document.querySelector(".subjectsT");

  console.log(subject);
  const studentClass = document.querySelector(".classT");
  const terms = document.getElementById("terms");

  // Fetch the staff details
  staffName.value = sessionStorage.getItem("staff-name");

  // Get the subjects
  fetch("https://schola.skaetch.com/api/subjectapi/getsubjects.php")
  .then((response) => response.json())
  .then((responseData) => {
    // console.log(responseData);
    responseData.map((subj) => {
      // console.log(subject);
      subject.innerHTML += `
      <option value="${subj.subject_id}">${subj.subject_name}</option>`
    });
  })


    // Get the classes
  fetch("https://schola.skaetch.com/api/classapi/getclasses.php")
  .then((response) => response.json())
  .then((data) => {
    console.log(data);

    data.map((claxx) => {
      // console.log(claxx);
      studentClass.innerHTML += `
      <option value="${claxx.class_id}">${claxx.class_name}</option>`
    });
  })


});

btn_Submit.addEventListener("click", ()=>{
  // e.preventDefault()

  if (textMessage.value == "") {
    alert("Please enter a question");
    return false;
  } else {
    
  }

});

