// console.log("addteacher js")
const form = document.querySelector('form');
let img_preview, email;
const url = document.URL

let img_preview_arr;
let img_address;


function loadPreview(event) {
    img_preview = URL.createObjectURL(event.target.files[0])
    let img_view = document.getElementById('img_upload');
    if(form.staff_passport.files[0].size > 419999) {
        alert ('You have selected a file larger than the threshold');
        form.staff_passport.value = '';
        img_view.src = '';
    } else {
        console.log(img_preview);
        img_preview_arr = img_preview.split(':');
        console.log(img_preview_arr)
        img_address = img_preview_arr[1] + ":" + img_preview_arr[2] + ":" + img_preview_arr[3]
        console.log(img_address)
        
        img_view.src = img_preview;

    }
    
    // return img_preview;
}

form.addEventListener('submit', (e) => {
    e.preventDefault();

    // let formData = new FormData(form);
    // console.log(formData)

    // Get form data
    let formData = {
        firstname: form.firstname.value,
        lastname: form.lastname.value,
        dob: form.dob.value,
        image: img_address,
        phone: form.phone.value,
        email: form.email.value,
        address: form.address.value,

        class_id: form.assignedclass.value,
        role: form.staff_role.value,
        rank: form.staff_rank.value,

        nok_name: form.nok_name.value,
        nok_phone: form.nok_phone.value,
        nok_email: form.nok_email.value,
        nok_address: form.nok_address.value,
        nok_rel: form.nok_rel.value,

        guarantor_name: form.guarantor_name.value,
        guarantor_phone: form.guarantor_phone.value,
        guarantor_email: form.guarantor_email.value,
        guarantor_address: form.guarantor_address.value,
        guarantor_rel: form.guarantor_rel.value,        
    }

console.log(formData)
    const configData = {
        method: 'POST',
        mode: 'no-cors',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(formData)
    }
    fetch("https://schola-2.myf2.net/api/staffapi/createstaff.php", configData)
    .then(res => res.json())
    .then((data) => {
        console.log(data);
    })
    .catch((err) => {
        console.log('something went wrong with your request');
    })

});


// Prefill the Classes box
let assignedClass = document.querySelector('#assignedclass');

// fetch('https://schola-2.myf2.net/api/classapi/getclasses.php')
fetch('http://localhost/streethub/schola/api/classapi/getclasses.php')
    .then(res => res.json())
    .then(data => {
        // console.log(data);
        data.result.forEach(claxx => {
            assignedClass.innerHTML += `<option value="${claxx.class_id}">${claxx.class_name}</option>`
        })

    })
    .catch(err => console.log(err))


// Prefill the Staff Role box
let roleBox = document.querySelector('#staffrole');

// fetch('https://schola-2.myf2.net/api/roleapi/getroles.php')
fetch('http://localhost/streethub/schola/api/roleapi/getroles.php')
    .then(res => res.json())
    .then(data => {
        // console.log(data);
        data.result.forEach(role => {
            roleBox.innerHTML += `<option value="${role.role_id}">${role.role_name}</option>`
        })

    })
    .catch(err => console.log(err))


//Set Staff rank
let rankBox = document.querySelector('#staffrank');

roleBox.addEventListener("change", (e) => {
    let role_id = e.target.value;
    // console.log(role_id)
    fetch(`http://localhost/streethub/schola/api/roleapi/getrole.php?role_id=${role_id}`)
        .then(res => res.json())
        .then(data => {
            // console.log(data.result);
                rankBox.value = data.result.role_no;
        })
    .catch(err => console.log(err))
}) 