const logoutBtn = document.getElementById('logout');
const logoutMobBtn = document.getElementById('logoutmob');

const vericheck = sessionStorage.getItem('schola-user');

//console.log(vericheck)

const reusable_data = JSON.parse(vericheck)
console.log(reusable_data)

//CHECK IF A SESSION IS EXISTING

const userdata = {staff_no: reusable_data.staff_no};


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
  
if(!reusable_data){
  alert('You do not have permission to view this page.');
    location.href = '../teachers/teacher_login.html';
}



// console.log(userdata)


  if (verifier){
    fetch('https://schola.skaetch.com/api/studentapi/stafflogout.php', configData)
    .then(res => res.json())
    .then(data => {
        if (data.status == 1){
            sessionStorage.removeItem('schola-user');
            alert('Sucessfully Logged out.');
            location.href  = '../teachers/teacher_login.html';
        }
    })
    .catch(err => alert("There is an issue with your network. Please try again"))
    
}
}