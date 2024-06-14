const logoutBtn = document.getElementById('logout');
const logoutMobBtn = document.getElementById('logoutmob');

//CHECK IF A SESSION IS EXISTING

const vericheck = sessionStorage.getItem('schola-user');

//console.log(vericheck)

const reusable_data = JSON.parse(vericheck)
//console.log(reusable_data)

const userdata = {admin_no: reusable_data.student.admin_no}

// console.log(userdata)


const configData = {
    method: "POST",
    mode: "no-cors",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(userdata)
  };


logoutBtn.addEventListener('click', logout)

logoutMobBtn.addEventListener('click', logout)



function logout(){
  if (verifier){
    fetch('https://schola.skaetch.com/api/studentapi/studentlogout.php', configData)
    .then(res => res.json())
    .then(data => {
        if (data.status == 1){
            sessionStorage.removeItem('schola-user');
            location.href = '../students/student_login.html'
        }
    })
    .catch(err => alert("There is an issue with your network. Please try again"))
    
}
}