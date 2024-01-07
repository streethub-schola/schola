const form = document.querySelector('#form');

form.addEventListener('submit', (e)=> {
    e.preventDefault()

    const formdata = new FormData(form);

    // console.log(formdata)

    for (let [key, values] of formdata){
        console.log(`${key} : ${values}`)
    }

    // console.log(formdata[4])

    // const firstName =form.studentFName.value; 
    // const lastName =form.studentLName.value; 
    // const studentDoB = form.studentDOB.value;
    // // const stdAddress = form.studentAddress.value;
    // const PGName = form.guardianName.value;
    // const guardianPhone = form.guardianPhone.value;
    // const guardianEmail = form.guardianEmail.value;
    // const guardianAddress = form.guardianAddress.value;
    // const password = form.password.value;

    // console.log(`
    // ${firstName}
    // ${lastName}
    // ${studentDoB}
    // ${PGName}
    // ${guardianPhone}
    // ${guardianAddress}
    // ${guardianEmail}
    // ${password}
    // `)

    // const userData = {
    //    firstname: `${firstName}`,
    //    lastname: `${lastName}`,
    //    dob: `${studentDoB}`,
    //    guardian_name: `${PGName}`,
    //    guardian_phone: `${guardianPhone}`,
    //    guardian_email: `${guardianEmail}`,
    //    guardian_address: `${guardianAddress}`,
    //    password: `${password}`
    // }

    // const configData ={
    //         method: 'POST',
    //         mode: 'no-cors',
    //         headers: {
    //             'Content-Type':'application/json',
    //             'Accept':'application/json'
    //         },
    //         body: JSON.stringify(formdata)
    //     };

    //     fetch('http://localhost/api/studentapi/createstudent.php', configData)
    //     .then(res => {
    //         // console.log('What have you done?')
    //         if(res.status != 'ok'){
    //             console.log(res.json())
    //         }else {
    //             console.log('student record created successfully')
    //         }
    //     })
    //     .catch(error => error);
})