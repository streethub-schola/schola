// https://scholabe.myf2.net/api/studentapi/studentlogin.php
let form = document.querySelector("form");

form.addEventListener("submit", (e) => {
  e.preventDefault();

  const url = document.URL;

  const userData = {
    admin_no: `${form.admin_no.value}`,
    password: `${form.password.value}`,
  };

<<<<<<< HEAD
  const configData = {
    method: "POST",
    mode: "no-cors",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(userData),
  };
=======
  console.log(userData);
>>>>>>> 9223e890b5424388c1417d82bc10f14a066d12c7

  url.includes('teacher') ? logteacher(userData) : logStudent(userData);

});


function logStudent(studentObject){
  // fetch("https://schola.myf2.net/api/studentapi/studentlogin.php", studentObject)

  // fetch("http://localhost/api/studentapi/studentlogin.php", studentObject)
  fetch("https://schola-2.myf2.net/api/studentapi/studentlogin.php", studentObject)
    .then(res => res.json())
    .then(data => {
      console.log(data);
      if (data.status == 1) {
        alert(data.message);

        // Save logged in user info to session storage so you can access them in other pages
        sessionStorage.setItem("schola-user", JSON.stringify(data) )

        location.href = "../students/dashboard.html";
      }
      else {
        alert(data.message);
      }
    })
    .catch((err) => console.log(err));
}


function logteacher(teacherObject){
  // fetch("https://schola.myf2.net/api/staffapi/stafflogin.php", teacherObject)

  fetch("http://localhost/oluaka/schola/api/studentapi/studentlogin.php", teacherObject)
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      if (data.status == 1) {
        alert(data.message);

        // Save logged in user info to session storage so you can access them in other pages
        sessionStorage.setItem("scola-user", JSON.stringify(data) )

        // location.href = "./admin/students/view_student.html";
        location.href = "../../teachers/index.html";
      }
      else {
        alert(data.message);
      }
    })
    .catch((err) => console.log(err));
}