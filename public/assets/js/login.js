let form = document.querySelector("form");

form.addEventListener("submit", (e) => {
  e.preventDefault();

  const url = document.URL;

  let userData = null;


    userData = {
      admin_no: `${form.admin_no.value}`,
      password: `${form.password.value}`,
    };


 const configData = {
    method: "POST",
    mode: "no-cors",
    headers: {
      "Content-Type": "application/json",
      "Accept": "application/json"
    },
    body: JSON.stringify(userData),
  };

  console.log(userData);


  // logStudent(configData);

  fetch(API_DOMAIN+"/api/studentapi/studentlogin.php", configData)
    .then(res => res.json())
    .then(data => {
      console.log(data);
      if (data.status == 1) {

        // Save logged in user info to session storage so you can access them in other pages
        sessionStorage.setItem("schola-user", JSON.stringify(data) )

        location.href = "../students/dashboard.html";
      }
      else {
        alert(data.message);
      }
    })
    .catch((err) => console.log(err));

});




