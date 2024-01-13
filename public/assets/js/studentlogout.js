const logoutBtn = document.getElementById('logout');
//CHECK IF A SESSION IS EXISTING

const vericheck = sessionStorage.getItem('schola-user');

//console.log(vericheck)

const reusable_data = JSON.parse(vericheck)
//console.log(reusable_data)

const userdata = {admin_no: reusable_data.student.admin_no}

console.log(userdata)


const configData = {
    method: "POST",
    mode: "no-cors",
    headers: {
      "Content-Type": "application/json",
    },
    body: userdata
  };


logoutBtn.addEventListener('click', ()=> {
    
if (verifier){
    fetch('https://schola.skaetch.com/api/studentapi/studentlogout.php', configData)
    .then(res => res.json())
    .then(data => {
        if (data.status == 'ok'){
            sessionStorage.removeItem('schola-user');
            location.href = '../students/login.html'
        }else {
         console.log(data.message)
       }
    })
    .catch(err => console.log(err))
    
}
})