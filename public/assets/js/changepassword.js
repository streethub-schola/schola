// Admin_no
// Password
// New_password
const flag = document.getElementById("flag");

const form = document.querySelector("form");

const reusable_data = JSON.parse(sessionStorage.getItem("schola-user"));

const closer = document.getElementById("close");

closer.addEventListener("click", () => {
  flag.style.display = "none";
});

form.addEventListener("submit", (e) => {
  e.preventDefault();

  const password = form.newPassword.value;
  const confirmPassword = form.confirmPassword.value;
  const msg = document.getElementById("message");

  let message = " ";

  const userData = {
    admin_no: `${reusable_data.student.admin_no}`,
    password: `${form.oldPassword.value}`,
    new_password: `${form.newPassword.value}`,
  };

  const configData = {
    method: "PATCH",
    mode: "no-cors",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(userData),
  };

  if (confirmPassword == password) {
    fetch(API_DOMAIN + "/api/studentapi/changepassword.php", configData)
      .then((res) => res.json())
      .then((data) => {
        console.log(data);
        if (data.status == 1) {
          sessionStorage.removeItem("schola-user");
          alert("Your Password has been changed successfully");
          location.href = "../students/login.html";
        }
      })
      .catch((err) => console.log(err));
  } else {
    flag.style.display = "flex";
    message = "Your New password does not match";
    msg.innerHTML = message;
  }
});
