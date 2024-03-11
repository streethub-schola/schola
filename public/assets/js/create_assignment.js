
var textBox = document.querySelector(".textBox");
var messageContainer = document.querySelector(".message");
var add_Question = document.getElementById("AddAss");
var textMessage = document.getElementById("assignmentText");
var remove_Question = document.getElementById("remove");
var btn_Submit = document.getElementById("postBtn");
var sname = document.getElementById("staff-name");
 
const delete_Assignment = document.getElementById("deleteAssignment");
const subject = document.querySelector(".subjectsT");
const staffName = document.getElementById("staff-name");
const session = document.querySelector("#session");

console.log(session)
  // const subject = document.querySelector(".subjectsT");

  console.log(subject);
  const studentClass = document.querySelector(".classT");
  const terms = document.getElementById("terms");

  // Fetch the staff details
  staffName.value = sessionStorage.getItem("staff-name");

document.addEventListener("DOMContentLoaded", () => {
  

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

    //this line to 69 is for debugging
    console.log(
      `${textMessage.value}
      ${subject.value}
      ${terms.value}`
    )


    let configData = {
      method: "POST",
      mode: "no-cors",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        "class_id": studentClass.value,
        "subject_id": subject.value,
        "term_id": terms.value,
        "session_id": session.value,
        "staff_id": 1,
        "assignment":textMessage.value
      })
    }

    fetch("https://schola-2.myf2.net/api/assignmentapi/createassignment.php", configData)
    // fetch("http://localhost/oluaka/schola/api/assignmentapi/createassignment.php", configData)
    .then(res => res.json())
    .then(data => {
      console.log(data)
    })
    .catch(err => {
      console.log(err)
    })
    
  }

});

