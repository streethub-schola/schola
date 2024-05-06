let form = document.querySelector("form");

form.addEventListener("submit", (e) => {
  e.preventDefault();

  const userData = {
    staff_no: `${form.staff_no.value}`,
    password: `${form.password.value}`,
  };

  console.log(userData);

  const configData = {
    method: "POST",
    mode: "no-cors",
    headers: {
      "Content-Type": "application/json",
      Accept: "application/json",
    },
    body: JSON.stringify(userData),
  };

  logteacher(configData);
});

function logteacher(teacherObject) {
  fetch("https://schola-2.myf2.net/api/staffapi/stafflogin.php", teacherObject)
    // fetch("http://localhost/schola-2/api/staffapi/stafflogin.php", teacherObject)
    .then((res) => res.json())
    .then((data) => {
      console.log(data);
      if (data.status == 1) {
        alert(data.message);

        // Save logged in user info to session storage so you can access them in other pages
        sessionStorage.setItem("scola-staff", JSON.stringify(data));

        location.href = "../../teachers/teacher_dashboard.html";
      } else {
        alert(data.message);
      }
    })

    .catch((err) => console.log("Error is on", err));
}
