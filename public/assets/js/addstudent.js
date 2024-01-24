const form = document.querySelector('form');
const preview = document.querySelector('#preview');

let img_preview, email;
const formdata = new FormData(form);


form.addEventListener('submit', (e)=>{
    e.preventDefault();

    const guardian_email = form.guardianEmail.value;
    console.log(guardian_email)
    

    if (guardian_email == ''){
        email = null;
    } else {
        email = guardian_email;
    }
    

    const newStudent = {
        'firstname': form.firstName.value,
        'lastname': form.lastName.value,
        'dob': form.studentDoB.value,
        'image': form.studentPassport.files[0].name,
        'guardian_name': form.PGName.value,
        'guardian_phone': form.guardianPhone.value,
        'guardian_rel': form.guardianRel.value,
        'guardian_address': form.guardianAddress.value,
        'guardian_email': email
    }
    

    console.log(newStudent)

    const configData = {
        method: 'POST',
        mode: 'no-cors',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(newStudent)
    }

    function addStudent(){
        fetch("https://schola-2.myf2.net/api/studentapi/createstudent.php", configData)
        .then(res => res.json())
        .then(data => {
            if (data.status == 1){
                alert(data);
            } 
        })
        .catch(err => alert(`${err}`))
    }

    
    // 
    
})

function loadPreview(event) {
    img_preview = URL.createObjectURL(event.target.files[0])
    let img_view = document.getElementById('img_upload');
    if(form.studentPassport.files[0].size > 41999) {
        alert ('You have selected a file larger than the threshold');
        form.studentPassport.value = '';
        img_view.src = '';
    } else {
        img_view.src = img_preview;
    }
    
    // return img_preview;
}


