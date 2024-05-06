// https://scholabe.myf2.net/api/studentapi/studentlogin.php
//recreate a dummy validation tool
const dummyValidator = {
  staff_no: "MTS/2002/0098",
  password: "admin"
}

const staff = {
  staff_id: 1,
  staff_no: 'MIS/TS/2024//003',
  firstname: 'Okezie',
  lastname: 'Ikpeazu',
  email: 'okezie@gmail.com',
  dob: '19-02-1998',
  phone:'08038428482',
  address: '77, Wetheral Road, Owerri',
  guarantor_name: 'Mr. Innocent Unachukwu',
  class_id: 1,
  rank: 2,
  role: 2,
  password: 'admin'
}


let form = document.querySelector("form");

form.addEventListener("submit", (e) => {
  e.preventDefault();



    const userData = {
      staff_no: `${form.staff_no.value}`,
      password: `${form.password.value}`,
    }
    console.log(userData);


    const configData = {
        method: "POST",
        mode: "no-cors",
        headers: {
          "Content-Type": "application/json",
          "Accept": "*/*"
        },
        body: JSON.stringify(userData),
      };


      fetch("http://localhost/schola-2/api/staffapi/stafflogin.php", configData)
      .then((res) => res.json())
      .then((data) => {
        console.log(data);
        if (data.status == 1) {
          alert(data.message);
          
          // Save logged in user info to session storage so you can access them in other pages
          sessionStorage.setItem("scola-staff", JSON.stringify(data) )
          
          location.href = "../../teachers/teacher_dashboard.html";
        }
        else {
          alert(data.message);
        }
      })
      
      .catch((err) => console.log("Error is on", err));
  });
