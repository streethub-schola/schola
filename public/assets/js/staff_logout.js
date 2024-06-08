const logoutBtn = document.getElementById('logout');
const logoutMobBtn = document.getElementById('logoutmob');

//CHECK IF A SESSION IS EXISTING

const vericheck = sessionStorage.getItem('schola-user');

//console.log(vericheck)

const reusable_data = JSON.parse(vericheck)
//console.log(reusable_data)

const userdata = {staff_no: reusable_data.staff_no}

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

  fetch(API_DOMAIN+'/api/staffapi/stafflogout.php', configData)
    .then(res => res.json())
    .then(data => {
        if (data.status == 1){
            sessionStorage.removeItem('schola-user');
          location.href = '../students/login.html'
          
        }
    })
    .catch(err => alert("There is an issue with your network. Please try again"))
    
}