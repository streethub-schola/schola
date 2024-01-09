// https://scholabe.myf2.net/api/studentapi/studentlogin.php
let form = document.querySelector("form");

form.addEventListener("submit", (e) => {
  e.preventDefault();

  const url = document.URL;

  const userData = {
    admin_no: `${form.admin_no.value}`,
    password: `${form.password.value}`,
  };

  const configData = {
    method: "POST",
    mode: "no-cors",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(userData),
  };

  url.includes('teacher') ? logteacher(configData) : logStudent(configData);

});


function logStudent(studentObject){
  // fetch("https://schola.myf2.net/api/studentapi/studentlogin.php", studentObject)

  console.log("We are trying to call the student login API here")
  fetch("http://localhost/api/studentapi/studentlogin.php", studentObject)
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      if (data.status == 1) {
        alert(data.message);

        // Save logged in user info to session storage so you can access them in other pages
        sessionStorage.setItem("scola-user", JSON.stringify(data) )

        // location.href = "./admin/students/view_student.html";
        location.href = "../../admin/students/dashboard.html";
      }
      else {
        alert(data.message);
      }
    })
    .catch((err) => console.log(err));
}


function logteacher(teacherObject){
  // fetch("https://schola.myf2.net/api/staffapi/stafflogin.php", teacherObject)

  console.log("We are trying to call the teachers login API here")
  fetch("http://localhost/api/studentapi/studentlogin.php", teacherObject)
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      if (data.status == 1) {
        alert(data.message);

        // Save logged in user info to session storage so you can access them in other pages
        sessionStorage.setItem("scola-user", JSON.stringify(data) )

        // location.href = "./admin/students/view_student.html";
        location.href = "../../admin/students/view.html";
      }
      else {
        alert(data.message);
      }
    })
    .catch((err) => console.log(err));
}